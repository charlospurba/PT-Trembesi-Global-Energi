@extends('layouts.app')

@section('content')
    <!-- Include Navbar Component -->
    @include('components.navadmin')

        <div class="min-h-screen bg-gray-100">
            <div class="max-w-5xl mx-auto px-4 py-8">
        <!-- Back to Dashboard Button -->
        <div class="mb-6">
            <a href="{{ route('superadmin.dashboard') }}"
            class="inline-flex items-center bg-red-500 text-white text-sm font-medium px-4 py-2 rounded-lg shadow hover:bg-red-600 transition">
                ← Back to Dashboard
            </a>
        </div>

            <!-- General Information Card -->
            <div class="bg-white p-8 rounded-xl shadow-sm mb-8">
                <h2 class="text-xl font-bold mb-6 text-gray-800">General Information</h2>

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Profile Picture -->
                    <div class="text-center mb-8">
                        <div class="w-32 h-32 rounded-full bg-gray-100 mx-auto overflow-hidden mb-4">
                            @if ($user && $user->profile_picture)
                                <img id="profilePreview"
                                    src="{{ asset('storage/profile_picture/' . $user->profile_picture) . '?t=' . time() }}"
                                    alt="Profile Picture" 
                                    class="w-full h-full object-cover">
                            @else
                                <img id="profilePreview" 
                                    src="https://via.placeholder.com/120?text=No+Image"
                                    alt="Profile Picture" 
                                    class="w-full h-full object-cover">
                            @endif
                        </div>

                        <input id="profilePictureInput" 
                               type="file" 
                               name="profile_picture" 
                               accept="image/*"
                               class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg cursor-pointer transition">
                        
                        <div class="text-xs text-gray-500 mt-2">
                            Image formats .jpg .jpeg .png and max size 300KB
                        </div>
                    </div>

                    <!-- Name Field -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                        <input id="name" 
                               name="name" 
                               type="text" 
                               value="{{ $user->name }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition">
                    </div>

                    <!-- Save Button -->
                    <div class="flex justify-end">
                        <button type="submit"
                                class="bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-6 rounded-lg transition">
                            Save
                        </button>
                    </div>
                </form>
            </div>

            <!-- Email and Phone Information Card -->
            <div class="bg-white p-8 rounded-xl shadow-sm">
                <h2 class="text-xl font-bold mb-6 text-gray-800">Email and Phone Number</h2>

                <!-- Email Field -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input id="email" 
                           type="email" 
                           value="{{ $user->email }}" 
                           readonly
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 cursor-not-allowed">
                </div>

                <!-- Phone Field -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                    <input id="phone" 
                           type="text" 
                           value="{{ $user->phone_number }}" 
                           readonly
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 cursor-not-allowed">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('profilePictureInput').addEventListener('change', function (e) {
            const file = e.target.files[0];
            const preview = document.getElementById('profilePreview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush