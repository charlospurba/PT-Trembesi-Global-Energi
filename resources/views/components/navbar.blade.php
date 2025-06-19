<!-- Navbar Component -->
<nav class="navbar bg-red-600 p-2 px-5 w-full shadow-md z-50">
    <div class="nav-container">
        <div class="logo-section">
            @php
                $role = Auth::check() ? Auth::user()->role : null;

                $dashboardLink = match ($role) {
                    'procurement' => route('procurement.dashboardproc'),
                    'superadmin' => route('superadmin.dashboard'),
                    'product_manager' => route('dashboard.productmanager'),
                    default => route('dashboard'),
                };
            @endphp

            <a href="{{ $dashboardLink }}" class="logo">
                <img src="{{ asset('assets/images/logo_trembesi.png') }}" alt="Trembesi Logo" class="logo-img">
            </a>
        </div>

        <!-- Search Form -->
        <form id="searchForm" action="/search" method="GET"
            style="flex-grow: 1; max-width: 600px; min-width: 300px; margin-right: 10px;">
            <div
                style="display: flex; width: 100%; border-radius: 999px; overflow: hidden; background-color: transparent; border: 1px solid white; align-items: center; height: 45px;">
                <div style="padding: 0 15px; color: white; display: flex; align-items: center;">
                    <i class="fas fa-search" style="font-size: 20px;"></i>
                </div>
                <input type="search" name="query" placeholder="Cari produk atau vendor" aria-label="Search"
                    style="flex-grow: 1; border: none; outline: none; height: 100%; font-size: 16px; padding: 0 10px; color: white; background-color: transparent;">
                <button type="submit"
                    style="padding: 0 20px; height: 100%; background-color: white; color: black; border: none; font-weight: bold; font-size: 16px; cursor: pointer; border-top-right-radius: 999px; border-bottom-right-radius: 999px;">Search</button>
            </div>
        </form>

        <div class="nav-right">
            <a href="/cart" class="nav-icon">
                <i class="fas fa-shopping-cart"></i>
                <span class="badge cart-badge" id="cartBadge" style="display: none;">0</span>
            </a>
            <div class="notification-dropdown" style="position: relative; display: inline-block;">
                <a href="#" class="nav-icon" onclick="toggleNotificationDropdown(event)">
                    <i class="fas fa-bell"></i>
                    <span class="badge notification-badge" id="notificationBadge" style="display: none;">0</span>
                </a>
                <div id="notificationDropdown" class="dropdown-menu"
                    style="position: absolute; top: 100%; right: 0; background-color: white; color: black; border-radius: 5px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); display: none; min-width: 250px; z-index: 999;">
                    <div id="notificationList" style="max-height: 300px; overflow-y: auto;">
                        <!-- Notifications will be loaded here -->
                    </div>
                </div>
            </div>
            <!-- Profile Dropdown -->
            <div class="profile-dropdown" style="position: relative;">
                <div class="profile-trigger" onclick="toggleProfileDropdown()"
                    style="cursor: pointer; display: flex; align-items: center; color: white;">
                    @auth
                        @php
                            $profilePicture = Auth::user()->profile_picture
                                ? asset('storage/profile_picture/' . Auth::user()->profile_picture)
                                : asset('assets/images/default-profile.png');
                        @endphp
                        <div style="width: 36px; height: 36px; border-radius: 50%; overflow: hidden; margin-right: 8px;">
                            <img src="{{ $profilePicture }}" alt="Profile Picture"
                                style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <span>{{ Auth::user()->name }}</span>
                    @endauth

                    @guest
                        <i class="fas fa-user-circle" style="font-size: 24px; margin-right: 8px;"></i>
                        <span>Guest</span>
                    @endguest

                    <i class="fas fa-caret-down" style="margin-left: 5px;"></i>
                </div>

                <!-- Dropdown Menu -->
                <div id="profileDropdown" class="dropdown-menu"
                    style="position: absolute; top: 100%; right: 0; background-color: white; color: black; border-radius: 5px; box-shadow: 0 2px10px rgba(0,0,0,0.1); display: none; min-width: 150px; z-index: 999;">
                    <a href="/dashboard/profile" class="dropdown-item"
                        style="display: block; padding: 10px 15px; text-decoration: none; color: black;">My Profile</a>
                    <form id="logoutForm" method="POST" action="/logout" style="margin: 0;">
                        @csrf
                        <button type="button" id="logoutBtn" class="dropdown-item"
                            style="width: 100%; text-align: left; background: none; border: none; padding: 10px 15px; cursor: pointer;">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
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
        dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";
        document.getElementById("profileDropdown").style.display = "none";
        if (dropdown.style.display === "block") {
            loadNotifications();
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

    function loadNotifications() {
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
                        ${notification.type === 'e-billing' ? `<a href="/storage/${notification.data.pdf_path}" target="_blank" style="color: #3085d6; text-decoration: none;">View E-Billing</a>` : ''}
                    `;
                        div.addEventListener('click', () => markAsRead(notification.id));
                        notificationList.appendChild(div);
                    });
                }
                const badge = document.getElementById('notificationBadge');
                badge.textContent = data.unread_count;
                badge.style.display = data.unread_count > 0 ? 'inline-block' : 'none';
            });
    }

    function markAsRead(notificationId) {
        fetch(`/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(() => loadNotifications());
    }

    // Logout with SweetAlert
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

    // Initialize cart and notification badges
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
    });
</script>
