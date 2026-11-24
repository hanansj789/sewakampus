<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageRole === 'ADMIN' ? 'Area admin' : 'Area mahasiswa' }} | SewaKampus</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <header class="site-header site-header-actions">
        <a class="wordmark" href="{{ route('dashboard') }}">SewaKampus</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="secondary-action" type="submit">Keluar</button>
        </form>
    </header>

    <main class="page-main">
        <section class="auth-panel dashboard-panel" aria-labelledby="page-title">
            <h1 id="page-title">{{ $pageRole === 'ADMIN' ? 'Area admin' : 'Area mahasiswa' }}</h1>
            <p class="intro">{{ auth()->user()->full_name }}</p>
            <p class="role-line">Peran akun: <strong>{{ $pageRole === 'ADMIN' ? 'Admin' : 'Mahasiswa' }}</strong></p>
            <p class="privacy-note">Login dan pembatasan peran aktif. Alur listing dan transaksi belum tersedia pada scaffold lokal ini.</p>
        </section>
    </main>
</body>
</html>
