<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trembesi Global Energi</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Tailwind & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom CSS (opsional, jika masih dipakai) -->
    <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/material.css') }}">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-50 text-gray-800">

    {{-- Navbar Global --}}
    @auth
        {{-- Navbar untuk user yang sudah login --}}
        @include('components.navbar')
    @endauth

    @guest
        {{-- Navbar untuk pengunjung yang belum login --}}
        @include('components.navold')
    @endguest

    {{-- Main Content --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    @stack('scripts')
</body>

</html>