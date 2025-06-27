<aside class="w-64 bg-gradient-to-br from-white via-red-50 to-pink-50 p-6 shadow-xl border-r border-red-100 hidden md:block relative overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-red-100 to-transparent rounded-full opacity-30 -translate-y-16 translate-x-16"></div>
    <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-pink-100 to-transparent rounded-full opacity-40 translate-y-12 -translate-x-12"></div>
    
    <!-- Header -->
    <div class="mb-8 relative z-10">
        <div class="flex items-center space-x-3 mb-2">
        </div>
        <div class="h-1 w-full bg-gradient-to-r from-red-500 to-pink-500 rounded-full"></div>
    </div>
    
    <nav class="space-y-3 font-medium relative z-10">
        <a href="/dashboard/vendor" 
           class="nav-item group flex items-center space-x-4 p-4 rounded-xl transition-all duration-300 hover:scale-105 hover:shadow-lg bg-gradient-to-r from-red-500 to-red-600 text-white shadow-md active-menu">
            <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg bg-white/20 group-hover:bg-white/30 transition-all duration-300">
                <span class="text-lg">📦</span>
            </div>
            <div class="flex-1">
                <span class="font-semibold">Dashboard</span>
                <p class="text-xs opacity-80">Overview & statistik</p>
            </div>
            <div class="w-2 h-2 bg-white rounded-full opacity-60"></div>
        </a>
        
        <a href="/myproducts" 
           class="nav-item group flex items-center space-x-4 p-4 rounded-xl transition-all duration-300 hover:scale-105 hover:shadow-lg bg-white/80 backdrop-blur-sm border border-gray-100 text-gray-700 hover:bg-gradient-to-r hover:from-red-500 hover:to-red-600 hover:text-white hover:border-red-300">
            <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 group-hover:bg-white/20 transition-all duration-300">
                <span class="text-lg">🛍️</span>
            </div>
            <div class="flex-1">
                <span class="font-semibold">My Products</span>
                <p class="text-xs opacity-60 group-hover:opacity-80">Manage product</p>
            </div>
            <div class="w-1 h-4 bg-red-200 group-hover:bg-white rounded-full transition-all duration-300"></div>
        </a>
        
        <a href="{{ route('vendor.add_product') }}" 
           class="nav-item group flex items-center space-x-4 p-4 rounded-xl transition-all duration-300 hover:scale-105 hover:shadow-lg bg-white/80 backdrop-blur-sm border border-gray-100 text-gray-700 hover:bg-gradient-to-r hover:from-red-500 hover:to-red-600 hover:text-white hover:border-red-300">
            <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg bg-green-50 group-hover:bg-white/20 transition-all duration-300">
                <span class="text-lg">➕</span>
            </div>
            <div class="flex-1">
                <span class="font-semibold">Add Products</span>
                <p class="text-xs opacity-60 group-hover:opacity-80">Add new product</p>
            </div>
            <div class="w-1 h-4 bg-green-200 group-hover:bg-white rounded-full transition-all duration-300"></div>
        </a>
        
        <a href="{{ route('vendor.orders') }}" 
           class="nav-item group flex items-center space-x-4 p-4 rounded-xl transition-all duration-300 hover:scale-105 hover:shadow-lg bg-white/80 backdrop-blur-sm border border-gray-100 text-gray-700 hover:bg-gradient-to-r hover:from-red-500 hover:to-red-600 hover:text-white hover:border-red-300">
            <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg bg-blue-50 group-hover:bg-white/20 transition-all duration-300">
                <span class="text-lg">📋</span>
            </div>
            <div class="flex-1">
                <span class="font-semibold">Orders</span>
                <p class="text-xs opacity-60 group-hover:opacity-80">Manage product</p>
            </div>
            <div class="w-1 h-4 bg-blue-200 group-hover:bg-white rounded-full transition-all duration-300"></div>
        </a>
        
        <a href="#" 
           class="nav-item group flex items-center space-x-4 p-4 rounded-xl transition-all duration-300 hover:scale-105 hover:shadow-lg bg-white/80 backdrop-blur-sm border border-gray-100 text-gray-700 hover:bg-gradient-to-r hover:from-red-500 hover:to-red-600 hover:text-white hover:border-red-300">
            <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg bg-yellow-50 group-hover:bg-white/20 transition-all duration-300">
                <span class="text-lg">💬</span>
            </div>
            <div class="flex-1">
                <span class="font-semibold">Review</span>
                <p class="text-xs opacity-60 group-hover:opacity-80">Customer's Riview</p>
            </div>
            <div class="w-1 h-4 bg-yellow-200 group-hover:bg-white rounded-full transition-all duration-300"></div>
        </a>
    </nav>
    
    </aside>



