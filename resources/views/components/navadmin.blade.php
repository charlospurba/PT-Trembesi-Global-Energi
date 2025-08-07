<header class="bg-red-600 shadow-md p-4 flex justify-between items-center text-white w-full z-50">
    <div class="flex items-center gap-2">
        <!-- Tombol hamburger untuk mobile -->
        <button id="sidebarToggle" class="text-white text-2xl md:hidden mr-2">
            ☰
        </button>

        <div class="logo-section flex items-center gap-2">
            <a href="{{ route('superadmin.dashboard') }}">
                <img src="{{ asset('assets/images/logo_trembesi.png') }}" alt="Logo Trembesi" class="logo-img h-8 w-auto">
            </a>
            <h1 class="text-xl font-bold text-white hidden sm:block">Admin Panel</h1>
        </div>
    </div>

    <!-- Profile Dropdown -->
    <div class="profile-dropdown relative">
        <div class="profile-trigger flex items-center cursor-pointer" onclick="toggleDropdown()">
            @auth
                <span class="mr-2 hidden sm:inline">Hello, {{ Auth::user()->name }}</span>
                @php
                    $profilePicture = Auth::user()->profile_picture
                        ? asset('storage/profile_picture/' . Auth::user()->profile_picture)
                        : asset('assets/images/default-profile.png');
                @endphp
                <div class="w-9 h-9 rounded-full overflow-hidden mr-2">
                    <img src="{{ $profilePicture }}" alt="Profile Picture" class="w-full h-full object-cover">
                </div>
            @endauth
            @guest
                <i class="fas fa-user-circle text-2xl mr-2"></i>
                <span>Guest</span>
            @endguest
            <i class="fas fa-caret-down ml-1"></i>
        </div>

        <div id="dropdownMenu" class="absolute top-full right-0 bg-white text-black rounded shadow-md hidden min-w-[150px] z-50">
            <a href="/dashboard/profilesa" class="block px-4 py-2 hover:bg-gray-100">My Profile</a>
            <form id="logoutForm" method="POST" action="/logout" class="m-0">
                @csrf
                <button type="button" id="logoutBtn" class="w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
            </form>
        </div>
    </div>
</header>

<script>
    function toggleDropdown() {
        const dropdown = document.getElementById("dropdownMenu");
        dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";
    }

    window.addEventListener("click", function (e) {
        const trigger = document.querySelector(".profile-trigger");
        const dropdown = document.getElementById("dropdownMenu");
        if (!trigger.contains(e.target)) {
            dropdown.style.display = "none";
        }
    });

    // Logout with SweetAlert
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

</script>
