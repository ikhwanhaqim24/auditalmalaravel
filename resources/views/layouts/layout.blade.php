<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    {{-- <link rel="stylesheet" href="/css/main.css"> --}}
    @vite(['resources/scss/app.scss', 'resources/scss/main.scss'])
</head>

<body class="antialiased">
    @yield('content')
    <footer>
        Copyright 2023 Pizza House
    </footer>
</body>
</html>