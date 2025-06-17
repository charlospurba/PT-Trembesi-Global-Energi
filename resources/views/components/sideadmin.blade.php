<aside class="w-64 bg-white p-6 shadow hidden md:block">
    <nav class="space-y-4 font-medium">
        <a href="{{ route('admin.dashboard') }}" class="block text-red-700 hover:font-semibold">📦 Dashboard</a>
        <a href="{{ route('admin.users.create') }}" class="block text-gray-700 hover:text-red-500">➕ Add User</a>
        <a href="{{ route('admin.requests.index') }}" class="block text-gray-700 hover:text-red-500">🔄 Request</a>
    </nav>
</aside>