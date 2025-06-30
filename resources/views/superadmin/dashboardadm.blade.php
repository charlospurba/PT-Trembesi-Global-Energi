@extends('layouts.app')
@section('content')
    @include('components.navadmin')

    <div class="flex h-screen overflow-hidden bg-white">
        @include('components.sideadmin')

        <div class="flex-1 bg-[#f2f2f2]">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-md mb-4">
                    <strong class="font-semibold">Success:</strong>
                    <span class="block mt-1">{{ session('success') }}</span>
                </div>
            @endif

            <div class="p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">User Management</h2>

                <div class="flex flex-wrap items-start gap-4 mb-6">
                    <!-- Cards (same as before) -->
                    <!-- Total User -->
                    <div class="bg-white rounded-xl shadow flex items-center px-4 py-3 border-t-4 border-[#FF3D00] w-full sm:w-auto min-w-[180px]">
                        <div class="text-[#FF3D00] text-3xl mr-4">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total User</p>
                            <p class="text-xl font-bold text-gray-800">{{ $totalUsers }}</p>
                        </div>
                    </div>

                    <!-- Procurement -->
                    <div class="bg-white rounded-xl shadow flex items-center px-4 py-3 border-t-4 border-green-500 w-full sm:w-auto min-w-[180px]">
                        <div class="text-green-500 text-3xl mr-4">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Procurement</p>
                            <p class="text-xl font-bold text-gray-800">{{ $totalProcurement }}</p>
                        </div>
                    </div>

                    <!-- Project Manager -->
                    <div class="bg-white rounded-xl shadow flex items-center px-4 py-3 border-t-4 border-yellow-400 w-full sm:w-auto min-w-[180px]">
                        <div class="text-yellow-400 text-3xl mr-4">
                            <i class="fas fa-store"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Project Manager</p>
                            <p class="text-xl font-bold text-gray-800">{{ $totalManager }}</p>
                        </div>
                    </div>

                    <!-- Vendor -->
                    <div class="bg-white rounded-xl shadow flex items-center px-4 py-3 border-t-4 border-[#2962FF] w-full sm:w-auto min-w-[180px]">
                        <div class="text-[#2962FF] text-3xl mr-4">
                            <i class="fas fa-user-tag"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Vendor</p>
                            <p class="text-xl font-bold text-gray-800">{{ $totalVendor }}</p>
                        </div>
                    </div>

                    <!-- Add User Button -->
                    <a href="{{ route('superadmin.add_users') }}"
                        class="ml-auto self-start flex items-center gap-2 bg-[#2962FF] hover:bg-blue-700 text-white font-semibold text-sm px-5 py-2 rounded-md shadow">
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
                                @forelse ($users as $user)
                                    <tr class="text-gray-700">
                                        <td class="py-3">{{ $user->name }}</td>
                                        <td class="py-3">{{ $user->email }}</td>
                                        <td class="py-3 capitalize">{{ $user->role }}</td>
                                        <td class="py-3">
                                            @if ($user->status === 'active')
                                                <span class="text-green-600 font-semibold">Active</span>
                                            @else
                                                <span class="text-gray-500">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="py-3">{{ $user->created_at->format('d M Y') }}</td>
                                        <td class="py-3">
                                            <div class="flex justify-center gap-3">
                                                <!-- Edit Icon -->
                                                <a href="{{ route('superadmin.edit', ['id' => $user->id]) }}"
                                                    class="text-blue-600 hover:text-blue-800">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <!-- Delete Icon with SweetAlert2 -->
                                                <button type="button"
                                                    class="text-red-600 hover:text-red-800 delete-button"
                                                    data-id="{{ $user->id }}"
                                                    data-name="{{ $user->name }}"
                                                    data-url="{{ route('superadmin.users.destroy', $user->id) }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-4 text-gray-500 italic">No users found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const buttons = document.querySelectorAll('.delete-button');

            buttons.forEach(button => {
                button.addEventListener('click', function () {
                    const userName = this.dataset.name;
                    const url = this.dataset.url;

                    Swal.fire({
                        icon: 'error',
                        title: 'Are you sure?',
                        html: `Do you really want to delete <strong>${userName}</strong>?<br>This process cannot be undone.`,
                        showCancelButton: true,
                        confirmButtonColor: '#ff0000',
                        cancelButtonColor: '#0066ff',
                        confirmButtonText: 'Delete',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true,
                        focusCancel: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = url;

                            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                            const csrfInput = document.createElement('input');
                            csrfInput.type = 'hidden';
                            csrfInput.name = '_token';
                            csrfInput.value = csrfToken;
                            form.appendChild(csrfInput);

                            const methodInput = document.createElement('input');
                            methodInput.type = 'hidden';
                            methodInput.name = '_method';
                            methodInput.value = 'DELETE';
                            form.appendChild(methodInput);

                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
