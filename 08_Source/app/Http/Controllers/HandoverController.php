<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingStatusHistory;
use App\Models\Deposit;
use App\Models\Handover;
use App\Models\Notification;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class HandoverController extends Controller
{
    public function show(Request $request, Booking $booking): View
    {
        $this->ensureParty($request, $booking);

        $handovers = $booking->handovers()->orderBy('id')->get();

        return view('bookings.handover', [
            'booking' => $booking->load('item', 'renter', 'owner'),
            'handovers' => $handovers,
            'canCreateOut' => $booking->status === 'APPROVED' && ! $handovers->contains('direction', 'OUT'),
            'canCreateReturn' => $booking->status === 'HANDED_OVER' && ! $handovers->contains('direction', 'RETURN'),
            'isRenter' => $booking->renter_id === $request->user()->id,
        ]);
    }

    public function showPhoto(Request $request, Booking $booking, Handover $handover): StreamedResponse
    {
        $this->ensureParty($request, $booking);
        abort_unless($handover->booking_id === $booking->id, 404);
        abort_unless(Storage::disk('local')->exists($handover->photo_path), 404);

        return Storage::disk('local')->response($handover->photo_path);
    }

    public function store(Request $request, Booking $booking): RedirectResponse
    {
        $this->ensureParty($request, $booking);

        $request->validate([
            'location' => ['required', 'string', 'max:120'],
            'condition_notes' => ['nullable', 'string', 'max:1000'],
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
        ]);

        $user = $request->user();

        DB::transaction(function () use ($request, $booking, $user) {
            // Kunci baris booking agar dua pihak tidak membuat arah yang sama bersamaan.
            $booking = Booking::query()->whereKey($booking->id)->lockForUpdate()->firstOrFail();

            $direction = match ($booking->status) {
                'APPROVED' => 'OUT',
                'HANDED_OVER' => 'RETURN',
                default => null,
            };

            abort_if($direction === null, 409, 'Status booking tidak mengizinkan serah terima.');
            abort_if(
                Handover::query()->where('booking_id', $booking->id)->where('direction', $direction)->exists(),
                409,
                'Handover arah ini sudah ada.'
            );

            $path = $request->file('photo')->store('handover/'.$booking->id, 'local');

            $handover = Handover::query()->create([
                'public_id' => (string) Str::ulid(),
                'booking_id' => $booking->id,
                'direction' => $direction,
                'location' => $request->string('location')->toString(),
                'condition_notes' => $request->input('condition_notes'),
                'photo_path' => $path,
                'renter_confirmed_at' => $booking->renter_id === $user->id ? now() : null,
                'owner_confirmed_at' => $booking->owner_id === $user->id ? now() : null,
            ]);

            $otherParty = $booking->renter_id === $user->id ? $booking->owner_id : $booking->renter_id;

            Notification::query()->create([
                'public_id' => (string) Str::ulid(),
                'user_id' => $otherParty,
                'type' => $direction === 'OUT' ? 'HANDOVER_OUT' : 'HANDOVER_RETURN',
                'title' => $direction === 'OUT' ? 'Serah terima dicatat' : 'Pengembalian dicatat',
                'body' => 'Konfirmasi '.($direction === 'OUT' ? 'serah terima' : 'pengembalian').' '.$booking->item->title.'.',
                'channel' => 'IN_APP',
                'status' => 'QUEUED',
                'entity_type' => 'BOOKING',
                'entity_public_id' => $booking->public_id,
            ]);

            return $handover;
        });

        return redirect()->route('bookings.handover', $booking)->with('status', 'Catatan serah terima disimpan. Menunggu konfirmasi pihak lain.');
    }

    public function confirm(Request $request, Booking $booking, Handover $handover): RedirectResponse
    {
        $this->ensureParty($request, $booking);
        abort_unless($handover->booking_id === $booking->id, 404);

        $user = $request->user();

        DB::transaction(function () use ($booking, $handover, $user) {
            $booking = Booking::query()->whereKey($booking->id)->lockForUpdate()->firstOrFail();
            $handover->refresh();

            abort_if($handover->confirmedByBothParties(), 409, 'Handover sudah dikonfirmasi kedua pihak.');

            $isRenter = $booking->renter_id === $user->id;

            if ($isRenter && $handover->renter_confirmed_at !== null) {
                abort(409, 'Anda sudah mengonfirmasi handover ini.');
            }

            if (! $isRenter && $handover->owner_confirmed_at !== null) {
                abort(409, 'Anda sudah mengonfirmasi handover ini.');
            }

            $handover->renter_confirmed_at = $isRenter ? now() : $handover->renter_confirmed_at;
            $handover->owner_confirmed_at = $isRenter ? $handover->owner_confirmed_at : now();
            $handover->save();

            if (! $handover->confirmedByBothParties()) {
                return;
            }

            if ($handover->direction === 'OUT') {
                $this->transition($booking, $user->id, 'HANDED_OVER', 'Serah terima dikonfirmasi kedua pihak.');
                return;
            }

            $lateDays = CarbonImmutable::parse($booking->end_date)->diffInDays(CarbonImmutable::now()->startOfDay(), false);
            $reason = $lateDays > 0
                ? 'Pengembalian dikonfirmasi, terlambat '.$lateDays.' hari.'
                : 'Pengembalian dikonfirmasi kedua pihak.';

            $this->transition($booking, $user->id, 'RETURNED', $reason);
        });

        return redirect()->route('bookings.handover', $booking)->with('status', 'Konfirmasi tersimpan.');
    }

    public function complete(Request $request, Booking $booking): RedirectResponse
    {
        $this->ensureParty($request, $booking);

        DB::transaction(function () use ($booking, $request) {
            $booking = Booking::query()->whereKey($booking->id)->lockForUpdate()->firstOrFail();
            abort_unless($booking->status === 'RETURNED', 409, 'Transaksi belum dikembalikan.');

            $this->transition($booking, $request->user()->id, 'COMPLETED', 'Transaksi diselesaikan dan deposit dikembalikan (simulasi).');

            Deposit::query()
                ->where('booking_id', $booking->id)
                ->whereIn('status', ['PAID_SIMULATED', 'HELD'])
                ->update([
                    'status' => 'REFUNDED',
                    'refunded_at' => now(),
                ]);
        });

        return redirect()->route('bookings.handover', $booking)->with('status', 'Transaksi selesai. Rating sudah bisa diberikan.');
    }

    private function transition(Booking $booking, int $actorId, string $to, string $reason): void
    {
        $from = $booking->status;
        $booking->status = $to;
        $booking->save();

        BookingStatusHistory::query()->create([
            'booking_id' => $booking->id,
            'from_status' => $from,
            'to_status' => $to,
            'changed_by' => $actorId,
            'reason' => $reason,
        ]);
    }

    private function ensureParty(Request $request, Booking $booking): void
    {
        $userId = $request->user()->id;
        abort_unless($booking->renter_id === $userId || $booking->owner_id === $userId, 403);
    }
}
