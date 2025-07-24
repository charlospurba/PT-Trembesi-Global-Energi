<!-- Navbar Component -->
<nav class="navbar bg-red-600 p-2 px-5 w-full shadow-md z-50 relative">
    <div class="flex items-center justify-between w-full relative z-10">

        <!-- Logo -->
        <div class="mr-4 z-10">
            @php
                $role = Auth::check() ? Auth::user()->role : null;
                $dashboardLink = match ($role) {
                    'procurement' => route('procurement.dashboardproc'),
                    'superadmin' => route('superadmin.dashboard'),
                    'product_manager' => route('dashboard.projectmanager'),
                    default => route('dashboard'),
                };
            @endphp
            <a href="{{ $dashboardLink }}">
                <img src="{{ asset('assets/images/logo_trembesi.png') }}" alt="Trembesi Logo" class="h-10">
            </a>
        </div>

        <!-- Right Side Icons & Auth -->
        <div class="flex items-center gap-3 z-10">

            <!-- Notes -->
            <a href="{{ route('procurement.notes') }}"
                class="relative w-9 h-9 flex items-center justify-center text-white hover:text-white/80 transition">
                <i class="fas fa-sticky-note text-base"></i>
            </a>

            <!-- Cart -->
            <a href="/cart"
                class="relative w-9 h-9 flex items-center justify-center text-white hover:text-white/80 transition">
                <i class="fas fa-shopping-cart text-base"></i>
                <span id="cartBadge"
                    class="absolute -top-1 -right-1 bg-white text-red-600 text-xs px-1.5 rounded-full hidden">0</span>
            </a>

            <!-- Notification -->
            <div class="notification-dropdown relative inline-block">
                <a href="#" class="nav-icon" onclick="toggleNotificationDropdown(event)">
                    <i class="fas fa-bell text-white text-base"></i>
                    <span id="notificationBadge"
                        class="absolute -top-1 -right-1 bg-white text-red-600 text-xs px-1.5 rounded-full hidden">0</span>
                </a>
                <div id="notificationDropdown"
                    class="dropdown-menu absolute top-full right-0 bg-white text-black rounded-md shadow-md hidden min-w-[250px] z-50 mt-2">
                    <div id="notificationList" class="max-h-72 overflow-y-auto"></div>
                </div>
            </div>

            <!-- Guest: Sign In / Up -->
            @guest
                <a href="/signin"
                    class="border border-white text-white px-3 py-1 rounded hover:bg-white hover:text-red-600 transition text-sm">Sign
                    In</a>
                <a href="/signup"
                    class="border border-white text-white px-3 py-1 rounded hover:bg-white hover:text-red-600 transition text-sm">Sign
                    Up</a>
            @endguest

            <!-- Auth: Profile -->
            @auth
                <div class="relative profile-trigger">
                    <div onclick="toggleProfileDropdown()"
                        class="flex items-center gap-2 text-white cursor-pointer hover:opacity-90">
                        @php
                            $profilePicture = Auth::user()->profile_picture
                                ? asset('storage/profile_picture/' . Auth::user()->profile_picture)
                                : asset('assets/images/default-profile.png');
                        @endphp
                        <img src="{{ $profilePicture }}" alt="Profile"
                            class="w-9 h-9 rounded-full object-cover border-2 border-white shadow">
                        <span class="font-medium max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                        <i class="fas fa-caret-down text-sm"></i>
                    </div>

                    <div id="profileDropdown"
                        class="absolute top-full right-0 mt-2 w-40 bg-white text-black rounded-md shadow-md hidden z-50">
                        <a href="/dashboard/profile" class="block px-4 py-2 hover:bg-gray-100 text-sm">My Profile</a>
                        @if (Auth::user()->role === 'procurement')
                            <a href="{{ route('procurement.order_history') }}"
                                class="block px-4 py-2 hover:bg-gray-100 text-sm">Order History</a>
                        @endif
                        <form id="logoutForm" method="POST" action="/logout">
                            @csrf
                            <button type="button" id="logoutBtn"
                                class="w-full text-left px-4 py-2 hover:bg-gray-100 text-sm">Logout</button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</nav>

