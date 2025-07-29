@extends('layouts.app')

@section('content')
    @include('components.navadmin')

    <div class="flex h-screen overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100">
        @include('components.sideadmin')

        <div class="flex-1 bg-transparent h-screen overflow-y-auto">
            <div class="p-6">

                <!-- Breadcrumb -->
                <div class="mb-6">
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('superadmin.dashboard') }}"
                                   class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">
                                    <i class="fas fa-home mr-2"></i>
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                    <span class="text-sm font-medium text-gray-500">Add New User</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>

                <!-- Card -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200/50 backdrop-blur-sm">

                    <!-- Header -->
                    <div class="bg-gradient-to-r from-red-600 to-red-700 text-white px-8 py-6">
                        <div class="flex items-center">
                            <div class="bg-white/20 p-3 rounded-lg mr-4">
                                <i class="fas fa-user-plus text-2xl"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold">Add New User</h1>
                                <p class="text-red-100 mt-1">Create a new user account with role permissions</p>
                            </div>
                        </div>
                    </div>

                    <!-- Errors -->
                    @if ($errors->any())
                        <div class="mx-8 mt-6">
                            <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-lg">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-triangle text-red-400"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                                        <div class="mt-2 text-sm text-red-700">
                                            <ul class="list-disc list-inside space-y-1">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Form -->
                    <form action="{{ route('superadmin.users.store') }}" method="POST" class="p-8">
                        @csrf
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                            <!-- Personal Info Header -->
                            <div class="lg:col-span-2">
                                <div class="border-b border-gray-200 pb-4 mb-6">
                                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                        <i class="fas fa-user text-blue-600 mr-2"></i>
                                        Personal Information
                                    </h3>
                                    <p class="text-sm text-gray-600 mt-1">Basic user details and contact information</p>
                                </div>
                            </div>

                            <!-- Full Name -->
                            <div class="group transition-all duration-200 hover:-translate-y-1 focus-within:scale-[1.02]">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-user text-gray-400 mr-2"></i>Full Name
                                </label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                       class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-700
                                              focus:border-blue-500 focus:ring-0 focus:shadow-lg focus:shadow-blue-500/20 transition-transform duration-200"
                                       placeholder="Enter full name" />
                            </div>

                            <!-- Email -->
                            <div class="group transition-all duration-200 hover:-translate-y-1 focus-within:scale-[1.02]">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-envelope text-gray-400 mr-2"></i>Email Address
                                </label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                       class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-700
                                              focus:border-blue-500 focus:ring-0 focus:shadow-lg focus:shadow-blue-500/20 transition-transform duration-200"
                                       placeholder="user@example.com" />
                            </div>

                            <!-- Phone -->
                            <div class="group transition-all duration-200 hover:-translate-y-1 focus-within:scale-[1.02]">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-phone text-gray-400 mr-2"></i>Phone Number
                                </label>
                                <input type="text" name="phone_number" value="{{ old('phone_number') }}"
                                       class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-700
                                              focus:border-blue-500 focus:ring-0 focus:shadow-lg focus:shadow-blue-500/20 transition-transform duration-200"
                                       placeholder="+62 812 3456 7890" />
                            </div>

                            <!-- Account Settings -->
                            <div class="lg:col-span-2">
                                <div class="border-b border-gray-200 pb-4 mb-6 mt-8">
                                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                        <i class="fas fa-cog text-green-600 mr-2"></i>
                                        Account Settings
                                    </h3>
                                    <p class="text-sm text-gray-600 mt-1">Login credentials and account configuration</p>
                                </div>
                            </div>

                            <!-- Username -->
                            <div class="group transition-all duration-200 hover:-translate-y-1 focus-within:scale-[1.02]">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-at text-gray-400 mr-2"></i>Username
                                </label>
                                <input type="text" name="username" value="{{ old('username') }}"
                                       class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-700
                                              focus:border-blue-500 focus:ring-0 focus:shadow-lg focus:shadow-blue-500/20 transition-transform duration-200"
                                       placeholder="username" />
                            </div>

                            <!-- Password -->
                            <div class="group transition-all duration-200 hover:-translate-y-1 focus-within:scale-[1.02]">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-lock text-gray-400 mr-2"></i>Password
                                </label>
                                <div class="relative">
                                    <input type="password" name="password" id="password"
                                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 pr-12 text-gray-700
                                                  focus:border-blue-500 focus:ring-0 focus:shadow-lg focus:shadow-blue-500/20"
                                           placeholder="Enter secure password" />
                                    <button type="button" onclick="togglePassword()"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-eye" id="toggleIcon"></i>
                                    </button>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Minimum 8 characters with letters and numbers</p>
                            </div>

                            <!-- Role Header -->
                            <div class="lg:col-span-2">
                                <div class="border-b border-gray-200 pb-4 mb-6 mt-8">
                                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                        <i class="fas fa-users-cog text-purple-600 mr-2"></i>
                                        Role & Permissions
                                    </h3>
                                    <p class="text-sm text-gray-600 mt-1">User role assignment and project configuration</p>
                                </div>
                            </div>

                            <!-- Role -->
                            <div class="group transition-all duration-200 hover:-translate-y-1 focus-within:scale-[1.02]">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-user-tag text-gray-400 mr-2"></i>Role
                                </label>
                                <select name="role"
                                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-700
                                               focus:border-blue-500 focus:ring-0 focus:shadow-lg focus:shadow-blue-500/20">
                                    <option value="">-- Select Role --</option>
                                    <option value="project_manager" {{ old('role') === 'project_manager' ? 'selected' : '' }}>Project Manager</option>
                                    <option value="procurement" {{ old('role') === 'procurement' ? 'selected' : '' }}>Procurement</option>
                                </select>
                            </div>

                            <!-- Status -->
                            <div class="group transition-all duration-200 hover:-translate-y-1 focus-within:scale-[1.02]">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-toggle-on text-gray-400 mr-2"></i>Status
                                </label>
                                <select name="status"
                                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-700
                                               focus:border-blue-500 focus:ring-0 focus:shadow-lg focus:shadow-blue-500/20">
                                    <option value="">-- Select Status --</option>
                                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <!-- Project Name -->
                            <div class="lg:col-span-2 group transition-all duration-200 hover:-translate-y-1 focus-within:scale-[1.02]">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-code text-gray-400 mr-2"></i>Project Name
                                </label>
                                <input type="text" name="project_name" value="{{ old('project_name') }}"
                                       class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-700
                                              focus:border-blue-500 focus:ring-0 focus:shadow-lg focus:shadow-blue-500/20"/>
                            </div>

                            
                            <!-- Procurement Code -->
                            <div class="lg:col-span-2 group transition-all duration-200 hover:-translate-y-1 focus-within:scale-[1.02]">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-code text-gray-400 mr-2"></i>Procurement Code
                                </label>
                                <input type="text" name="procurement_kode" value="{{ old('procurement_kode') }}"
                                       class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-gray-700
                                              focus:border-blue-500 focus:ring-0 focus:shadow-lg focus:shadow-blue-500/20"
                                       placeholder="PRJ-001" />
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 mt-6 border-t border-gray-200">
                            <a href="{{ route('superadmin.dashboard') }}"
                               class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 
                                      text-gray-700 bg-white rounded-lg hover:bg-gray-50 hover:border-gray-400 
                                      text-sm font-medium transition-all duration-200 focus:outline-none focus:ring-2 
                                      focus:ring-gray-500 focus:ring-offset-2">
                                <i class="fas fa-times mr-1.5 text-xs"></i>
                                Cancel
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center justify-center px-5 py-2 bg-gradient-to-r 
                                           from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 
                                           hover:to-blue-800 text-sm font-medium shadow-md hover:shadow-lg 
                                           transition-transform duration-200 transform hover:scale-105 
                                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <i class="fas fa-save mr-1.5 text-xs"></i>
                                Create User
                            </button>
                        </div>
                    </form>
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
@endsection
