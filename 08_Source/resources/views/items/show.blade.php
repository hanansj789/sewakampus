@extends('layouts.app')

@section('title', $item->title)

@section('content')
    <p class="back-link"><a href="{{ route('items.index') }}">← Kembali ke katalog</a></p>

    <section class="detail-panel" aria-labelledby="page-title">
        <div class="detail-head">
            <div>
                <p class="item-meta">
                    {{ $item->category?->name ?? 'Tanpa kategori' }}
                    <span class="status-badge status-{{ strtolower($item->status) }}">{{ $item->status }}</span>
                </p>
                <h1 id="page-title">{{ $item->title }}</h1>
                <p class="item-detail">Pemilik: {{ $item->owner?->full_name ?? 'Tidak diketahui' }}</p>
                <p class="item-detail">Serah terima: {{ $item->pickup_point }}</p>
            </div>

            <div class="detail-price">
                <p class="item-price">Rp{{ number_format((float) $item->daily_rate, 0, ',', '.') }} / hari</p>
                <p class="deposit">Deposit Rp{{ number_format((float) $item->deposit_amount, 0, ',', '.') }}</p>
                @if ($isOwner)
                    <a class="secondary-action" href="{{ route('items.edit', $item) }}">Kelola listing</a>
                @endif
            </div>
        </div>

        <p class="detail-description">{{ $item->description }}</p>

        @php($visiblePhotos = $item->photos->filter(fn ($photo) => \Illuminate\Support\Facades\Storage::disk('local')->exists($photo->file_path)))
        @if ($visiblePhotos->isNotEmpty())
            <ul class="detail-gallery">
                @foreach ($visiblePhotos as $photo)
                    <li>
                        <img src="{{ route('items.photos.show', [$item, $photo]) }}"
                             alt="Foto {{ $item->title }}" width="480" height="320" loading="lazy">
                    </li>
                @endforeach
            </ul>
        @else
            <p class="field-hint">Foto belum tersedia untuk listing ini.</p>
        @endif
    </section>

    <section class="calendar-panel" aria-labelledby="calendar-title">
        <div class="calendar-head">
            <h2 id="calendar-title">Ketersediaan</h2>

            <nav class="calendar-nav" aria-label="Pindah bulan">
                <a class="secondary-action" href="{{ route('items.show', ['item' => $item, 'month' => $previousMonth]) }}">Bulan sebelumnya</a>
                <span class="calendar-month">{{ $month->locale('id')->translatedFormat('F Y') }}</span>
                <a class="secondary-action" href="{{ route('items.show', ['item' => $item, 'month' => $nextMonth]) }}">Bulan berikutnya</a>
            </nav>
        </div>

        <ol class="calendar-weekdays" aria-hidden="true">
            @foreach (['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $dayName)
                <li>{{ $dayName }}</li>
            @endforeach
        </ol>

        <ol class="calendar-grid">
            @foreach ($weeks as $week)
                @foreach ($week as $day)
                    @if ($day === null)
                        <li class="calendar-day is-empty" aria-hidden="true"></li>
                    @else
                        <li @class([
                                'calendar-day',
                                'is-unavailable' => $day['unavailable'],
                                'is-free' => ! $day['unavailable'],
                                'is-today' => $day['today'],
                            ])
                            data-date="{{ $day['date'] }}"@if ($day['unavailable']) data-unavailable="1"@endif
                            aria-label="{{ $day['date'] }} {{ $day['unavailable'] ? 'tidak tersedia' : 'tersedia' }}">
                            <span>{{ $day['day'] }}</span>
                        </li>
                    @endif
                @endforeach
            @endforeach
        </ol>

        <ul class="calendar-legend">
            <li><span class="legend-swatch is-free"></span> Tersedia</li>
            <li><span class="legend-swatch is-unavailable"></span> Terisi atau diblokir</li>
            <li><span class="legend-swatch is-today"></span> Hari ini</li>
        </ul>

        <p class="field-hint">
            Tanggal terisi berasal dari booking yang masih berjalan dan blokir pemilik.
            Pengajuan sewa belum dibuka pada tahap ini.
        </p>
    </section>
@endsection
