<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <x-layout.head/>
</head>
<body>

<main class="auth-page">
    {{ $slot }}
</main>

</body>
</html>
