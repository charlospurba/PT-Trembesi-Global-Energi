@extends('layouts.app')

@section('content')
@include('components.navadmin')

<div class="flex h-screen overflow-hidden bg-white">
    @include('components.sideadmin')

    <div class="flex-1 bg-[#f2f2f2] p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Vendor's Request</h2>

        <div class="bg-white rounded-xl shadow-md p-6">
            <table class="w-full text-sm text-left border border-gray-300">
                <thead class="bg-red-600 text-white uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-4 py-2">Username</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Register</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800">
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2">PT. Trembesi</td>
                        <td class="px-4 py-2">trembesi@trembesi.com</td>
                        <td class="px-4 py-2">
                            <span class="bg-green-100 text-green-800 text-xs px-3 py-0.5 rounded-full font-medium">
                                Active
                            </span>
                        </td>
                        <td class="px-4 py-2">Jun 13, 2025</td>
                            <td class="px-4 py-2">
                            <a href="/superadmin/view-detail"
                                style="background-color:#2563eb; color:white; padding:4px 12px; border-radius:6px; font-size:12px; font-weight:500; display:inline-block;">
                                    View
                            </a>
                        </td>
                            <!-- Add User Button -->
                            <a href="{{ route('superadmin.add_users') }}"
                            class="inline-flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white text-[12px] font-medium px-3 py-1 rounded-md">
                                <i class="fas fa-user-plus text-[12px]"></i> Add User
                            </a>
                        </td>
                       
                    </tr>
                    <tr class="border-t border-gray-200">
                        <td class="px-4 py-2">PT. Janji Maria Menteng Agung</td>
                        <td class="px-4 py-2">mariajanji@maria.com</td>
                        <td class="px-4 py-2">
                            <span class="bg-yellow-100 text-yellow-800 text-xs px-3 py-0.5 rounded-full font-medium">
                                Pending
                            </span>
                        </td>
                        <td class="px-4 py-2">Jun 13, 2025</td>
                        <td class="px-4 py-2">
                            <a href="/superadmin/view-detail"
                                style="background-color:#2563eb; color:white; padding:4px 12px; border-radius:6px; font-size:12px; font-weight:500; display:inline-block;">
                                    View
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
