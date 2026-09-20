<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <x-layout.head/>
</head>
<body>

<header class="app-bar">
    <a href="{{ route('dashboard') }}" class="app-bar__brand gradient-text">{{ config('app.name') }}</a>

    <div class="app-bar__session">
        <span>{{ auth()->user()->first_name }}</span>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="app-bar__logout">{{ __('Log out') }}</button>
        </form>
    </div>
</header>

<main>
    {{ $slot }}
</main>

</body>
</html>
