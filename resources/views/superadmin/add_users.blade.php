@extends('layouts.app')

@section('content')
    @include('components.navadmin')

    <div class="flex h-screen overflow-hidden bg-white">
        <!-- Sidebar -->
        @include('components.sideadmin')

        <!-- Main Content -->
        <div class="flex-1 bg-[#f2f2f2]">
            <div class="p-6">
                <div class="bg-white rounded-xl shadow-md">
                    <!-- Header Merah Add New User -->
                    <div class="bg-red-600 text-white rounded-t-xl px-6 py-3 font-semibold">
                        Add New User
                    </div>

                    <!-- Form -->
                    <form class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium">Name</label>
                            <input type="text" class="w-full border rounded px-3 py-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Email</label>
                            <input type="email" class="w-full border rounded px-3 py-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Phone Number</label>
                            <input type="text" class="w-full border rounded px-3 py-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Role</label>
                            <select class="w-full border rounded px-3 py-2">
                                <option value="">-- Select Role --</option>
                                <option value="admin">Project Manager</option>
                                <option value="procurement">Procurement</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Status</label>
                            <select class="w-full border rounded px-3 py-2">
                                <option value="">-- Select Status --</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Project Code</label>
                            <input type="text" class="w-full border rounded px-3 py-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Username</label>
                            <input type="text" class="w-full border rounded px-3 py-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Password</label>
                            <input type="password" class="w-full border rounded px-3 py-2" />
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end gap-3 pt-4">
                            <a href="{{ route('superadmin.dashboard') }}" class="bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-700">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
