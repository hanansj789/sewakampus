@extends('layouts.app')

@section('title', $mine ? 'Barang saya' : 'Katalog')

@section('content')
    <section aria-labelledby="page-title">
        <div class="page-heading">
            <div>
                <h1 id="page-title">{{ $mine ? 'Barang saya' : 'Katalog barang' }}</h1>
                <p class="intro">
                    {{ $mine
                        ? 'Semua listing milik Anda, termasuk draf dan yang dijeda.'
                        : 'Barang yang sedang tersedia untuk disewa di kampus.' }}
                </p>
            </div>

            <nav class="filter-tabs" aria-label="Saringan katalog">
                <a href="{{ route('items.index') }}" @class(['is-current' => ! $mine])>Semua barang</a>
                <a href="{{ route('items.index', ['mine' => 1]) }}" @class(['is-current' => $mine])>Milik saya</a>
            </nav>
        </div>

        @if ($items->isEmpty())
            <div class="empty-state">
                <p>{{ $mine ? 'Belum ada listing milik Anda.' : 'Belum ada barang yang aktif di katalog.' }}</p>
                <a class="primary-action" href="{{ route('items.create') }}">Tambah barang pertama</a>
            </div>
        @else
            <ul class="item-grid">
                @foreach ($items as $item)
                    <li class="item-card">
                        <div class="item-photo">
                            @php($primary = $item->primaryPhoto)
                            @if ($primary && \Illuminate\Support\Facades\Storage::disk('local')->exists($primary->file_path))
                                <img src="{{ route('items.photos.show', [$item, $primary]) }}"
                                     alt="Foto {{ $item->title }}" width="640" height="420" loading="lazy">
                            @else
                                <span class="photo-placeholder">Belum ada foto</span>
                            @endif
                        </div>

                        <div class="item-body">
                            <p class="item-meta">
                                {{ $item->category?->name ?? 'Tanpa kategori' }}
                                @if ($mine)
                                    <span class="status-badge status-{{ strtolower($item->status) }}">{{ $item->status }}</span>
                                @endif
                            </p>

                            <h2 class="item-title">
                                <a href="{{ route('items.show', $item) }}">{{ $item->title }}</a>
                            </h2>

                            <p class="item-price">
                                Rp{{ number_format((float) $item->daily_rate, 0, ',', '.') }} / hari
                                <span class="deposit">Deposit Rp{{ number_format((float) $item->deposit_amount, 0, ',', '.') }}</span>
                            </p>

                            <p class="item-detail">Serah terima: {{ $item->pickup_point }}</p>
                            <p class="item-detail">Pemilik: {{ $item->owner?->full_name ?? 'Tidak diketahui' }}</p>

                            @if ($mine)
                                <a class="secondary-action" href="{{ route('items.edit', $item) }}">Kelola listing</a>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="pagination-wrap">{{ $items->links() }}</div>
        @endif
    </section>
@endsection
