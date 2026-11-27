<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use DatabaseTransactions;

    private function item(): Item
    {
        return Item::query()->where('status', 'ACTIVE')->orderBy('id')->firstOrFail();
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

    /**
     * @return array<string, string>
     */
    private function payload(string $start = '2027-01-10', string $end = '2027-01-12'): array
    {
        return [
            'start_date' => $start,
            'end_date' => $end,
            'renter_note' => 'Dipakai untuk acara kampus.',
        ];
    }

    public function test_guest_cannot_create_booking(): void
    {
        $this->post('/items/'.$this->item()->id.'/bookings', $this->payload())
            ->assertRedirect('/login');
    }

    public function test_renter_can_create_booking_with_price_snapshot(): void
    {
        $item = $this->item();
        $renter = $this->renter();

        $this->actingAs($renter)
            ->post("/items/{$item->id}/bookings", $this->payload())
            ->assertRedirect('/bookings');

        $booking = Booking::query()->latest('id')->firstOrFail();

        $this->assertSame('PENDING', $booking->status);
        $this->assertSame($renter->id, $booking->renter_id);
        $this->assertSame($item->owner_id, $booking->owner_id);
        $this->assertEquals((float) $item->daily_rate * 3, (float) $booking->subtotal);
        $this->assertEquals((float) $item->deposit_amount, (float) $booking->deposit_snapshot);
        $this->assertEquals((float) $booking->subtotal + (float) $booking->deposit_snapshot, (float) $booking->total_amount);

        $this->assertDatabaseHas('booking_status_histories', [
            'booking_id' => $booking->id,
            'from_status' => 'NEW',
            'to_status' => 'PENDING',
        ]);

        $this->assertDatabaseHas('notifications', [
            'user_id' => $booking->owner_id,
            'type' => 'BOOKING_REQUEST',
        ]);
    }

    public function test_owner_cannot_rent_own_item(): void
    {
        $item = $this->item();

        $this->actingAs($this->owner())
            ->post("/items/{$item->id}/bookings", $this->payload())
            ->assertSessionHasErrors('start_date');

        $this->assertSame(0, Booking::query()->where('item_id', $item->id)->where('status', 'PENDING')->count());
    }

    public function test_overlapping_dates_are_rejected(): void
    {
        $item = $this->item();
        $renter = $this->renter();

        $this->actingAs($renter)->post("/items/{$item->id}/bookings", $this->payload());

        $this->actingAs($renter)
            ->post("/items/{$item->id}/bookings", $this->payload('2027-01-11', '2027-01-13'))
            ->assertSessionHasErrors('start_date');

        $this->assertSame(1, Booking::query()->where('item_id', $item->id)->where('status', 'PENDING')->count());
    }

    public function test_past_date_is_rejected(): void
    {
        $item = $this->item();

        $this->actingAs($this->renter())
            ->post("/items/{$item->id}/bookings", $this->payload('2020-01-01', '2020-01-02'))
            ->assertSessionHasErrors('start_date');
    }

    public function test_owner_can_approve_pending_booking(): void
    {
        $item = $this->item();
        $renter = $this->renter();

        $this->actingAs($renter)->post("/items/{$item->id}/bookings", $this->payload());
        $booking = Booking::query()->latest('id')->firstOrFail();

        $this->actingAs($this->owner())
            ->post("/bookings/{$booking->id}/approve")
            ->assertRedirect('/bookings');

        $booking->refresh();
        $this->assertSame('APPROVED', $booking->status);
        $this->assertNotNull($booking->approved_at);

        $this->assertDatabaseHas('booking_status_histories', [
            'booking_id' => $booking->id,
            'to_status' => 'APPROVED',
        ]);

        $this->assertDatabaseHas('notifications', [
            'user_id' => $renter->id,
            'type' => 'BOOKING_APPROVED',
        ]);
    }

    public function test_owner_can_reject_with_reason(): void
    {
        $item = $this->item();
        $renter = $this->renter();

        $this->actingAs($renter)->post("/items/{$item->id}/bookings", $this->payload());
        $booking = Booking::query()->latest('id')->firstOrFail();

        $this->actingAs($this->owner())
            ->post("/bookings/{$booking->id}/reject", ['reason' => 'Barang sedang dipakai.'])
            ->assertRedirect('/bookings');

        $this->assertSame('REJECTED', $booking->fresh()->status);

        $this->assertDatabaseHas('booking_status_histories', [
            'booking_id' => $booking->id,
            'to_status' => 'REJECTED',
            'reason' => 'Barang sedang dipakai.',
        ]);
    }

    public function test_reject_requires_reason(): void
    {
        $item = $this->item();

        $this->actingAs($this->renter())->post("/items/{$item->id}/bookings", $this->payload());
        $booking = Booking::query()->latest('id')->firstOrFail();

        $this->actingAs($this->owner())
            ->post("/bookings/{$booking->id}/reject", ['reason' => ''])
            ->assertSessionHasErrors('reason');

        $this->assertSame('PENDING', $booking->fresh()->status);
    }

    public function test_non_owner_cannot_approve(): void
    {
        $item = $this->item();

        $this->actingAs($this->renter())->post("/items/{$item->id}/bookings", $this->payload());
        $booking = Booking::query()->latest('id')->firstOrFail();

        $this->actingAs($this->renter())
            ->post("/bookings/{$booking->id}/approve")
            ->assertForbidden();
    }

    public function test_renter_can_cancel_pending_booking(): void
    {
        $item = $this->item();
        $renter = $this->renter();

        $this->actingAs($renter)->post("/items/{$item->id}/bookings", $this->payload());
        $booking = Booking::query()->latest('id')->firstOrFail();

        $this->actingAs($renter)
            ->post("/bookings/{$booking->id}/cancel")
            ->assertRedirect('/bookings');

        $booking->refresh();
        $this->assertSame('CANCELLED', $booking->status);
        $this->assertNotNull($booking->cancelled_at);
    }

    public function test_approved_booking_cannot_be_approved_again(): void
    {
        $item = $this->item();
        $renter = $this->renter();

        $this->actingAs($renter)->post("/items/{$item->id}/bookings", $this->payload());
        $booking = Booking::query()->latest('id')->firstOrFail();

        $this->actingAs($this->owner())->post("/bookings/{$booking->id}/approve");
        $this->actingAs($this->owner())
            ->post("/bookings/{$booking->id}/approve")
            ->assertStatus(409);
    }

    public function test_approved_dates_become_unavailable(): void
    {
        $item = $this->item();
        $renter = $this->renter();

        $this->actingAs($renter)->post("/items/{$item->id}/bookings", $this->payload());
        $booking = Booking::query()->latest('id')->firstOrFail();
        $this->actingAs($this->owner())->post("/bookings/{$booking->id}/approve");

        $this->actingAs($renter)
            ->getJson("/items/{$item->id}/availability?start_date=2027-01-10&end_date=2027-01-11")
            ->assertJson(['available' => false]);
    }

    public function test_owner_sees_masked_nim_not_full_nim(): void
    {
        $item = $this->item();
        $renter = $this->renter();

        $this->actingAs($renter)->post("/items/{$item->id}/bookings", $this->payload());

        $nim = $renter->verification?->nim;
        $this->assertNotNull($nim, 'Data seed verifikasi harus tersedia.');

        $this->actingAs($this->owner())
            ->get('/bookings')
            ->assertOk()
            ->assertSee('NIM ******'.substr($nim, -4))
            ->assertDontSee($nim);
    }
}
