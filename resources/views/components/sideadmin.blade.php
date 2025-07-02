<aside class="w-64 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden hidden md:block">
    <div class="p-4 pt-6">
        <nav class="space-y-2">
            @php
                $menus = [
                    [
                        'label' => 'Dashboard',
                        'icon' => '📊',
                        'route' => 'superadmin.dashboard',
                    ],
                    [
                        'label' => 'Add User',
                        'icon' => '👤',
                        'route' => 'superadmin.add_users',
                    ],
                    [
                        'label' => 'Requests',
                        'icon' => '📋',
                        'route' => 'superadmin.request',
                        'badge' => $pendingRequests ?? 0,
                    ],
                ];
            @endphp

            @foreach($menus as $menu)
                @php
                    $isActive = request()->routeIs($menu['route']);
                @endphp
                <a href="{{ route($menu['route']) }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl group transition-all duration-300 ease-in-out
                          {{ $isActive 
                              ? 'bg-gradient-to-r from-red-500 to-red-600 text-white shadow-lg'
                              : 'text-gray-700 hover:bg-red-50 hover:text-red-600 hover:shadow-md hover:translate-x-1' }}">
                    
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg transition-colors
                                {{ $isActive ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-red-100' }}">
                        <span class="text-lg">{{ $menu['icon'] }}</span>
                    </div>

                    <span class="font-semibold text-sm">{{ $menu['label'] }}</span>

                    <div class="ml-auto flex items-center space-x-2">
                        @if(isset($menu['badge']) && $menu['badge'] > 0)
                            <span class="px-2 py-1 bg-orange-400 text-white text-xs font-bold rounded-full">
                                {{ $menu['badge'] > 99 ? '99+' : $menu['badge'] }}
                            </span>
                        @endif

                        @if($isActive)
                            <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                        @endif

                        <svg class="w-4 h-4 transition-all 
                                    {{ $isActive 
                                        ? 'text-white/70' 
                                        : 'text-gray-400 opacity-0 group-hover:opacity-100 group-hover:text-red-500' }}" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
            @endforeach
        </nav>
    </div>
</aside>
