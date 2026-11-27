<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\ItemPhoto;
use App\Services\ItemAvailabilityService;
use Carbon\CarbonImmutable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ItemController extends Controller
{
    public function index(Request $request): View
    {
        $mine = $request->boolean('mine');

        $query = Item::with(['category', 'owner', 'primaryPhoto'])->latest();

        if ($mine) {
            $query->where('owner_id', $request->user()->id);
        } else {
            $query->active();
        }

        return view('items.index', [
            'items' => $query->paginate(12)->withQueryString(),
            'mine' => $mine,
        ]);
    }

    public function show(Request $request, Item $item, ItemAvailabilityService $availability): View
    {
        if ($item->status !== 'ACTIVE' && $item->owner_id !== $request->user()->id) {
            abort(404);
        }

        $month = $request->query('month');
        $monthStart = is_string($month) && preg_match('/^\d{4}-\d{2}$/', $month) === 1
            ? CarbonImmutable::createFromFormat('Y-m-d', $month.'-01')->startOfMonth()
            : CarbonImmutable::now()->startOfMonth();

        $unavailable = $availability->unavailableDates($item, $monthStart);

        $days = [];
        $leading = $monthStart->dayOfWeekIso - 1;
        for ($i = 0; $i < $leading; $i++) {
            $days[] = null;
        }

        $cursor = $monthStart;
        while ($cursor->month === $monthStart->month) {
            $days[] = [
                'date' => $cursor->toDateString(),
                'day' => $cursor->day,
                'unavailable' => in_array($cursor->toDateString(), $unavailable, true),
                'today' => $cursor->isToday(),
            ];
            $cursor = $cursor->addDay();
        }

        while (count($days) % 7 !== 0) {
            $days[] = null;
        }

        return view('items.show', [
            'item' => $item->load('category', 'owner', 'photos'),
            'month' => $monthStart,
            'weeks' => array_chunk($days, 7),
            'previousMonth' => $monthStart->subMonth()->format('Y-m'),
            'nextMonth' => $monthStart->addMonth()->format('Y-m'),
            'isOwner' => $item->owner_id === $request->user()->id,
        ]);
    }

    public function availability(Request $request, Item $item, ItemAvailabilityService $availability): JsonResponse
    {
        $data = $request->validate([
            'start_date' => ['required', 'date_format:Y-m-d'],
            'end_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:start_date'],
        ]);

        $conflicts = $availability->conflicts($item, $data['start_date'], $data['end_date']);

        return response()->json([
            'item_public_id' => $item->public_id,
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'available' => $conflicts->isEmpty(),
            'conflicts' => $conflicts,
        ]);
    }

    public function create(): View
    {
        return view('items.create', [
            'categories' => ItemCategory::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $photo = $data['photo'] ?? null;
        unset($data['photo']);

        $item = new Item($data);
        $item->public_id = (string) Str::ulid();
        $item->owner_id = $request->user()->id;
        $item->status = 'DRAFT';
        $item->save();

        if ($photo !== null) {
            $this->savePhoto($item, $photo);
            $item->status = 'ACTIVE';
            $item->save();
        }

        $message = $photo !== null
            ? 'Listing aktif dan sudah tampil di katalog.'
            : 'Listing disimpan sebagai draf. Tambahkan foto agar tampil di katalog.';

        return redirect()->route('items.index', ['mine' => 1])->with('status', $message);
    }

    public function edit(Request $request, Item $item): View
    {
        $this->ensureOwner($request, $item);

        return view('items.edit', [
            'item' => $item->load('photos', 'category'),
            'categories' => ItemCategory::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function update(Request $request, Item $item): RedirectResponse
    {
        $this->ensureOwner($request, $item);

        $item->update($this->validated($request, withPhoto: false));

        return redirect()->route('items.edit', $item)->with('status', 'Perubahan listing tersimpan.');
    }

    public function pause(Request $request, Item $item): RedirectResponse
    {
        $this->ensureOwner($request, $item);

        $item->status = $item->status === 'ACTIVE' ? 'PAUSED' : 'ACTIVE';
        $item->save();

        $message = $item->status === 'PAUSED'
            ? 'Listing dijeda dan hilang dari katalog.'
            : 'Listing aktif kembali dan tampil di katalog.';

        return redirect()->route('items.edit', $item)->with('status', $message);
    }

    public function storePhoto(Request $request, Item $item): RedirectResponse
    {
        $this->ensureOwner($request, $item);

        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
        ]);

        $this->savePhoto($item, $request->file('photo'));

        if ($item->status === 'DRAFT') {
            $item->status = 'ACTIVE';
            $item->save();
        }

        return redirect()->route('items.edit', $item)->with('status', 'Foto ditambahkan.');
    }

    public function showPhoto(Request $request, Item $item, ItemPhoto $photo): StreamedResponse
    {
        abort_unless($photo->item_id === $item->id, 404);
        abort_unless(Storage::disk('local')->exists($photo->file_path), 404);

        return Storage::disk('local')->response($photo->file_path);
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request, bool $withPhoto = true): array
    {
        $rules = [
            'title' => ['required', 'string', 'max:120'],
            'description' => ['required', 'string', 'max:2000'],
            'condition' => ['required', Rule::in(['NEW', 'GOOD', 'FAIR'])],
            'category_id' => ['required', 'integer', 'exists:item_categories,id'],
            'daily_rate' => ['required', 'numeric', 'min:0', 'max:9999999999.99'],
            'deposit_amount' => ['required', 'numeric', 'min:0', 'max:9999999999.99'],
            'pickup_point' => ['required', 'string', 'max:120'],
        ];

        if ($withPhoto) {
            $rules['photo'] = ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'];
        }

        return $request->validate($rules);
    }

    private function ensureOwner(Request $request, Item $item): void
    {
        abort_unless($item->owner_id === $request->user()->id, 403);
    }

    private function savePhoto(Item $item, $file): void
    {
        $path = $file->store('items/'.$item->id, 'local');
        $count = $item->photos()->count();

        ItemPhoto::query()->create([
            'item_id' => $item->id,
            'file_path' => $path,
            'alt_text' => $item->title,
            'sort_order' => $count,
            'is_primary' => $count === 0,
        ]);
    }
}
