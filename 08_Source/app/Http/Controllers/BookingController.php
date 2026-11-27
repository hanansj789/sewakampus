<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingStatusHistory;
use App\Models\Item;
use App\Models\Notification;
use App\Services\ItemAvailabilityService;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $incoming = Booking::with(['item', 'renter'])
            ->where('owner_id', $user->id)
            ->latest()
            ->get();

        $outgoing = Booking::with(['item', 'owner'])
            ->where('renter_id', $user->id)
            ->latest()
            ->get();

        return view('bookings.index', [
            'incoming' => $incoming,
            'outgoing' => $outgoing,
        ]);
    }

    public function store(Request $request, Item $item, ItemAvailabilityService $availability): RedirectResponse
    {
        $data = $request->validate([
            'start_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'end_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:start_date'],
            'renter_note' => ['nullable', 'string', 'max:500'],
        ]);

        $user = $request->user();

        if ($item->owner_id === $user->id) {
            throw ValidationException::withMessages([
                'start_date' => 'Tidak dapat mengajukan sewa pada barang milik sendiri.',
            ]);
        }

        abort_unless($item->status === 'ACTIVE', 404);

        $booking = DB::transaction(function () use ($item, $user, $data, $availability) {
            // Kunci baris item agar dua pengajuan bersamaan tidak lolos.
            Item::query()->whereKey($item->id)->lockForUpdate()->firstOrFail();

            if (! $availability->isRangeAvailable($item, $data['start_date'], $data['end_date'])) {
                throw ValidationException::withMessages([
                    'start_date' => 'Rentang tanggal itu sudah terpakai. Pilih tanggal lain.',
                ]);
            }

            $days = CarbonImmutable::parse($data['start_date'])
                ->diffInDays(CarbonImmutable::parse($data['end_date'])) + 1;

            $subtotal = round((float) $item->daily_rate * $days, 2);
            $deposit = (float) $item->deposit_amount;

            $booking = Booking::query()->create([
                'public_id' => (string) Str::ulid(),
                'item_id' => $item->id,
                'renter_id' => $user->id,
                'owner_id' => $item->owner_id,
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'daily_rate_snapshot' => $item->daily_rate,
                'subtotal' => $subtotal,
                'deposit_snapshot' => $deposit,
                'total_amount' => round($subtotal + $deposit, 2),
                'status' => 'PENDING',
                'pickup_point' => $item->pickup_point,
                'renter_note' => $data['renter_note'] ?? null,
            ]);

            BookingStatusHistory::query()->create([
                'booking_id' => $booking->id,
                'from_status' => 'NEW',
                'to_status' => 'PENDING',
                'changed_by' => $user->id,
                'reason' => 'Pengajuan dibuat penyewa.',
            ]);

            Notification::query()->create([
                'public_id' => (string) Str::ulid(),
                'user_id' => $item->owner_id,
                'type' => 'BOOKING_REQUEST',
                'title' => 'Pengajuan sewa baru',
                'body' => $user->full_name.' mengajukan sewa '.$item->title.'.',
                'channel' => 'IN_APP',
                'status' => 'QUEUED',
                'entity_type' => 'BOOKING',
                'entity_public_id' => $booking->public_id,
            ]);

            return $booking;
        });

        return redirect()->route('bookings.index')
            ->with('status', 'Pengajuan untuk '.$booking->item->title.' terkirim ke pemilik.');
    }

    public function approve(Request $request, Booking $booking): RedirectResponse
    {
        $this->ensureOwner($request, $booking);
        $this->ensureStatus($booking, 'PENDING');

        DB::transaction(function () use ($request, $booking) {
            $booking->status = 'APPROVED';
            $booking->approved_at = now();
            $booking->save();

            BookingStatusHistory::query()->create([
                'booking_id' => $booking->id,
                'from_status' => 'PENDING',
                'to_status' => 'APPROVED',
                'changed_by' => $request->user()->id,
                'reason' => 'Disetujui pemilik.',
            ]);

            Notification::query()->create([
                'public_id' => (string) Str::ulid(),
                'user_id' => $booking->renter_id,
                'type' => 'BOOKING_APPROVED',
                'title' => 'Pengajuan disetujui',
                'body' => 'Pemilik menyetujui pengajuan '.$booking->item->title.'.',
                'channel' => 'IN_APP',
                'status' => 'QUEUED',
                'entity_type' => 'BOOKING',
                'entity_public_id' => $booking->public_id,
            ]);
        });

        return redirect()->route('bookings.index')->with('status', 'Pengajuan disetujui.');
    }

    public function reject(Request $request, Booking $booking): RedirectResponse
    {
        $this->ensureOwner($request, $booking);
        $this->ensureStatus($booking, 'PENDING');

        $data = $request->validate([
            'reason' => ['required', 'string', 'max:500'],
        ]);

        DB::transaction(function () use ($request, $booking, $data) {
            $booking->status = 'REJECTED';
            $booking->save();

            BookingStatusHistory::query()->create([
                'booking_id' => $booking->id,
                'from_status' => 'PENDING',
                'to_status' => 'REJECTED',
                'changed_by' => $request->user()->id,
                'reason' => $data['reason'],
            ]);

            Notification::query()->create([
                'public_id' => (string) Str::ulid(),
                'user_id' => $booking->renter_id,
                'type' => 'BOOKING_REJECTED',
                'title' => 'Pengajuan ditolak',
                'body' => 'Pengajuan '.$booking->item->title.' ditolak: '.$data['reason'],
                'channel' => 'IN_APP',
                'status' => 'QUEUED',
                'entity_type' => 'BOOKING',
                'entity_public_id' => $booking->public_id,
            ]);
        });

        return redirect()->route('bookings.index')->with('status', 'Pengajuan ditolak.');
    }

    public function cancel(Request $request, Booking $booking): RedirectResponse
    {
        abort_unless($booking->renter_id === $request->user()->id, 403);
        $this->ensureStatus($booking, 'PENDING');

        DB::transaction(function () use ($request, $booking) {
            $booking->status = 'CANCELLED';
            $booking->cancelled_at = now();
            $booking->cancellation_reason = 'Dibatalkan penyewa.';
            $booking->save();

            BookingStatusHistory::query()->create([
                'booking_id' => $booking->id,
                'from_status' => 'PENDING',
                'to_status' => 'CANCELLED',
                'changed_by' => $request->user()->id,
                'reason' => 'Dibatalkan penyewa.',
            ]);
        });

        return redirect()->route('bookings.index')->with('status', 'Pengajuan dibatalkan.');
    }

    private function ensureOwner(Request $request, Booking $booking): void
    {
        abort_unless($booking->owner_id === $request->user()->id, 403);
    }

    private function ensureStatus(Booking $booking, string $expected): void
    {
        abort_unless($booking->status === $expected, 409, 'Status pengajuan tidak sesuai.');
    }
}
