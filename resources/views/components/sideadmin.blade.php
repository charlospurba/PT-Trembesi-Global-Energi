<aside class="w-64 bg-white p-6 shadow hidden md:block">
    <nav class="space-y-4 font-medium">
        <a href="{{ route('superadmin.dashboard') }}"
           class="block {{ request()->routeIs('superadmin.dashboard') ? 'text-red-700 font-semibold' : 'text-gray-700 hover:text-red-500' }}">
            📦 Dashboard
        </a>
        <a href="{{ route('superadmin.add_users') }}"
           class="block {{ request()->routeIs('superadmin.add_users') ? 'text-red-700 font-semibold' : 'text-gray-700 hover:text-red-500' }}">
            ➕ Add User
        </a>
        <a href="{{ route('superadmin.request') }}"
          class="block {{ request()->routeIs('superadmin.request') ? 'text-red-700 font-semibold' : 'text-gray-700 hover:text-red-500' }}">
            🔄 Request
        </a>
    </nav>
</aside>