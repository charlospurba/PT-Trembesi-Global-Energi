<aside class="w-64 bg-white p-6 shadow-lg border-r border-gray-200 hidden md:block">
    <nav class="space-y-2 text-sm font-medium">
        @php
            $menus = [
                [
                    'label' => 'Dashboard',
                    'icon' => '📦',
                    'route' => route('dashboard.projectmanager'),
                    'desc' => 'Overview & statistik'
                ],
                [
                    'label' => 'Purchase Requests',
                    'icon' => '🛒',
                    'route' => route('projectmanager.purchaserequest'),
                    'desc' => 'Manage purchase requests'
                ],
                [
                    'label' => 'Add Request',
                    'icon' => '➕',
                    'route' => route('projectmanager.addrequest'),
                    'desc' => 'Create new request'
                ]
            ];

            $currentPath = request()->path();
        @endphp

        @foreach ($menus as $menu)
            @php
                $routePath = trim(parse_url($menu['route'], PHP_URL_PATH), '/');
                $isActive = $currentPath === $routePath;
            @endphp

            <a href="{{ $menu['route'] }}"
               class="group flex items-start space-x-3 p-3 rounded-lg transition-all duration-200
               {{ $isActive 
                   ? 'bg-red-50 border-l-4 border-red-600 text-red-700' 
                   : 'hover:bg-gray-50 text-gray-700 hover:text-red-600' }}">
                <div class="flex items-center justify-center w-7 h-7 bg-red-100 text-red-600 rounded-md text-base">
                    {{ $menu['icon'] }}
                </div>
                <div class="flex-1">
                    <span class="font-semibold block">{{ $menu['label'] }}</span>
                    <span class="text-xs text-gray-500">{{ $menu['desc'] }}</span>
                </div>
            </a>
        @endforeach
    </nav>
</aside>