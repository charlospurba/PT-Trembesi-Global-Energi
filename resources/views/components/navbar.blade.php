<nav class="navbar">
    <div class="nav-container">
        <!-- Logo Section -->
        <div class="logo-section">
            <a href="/">
                <img src="{{ asset('assets/images/logo_trembesi.png') }}" alt="Trembesi Logo" class="logo">
            </a>
        </div>

        <!-- Search Form -->
        <form id="searchForm" action="/search" method="GET" class="search-form">
            <div class="search-wrapper">
                <div class="search-icon">
                    <i class="fas fa-search"></i>
                </div>
                <input type="search" name="query" placeholder="Cari produk atau vendor" aria-label="Search"
                    class="search-input">
                <button type="submit" class="search-button">Search</button>
            </div>
        </form>

        <!-- Right Side Icons and Buttons -->
        <div class="nav-right">
            <!-- Cart Icon -->
            <a href="/cart" class="nav-icon">
                <i class="fas fa-shopping-cart"></i>
                <span class="badge">0</span>
            </a>

            <!-- Notification Icon -->
            <a href="/notifications" class="nav-icon">
                <i class="fas fa-bell"></i>
                <span class="badge">0</span>
            </a>

            <!-- Log In Button -->
            <a href="/login" class="nav-button login">Log In</a>

            <!-- Register Button -->
            <a href="{{ route('auth.register') }}" class="nav-button register">Register</a>
        </div>
    </div>
</nav>

<!-- Catatan: Tambahkan link CSS berikut di file induk (misalnya dashboard.blade.php) -->
<link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">
