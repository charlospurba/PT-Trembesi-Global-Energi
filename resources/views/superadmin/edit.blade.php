@extends('layouts.app')

@section('content')
@include('components.navadmin')

<div class="flex h-screen overflow-hidden bg-white">
    @include('components.sideadmin')

    <!-- Main Content -->
    <div class="flex-1 bg-[#f2f2f2] h-screen overflow-y-auto">
        <div class="p-6">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">

                <!-- Header Merah -->
                <div class="bg-red-600 text-white rounded-t-xl px-6 py-3 font-semibold">
                    Edit User
                </div>

                <!-- Form -->
                <form action="#" method="POST" class="p-6 space-y-4">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" value="Maria Nasution"
                            class="w-full border rounded px-3 py-2 bg-gray-100" disabled />
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" value="maria@trembesi.com"
                            class="w-full border rounded px-3 py-2 bg-gray-100" disabled />
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="text" value="0822-7544-8126"
                            class="w-full border rounded px-3 py-2 bg-gray-100" disabled />
                    </div>

                    <!-- Role -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Role</label>
                        <input type="text" value="Project Manager"
                            class="w-full border rounded px-3 py-2 bg-gray-100" disabled />
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" class="w-full border rounded px-3 py-2">
                            <option value="Active" selected>Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>

                    <!-- Project Code -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Project Code</label>
                        <input type="text" value="1"
                            class="w-full border rounded px-3 py-2 bg-gray-100" disabled />
                    </div>

                    <!-- Username -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" value="mariant"
                            class="w-full border rounded px-3 py-2 bg-gray-100" disabled />
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" value="maria0014"
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
