<nav
    style="background: #E82929; padding: 10px 20px; width: 100%; box-sizing: border-box; position: relative; z-index: 1;">

    <div class="nav-container"
        style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: nowrap; width: 100%;">
        <!-- Logo Section -->
        <div style="display: flex; align-items: center; flex-shrink: 0; margin-right: 10px;">
            <a href="/" style="text-decoration: none;">
                <img src="{{ asset('assets/images/logo_trembesi.png') }}" alt="Trembesi Logo"
                    style="height: 120px; width: 120px;">
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

        <!-- Right Side Icons and Buttons -->
        <div style="display: flex; align-items: center; gap: 10px; flex-shrink: 0;">
            <!-- Cart Icon -->
            <a href="/cart"
                style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; position: relative; text-decoration: none;">
                <i class="fas fa-shopping-cart" style="color: white; font-size: 28px;"></i>
                <span
                    style="position: absolute; top: -5px; right: -5px; background-color: #6c757d; color: white; font-size: 10px; padding: 2px 5px; border-radius: 10px; min-width: 18px; text-align: center; display: none;">0</span>
            </a>

            <!-- Notification Icon -->
            <a href="/notifications"
                style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; position: relative; text-decoration: none;">
                <i class="fas fa-bell" style="color: white; font-size: 28px;"></i>
                <span
                    style="position: absolute; top: -5px; right: -5px; background-color: #6c757d; color: white; font-size: 10px; padding: 2px 5px; border-radius: 10px; min-width: 18px; text-align: center; display: none;">0</span>
            </a>

            <!-- Log In Button -->
            <a href="/login"
                style="background-color: #e30613; color: white; border: 1px solid white; border-radius: 5px; padding: 10px 20px; font-size: 16px; text-decoration: none; font-weight: 500; height: 50px; display: flex; align-items: center; justify-content: center;">Log
                In</a>

            <!-- Register Button -->
            <a href="/register"
                style="background-color: white; color: #e30613; border-radius: 5px; padding: 10px 20px; font-size: 16px; text-decoration: none; font-weight: 500; height: 50px; display: flex; align-items: center; justify-content: center;">Register</a>
        </div>
    </div>
</nav>
