@php($item = $item ?? null)

<div class="field">
    <label for="title">Nama barang</label>
    <input id="title" name="title" type="text" maxlength="120" required
           value="{{ old('title', $item?->title) }}"
           @error('title') aria-invalid="true" aria-describedby="title-error" @enderror>
    @error('title')<p class="field-error" id="title-error">{{ $message }}</p>@enderror
</div>

<div class="field">
    <label for="description">Deskripsi dan kondisi</label>
    <textarea id="description" name="description" rows="4" maxlength="2000" required
              @error('description') aria-invalid="true" aria-describedby="description-error" @enderror>{{ old('description', $item?->description) }}</textarea>
    @error('description')<p class="field-error" id="description-error">{{ $message }}</p>@enderror
</div>

<div class="field-row">
    <div class="field">
        <label for="category_id">Kategori</label>
        <select id="category_id" name="category_id" required
                @error('category_id') aria-invalid="true" aria-describedby="category-error" @enderror>
            <option value="">Pilih kategori</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected((int) old('category_id', $item?->category_id) === $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')<p class="field-error" id="category-error">{{ $message }}</p>@enderror
    </div>

    <div class="field">
        <label for="condition">Kondisi</label>
        <select id="condition" name="condition" required
                @error('condition') aria-invalid="true" aria-describedby="condition-error" @enderror>
            <option value="NEW" @selected(old('condition', $item?->condition) === 'NEW')>Baru</option>
            <option value="GOOD" @selected(old('condition', $item?->condition) === 'GOOD')>Baik</option>
            <option value="FAIR" @selected(old('condition', $item?->condition) === 'FAIR')>Cukup</option>
        </select>
        @error('condition')<p class="field-error" id="condition-error">{{ $message }}</p>@enderror
    </div>
</div>

<div class="field-row">
    <div class="field">
        <label for="daily_rate">Harga per hari (Rp)</label>
        <input id="daily_rate" name="daily_rate" type="number" min="0" step="1000" required
               value="{{ old('daily_rate', $item?->daily_rate) }}"
               @error('daily_rate') aria-invalid="true" aria-describedby="rate-error" @enderror>
        @error('daily_rate')<p class="field-error" id="rate-error">{{ $message }}</p>@enderror
    </div>

    <div class="field">
        <label for="deposit_amount">Deposit (Rp)</label>
        <input id="deposit_amount" name="deposit_amount" type="number" min="0" step="1000" required
               value="{{ old('deposit_amount', $item?->deposit_amount) }}"
               @error('deposit_amount') aria-invalid="true" aria-describedby="deposit-error" @enderror>
        @error('deposit_amount')<p class="field-error" id="deposit-error">{{ $message }}</p>@enderror
    </div>
</div>

<div class="field">
    <label for="pickup_point">Titik serah terima</label>
    <input id="pickup_point" name="pickup_point" type="text" maxlength="120" required
           value="{{ old('pickup_point', $item?->pickup_point) }}"
           placeholder="Contoh: Gedung FST Lantai 1"
           @error('pickup_point') aria-invalid="true" aria-describedby="pickup-error" @enderror>
    @error('pickup_point')<p class="field-error" id="pickup-error">{{ $message }}</p>@enderror
</div>