<script>
    function toggleProfileDropdown() {
        const dropdown = document.getElementById("profileDropdown");
        dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";
        document.getElementById("notificationDropdown").style.display = "none";
    }

    function toggleNotificationDropdown(event) {
        event.preventDefault();
        const dropdown = document.getElementById("notificationDropdown");
        const isVisible = dropdown.style.display === "block";

        dropdown.style.display = isVisible ? "none" : "block";
        document.getElementById("profileDropdown").style.display = "none";

        // Jika baru dibuka (bukan ditutup)
        if (!isVisible) {
            // Tandai semua sebagai sudah dibaca di backend
            fetch('/notifications/read-all', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(() => {
                loadNotifications(); // refresh tampilan list & badge
            });
        }
    }

    window.addEventListener("click", function(e) {
        const profileTrigger = document.querySelector(".profile-trigger");
        const profileDropdown = document.getElementById("profileDropdown");
        const notificationTrigger = document.querySelector(".notification-dropdown .nav-icon");
        const notificationDropdown = document.getElementById("notificationDropdown");
        if (!profileTrigger.contains(e.target) && !profileDropdown.contains(e.target)) {
            profileDropdown.style.display = "none";
        }
        if (!notificationTrigger.contains(e.target) && !notificationDropdown.contains(e.target)) {
            notificationDropdown.style.display = "none";
        }
    });

    function loadNotifications(updateBadge = true) {
        fetch('/notifications', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                const notificationList = document.getElementById('notificationList');
                notificationList.innerHTML = '';
                if (data.notifications.length === 0) {
                    notificationList.innerHTML =
                        '<div style="padding: 10px; text-align: center;">No notifications</div>';
                } else {
                    data.notifications.forEach(notification => {
                        const div = document.createElement('div');
                        div.style.padding = '10px 15px';
                        div.style.borderBottom = '1px solid #ddd';
                        div.style.backgroundColor = notification.read ? '#fff' : '#f9f9f9';
                        div.innerHTML = `
                    <div style="font-weight: ${notification.read ? 'normal' : 'bold'}">${notification.message}</div>
                    <div style="font-size: 12px; color: #666;">${notification.created_at}</div>
                   ${notification.type === 'e-billing' ? `<a href="/e-billing/view/${notification.id}" style="color: #3085d6; text-decoration: none;">View E-Billing</a>` : ''}
                `;

                        // Event klik - tandai sebagai dibaca
                        div.addEventListener('click', () => markAsRead(notification.id, div));
                        notificationList.appendChild(div);
                    });
                }

                // Update badge jika diizinkan
                if (updateBadge) {
                    const badge = document.getElementById('notificationBadge');
                    badge.textContent = data.unread_count;
                    badge.style.display = data.unread_count > 0 ? 'inline-block' : 'none';
                }
            })
            .catch(error => {
                console.error('Failed to load notifications:', error);
            });
    }

    function markAsRead(notificationId, element) {
        fetch(`/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(() => {
                // Ubah style bold menjadi normal saat sudah dibaca
                element.style.backgroundColor = '#fff';
                const message = element.querySelector('div:first-child');
                if (message) message.style.fontWeight = 'normal';

                // Kurangi badge count
                const badge = document.getElementById('notificationBadge');
                const currentCount = parseInt(badge.textContent);
                const newCount = currentCount - 1;
                badge.textContent = newCount;
                badge.style.display = newCount > 0 ? 'inline-block' : 'none';
            })
            .catch(error => {
                console.error('Failed to mark notification as read:', error);
            });
    }

    document.getElementById('logoutBtn').addEventListener('click', function(e) {
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

    document.addEventListener('DOMContentLoaded', function() {
        fetch('/cart/count', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('cartBadge');
                badge.textContent = data.count;
                badge.style.display = data.count > 0 ? 'inline-block' : 'none';
            });

        loadNotifications();
        setInterval(loadNotifications, 30000); // Poll every 30 seconds
    });
</script>
