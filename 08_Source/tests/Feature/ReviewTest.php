<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Item;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use DatabaseTransactions;

    private function item(): Item
    {
        // Item 2 tidak punya review seed, sehingga hitungan mudah diperiksa.
        return Item::query()->where('status', 'ACTIVE')->whereKey(2)->firstOrFail();
    }

    private function owner(): User
    {
        return User::query()->findOrFail($this->item()->owner_id);
    }

    private function renter(): User
    {
        return User::query()
            ->where('role', 'STUDENT')
            ->where('account_status', 'ACTIVE')
            ->where('id', '!=', $this->item()->owner_id)
            ->firstOrFail();
    }

    private function completedBooking(string $status = 'COMPLETED'): Booking
    {
        $item = $this->item();
        $renter = $this->renter();

        return Booking::query()->create([
            'public_id' => (string) Str::ulid(),
            'item_id' => $item->id,
            'renter_id' => $renter->id,
            'owner_id' => $item->owner_id,
            'start_date' => now()->subDays(5)->toDateString(),
            'end_date' => now()->subDays(3)->toDateString(),
            'daily_rate_snapshot' => $item->daily_rate,
            'subtotal' => 100000,
            'deposit_snapshot' => 50000,
            'total_amount' => 150000,
            'status' => $status,
            'pickup_point' => $item->pickup_point,
        ]);
    }

    public function test_guest_cannot_open_review_page(): void
    {
        $booking = $this->completedBooking();

        $this->get("/bookings/{$booking->id}/review")->assertRedirect('/login');
    }

    public function test_renter_can_review_completed_booking(): void
    {
        $booking = $this->completedBooking();
        $item = $this->item();

        $this->actingAs($this->renter())
            ->post("/bookings/{$booking->id}/reviews", [
                'rating' => 5,
                'comment' => 'Barang sesuai deskripsi.',
            ])
            ->assertRedirect('/bookings');

        $review = Review::query()->where('booking_id', $booking->id)->firstOrFail();

        $this->assertSame('RENTER', $review->reviewer_role);
        $this->assertSame($booking->owner_id, $review->reviewee_id);
        $this->assertSame(5, $review->rating);

        $item->refresh();
        $this->assertSame(1, $item->review_count);
        $this->assertEquals(5.0, (float) $item->average_rating);
    }

    public function test_owner_can_review_completed_booking(): void
    {
        $booking = $this->completedBooking();

        $this->actingAs($this->owner())
            ->post("/bookings/{$booking->id}/reviews", ['rating' => 4])
            ->assertRedirect('/bookings');

        $review = Review::query()->where('booking_id', $booking->id)->firstOrFail();

        $this->assertSame('OWNER', $review->reviewer_role);
        $this->assertSame($booking->renter_id, $review->reviewee_id);
    }

    public function test_review_requires_completed_booking(): void
    {
        $booking = $this->completedBooking('RETURNED');

        $this->actingAs($this->renter())
            ->post("/bookings/{$booking->id}/reviews", ['rating' => 5])
            ->assertStatus(409);
    }

    public function test_non_party_cannot_review(): void
    {
        $booking = $this->completedBooking();

        $outsider = User::query()
            ->where('role', 'STUDENT')
            ->whereNotIn('id', [$booking->renter_id, $booking->owner_id])
            ->firstOrFail();

        $this->actingAs($outsider)
            ->post("/bookings/{$booking->id}/reviews", ['rating' => 5])
            ->assertForbidden();
    }

    public function test_one_review_per_role_per_booking(): void
    {
        $booking = $this->completedBooking();

        $this->actingAs($this->renter())
            ->post("/bookings/{$booking->id}/reviews", ['rating' => 5]);

        $this->actingAs($this->renter())
            ->post("/bookings/{$booking->id}/reviews", ['rating' => 3])
            ->assertStatus(409);

        $this->assertSame(1, Review::query()->where('booking_id', $booking->id)->count());
    }

    public function test_rating_must_be_between_one_and_five(): void
    {
        $booking = $this->completedBooking();

        $this->actingAs($this->renter())
            ->post("/bookings/{$booking->id}/reviews", ['rating' => 0])
            ->assertSessionHasErrors('rating');

        $this->actingAs($this->renter())
            ->post("/bookings/{$booking->id}/reviews", ['rating' => 6])
            ->assertSessionHasErrors('rating');
    }

    public function test_item_average_is_recalculated_from_published_reviews(): void
    {
        $renter = $this->renter();

        $first = $this->completedBooking();
        $second = $this->completedBooking();

        $this->actingAs($renter)->post("/bookings/{$first->id}/reviews", ['rating' => 5]);
        $this->actingAs($renter)->post("/bookings/{$second->id}/reviews", ['rating' => 3]);

        $item = $this->item()->refresh();

        $this->assertSame(2, $item->review_count);
        $this->assertEquals(4.0, (float) $item->average_rating);
    }

    public function test_review_appears_on_item_page(): void
    {
        $booking = $this->completedBooking();

        $this->actingAs($this->renter())
            ->post("/bookings/{$booking->id}/reviews", [
                'rating' => 5,
                'comment' => 'Pemilik ramah dan barang bersih.',
            ]);

        $this->actingAs($this->owner())
            ->get("/items/{$this->item()->id}")
            ->assertOk()
            ->assertSee('Pemilik ramah dan barang bersih.');
    }

    public function test_review_page_renders_form(): void
    {
        $booking = $this->completedBooking();

        $this->actingAs($this->renter())
            ->get("/bookings/{$booking->id}/review")
            ->assertOk()
            ->assertSee('Beri rating')
            ->assertSee('Pilih rating');
    }
}
