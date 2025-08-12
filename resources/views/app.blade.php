<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Taman Sari Kost">
    <meta name="keywords" content="Kost, Taman Sari, Kos-kosan, Kost Murah">
    <meta name="author" content="Gung Dika Ebs">
    <meta name="title" content="Taman Sari Kost">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    {{-- css --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- favicon --}}


    <title inertia>{{ config('app.name', 'Laravel') }}</title>
    @vite('resources/js/app.js') {{-- Or mix() if using Laravel Mix --}}
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia
    {{-- <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

</body>

</html>
