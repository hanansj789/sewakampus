<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ItemAvailabilityTest extends TestCase
{
    use DatabaseTransactions;

    private function student(): User
    {
        return User::query()->where('role', 'STUDENT')->where('account_status', 'ACTIVE')->firstOrFail();
    }

    private function otherStudent(): User
    {
        $first = $this->student();

        return User::query()
            ->where('role', 'STUDENT')
            ->where('account_status', 'ACTIVE')
            ->where('id', '!=', $first->id)
            ->firstOrFail();
    }

    private function listedItem(): Item
    {
        return Item::query()->where('status', 'ACTIVE')->orderBy('id')->firstOrFail();
    }

    public function test_detail_page_shows_calendar_for_the_month(): void
    {
        $item = $this->listedItem();

        $this->actingAs($this->student())
            ->get("/items/{$item->id}?month=2026-12")
            ->assertOk()
            ->assertSee('Desember 2026')
            ->assertSee('data-date="2026-12-01"', false);
    }

    public function test_booked_date_is_marked_unavailable(): void
    {
        $item = $this->listedItem();

        $this->actingAs($this->student())
            ->get("/items/{$item->id}?month=2026-12")
            ->assertSee('data-date="2026-12-01" data-unavailable="1"', false);
    }

    public function test_blocked_date_is_marked_unavailable(): void
    {
        $item = $this->listedItem();

        $this->actingAs($this->student())
            ->get("/items/{$item->id}?month=2026-12")
            ->assertSee('data-date="2026-12-24" data-unavailable="1"', false);
    }

    public function test_free_date_is_not_marked_unavailable(): void
    {
        $item = $this->listedItem();

        $this->actingAs($this->student())
            ->get("/items/{$item->id}?month=2026-12")
            ->assertSee('data-date="2026-12-04"', false)
            ->assertDontSee('data-date="2026-12-04" data-unavailable="1"', false);
    }

    public function test_range_overlapping_booking_is_not_available(): void
    {
        $item = $this->listedItem();

        $this->actingAs($this->student())
            ->getJson("/items/{$item->id}/availability?start_date=2026-12-01&end_date=2026-12-02")
            ->assertOk()
            ->assertJson(['available' => false])
            ->assertJsonPath('conflicts.0.type', 'BOOKING');
    }

    public function test_range_touching_last_booked_day_is_not_available(): void
    {
        $item = $this->listedItem();

        $this->actingAs($this->student())
            ->getJson("/items/{$item->id}/availability?start_date=2026-12-03&end_date=2026-12-04")
            ->assertOk()
            ->assertJson(['available' => false]);
    }

    public function test_range_after_booking_is_available(): void
    {
        $item = $this->listedItem();

        $this->actingAs($this->student())
            ->getJson("/items/{$item->id}/availability?start_date=2026-12-04&end_date=2026-12-05")
            ->assertOk()
            ->assertJson(['available' => true]);
    }

    public function test_range_overlapping_owner_block_is_not_available(): void
    {
        $item = $this->listedItem();

        $this->actingAs($this->student())
            ->getJson("/items/{$item->id}/availability?start_date=2026-12-25&end_date=2026-12-27")
            ->assertOk()
            ->assertJson(['available' => false])
            ->assertJsonPath('conflicts.0.type', 'BLOCKED');
    }

    public function test_invalid_date_range_is_rejected(): void
    {
        $item = $this->listedItem();

        $this->actingAs($this->student())
            ->getJson("/items/{$item->id}/availability?start_date=2026-12-10&end_date=2026-12-05")
            ->assertStatus(422);
    }

    public function test_draft_listing_is_hidden_from_other_students(): void
    {
        $owner = $this->student();
        $other = $this->otherStudent();

        $item = Item::query()->where('owner_id', $owner->id)->first();

        if ($item === null) {
            $this->markTestSkipped('Tidak ada listing milik pengguna pertama pada data seed.');
        }

        $item->status = 'DRAFT';
        $item->save();

        $this->actingAs($other)->get("/items/{$item->id}")->assertNotFound();
        $this->actingAs($owner)->get("/items/{$item->id}")->assertOk();
    }
}
