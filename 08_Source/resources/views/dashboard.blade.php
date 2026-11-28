@extends('layouts.app')

@section('title', $pageRole === 'ADMIN' ? 'Area admin' : 'Area mahasiswa')

@section('content')
    <section class="form-panel" aria-labelledby="page-title">
        <h1 id="page-title">{{ $pageRole === 'ADMIN' ? 'Area admin' : 'Area mahasiswa' }}</h1>
        <p class="intro">{{ auth()->user()->full_name }}</p>
        <p class="role-line">Peran akun: <strong>{{ $pageRole === 'ADMIN' ? 'Admin' : 'Mahasiswa' }}</strong></p>

        @if ($pageRole === 'STUDENT')
            <p class="field-hint">Mulai dari katalog untuk mencari barang, atau tambahkan barang yang ingin Anda sewakan.</p>
            <div class="form-actions">
                <a class="primary-action" href="{{ route('items.index') }}">Buka katalog</a>
                <a class="secondary-action" href="{{ route('items.create') }}">Tambah barang</a>
                <a class="secondary-action" href="{{ route('bookings.index') }}">Pengajuan sewa</a>
            </div>
        @else
            <p class="field-hint">Admin memakai menu yang sama untuk memeriksa katalog dan pengajuan. Layar verifikasi KTM belum tersedia.</p>
            <div class="form-actions">
                <a class="primary-action" href="{{ route('items.index') }}">Buka katalog</a>
                <a class="secondary-action" href="{{ route('bookings.index') }}">Pengajuan sewa</a>
            </div>
        @endif
    </section>
@endsection
