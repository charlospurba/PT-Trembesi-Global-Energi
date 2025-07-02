<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Trembesi Global Energi</title>
  <link rel="icon" href="{{ asset('assets/images/logo_merah.png') }}" type="image/png">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <!-- Tailwind & JS -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/material.css') }}">

  <!-- SweetAlert2 & Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    body {
      margin: 0;
      height: 100vh;
      overflow-x: hidden;
      background: #ffffff;
      font-family: 'Arial', sans-serif;
    }

    .svg-container {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -10;
      pointer-events: none;
    }

    .svg-background {
      width: 100%;
      height: 100%;
    }

    .layer-1, .layer-2, .layer-3, .layer-4 {
      animation: waveMove 20s ease-in-out infinite alternate;
    }

    .layer-2 { animation-delay: 2s; }
    .layer-3 { animation-delay: 4s; }
    .layer-4 { animation-delay: 6s; }

    @keyframes waveMove {
      0%   { transform: translateY(0px) translateX(0px); }
      25%  { transform: translateY(-12px) translateX(-10px); }
      50%  { transform: translateY(-8px) translateX(10px); }
      75%  { transform: translateY(-14px) translateX(-5px); }
      100% { transform: translateY(0px) translateX(0px); }
    }
  </style>
</head>
<body class="text-gray-800 relative overflow-x-hidden">

  <!-- SVG Background Gelombang -->
  <div class="svg-container">
    <svg viewBox="0 0 1600 900" xmlns="http://www.w3.org/2000/svg" class="svg-background" preserveAspectRatio="none">
      <defs>
        <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%">
          <stop offset="0%" stop-color="#fbe4e2" />
          <stop offset="100%" stop-color="#f5c1bd" />
        </linearGradient>
        <linearGradient id="grad2" x1="0%" y1="0%" x2="100%" y2="100%">
          <stop offset="0%" stop-color="#f5c1bd" />
          <stop offset="100%" stop-color="#e68a7a" />
        </linearGradient>
        <linearGradient id="grad3" x1="0%" y1="0%" x2="100%" y2="100%">
          <stop offset="0%" stop-color="#e68a7a" />
          <stop offset="100%" stop-color="#d25145" />
        </linearGradient>
        <linearGradient id="grad4" x1="0%" y1="0%" x2="100%" y2="100%">
          <stop offset="0%" stop-color="#d25145" />
          <stop offset="100%" stop-color="#b02e27" />
        </linearGradient>
      </defs>

      <!-- Wave Paths -->
      <path class="layer-1" fill="url(#grad1)" d="M0,150 Q300,80 600,140 T1200,130 T1600,100 L1600,900 L0,900 Z" opacity="0.25" />
      <path class="layer-2" fill="url(#grad2)" d="M0,250 Q200,350 500,270 T1000,330 T1600,280 L1600,900 L0,900 Z" opacity="0.20" />
      <path class="layer-3" fill="url(#grad3)" d="M0,400 Q250,500 550,390 T950,470 T1400,400 T1600,450 L1600,900 L0,900 Z" opacity="0.15" />
      <path class="layer-4" fill="url(#grad4)" d="M0,600 Q350,750 700,600 T1100,750 T1600,600 L1600,900 L0,900 Z" opacity="0.10" />
    </svg>
  </div>

  <!-- Konten Utama -->
  <main class="min-h-screen relative z-10">
    @yield('content')
  </main>

  @stack('scripts')
</body>
</html>
