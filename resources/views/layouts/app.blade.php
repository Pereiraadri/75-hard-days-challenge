<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>75 Hard</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">

    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#ff6b35">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="75 Hard">
</head>
<body class="font-sans antialiased" style="background:#0e0e0e; margin:0;">

{{-- Navbar --}}
<nav style="background:#111; border-bottom:1px solid #1e1e1e; padding:12px 20px; display:flex; align-items:center; justify-content:space-between;">
            <span style="font-family:'Bebas Neue',sans-serif; font-size:22px; background:linear-gradient(135deg,#ff6b35,#f7c948); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; letter-spacing:.05em;">
                75 HARD
            </span>
    <div style="display:flex; align-items:center; gap:16px;">
        <span style="font-size:13px; color:#555;">{{ auth()->user()->first_name }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="font-size:12px; color:#444; background:none; border:none; cursor:pointer; transition:color .2s;"
                    onmouseover="this.style.color='#ff6b35'" onmouseout="this.style.color='#444'">
                Déconnexion
            </button>
        </form>
    </div>
</nav>

<main>
    {{ $slot }}
</main>

<script>
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw.js');
    }
</script>
</body>
</html>
