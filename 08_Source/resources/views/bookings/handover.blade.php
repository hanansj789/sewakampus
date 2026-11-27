@extends('layouts.app')

@section('title', 'Serah terima')

@section('content')
    <p class="back-link"><a href="{{ route('bookings.index') }}">← Kembali ke pengajuan</a></p>

    <section class="booking-panel" aria-labelledby="page-title">
        <p class="item-meta">
            {{ $booking->item?->title }}
            <span class="status-badge status-{{ strtolower($booking->status) }}">{{ $booking->status }}</span>
        </p>
        <h1 id="page-title">Serah terima</h1>
        <p class="item-detail">
            {{ $booking->start_date->format('d-m-Y') }} sampai {{ $booking->end_date->format('d-m-Y') }}
            · {{ $booking->pickup_point }}
        </p>
        <p class="item-detail">
            Penyewa: {{ $booking->renter?->full_name }} · Pemilik: {{ $booking->owner?->full_name }}
        </p>
        <p class="item-price">Total Rp{{ number_format((float) $booking->total_amount, 0, ',', '.') }}</p>
    </section>

    @foreach ($handovers as $handover)
        <section class="booking-panel" aria-labelledby="handover-{{ $handover->id }}">
            <h2 id="handover-{{ $handover->id }}">
                {{ $handover->direction === 'OUT' ? 'Serah terima barang' : 'Pengembalian barang' }}
            </h2>

            <ul class="photo-list">
                <li>
                    <img src="{{ route('bookings.handovers.photo', [$booking, $handover]) }}"
                         alt="Foto kondisi {{ $handover->direction === 'OUT' ? 'serah terima' : 'pengembalian' }}"
                         width="320" height="213" loading="lazy">
                </li>
            </ul>

            <p class="item-detail">Lokasi: {{ $handover->location }}</p>
            @if ($handover->condition_notes)
                <p class="item-detail">Catatan kondisi: {{ $handover->condition_notes }}</p>
            @endif

            <ul class="confirm-list">
                <li>Penyewa: {{ $handover->renter_confirmed_at ? 'sudah konfirmasi' : 'belum konfirmasi' }}</li>
                <li>Pemilik: {{ $handover->owner_confirmed_at ? 'sudah konfirmasi' : 'belum konfirmasi' }}</li>
            </ul>

            @php($myConfirmed = $isRenter ? $handover->renter_confirmed_at : $handover->owner_confirmed_at)
            @if (! $handover->confirmedByBothParties() && $myConfirmed === null)
                <form method="POST" action="{{ route('bookings.handovers.confirm', [$booking, $handover]) }}">
                    @csrf
                    <button class="primary-action" type="submit">Konfirmasi</button>
                </form>
            @endif
        </section>
    @endforeach

    @if ($canCreateOut)
        <section class="booking-panel" aria-labelledby="out-title">
            <h2 id="out-title">Catat serah terima</h2>
            <p class="field-hint">Foto kondisi wajib. Setelah kedua pihak mengonfirmasi, status berubah menjadi diserahkan.</p>

            <form method="POST" action="{{ route('bookings.handovers.store', $booking) }}" enctype="multipart/form-data" class="item-form">
                @csrf
                <div class="field">
                    <label for="out-location">Lokasi serah terima</label>
                    <input id="out-location" name="location" type="text" maxlength="120" required value="{{ old('location', $booking->pickup_point) }}">
                </div>
                <div class="field">
                    <label for="out-notes">Catatan kondisi (opsional)</label>
                    <textarea id="out-notes" name="condition_notes" rows="2" maxlength="1000">{{ old('condition_notes') }}</textarea>
                </div>
                <div class="field">
                    <label for="out-photo">Foto kondisi</label>
                    <input id="out-photo" name="photo" type="file" accept="image/jpeg,image/png" required>
                    @error('photo')<p class="field-error">{{ $message }}</p>@enderror
                </div>
                <button class="primary-action" type="submit">Simpan serah terima</button>
            </form>
        </section>
    @endif

    @if ($canCreateReturn)
        <section class="booking-panel" aria-labelledby="return-title">
            <h2 id="return-title">Catat pengembalian</h2>
            <p class="field-hint">Foto kondisi akhir wajib. Keterlambatan dihitung dari tanggal selesai.</p>

            <form method="POST" action="{{ route('bookings.handovers.store', $booking) }}" enctype="multipart/form-data" class="item-form">
                @csrf
                <div class="field">
                    <label for="return-location">Lokasi pengembalian</label>
                    <input id="return-location" name="location" type="text" maxlength="120" required value="{{ old('location', $booking->pickup_point) }}">
                </div>
                <div class="field">
                    <label for="return-notes">Catatan kondisi (opsional)</label>
                    <textarea id="return-notes" name="condition_notes" rows="2" maxlength="1000">{{ old('condition_notes') }}</textarea>
                </div>
                <div class="field">
                    <label for="return-photo">Foto kondisi</label>
                    <input id="return-photo" name="photo" type="file" accept="image/jpeg,image/png" required>
                    @error('photo')<p class="field-error">{{ $message }}</p>@enderror
                </div>
                <button class="primary-action" type="submit">Simpan pengembalian</button>
            </form>
        </section>
    @endif

    @if ($booking->status === 'RETURNED')
        <section class="booking-panel" aria-labelledby="complete-title">
            <h2 id="complete-title">Selesaikan transaksi</h2>
            <p class="field-hint">Setelah transaksi selesai, deposit simulasi dikembalikan dan rating bisa diberikan.</p>
            <form method="POST" action="{{ route('bookings.complete', $booking) }}">
                @csrf
                <button class="primary-action" type="submit">Tandai selesai</button>
            </form>
        </section>
    @endif
@endsection
