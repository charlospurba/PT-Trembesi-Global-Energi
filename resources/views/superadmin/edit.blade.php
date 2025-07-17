@extends('layouts.app')

@section('content')
    @include('components.navadmin')

    <div class="flex h-screen overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100">
        @include('components.sideadmin')

        {{-- Success Alert --}}
        @if (session('success'))
            <script>
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-lg transition-colors duration-200'
                    }
                });
            </script>
        @endif

        <!-- Main Content -->
        <div class="flex-1 p-8 overflow-y-auto">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit User</h1>
                        <p class="text-gray-600">Update user information and status</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('superadmin.dashboard') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Dashboard
                        </a>

                        @php
                            $statusConfig = $user->status === 'active' ? [
                                'bg' => 'bg-green-100',
                                'text' => 'text-green-800',
                                'ring' => 'ring-green-600/20',
                                'icon' => '🟢'
                            ] : [
                                'bg' => 'bg-red-100',
                                'text' => 'text-red-800',
                                'ring' => 'ring-red-600/20',
                                'icon' => '🔴'
                            ];
                        @endphp

                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} ring-1 {{ $statusConfig['ring'] }}">
                            <span class="mr-2">{{ $statusConfig['icon'] }}</span>
                            {{ ucfirst($user->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Card Content -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                <!-- Header Card -->
                <div class="bg-gradient-to-r from-red-600 to-red-700 text-white px-8 py-6">
                    <div class="flex items-center space-x-4">
                        <div class="h-16 w-16 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center">
                            <span class="text-white font-bold text-2xl">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
                            <p class="text-red-100 text-sm">{{ ucfirst($user->role) }} • {{ $user->email }}</p>
                            <p class="text-red-100 text-xs mt-1">User ID: {{ $user->id }}</p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('superadmin.users.update', ['id' => $user->id]) }}" method="POST" class="p-8">
                    @csrf

                    <!-- User Info Section -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                            <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            User Information
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach ([
                                ['label' => 'Full Name', 'value' => $user->name],
                                ['label' => 'Username', 'value' => $user->username],
                                ['label' => 'Email Address', 'value' => $user->email],
                                ['label' => 'Phone Number', 'value' => $user->phone_number],
                                ['label' => 'User Role', 'value' => ucfirst($user->role)],
                                ['label' => 'Procurement Code', 'value' => $user->procurement_kode]
                            ] as $field)
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700">{{ $field['label'] }}</label>
                                    <input type="text" value="{{ $field['value'] }}"
                                           class="w-full border border-gray-200 rounded-lg px-4 py-3 bg-gray-50 text-gray-500 cursor-not-allowed"
                                           disabled />
                                    <p class="text-xs text-gray-500">This field cannot be modified</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Editable Section -->
                    <div class="mb-8 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Editable Settings
                        </h3>

                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">Account Status</label>
                            <select name="status"
                                    class="w-full border border-blue-300 rounded-lg px-4 py-3 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>
                                    🟢 Active - User can access the system
                                </option>
                                <option value="inactive" {{ $user->status !== 'active' ? 'selected' : '' }}>
                                    🔴 Inactive - User access is suspended
                                </option>
                            </select>
                            <p class="text-xs text-blue-600">⚠️ This is the only field you can modify</p>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <div class="text-sm text-gray-500 flex items-center space-x-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Only the status field can be modified</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('superadmin.dashboard') }}"
                               class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Cancel
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm font-semibold rounded-lg transition-transform duration-200 transform hover:scale-105 shadow-md hover:shadow-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
