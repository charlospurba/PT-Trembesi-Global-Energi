<aside class="w-64 bg-gradient-to-br from-white via-red-50 to-pink-50 p-6 shadow-xl border-r border-red-100 hidden md:block relative overflow-hidden">
    <!-- Decorative gradient circles -->
    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-red-100 to-transparent rounded-full opacity-30 -translate-y-16 translate-x-16"></div>
    <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-pink-100 to-transparent rounded-full opacity-40 translate-y-12 -translate-x-12"></div>

    <!-- Section Header -->
    <div class="mb-8 relative z-10">
        <div class="h-1 w-full bg-gradient-to-r from-red-500 to-pink-500 rounded-full"></div>
    </div>

    <!-- Navigation -->
    <nav class="space-y-3 font-medium relative z-10">
        @php
            $menus = [
                [
                    'label' => 'Dashboard',
                    'icon' => '📦',
                    'route' => '/dashboard/vendor',
                    'desc' => 'Overview & statistik'
                ],
                [
                    'label' => 'My Products',
                    'icon' => '🛍️',
                    'route' => '/myproducts',
                    'desc' => 'Manage product'
                ],
                [
                    'label' => 'Add Products',
                    'icon' => '➕',
                    'route' => route('vendor.add_product'),
                    'desc' => 'Add new product'
                ],
                [
                    'label' => 'Orders',
                    'icon' => '📋',
                    'route' => route('vendor.orders'),
                    'desc' => 'Manage orders'
                ],
                [
                    'label' => 'Review',
                    'icon' => '💬',
                    'route' => '#',
                    'desc' => "Customer's Review"
                ]
            ];

            $current = request()->path();
        @endphp

        @foreach ($menus as $menu)
            @php
                $isActive = str_contains($current, trim(parse_url($menu['route'], PHP_URL_PATH), '/'));
            @endphp

            <a href="{{ $menu['route'] }}"
               class="group flex items-center space-x-4 p-4 rounded-xl transition-all duration-300
               {{ $isActive 
                   ? 'bg-gradient-to-r from-red-500 to-red-600 text-white shadow-lg' 
                   : 'bg-white/80 backdrop-blur-sm border border-gray-100 text-gray-700 hover:bg-gradient-to-r hover:from-red-500 hover:to-red-600 hover:text-white hover:border-red-300' }}">
                <div class="w-8 h-8 flex items-center justify-center rounded-lg 
                            {{ $isActive ? 'bg-white/20' : 'bg-red-50 group-hover:bg-white/20' }}">
                    <span class="text-lg">{{ $menu['icon'] }}</span>
                </div>
                <div class="flex-1">
                    <span class="font-semibold text-sm">{{ $menu['label'] }}</span>
                    <p class="text-xs opacity-70 group-hover:opacity-90">{{ $menu['desc'] }}</p>
                </div>
                @if($isActive)
                    <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                @endif
            </a>
        @endforeach
    </nav>
</aside>
