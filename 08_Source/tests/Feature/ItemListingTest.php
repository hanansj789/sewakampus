<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ItemListingTest extends TestCase
{
    use DatabaseTransactions;

    private function student(): User
    {
        return User::query()->where('role', 'STUDENT')->where('account_status', 'ACTIVE')->firstOrFail();
    }

    /**
     * @return array<string, mixed>
     */
    private function payload(array $overrides = []): array
    {
        $category = ItemCategory::query()->firstOrFail();

        return array_merge([
            'title' => 'Kamera uji M1',
            'description' => 'Kamera untuk pengujian listing M1.',
            'condition' => 'GOOD',
            'category_id' => $category->id,
            'daily_rate' => 50000,
            'deposit_amount' => 100000,
            'pickup_point' => 'Gedung FST Lantai 1',
        ], $overrides);
    }

    public function test_guest_cannot_open_catalog(): void
    {
        $this->get('/items')->assertRedirect('/login');
    }

    public function test_student_can_open_catalog(): void
    {
        $this->actingAs($this->student())->get('/items')->assertOk();
    }

    public function test_listing_with_photo_is_active_and_visible_in_catalog(): void
    {
        Storage::fake('local');

        $student = $this->student();

        $response = $this->actingAs($student)->post('/items', $this->payload([
            'photo' => UploadedFile::fake()->image('kamera.png', 640, 480),
        ]));

        $response->assertRedirect('/items?mine=1');

        $item = Item::query()->where('title', 'Kamera uji M1')->firstOrFail();

        $this->assertSame('ACTIVE', $item->status);
        $this->assertSame($student->id, $item->owner_id);
        $this->assertCount(1, $item->photos);
        $this->assertTrue($item->photos->first()->is_primary);
        Storage::disk('local')->assertExists($item->photos->first()->file_path);

        $this->actingAs($student)->get('/items')->assertSee('Kamera uji M1');
    }

    public function test_listing_without_photo_is_draft_and_hidden_from_catalog(): void
    {
        $student = $this->student();

        $this->actingAs($student)->post('/items', $this->payload())->assertRedirect('/items?mine=1');

        $item = Item::query()->where('title', 'Kamera uji M1')->firstOrFail();

        $this->assertSame('DRAFT', $item->status);
        $this->actingAs($student)->get('/items')->assertDontSee('Kamera uji M1');
    }

    public function test_listing_requires_valid_data(): void
    {
        $student = $this->student();

        $this->actingAs($student)
            ->post('/items', $this->payload(['title' => '', 'condition' => 'RUSAK']))
            ->assertSessionHasErrors(['title', 'condition']);

        $this->assertDatabaseMissing('items', ['title' => '']);
    }

    public function test_non_owner_cannot_edit_or_pause_listing(): void
    {
        $owner = $this->student();
        $other = User::query()->where('role', 'STUDENT')->where('id', '!=', $owner->id)->firstOrFail();

        $this->actingAs($owner)->post('/items', $this->payload());

        $item = Item::query()->where('title', 'Kamera uji M1')->firstOrFail();

        $this->actingAs($other)->get("/items/{$item->id}/edit")->assertForbidden();
        $this->actingAs($other)->post("/items/{$item->id}/pause")->assertForbidden();
    }

    public function test_non_image_upload_is_rejected(): void
    {
        Storage::fake('local');

        $student = $this->student();

        $this->actingAs($student)
            ->post('/items', $this->payload([
                'photo' => UploadedFile::fake()->create('dokumen.pdf', 100, 'application/pdf'),
            ]))
            ->assertSessionHasErrors('photo');
    }

    public function test_owner_can_pause_and_reactivate_listing(): void
    {
        Storage::fake('local');

        $student = $this->student();

        $this->actingAs($student)->post('/items', $this->payload([
            'photo' => UploadedFile::fake()->image('kamera.png', 640, 480),
        ]));

        $item = Item::query()->where('title', 'Kamera uji M1')->firstOrFail();

        $this->actingAs($student)->post("/items/{$item->id}/pause")->assertRedirect("/items/{$item->id}/edit");
        $this->assertSame('PAUSED', $item->fresh()->status);
        $this->actingAs($student)->get('/items')->assertDontSee('Kamera uji M1');

        $this->actingAs($student)->post("/items/{$item->id}/pause");
        $this->assertSame('ACTIVE', $item->fresh()->status);
    }

    public function test_owner_can_update_listing(): void
    {
        $student = $this->student();

        $this->actingAs($student)->post('/items', $this->payload());
        $item = Item::query()->where('title', 'Kamera uji M1')->firstOrFail();

        $this->actingAs($student)
            ->patch("/items/{$item->id}", $this->payload(['title' => 'Kamera uji M1 revisi']))
            ->assertRedirect("/items/{$item->id}/edit");

        $this->assertSame('Kamera uji M1 revisi', $item->fresh()->title);
    }

    public function test_student_can_open_create_form(): void
    {
        $this->actingAs($this->student())
            ->get('/items/create')
            ->assertOk()
            ->assertSee('Nama barang')
            ->assertSee('Titik serah terima');
    }

    public function test_owner_can_open_edit_form_and_see_photo(): void
    {
        Storage::fake('local');

        $student = $this->student();

        $this->actingAs($student)->post('/items', $this->payload([
            'photo' => UploadedFile::fake()->image('kamera.png', 640, 480),
        ]));

        $item = Item::query()->where('title', 'Kamera uji M1')->firstOrFail();

        $this->actingAs($student)
            ->get("/items/{$item->id}/edit")
            ->assertOk()
            ->assertSee('Kelola listing')
            ->assertSee('Utama');
    }
}
