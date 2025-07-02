<aside class="w-64 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden hidden md:block">
    <!-- Navigation Section -->
    <div class="p-4 pt-6">
        <nav class="space-y-2">
            <!-- Dashboard -->
            <a href="{{ route('superadmin.dashboard') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-xl group transition-all duration-300 ease-in-out
                      {{ request()->routeIs('superadmin.dashboard')
                          ? 'bg-gradient-to-r from-red-500 to-red-600 text-white shadow-lg'
                          : 'text-gray-700 hover:bg-red-50 hover:text-red-600 hover:shadow-md hover:translate-x-1' }}">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg 
                            {{ request()->routeIs('superadmin.dashboard') 
                                ? 'bg-white/20' 
                                : 'bg-gray-100 group-hover:bg-red-100' }} transition-colors">
                    <span class="text-lg">📊</span>
                </div>
                <span class="font-semibold">Dashboard</span>
                <div class="ml-auto flex items-center space-x-2">
                    @if(request()->routeIs('superadmin.dashboard'))
                        <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    @endif
                    <svg class="w-4 h-4 {{ request()->routeIs('superadmin.dashboard') ? 'text-white/70' : 'text-gray-400 group-hover:text-red-500 opacity-0 group-hover:opacity-100' }} transition-all" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>

            <!-- Add User -->
            <a href="{{ route('superadmin.add_users') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-xl group transition-all duration-300 ease-in-out
                      {{ request()->routeIs('superadmin.add_users')
                          ? 'bg-gradient-to-r from-red-500 to-red-600 text-white shadow-lg'
                          : 'text-gray-700 hover:bg-red-50 hover:text-red-600 hover:shadow-md hover:translate-x-1' }}">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg 
                            {{ request()->routeIs('superadmin.add_users') 
                                ? 'bg-white/20' 
                                : 'bg-gray-100 group-hover:bg-red-100' }} transition-colors">
                    <span class="text-lg">👤</span>
                </div>
                <span class="font-semibold">Add User</span>
                <div class="ml-auto flex items-center space-x-2">
                    @if(request()->routeIs('superadmin.add_users'))
                        <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    @endif
                    <svg class="w-4 h-4 {{ request()->routeIs('superadmin.add_users') ? 'text-white/70' : 'text-gray-400 group-hover:text-red-500 opacity-0 group-hover:opacity-100' }} transition-all" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>

            <!-- Request Management -->
            <a href="{{ route('superadmin.request') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-xl group transition-all duration-300 ease-in-out
                      {{ request()->routeIs('superadmin.request')
                          ? 'bg-gradient-to-r from-red-500 to-red-600 text-white shadow-lg'
                          : 'text-gray-700 hover:bg-red-50 hover:text-red-600 hover:shadow-md hover:translate-x-1' }}">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg 
                            {{ request()->routeIs('superadmin.request') 
                                ? 'bg-white/20' 
                                : 'bg-gray-100 group-hover:bg-red-100' }} transition-colors relative">
                    <span class="text-lg">📋</span>
                    {{-- Optional notification badge --}}
                    @if(isset($pendingRequests) && $pendingRequests > 0)
                        <div class="absolute -top-1 -right-1 w-3 h-3 bg-orange-400 rounded-full text-xs text-white flex items-center justify-center font-bold" style="font-size: 8px;">
                            {{ $pendingRequests > 9 ? '9+' : $pendingRequests }}
                        </div>
                    @endif
                </div>
                <span class="font-semibold">Requests</span>
                <div class="ml-auto flex items-center space-x-2">
                    @if(isset($pendingRequests) && $pendingRequests > 0)
                        <span class="px-2 py-1 bg-orange-400 text-white text-xs font-bold rounded-full">
                            {{ $pendingRequests > 99 ? '99+' : $pendingRequests }}
                        </span>
                    @endif
                    @if(request()->routeIs('superadmin.request'))
                        <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    @endif
                    <svg class="w-4 h-4 {{ request()->routeIs('superadmin.request') ? 'text-white/70' : 'text-gray-400 group-hover:text-red-500 opacity-0 group-hover:opacity-100' }} transition-all" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>

            {{-- You can add more navigation items here --}}
            {{-- 
            <a href="{{ route('superadmin.users') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-xl group transition-all duration-300 ease-in-out
                      {{ request()->routeIs('superadmin.users')
                          ? 'bg-gradient-to-r from-red-500 to-red-600 text-white shadow-lg'
                          : 'text-gray-700 hover:bg-red-50 hover:text-red-600 hover:shadow-md hover:translate-x-1' }}">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg 
                            {{ request()->routeIs('superadmin.users') 
                                ? 'bg-white/20' 
                                : 'bg-gray-100 group-hover:bg-red-100' }} transition-colors">
                    <span class="text-lg">👥</span>
                </div>
                <span class="font-semibold">Users</span>
                <div class="ml-auto flex items-center space-x-2">
                    @if(request()->routeIs('superadmin.users'))
                        <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    @endif
                    <svg class="w-4 h-4 {{ request()->routeIs('superadmin.users') ? 'text-white/70' : 'text-gray-400 group-hover:text-red-500 opacity-0 group-hover:opacity-100' }} transition-all" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>
            --}}
        </nav>
    </div>
</aside>

{{-- Add custom CSS to your layout file or in a style tag --}}
<style>
    .nav-item {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .nav-item:hover {
        transform: translateX(4px);
    }
</style>