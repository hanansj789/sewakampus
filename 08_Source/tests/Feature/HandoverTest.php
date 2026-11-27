<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Deposit;
use App\Models\Handover;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HandoverTest extends TestCase
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

    private function approvedBooking(): Booking
    {
        $item = $this->item();
        $renter = $this->renter();

        $this->actingAs($renter)->post("/items/{$item->id}/bookings", [
            'start_date' => '2027-02-10',
            'end_date' => '2027-02-12',
        ]);

        $booking = Booking::query()->latest('id')->firstOrFail();

        $this->actingAs($this->owner())->post("/bookings/{$booking->id}/approve");

        return $booking->fresh();
    }

    private function photo(string $name = 'kondisi.png'): UploadedFile
    {
        return UploadedFile::fake()->image($name, 640, 480);
    }

    public function test_guest_cannot_open_handover_page(): void
    {
        $booking = $this->approvedBooking();

        auth()->logout();
        $this->app['auth']->forgetGuards();

        $this->get("/bookings/{$booking->id}/handover")->assertRedirect('/login');
    }

    public function test_renter_can_create_out_handover_with_photo(): void
    {
        Storage::fake('local');

        $booking = $this->approvedBooking();

        $this->actingAs($this->renter())
            ->post("/bookings/{$booking->id}/handovers", [
                'location' => 'Gedung FST Lantai 1',
                'condition_notes' => 'Lensa mulus tanpa jamur.',
                'photo' => $this->photo(),
            ])
            ->assertRedirect("/bookings/{$booking->id}/handover");

        $handover = Handover::query()->where('booking_id', $booking->id)->firstOrFail();

        $this->assertSame('OUT', $handover->direction);
        $this->assertNotNull($handover->renter_confirmed_at);
        $this->assertNull($handover->owner_confirmed_at);
        Storage::disk('local')->assertExists($handover->photo_path);
        $this->assertSame('APPROVED', $booking->fresh()->status);
    }

    public function test_handover_requires_photo(): void
    {
        Storage::fake('local');

        $booking = $this->approvedBooking();

        $this->actingAs($this->renter())
            ->post("/bookings/{$booking->id}/handovers", [
                'location' => 'Gedung FST Lantai 1',
            ])
            ->assertSessionHasErrors('photo');

        $this->assertSame(0, Handover::query()->where('booking_id', $booking->id)->count());
    }

    public function test_non_party_cannot_create_handover(): void
    {
        Storage::fake('local');

        $booking = $this->approvedBooking();

        $outsider = User::query()
            ->where('role', 'STUDENT')
            ->whereNotIn('id', [$booking->renter_id, $booking->owner_id])
            ->firstOrFail();

        $this->actingAs($outsider)
            ->post("/bookings/{$booking->id}/handovers", [
                'location' => 'Tempat lain',
                'photo' => $this->photo(),
            ])
            ->assertForbidden();
    }

    public function test_out_handover_requires_approved_booking(): void
    {
        Storage::fake('local');

        $item = $this->item();
        $renter = $this->renter();

        $this->actingAs($renter)->post("/items/{$item->id}/bookings", [
            'start_date' => '2027-02-10',
            'end_date' => '2027-02-12',
        ]);
        $booking = Booking::query()->latest('id')->firstOrFail();

        $this->actingAs($renter)
            ->post("/bookings/{$booking->id}/handovers", [
                'location' => 'Gedung FST Lantai 1',
                'photo' => $this->photo(),
            ])
            ->assertStatus(409);
    }

    public function test_owner_confirmation_moves_booking_to_handed_over(): void
    {
        Storage::fake('local');

        $booking = $this->approvedBooking();

        $this->actingAs($this->renter())->post("/bookings/{$booking->id}/handovers", [
            'location' => 'Gedung FST Lantai 1',
            'photo' => $this->photo(),
        ]);
        $handover = Handover::query()->where('booking_id', $booking->id)->firstOrFail();

        $this->actingAs($this->owner())
            ->post("/bookings/{$booking->id}/handovers/{$handover->id}/confirm")
            ->assertRedirect("/bookings/{$booking->id}/handover");

        $handover->refresh();
        $this->assertNotNull($handover->owner_confirmed_at);
        $this->assertTrue($handover->confirmedByBothParties());
        $this->assertSame('HANDED_OVER', $booking->fresh()->status);
        $this->assertDatabaseHas('booking_status_histories', [
            'booking_id' => $booking->id,
            'to_status' => 'HANDED_OVER',
        ]);
    }

    public function test_duplicate_out_handover_is_rejected(): void
    {
        Storage::fake('local');

        $booking = $this->approvedBooking();

        $this->actingAs($this->renter())->post("/bookings/{$booking->id}/handovers", [
            'location' => 'Gedung FST Lantai 1',
            'photo' => $this->photo(),
        ]);

        $this->actingAs($this->owner())
            ->post("/bookings/{$booking->id}/handovers", [
                'location' => 'Gedung FST Lantai 1',
                'photo' => $this->photo('kedua.png'),
            ])
            ->assertStatus(409);
    }

    public function test_third_handover_is_rejected_after_both_directions_exist(): void
    {
        Storage::fake('local');

        $booking = $this->approvedBooking();

        $this->actingAs($this->renter())->post("/bookings/{$booking->id}/handovers", [
            'location' => 'Gedung FST Lantai 1',
            'photo' => $this->photo('out.png'),
        ]);
        $out = Handover::query()->where('booking_id', $booking->id)->firstOrFail();
        $this->actingAs($this->owner())->post("/bookings/{$booking->id}/handovers/{$out->id}/confirm");

        $this->actingAs($this->renter())->post("/bookings/{$booking->id}/handovers", [
            'location' => 'Gedung FST Lantai 1',
            'photo' => $this->photo('return.png'),
        ]);
        $return = Handover::query()->where('booking_id', $booking->id)->where('direction', 'RETURN')->firstOrFail();
        $this->actingAs($this->owner())->post("/bookings/{$booking->id}/handovers/{$return->id}/confirm");

        $this->actingAs($this->renter())
            ->post("/bookings/{$booking->id}/handovers", [
                'location' => 'Gedung FST Lantai 1',
                'photo' => $this->photo('ketiga.png'),
            ])
            ->assertStatus(409);
    }

    public function test_return_and_confirmation_move_booking_to_returned(): void
    {
        Storage::fake('local');

        $booking = $this->approvedBooking();

        $this->actingAs($this->renter())->post("/bookings/{$booking->id}/handovers", [
            'location' => 'Gedung FST Lantai 1',
            'photo' => $this->photo('out.png'),
        ]);
        $out = Handover::query()->where('booking_id', $booking->id)->firstOrFail();
        $this->actingAs($this->owner())->post("/bookings/{$booking->id}/handovers/{$out->id}/confirm");

        $this->actingAs($this->renter())->post("/bookings/{$booking->id}/handovers", [
            'location' => 'Gedung FST Lantai 1',
            'condition_notes' => 'Kembali lengkap.',
            'photo' => $this->photo('return.png'),
        ]);

        $return = Handover::query()->where('booking_id', $booking->id)->where('direction', 'RETURN')->firstOrFail();
        $this->actingAs($this->owner())->post("/bookings/{$booking->id}/handovers/{$return->id}/confirm");

        $this->assertSame('RETURNED', $booking->fresh()->status);
    }

    public function test_late_return_is_noted_in_history(): void
    {
        Storage::fake('local');

        $booking = $this->approvedBooking();

        $this->actingAs($this->renter())->post("/bookings/{$booking->id}/handovers", [
            'location' => 'Gedung FST Lantai 1',
            'photo' => $this->photo('out.png'),
        ]);
        $out = Handover::query()->where('booking_id', $booking->id)->firstOrFail();
        $this->actingAs($this->owner())->post("/bookings/{$booking->id}/handovers/{$out->id}/confirm");

        $booking->refresh();
        $booking->start_date = now()->subDays(5)->toDateString();
        $booking->end_date = now()->subDays(2)->toDateString();
        $booking->save();

        $this->actingAs($this->renter())->post("/bookings/{$booking->id}/handovers", [
            'location' => 'Gedung FST Lantai 1',
            'photo' => $this->photo('return.png'),
        ]);
        $return = Handover::query()->where('booking_id', $booking->id)->where('direction', 'RETURN')->firstOrFail();
        $this->actingAs($this->owner())->post("/bookings/{$booking->id}/handovers/{$return->id}/confirm");

        $history = $booking->fresh()->statusHistory()->where('to_status', 'RETURNED')->firstOrFail();
        $this->assertStringContainsString('terlambat', (string) $history->reason);
    }

    public function test_transaction_can_be_completed_after_return(): void
    {
        Storage::fake('local');

        $booking = $this->approvedBooking();

        $this->actingAs($this->renter())->post("/bookings/{$booking->id}/handovers", [
            'location' => 'Gedung FST Lantai 1',
            'photo' => $this->photo('out.png'),
        ]);
        $out = Handover::query()->where('booking_id', $booking->id)->firstOrFail();
        $this->actingAs($this->owner())->post("/bookings/{$booking->id}/handovers/{$out->id}/confirm");

        $this->actingAs($this->renter())->post("/bookings/{$booking->id}/handovers", [
            'location' => 'Gedung FST Lantai 1',
            'photo' => $this->photo('return.png'),
        ]);
        $return = Handover::query()->where('booking_id', $booking->id)->where('direction', 'RETURN')->firstOrFail();
        $this->actingAs($this->owner())->post("/bookings/{$booking->id}/handovers/{$return->id}/confirm");

        Deposit::query()->create([
            'public_id' => (string) \Illuminate\Support\Str::ulid(),
            'booking_id' => $booking->id,
            'amount' => 100000,
            'status' => 'HELD',
            'method' => 'SIMULATED',
            'paid_at' => now(),
        ]);

        $this->actingAs($this->renter())
            ->post("/bookings/{$booking->id}/complete")
            ->assertRedirect("/bookings/{$booking->id}/handover");

        $this->assertSame('COMPLETED', $booking->fresh()->status);
        $this->assertDatabaseHas('deposits', [
            'booking_id' => $booking->id,
            'status' => 'REFUNDED',
        ]);
    }

    public function test_cannot_complete_before_return(): void
    {
        $booking = $this->approvedBooking();

        $this->actingAs($this->renter())
            ->post("/bookings/{$booking->id}/complete")
            ->assertStatus(409);
    }

    public function test_cannot_confirm_twice(): void
    {
        Storage::fake('local');

        $booking = $this->approvedBooking();

        $this->actingAs($this->renter())->post("/bookings/{$booking->id}/handovers", [
            'location' => 'Gedung FST Lantai 1',
            'photo' => $this->photo(),
        ]);
        $handover = Handover::query()->where('booking_id', $booking->id)->firstOrFail();

        $this->actingAs($this->owner())->post("/bookings/{$booking->id}/handovers/{$handover->id}/confirm");

        $this->actingAs($this->owner())
            ->post("/bookings/{$booking->id}/handovers/{$handover->id}/confirm")
            ->assertStatus(409);
    }

    public function test_handover_page_shows_out_form_for_approved_booking(): void
    {
        $booking = $this->approvedBooking();

        $this->actingAs($this->renter())
            ->get("/bookings/{$booking->id}/handover")
            ->assertOk()
            ->assertSee('Catat serah terima')
            ->assertSee('Foto kondisi');
    }

    public function test_handover_page_shows_confirm_button_for_other_party(): void
    {
        Storage::fake('local');

        $booking = $this->approvedBooking();

        $this->actingAs($this->renter())->post("/bookings/{$booking->id}/handovers", [
            'location' => 'Gedung FST Lantai 1',
            'photo' => $this->photo(),
        ]);

        $this->actingAs($this->owner())
            ->get("/bookings/{$booking->id}/handover")
            ->assertOk()
            ->assertSee('Konfirmasi');
    }
}
