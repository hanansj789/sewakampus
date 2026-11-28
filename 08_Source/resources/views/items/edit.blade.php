@extends('layouts.app')

@section('title', 'Kelola listing')

@section('content')
    <section class="form-panel" aria-labelledby="page-title">
        <h1 id="page-title">Kelola listing</h1>
        <p class="intro">
            Status: <span class="status-badge status-{{ strtolower($item->status) }}">{{ $item->status }}</span>
            @if ($item->status === 'DRAFT')
                — tambahkan foto agar tampil di katalog.
            @endif
        </p>

        <form method="POST" action="{{ route('items.update', $item) }}" class="item-form">
            @csrf
            @method('PATCH')

            @include('items._form', ['item' => $item])

            <div class="form-actions">
                <button class="primary-action" type="submit">Simpan perubahan</button>
                <a class="secondary-action" href="{{ route('items.index', ['mine' => 1]) }}">Kembali</a>
            </div>
        </form>
    </section>

    <section class="form-panel" aria-labelledby="photos-title">
        <h2 id="photos-title">Foto barang</h2>

        @php($visiblePhotos = $item->photos->filter(fn ($photo) => \Illuminate\Support\Facades\Storage::disk('local')->exists($photo->file_path)))
        @if ($visiblePhotos->isEmpty())
            <p class="field-hint">Belum ada foto. Listing berstatus draf sampai foto pertama ditambahkan.</p>
        @else
            <ul class="photo-list">
                @foreach ($visiblePhotos as $photo)
                    <li>
                        <img src="{{ route('items.photos.show', [$item, $photo]) }}"
                             alt="Foto {{ $item->title }}" width="240" height="160" loading="lazy">
                        @if ($photo->is_primary)
                            <span class="status-badge status-active">Utama</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif

        <form method="POST" action="{{ route('items.photos.store', $item) }}" enctype="multipart/form-data" class="item-form">
            @csrf
            <div class="field">
                <label for="photo">Tambah foto</label>
                <input id="photo" name="photo" type="file" accept="image/jpeg,image/png" required
                       data-photo-input data-photo-preview="#photo-preview-edit"
                       @error('photo') aria-invalid="true" aria-describedby="photo-error" @enderror>
                <img id="photo-preview-edit" class="photo-preview" alt="Pratinjau foto yang dipilih" hidden>
                @error('photo')<p class="field-error" id="photo-error">{{ $message }}</p>@enderror
            </div>
            <button class="secondary-action" type="submit">Unggah foto</button>
        </form>
    </section>

    <section class="form-panel" aria-labelledby="status-title">
        <h2 id="status-title">Ketersediaan</h2>
        <p class="field-hint">
            {{ $item->status === 'ACTIVE'
                ? 'Listing aktif dan tampil di katalog.'
                : 'Listing tidak tampil di katalog selama dijeda atau masih draf.' }}
        </p>

        @if ($item->status !== 'DRAFT')
            <form method="POST" action="{{ route('items.pause', $item) }}">
                @csrf
                <button class="secondary-action" type="submit">
                    {{ $item->status === 'ACTIVE' ? 'Jeda listing' : 'Aktifkan lagi' }}
                </button>
            </form>
        @endif
    </section>
@endsection
