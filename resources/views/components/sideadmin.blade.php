<!-- Sidebar -->
<aside class="fixed inset-y-0 left-0 w-64 sm:w-56 bg-white p-4 sm:p-6 shadow-lg border-r border-gray-200 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out md:static md:block z-50"
    id="sidebar">
    <nav class="space-y-2 text-sm font-medium">
        @php
            $menus = [
                [
                    'label' => 'Dashboard',
                    'icon' => '📊',
                    'route' => route('superadmin.dashboard'),
                    'desc' => 'Overview & statistik'
                ],
                [
                    'label' => 'Add User',
                    'icon' => '👤',
                    'route' => route('superadmin.add_users'),
                    'desc' => 'Manage users'
                ],
                [
                    'label' => 'Requests',
                    'icon' => '📋',
                    'route' => route('superadmin.request'),
                    'desc' => 'Manage requests',
                    'badge' => $pendingRequests ?? 0
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
                    <div class="flex items-center justify-between">
                        <span class="font-semibold block">{{ $menu['label'] }}</span>
                        @if(isset($menu['badge']) && $menu['badge'] > 0)
                            <span class="px-2 py-1 bg-orange-400 text-white text-xs font-bold rounded-full">
                                {{ $menu['badge'] > 99 ? '99+' : $menu['badge'] }}
                            </span>
                        @endif
                    </div>
                    <span class="text-xs text-gray-500">{{ $menu['desc'] }}</span>
                </div>
            </a>
        @endforeach
    </nav>
</aside>
<script>
    function toggleDropdown() {
        document.getElementById("dropdownMenu").classList.toggle("hidden");
    }

    window.addEventListener("click", function (e) {
        const trigger = document.querySelector(".profile-trigger");
        const dropdown = document.getElementById("dropdownMenu");
        if (!trigger.contains(e.target)) {
            dropdown.classList.add("hidden");
        }
    });

    document.getElementById('logoutBtn').addEventListener('click', function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You will be signed out of your account.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, log out',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logoutForm').submit();
            }
        });
    });

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