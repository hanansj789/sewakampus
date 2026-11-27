<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Item;
use App\Models\Notification;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function create(Request $request, Booking $booking): View|RedirectResponse
    {
        $this->ensureReviewable($request, $booking);

        return view('bookings.review', [
            'booking' => $booking->load('item', 'renter', 'owner'),
            'role' => $this->roleOf($request, $booking),
        ]);
    }

    public function store(Request $request, Booking $booking): RedirectResponse
    {
        $this->ensureReviewable($request, $booking);

        $data = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $user = $request->user();
        $role = $this->roleOf($request, $booking);
        $revieweeId = $role === 'RENTER' ? $booking->owner_id : $booking->renter_id;

        DB::transaction(function () use ($booking, $user, $role, $revieweeId, $data) {
            $exists = Review::query()
                ->where('booking_id', $booking->id)
                ->where('reviewer_role', $role)
                ->exists();

            abort_if($exists, 409, 'Anda sudah memberi rating untuk transaksi ini.');

            Review::query()->create([
                'public_id' => (string) Str::ulid(),
                'booking_id' => $booking->id,
                'reviewer_id' => $user->id,
                'reviewee_id' => $revieweeId,
                'reviewer_role' => $role,
                'rating' => $data['rating'],
                'comment' => $data['comment'] ?? null,
                'status' => 'PUBLISHED',
            ]);

            $this->recalculateItemRating($booking->item_id);

            Notification::query()->create([
                'public_id' => (string) Str::ulid(),
                'user_id' => $revieweeId,
                'type' => 'REVIEW_RECEIVED',
                'title' => 'Ulasan baru',
                'body' => 'Anda menerima ulasan bintang '.$data['rating'].' untuk '.$booking->item->title.'.',
                'channel' => 'IN_APP',
                'status' => 'QUEUED',
                'entity_type' => 'BOOKING',
                'entity_public_id' => $booking->public_id,
            ]);
        });

        return redirect()->route('bookings.index')->with('status', 'Rating tersimpan. Terima kasih.');
    }

    private function recalculateItemRating(int $itemId): void
    {
        $stats = Review::query()
            ->join('bookings', 'bookings.id', '=', 'reviews.booking_id')
            ->where('bookings.item_id', $itemId)
            ->where('reviews.status', 'PUBLISHED')
            ->selectRaw('COUNT(*) as total, AVG(reviews.rating) as average')
            ->first();

        Item::query()->whereKey($itemId)->update([
            'review_count' => (int) ($stats->total ?? 0),
            'average_rating' => round((float) ($stats->average ?? 0), 2),
        ]);
    }

    private function ensureReviewable(Request $request, Booking $booking): void
    {
        $userId = $request->user()->id;

        abort_unless($booking->renter_id === $userId || $booking->owner_id === $userId, 403);
        abort_unless($booking->status === 'COMPLETED', 409, 'Rating hanya setelah transaksi selesai.');

        $role = $this->roleOf($request, $booking);

        $exists = Review::query()
            ->where('booking_id', $booking->id)
            ->where('reviewer_role', $role)
            ->exists();

        abort_if($exists, 409, 'Anda sudah memberi rating untuk transaksi ini.');
    }

    private function roleOf(Request $request, Booking $booking): string
    {
        return $booking->renter_id === $request->user()->id ? 'RENTER' : 'OWNER';
    }
}
