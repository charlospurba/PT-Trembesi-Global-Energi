<!-- Navbar Component -->
<nav class="navbar bg-red-600 p-2 px-5 w-full shadow-md z-50 relative">
    <div class="flex items-center justify-between w-full relative z-10">

        <!-- Logo -->
        <div class="mr-2 z-10">
            <a href="/" class="block">
                <img src="{{ asset('assets/images/logo_trembesi.png') }}" alt="Trembesi Logo" class="h-10">
            </a>
        </div>

        <!-- Icons + Auth Buttons (Right Aligned) -->
        <div class="flex items-center gap-2 ml-4 z-10">
            <!-- Notes Icon -->
            <a href="/signin" class="relative w-9 h-9 flex items-center justify-center text-white hover:text-white/80 transition">
                <i class="fas fa-sticky-note text-base"></i>
            </a>

            <!-- Cart Icon -->
            <a href="/signin" class="relative w-9 h-9 flex items-center justify-center text-white hover:text-white/80 transition">
                <i class="fas fa-shopping-cart text-base"></i>
                <span id="cartBadge" class="absolute -top-1 -right-1 bg-white text-red-600 text-xs px-1.5 rounded-full hidden">0</span>
            </a>

            <!-- Notification Icon -->
            <a href="/signin" class="relative w-9 h-9 flex items-center justify-center text-white hover:text-white/80 transition">
                <i class="fas fa-bell text-base"></i>
                <span id="notificationBadge" class="absolute -top-1 -right-1 bg-white text-red-600 text-xs px-1.5 rounded-full hidden">0</span>
            </a>

            <!-- Auth Buttons -->
            <a href="/signin"
                class="border border-white text-white px-3 py-1 rounded hover:bg-white hover:text-red-600 transition text-sm">
                Sign In
            </a>
            <a href="/signup"
                class="border border-white text-white px-3 py-1 rounded hover:bg-white hover:text-red-600 transition text-sm">
                Sign Up
            </a>
        </div>

        <!-- Search Form Centered Absolutely -->
        <div class="absolute left-1/2 -translate-x-1/2 w-full max-w-2xl z-0">
            <form id="searchForm" action="{{ route('search.products') }}" method="GET">
                <div class="flex items-center h-10 border border-white rounded-full overflow-hidden bg-transparent">
                    <!-- Search Icon -->
                    <div class="px-3 text-white">
                        <i class="fas fa-search text-base"></i>
                    </div>
                    
                    <!-- Search Input -->
                    <input type="search" name="query" placeholder="Search for products or vendors"
                        class="flex-grow bg-transparent text-white placeholder-white text-sm focus:outline-none px-2" />

                    <!-- Search Button -->
                    <button type="submit"
                        class="bg-white text-black font-semibold px-4 h-full text-sm">
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>
</nav>
