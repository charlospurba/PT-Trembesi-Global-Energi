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

                    <!-- Form -->
<form class="p-6 space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Name</label>
        <input type="text" class="w-full border rounded px-3 py-2 hover:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" class="w-full border rounded px-3 py-2 hover:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Phone Number</label>
        <input type="text" class="w-full border rounded px-3 py-2 hover:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Role</label>
        <select class="w-full border rounded px-3 py-2 hover:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            <option value="">-- Select Role --</option>
            <option value="admin">Project Manager</option>
            <option value="procurement">Procurement</option>
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Status</label>
        <select class="w-full border rounded px-3 py-2 hover:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            <option value="">-- Select Status --</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Project Code</label>
        <input type="text" class="w-full border rounded px-3 py-2 hover:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Username</label>
        <input type="text" class="w-full border rounded px-3 py-2 hover:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" class="w-full border rounded px-3 py-2 hover:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
    </div>

    <!-- Tombol Aksi -->
    <div class="flex justify-end gap-3 pt-4">
        <a href="{{ route('superadmin.dashboard') }}"
           class="flex items-center gap-2 bg-red-600 text-white px-5 py-2 rounded-md shadow hover:bg-red-700 text-sm font-medium transition duration-150">
            <i class="fas fa-times"></i> Cancel
        </a>
        <button type="submit"
                class="flex items-center gap-2 bg-[#2962FF] text-white px-5 py-2 rounded-md shadow hover:bg-blue-700 text-sm font-medium transition duration-150">
            <i class="fas fa-save"></i> Save
        </button>
    </div>
</form>

                        <!-- Tombol Aksi -->
                        <div class="flex justify-end gap-3 pt-4">
                            <a href="{{ route('superadmin.dashboard') }}"
                               class="flex items-center gap-2 bg-red-600 text-white px-5 py-2 rounded-md shadow hover:bg-red-700 text-sm font-medium">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit"
                                    class="flex items-center gap-2 bg-[#2962FF] text-white px-5 py-2 rounded-md shadow hover:bg-blue-700 text-sm font-medium">
                                <i class="fas fa-save"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
