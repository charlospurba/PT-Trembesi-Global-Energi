@extends('layouts.app')

@section('content')
    @include('components.navadmin')

    <div class="flex h-screen overflow-hidden bg-white">
        <!-- Sidebar -->
        @include('components.sideadmin')

        <!-- Main Content -->
        <div class="flex-1 bg-[#f2f2f2]">
            <div class="p-6">
                <div class="bg-white rounded-xl shadow-md overflow-hidden">

                    <!-- Header Merah -->
                    <div class="bg-red-600 text-white rounded-t-xl px-6 py-3 font-semibold">
                        Add New User
                    </div>

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form -->
                    <form action="{{ route('superadmin.users.store') }}" method="POST" class="p-6 space-y-4">
                        @csrf

                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full border rounded px-3 py-2 hover:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full border rounded px-3 py-2 hover:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="text" name="phone_number" value="{{ old('phone_number') }}"
                                class="w-full border rounded px-3 py-2 hover:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
                        </div>

                        <!-- Role -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Role</label>
                            <select name="role"
                                class="w-full border rounded px-3 py-2 hover:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                                <option value="">-- Select Role --</option>
                                <option value="project_manager" {{ old('role') === 'project_manager' ? 'selected' : '' }}>project_manager</option>
                                <option value="procurement" {{ old('role') === 'procurement' ? 'selected' : '' }}>procurement</option>
                            </select>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status"
                                class="w-full border rounded px-3 py-2 hover:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                                <option value="">-- Select Status --</option>
                                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                        </div>

                        <!-- Project Code -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Project Code</label>
                            <input type="text" name="project_kode" value="{{ old('project_kode') }}"
                                class="w-full border rounded px-3 py-2 hover:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
                        </div>

                        <!-- Username -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Username</label>
                            <input type="text" name="username" value="{{ old('username') }}"
                                class="w-full border rounded px-3 py-2 hover:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password"
                                class="w-full border rounded px-3 py-2 hover:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="flex justify-end gap-3 pt-4">
                            <a href="{{ route('superadmin.dashboard') }}"
                                class="flex items-center gap-2 bg-red-600 text-white px-5 py-2 rounded-md shadow hover:bg-red-700 text-sm font-medium transition duration-150">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit"
                                class="flex items-center gap-2 bg-blue-600 text-white px-5 py-2 rounded-md shadow hover:bg-blue-700 text-sm font-medium transition duration-150">
                                <i class="fas fa-save"></i> Save
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection