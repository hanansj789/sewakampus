@extends('layouts.app')

@section('title', 'Tambah barang')

@section('content')
    <section class="form-panel" aria-labelledby="page-title">
        <h1 id="page-title">Tambah barang</h1>
        <p class="intro">Listing dengan foto langsung tampil di katalog. Tanpa foto, listing disimpan sebagai draf.</p>

        <form method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data" class="item-form">
            @csrf

            @include('items._form', ['item' => null])

            <div class="field">
                <label for="photo">Foto barang</label>
                <input id="photo" name="photo" type="file" accept="image/jpeg,image/png"
                       data-photo-input data-photo-preview="#photo-preview-create"
                       @error('photo') aria-invalid="true" aria-describedby="photo-error" @enderror>
                <img id="photo-preview-create" class="photo-preview" alt="Pratinjau foto yang dipilih" hidden>
                <p class="field-hint">JPG atau PNG, maksimal 5 MB. Foto pertama menjadi foto utama.</p>
                @error('photo')<p class="field-error" id="photo-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-actions">
                <button class="primary-action" type="submit">Simpan listing</button>
                <a class="secondary-action" href="{{ route('items.index', ['mine' => 1]) }}">Batal</a>
            </div>
        </form>
    </section>
@endsection