<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get current page URL
    const currentPath = window.location.pathname;
    const navItems = document.querySelectorAll('.nav-item');
    
    // Remove active classes from all items
    navItems.forEach(item => {
        item.classList.remove('bg-gradient-to-r', 'from-red-500', 'to-red-600', 'text-white', 'shadow-md', 'border-l-4', 'border-l-white');
        item.classList.add('bg-white/80', 'backdrop-blur-sm', 'border', 'border-gray-100', 'text-gray-700');
        
        // Reset hover classes
        item.classList.add('hover:bg-gradient-to-r', 'hover:from-red-500', 'hover:to-red-600', 'hover:text-white', 'hover:border-red-300', 'hover:border-l-4', 'hover:border-l-white');
        
        // Find the pulse dot and remove animation
        const dot = item.querySelector('.animate-pulse');
        if (dot) {
            dot.classList.remove('animate-pulse');
        }
    });
    
    // Add active class based on current URL
    navItems.forEach(item => {
        const href = item.getAttribute('href');
        if (href && (currentPath === href || currentPath.includes(href) && href !== '#')) {
            // Apply active state
            item.classList.remove('bg-white/80', 'backdrop-blur-sm', 'border', 'border-gray-100', 'text-gray-700');
            item.classList.add('bg-gradient-to-r', 'from-red-500', 'to-red-600', 'text-white', 'shadow-md', 'border-l-4', 'border-l-white');
            
            // Remove hover classes for active item
            item.classList.remove('hover:bg-gradient-to-r', 'hover:from-red-500', 'hover:to-red-600', 'hover:text-white', 'hover:border-red-300', 'hover:border-l-4', 'hover:border-l-white');
            
            // Add pulse animation to dot
            const dot = item.querySelector('.w-2.h-2, .w-1.h-4');
            if (dot) {
                dot.classList.add('animate-pulse');
            }
        }
    });
    
    // Handle click events
    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            // Remove active from all items
            navItems.forEach(nav => {
                nav.classList.remove('bg-gradient-to-r', 'from-red-500', 'to-red-600', 'text-white', 'shadow-md', 'border-l-4', 'border-l-white');
                nav.classList.add('bg-white/80', 'backdrop-blur-sm', 'border', 'border-gray-100', 'text-gray-700');
                nav.classList.add('hover:bg-gradient-to-r', 'hover:from-red-500', 'hover:to-red-600', 'hover:text-white', 'hover:border-red-300', 'hover:border-l-4', 'hover:border-l-white');
                
                const dot = nav.querySelector('.animate-pulse');
                if (dot) {
                    dot.classList.remove('animate-pulse');
                }
            });
            
            // Add active to clicked item
            this.classList.remove('bg-white/80', 'backdrop-blur-sm', 'border', 'border-gray-100', 'text-gray-700');
            this.classList.add('bg-gradient-to-r', 'from-red-500', 'to-red-600', 'text-white', 'shadow-md', 'border-l-4', 'border-l-white');
            this.classList.remove('hover:bg-gradient-to-r', 'hover:from-red-500', 'hover:to-red-600', 'hover:text-white', 'hover:border-red-300', 'hover:border-l-4', 'hover:border-l-white');
            
            const dot = this.querySelector('.w-2.h-2, .w-1.h-4');
            if (dot) {
                dot.classList.add('animate-pulse');
            }
        });
    });
});
</script>