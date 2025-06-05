<!-- Navbar Component -->
<nav class="navbar">
    <div class="nav-container">
        <div class="logo-section">
            <a href="/" class="logo">
                <img src="{{ asset('assets/images/logo_trembesi.png') }}" alt="Trembesi Logo" class="logo-img">
            </a>
        </div>

               <!-- Search Form -->
        <form id="searchForm" action="/search" method="GET"
            style="flex-grow: 1; max-width: 600px; min-width: 300px; margin-right: 10px;">
            <div
                style="display: flex; width: 100%; border-radius: 999px; overflow: hidden; background-color: transparent; border: 1px solid white; align-items: center; height: 45px;">
                <div style="padding: 0 15px; color: white; display: flex; align-items: center;">
                    <i class="fas fa-search" style="font-size: 20px;"></i>
                </div>
                <input type="search" name="query" placeholder="Cari produk atau vendor" aria-label="Search"
                    style="flex-grow: 1; border: none; outline: none; height: 100%; font-size: 16px; padding: 0 10px; color: white; background-color: transparent;">
                <button type="submit"
                    style="padding: 0 20px; height: 100%; background-color: white; color: black; border: none; font-weight: bold; font-size: 16px; cursor: pointer; border-top-right-radius: 999px; border-bottom-right-radius: 999px;">Search</button>
            </div>
        </form>

        <div class="nav-right">
            <a href="/cart" class="nav-icon">
                <i class="fas fa-shopping-cart"></i>
                <span class="badge cart-badge" id="cartBadge" style="display: none;">0</span>
            </a>
            <a href="/notifications" class="nav-icon">
                <i class="fas fa-bell"></i>
                <span class="badge notification-badge" id="notificationBadge" style="display: none;">0</span>
            </a>
            <a href="/login" class="nav-button login">Log In</a>
            <a href="/register" class="nav-button register">Register</a>
        </div>
    </div>
</nav>