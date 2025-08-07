<aside
    class="fixed inset-y-0 left-0 w-64 sm:w-56 bg-white p-4 sm:p-6 shadow-lg border-r border-gray-200 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out md:static md:block z-50"
    id="sidebar">
    <nav class="space-y-2 text-sm font-medium">
        @php
            $menus = [
                [
                    'label' => 'Dashboard',
                    'icon' => '📦',
                    'route' => '/dashboard/vendor',
                    'desc' => 'Overview & statistik',
                ],
                [
                    'label' => 'My Products',
                    'icon' => '🛍️',
                    'route' => '/myproducts',
                    'desc' => 'Manage product',
                ],
                [
                    'label' => 'Add Products',
                    'icon' => '➕',
                    'route' => route('vendor.add_product'),
                    'desc' => 'Add new product',
                ],
                [
                    'label' => 'Orders',
                    'icon' => '📋',
                    'route' => route('vendor.orders'),
                    'desc' => 'Manage orders',
                ],
            ];

            $currentPath = request()->path();
        @endphp

        @foreach ($menus as $menu)
            @php
                $routePath = trim(parse_url($menu['route'], PHP_URL_PATH), '/');
                $isActive = $currentPath === $routePath;
            @endphp

            <a href="{{ $menu['route'] }}"
                class="group flex items-start space-x-3 p-2 sm:p-3 rounded-lg transition-all duration-200
               {{ $isActive
                   ? 'bg-red-50 border-l-4 border-red-600 text-red-700'
                   : 'hover:bg-gray-50 text-gray-700 hover:text-red-600' }}">
                <div
                    class="flex items-center justify-center w-8 h-8 bg-red-100 text-red-600 rounded-md text-base">
                    {{ $menu['icon'] }}
                </div>
                <div class="flex-1 min-w-0">
                    <span
                        class="font-semibold block text-xs sm:text-sm truncate">{{ $menu['label'] }}</span>
                    <span class="text-xs text-gray-500 truncate">{{ $menu['desc'] }}</span>
                </div>
            </a>
        @endforeach
    </nav>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const toggleButton = document.getElementById('sidebarToggle');

        if (toggleButton) {
            toggleButton.addEventListener('click', function () {
                sidebar.classList.toggle('-translate-x-full');
            });
        }

        document.addEventListener('click', function (e) {
            if (window.innerWidth < 768 &&
                !sidebar.contains(e.target) &&
                !toggleButton.contains(e.target)) {
                sidebar.classList.add('-translate-x-full');
            }
        });
    });
</script>
