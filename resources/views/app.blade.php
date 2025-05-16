<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Taman Sari Kost">
    <meta name="keywords" content="Kost, Taman Sari, Kos-kosan, Kost Murah">
    <meta name="author" content="Gung Dika Ebs">
    <meta name="title" content="Taman Sari Kost">


    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    @vite('resources/js/app.js') {{-- Or mix() if using Laravel Mix --}}
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia
</body>

</html>
