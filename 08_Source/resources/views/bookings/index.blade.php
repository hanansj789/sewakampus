@extends('layouts.app')

@section('title', 'Pengajuan sewa')

@section('content')
    <section aria-labelledby="page-title">
        <h1 id="page-title">Pengajuan sewa</h1>
        <p class="intro">Pengajuan yang Anda terima sebagai pemilik, dan yang Anda kirim sebagai penyewa.</p>
    </section>

    <section class="booking-panel" aria-labelledby="incoming-title">
        <h2 id="incoming-title">Masuk sebagai pemilik</h2>

        @if ($incoming->isEmpty())
            <p class="field-hint">Belum ada pengajuan untuk barang Anda.</p>
        @else
            <ul class="booking-list">
                @foreach ($incoming as $booking)
                    <li class="booking-card">
                        <div class="booking-main">
                            <p class="item-meta">
                                {{ $booking->item?->title }}
                                <span class="status-badge status-{{ strtolower($booking->status) }}">{{ $booking->status }}</span>
                            </p>
                            <p class="item-detail">
                                Penyewa: {{ $booking->renter?->full_name }}
                                @if ($booking->renter?->maskedNim())
                                    · NIM {{ $booking->renter->maskedNim() }}
                                @endif
                            </p>
                            <p class="item-detail">
                                {{ $booking->start_date->format('d-m-Y') }} sampai {{ $booking->end_date->format('d-m-Y') }}
                            </p>
                            <p class="item-price">
                                Total Rp{{ number_format((float) $booking->total_amount, 0, ',', '.') }}
                                <span class="deposit">Termasuk deposit Rp{{ number_format((float) $booking->deposit_snapshot, 0, ',', '.') }}</span>
                            </p>
                            @if ($booking->renter_note)
                                <p class="item-detail">Catatan: {{ $booking->renter_note }}</p>
                            @endif
                        </div>

                        @if (in_array($booking->status, ['APPROVED', 'HANDED_OVER', 'RETURNED'], true))
                            <a class="secondary-action" href="{{ route('bookings.handover', $booking) }}">Serah terima</a>
                        @endif

                        @if ($booking->status === 'COMPLETED' && ! $booking->reviews->contains('reviewer_role', 'OWNER'))
                            <a class="secondary-action" href="{{ route('bookings.reviews.create', $booking) }}">Beri rating</a>
                        @endif

                        @if ($booking->status === 'PENDING')
                            <div class="booking-actions">
                                <form method="POST" action="{{ route('bookings.approve', $booking) }}">
                                    @csrf
                                    <button class="primary-action" type="submit">Setujui</button>
                                </form>

                                <form method="POST" action="{{ route('bookings.reject', $booking) }}" class="reject-form">
                                    @csrf
                                    <label class="visually-hidden" for="reason-{{ $booking->id }}">Alasan penolakan</label>
                                    <input id="reason-{{ $booking->id }}" name="reason" type="text" maxlength="500"
                                           placeholder="Alasan penolakan" required>
                                    <button class="secondary-action" type="submit">Tolak</button>
                                </form>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </section>

    <section class="booking-panel" aria-labelledby="outgoing-title">
        <h2 id="outgoing-title">Pengajuan saya</h2>

        @if ($outgoing->isEmpty())
            <p class="field-hint">Anda belum mengajukan sewa. Buka barang di katalog untuk mengajukan.</p>
        @else
            <ul class="booking-list">
                @foreach ($outgoing as $booking)
                    <li class="booking-card">
                        <div class="booking-main">
                            <p class="item-meta">
                                {{ $booking->item?->title }}
                                <span class="status-badge status-{{ strtolower($booking->status) }}">{{ $booking->status }}</span>
                            </p>
                            <p class="item-detail">
                                Pemilik: {{ $booking->owner?->full_name }}
                                @if ($booking->owner?->maskedNim())
                                    · NIM {{ $booking->owner->maskedNim() }}
                                @endif
                            </p>
                            <p class="item-detail">
                                {{ $booking->start_date->format('d-m-Y') }} sampai {{ $booking->end_date->format('d-m-Y') }}
                            </p>
                            <p class="item-price">
                                Total Rp{{ number_format((float) $booking->total_amount, 0, ',', '.') }}
                            </p>
                        </div>

                        @if (in_array($booking->status, ['APPROVED', 'HANDED_OVER', 'RETURNED'], true))
                            <a class="secondary-action" href="{{ route('bookings.handover', $booking) }}">Serah terima</a>
                        @endif

                        @if ($booking->status === 'COMPLETED' && ! $booking->reviews->contains('reviewer_role', 'RENTER'))
                            <a class="secondary-action" href="{{ route('bookings.reviews.create', $booking) }}">Beri rating</a>
                        @endif

                        @if ($booking->status === 'PENDING')
                            <form method="POST" action="{{ route('bookings.cancel', $booking) }}">
                                @csrf
                                <button class="secondary-action" type="submit">Batalkan</button>
                            </form>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </section>
@endsection
