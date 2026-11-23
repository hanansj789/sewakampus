<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk | SewaKampus</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <header class="site-header">
        <a class="wordmark" href="{{ route('login') }}">SewaKampus</a>
    </header>

    <main class="page-main">
        <section class="auth-panel" aria-labelledby="page-title">
            <h1 id="page-title">Masuk</h1>
            <p class="intro">Gunakan akun kampus untuk melanjutkan ke SewaKampus.</p>

            @if ($errors->any())
                <div class="message message-error" role="alert">{{ $errors->first() }}</div>
            @endif

            @if (session('status'))
                <p class="message message-status" role="status">{{ session('status') }}</p>
            @endif

            <a class="primary-action" href="{{ route('auth.keycloak.redirect') }}">Masuk dengan akun kampus</a>

            <p class="privacy-note">Autentikasi dikelola Keycloak. SewaKampus tidak menyimpan kata sandi akun kampus.</p>
        </section>
    </main>
</body>
</html>
