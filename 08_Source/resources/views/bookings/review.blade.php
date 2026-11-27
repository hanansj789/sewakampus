@extends('layouts.app')

@section('title', 'Beri rating')

@section('content')
    <p class="back-link"><a href="{{ route('bookings.index') }}">← Kembali ke pengajuan</a></p>

    <section class="booking-panel" aria-labelledby="page-title">
        <p class="item-meta">
            {{ $booking->item?->title }}
            <span class="status-badge status-completed">COMPLETED</span>
        </p>
        <h1 id="page-title">Beri rating</h1>
        <p class="item-detail">
            {{ $booking->start_date->format('d-m-Y') }} sampai {{ $booking->end_date->format('d-m-Y') }}
            · Anda sebagai {{ $role === 'RENTER' ? 'penyewa' : 'pemilik' }}
        </p>

        <form method="POST" action="{{ route('bookings.reviews.store', $booking) }}" class="item-form">
            @csrf

            <div class="field">
                <label for="rating">Rating</label>
                <select id="rating" name="rating" required
                        @error('rating') aria-invalid="true" aria-describedby="rating-error" @enderror>
                    <option value="">Pilih rating</option>
                    <option value="5" @selected(old('rating') === '5')>5 — sangat baik</option>
                    <option value="4" @selected(old('rating') === '4')>4 — baik</option>
                    <option value="3" @selected(old('rating') === '3')>3 — cukup</option>
                    <option value="2" @selected(old('rating') === '2')>2 — kurang</option>
                    <option value="1" @selected(old('rating') === '1')>1 — buruk</option>
                </select>
                @error('rating')<p class="field-error" id="rating-error">{{ $message }}</p>@enderror
            </div>

            <div class="field">
                <label for="comment">Komentar (opsional)</label>
                <textarea id="comment" name="comment" rows="3" maxlength="1000"
                          @error('comment') aria-invalid="true" aria-describedby="comment-error" @enderror>{{ old('comment') }}</textarea>
                @error('comment')<p class="field-error" id="comment-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-actions">
                <button class="primary-action" type="submit">Kirim rating</button>
                <a class="secondary-action" href="{{ route('bookings.index') }}">Batal</a>
            </div>
        </form>
    </section>
@endsection
