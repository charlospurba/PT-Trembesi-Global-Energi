<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign In - Trembesi Manunggal Energi</title>
    <link rel="icon" href="{{ asset('assets/images/logo_merah.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-200 font-sans min-h-screen flex items-center justify-center">
    <div class="flex flex-col md:flex-row w-full max-w-5xl bg-white rounded-xl shadow-2xl overflow-hidden">
        <!-- Left Section - Logo and Branding -->
        <div
            class="flex-1 bg-gradient-to-br from-red-500 via-red-600 to-red-700 text-white flex flex-col justify-center items-center text-center p-12 relative overflow-hidden">
            <!-- Background decorative circles -->
            <div
                class="absolute top-0 left-0 w-80 h-80 bg-red-400 rounded-full opacity-20 -translate-x-1/2 -translate-y-1/2">
            </div>
            <div
                class="absolute bottom-0 right-0 w-96 h-96 bg-red-400 rounded-full opacity-20 translate-x-1/3 translate-y-1/3">
            </div>

            <!-- Logo -->
            <div class="relative z-10 mb-8">
                <div>
                    <img src="{{ asset('assets/images/logo_trembesi.png') }}" alt="logo_trembesi"
                        class="w-full h-full object-contain">
                </div>
            </div>
        </div>

        <!-- Right Section - Login Form -->
        <div class="flex-1 p-12 flex flex-col justify-center bg-white">
            <div class="max-w-md mx-auto w-full">
                <!-- Header -->
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Sign In</h2>
                    <p class="text-gray-600">Welcome back! Please sign in to your account.</p>
                </div>

                @if ($errors->has('login'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        {{ $errors->first('login') }}
                    </div>
                @endif

                @if ($errors->has('inactive'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        {{ $errors->first('inactive') }}
                    </div>
                @endif

                @if ($errors->has('role'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        {{ $errors->first('role') }}
                    </div>
                @endif

                <!-- Login Form -->
                <form class="space-y-6" method="POST" action="{{ route('login') }}">
                    @csrf
                    <!-- Username Field -->
                    <div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input type="text" name="username" id="username"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent bg-gray-50 text-gray-900 placeholder-gray-500"
                                placeholder="username" required>
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" name="password" id="password"
                                class="block w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent bg-gray-50 text-gray-900 placeholder-gray-500"
                                placeholder="password" required>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <button type="button" class="text-gray-400 hover:text-gray-600"
                                    onclick="togglePassword()">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember"
                            class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 rounded focus:ring-red-500 focus:ring-2">
                        <label for="remember" class="ml-2 text-sm text-gray-700 cursor-pointer">
                            Remember me
                        </label>
                    </div>

                    <!-- Sign In Button -->
                    <button type="submit"
                        class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 shadow-lg">
                        Sign In
                    </button>
                </form>

                <!-- Sign Up Link -->
                <div class="mt-8 text-center text-sm text-gray-600">
                    Don't have account ?
                    <a href="/signup"
                        class="text-red-600 hover:text-red-700 font-semibold hover:underline transition duration-200">
                        sign up
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>