@extends('layouts.app')

@section('content')
    @include('components.navadmin')

    <div class="flex h-screen overflow-hidden bg-white">
        @include('components.sideadmin')

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Main Content -->
        <div class="flex-1 bg-[#f2f2f2] h-screen overflow-y-auto">
            <div class="p-6">
                <div class="bg-white rounded-xl shadow-md overflow-hidden">

                    <!-- Header Merah -->
                    <div class="bg-red-600 text-white rounded-t-xl px-6 py-3 font-semibold">
                        Edit User
                    </div>

                    <!-- Form -->
                    <form action="{{ route('superadmin.users.update', ['id' => $user->id]) }}" method="POST"
                        class="p-6 space-y-4">
                        @csrf

                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" value="{{ $user->name }}" class="w-full border rounded px-3 py-2 bg-gray-100"
                                disabled />
                        </div>

                        <!-- Username -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Username</label>
                             <input type="text" value="{{ $user->username }}" class="w-full border rounded px-3 py-2 bg-gray-100"
                                disabled />
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" value="{{ $user->email }}"
                                class="w-full border rounded px-3 py-2 bg-gray-100" disabled />
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="text" value="{{ $user->phone_number }}"
                                class="w-full border rounded px-3 py-2 bg-gray-100" disabled />
                        </div>

                        <!-- Role -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Role</label>
                            <input type="text" value="{{ ucfirst($user->role) }}"
                                class="w-full border rounded px-3 py-2 bg-gray-100" disabled />
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" class="w-full border rounded px-3 py-2">
                                <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $user->status !== 'active' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <!-- Project Code -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Project Code</label>
                            <input type="text" value="{{ $user->project_kode }}"
                                class="w-full border rounded px-3 py-2 bg-gray-100" disabled />
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end gap-4 pt-4">
                            <a href="{{ route('superadmin.dashboard') }}"
                                class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">Cancel</a>
                            <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Save</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection