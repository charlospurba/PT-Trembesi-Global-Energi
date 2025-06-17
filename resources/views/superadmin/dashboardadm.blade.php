@extends('layouts.app')

@section('content')
    @include('components.navadmin')

    <div class="flex h-screen overflow-hidden bg-white">
        <!-- Sidebar -->
        @include('components.sideadmin')

        <!-- Main Content -->
        <div class="flex-1 bg-[#f2f2f2]">

            <!-- Content -->
            <div class="p-6">
                <h2 class="text-xl font-bold mb-4">User Management</h2>

               <!-- Summary Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-xl shadow-lg p-5 border-l-4 border-[#FF3D00] flex items-center">
        <div class="text-[#FF3D00] text-3xl mr-4">
            <i class="fas fa-users"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500">Total User</p>
            <p class="text-2xl font-bold text-gray-800">24</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-5 border-l-4 border-green-500 flex items-center">
        <div class="text-green-500 text-3xl mr-4">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500">Procurement</p>
            <p class="text-2xl font-bold text-gray-800">8</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-5 border-l-4 border-yellow-400 flex items-center">
        <div class="text-yellow-400 text-3xl mr-4">
            <i class="fas fa-store"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500">Vendor</p>
            <p class="text-2xl font-bold text-gray-800">20</p>
        </div>
    </div>
</div>
                <!-- Add User Button -->
                <div class="flex justify-end mb-4">
                    <a href="{{ route('admin.users.create') }}"
                       class="bg-[#2962FF] hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-md shadow flex items-center gap-2 text-sm">
                        <i class="fas fa-plus"></i> Add User
                    </a>
                </div>

                <!-- User Table -->
                <div class="bg-white rounded-xl shadow p-4">
                    <h3 class="text-md font-semibold mb-3">User List</h3>
                    <div class="border-2 border-blue-600 rounded-md overflow-hidden">
                        <table class="w-full text-sm text-center">
                            <thead class="bg-white text-red-600 font-semibold">
                                <tr>
                                    <th class="py-2 border-b">User</th>
                                    <th class="py-2 border-b">Email</th>
                                    <th class="py-2 border-b">Role</th>
                                    <th class="py-2 border-b">Status</th>
                                    <th class="py-2 border-b">Created</th>
                                    <th class="py-2 border-b">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-gray-700">
                                    <td class="py-3">-</td>
                                    <td class="py-3">-</td>
                                    <td class="py-3">-</td>
                                    <td class="py-3">-</td>
                                    <td class="py-3">-</td>
                                    <td class="py-3">-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
<!-- Include SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
