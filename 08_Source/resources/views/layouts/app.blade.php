<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SewaKampus') | SewaKampus</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/items.css') }}">
</head>
<body>
    <header class="site-header site-header-actions">
        <a class="wordmark" href="{{ route('dashboard') }}">SewaKampus</a>

        <nav class="header-nav" aria-label="Navigasi utama">
            <a href="{{ route('items.index') }}" @class(['is-current' => request()->routeIs('items.index') && ! request()->boolean('mine')])>Katalog</a>
            <a href="{{ route('items.index', ['mine' => 1]) }}" @class(['is-current' => request()->boolean('mine')])>Barang saya</a>
            <a href="{{ route('bookings.index') }}" @class(['is-current' => request()->routeIs('bookings.*')])>Pengajuan</a>
            <a class="primary-action" href="{{ route('items.create') }}">Tambah barang</a>
        </nav>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="secondary-action" type="submit">Keluar</button>
        </form>
    </header>

    <main class="page-main">
        @if (session('status'))
            <p class="flash" role="status">{{ session('status') }}</p>
        @endif

        @yield('content')
    </main>
    <script src="{{ asset('js/items.js') }}" defer></script>
</body>
</html>
