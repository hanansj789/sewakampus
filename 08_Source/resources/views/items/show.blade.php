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
        </p>
    </section>

    @if (! $isOwner && $item->status === 'ACTIVE')
        <section class="booking-panel" aria-labelledby="booking-title">
            <h2 id="booking-title">Ajukan sewa</h2>
            <p class="field-hint">Pilih rentang tanggal. Pengajuan diteruskan ke pemilik untuk diputuskan.</p>

            <form method="POST" action="{{ route('bookings.store', $item) }}" class="item-form">
                @csrf

                <div class="field-row">
                    <div class="field">
                        <label for="start_date">Tanggal mulai</label>
                        <input id="start_date" name="start_date" type="date" required
                               value="{{ old('start_date') }}"
                               @error('start_date') aria-invalid="true" aria-describedby="start-error" @enderror>
                        @error('start_date')<p class="field-error" id="start-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="field">
                        <label for="end_date">Tanggal selesai</label>
                        <input id="end_date" name="end_date" type="date" required
                               value="{{ old('end_date') }}"
                               @error('end_date') aria-invalid="true" aria-describedby="end-error" @enderror>
                        @error('end_date')<p class="field-error" id="end-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="field">
                    <label for="renter_note">Catatan untuk pemilik (opsional)</label>
                    <textarea id="renter_note" name="renter_note" rows="2" maxlength="500"
                              @error('renter_note') aria-invalid="true" aria-describedby="note-error" @enderror>{{ old('renter_note') }}</textarea>
                    @error('renter_note')<p class="field-error" id="note-error">{{ $message }}</p>@enderror
                </div>

                <button class="primary-action" type="submit">Kirim pengajuan</button>
            </form>
        </section>
    @endif
@endsection
