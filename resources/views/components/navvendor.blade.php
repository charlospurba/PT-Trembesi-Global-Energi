<header class="bg-red-600 shadow-md p-4 flex justify-between items-center text-white w-full z-50">
    <div class="flex items-center gap-2">
        <img src="{{ asset('assets/images/logo_trembesi.png') }}" alt="Logo Trembesi" class="logo-img" />
        <h1 class="text-xl font-bold text-white">Trembesi Shop</h1>
    </div>
      <!-- Profile Dropdown -->
            <div class="profile-dropdown" style="position: relative;">
                <div class="profile-trigger" onclick="toggleDropdown()"
                    style="cursor: pointer; display: flex; align-items: center; color: white;">
                    @auth
                    <span>Hello, {{ Auth::user()->name }} </span> 
                        @php
                            $profilePicture = Auth::user()->profile_picture
                                ? asset('storage/profile_picture/' . Auth::user()->profile_picture)
                                : asset('assets/images/default-profile.png');
                        @endphp
                        <div style="width: 36px; height: 36px; border-radius: 50%; overflow: hidden; margin-right: 8px;">
                            <img src="{{ $profilePicture }}" alt="Profile Picture"
                                style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    @endauth


                    @guest
                        <i class="fas fa-user-circle" style="font-size: 24px; margin-right: 8px;"></i>
                        <span>Guest</span>
                    @endguest

                    <i class="fas fa-caret-down" style="margin-left: 5px;"></i>
                </div>

                <!-- Dropdown Menu -->
                <div id="dropdownMenu" class="dropdown-menu"
                    style="position: absolute; top: 100%; right: 0; background-color: white; color: black; border-radius: 5px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); display: none; min-width: 150px; z-index: 999;">
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
