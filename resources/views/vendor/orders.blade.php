@extends('layouts.app')

@section('content')
    @include('components.navvendor')

    <div class="flex min-h-screen">
        @include('components.sidevendor')
        <!-- Main Content -->
        <main class="flex-1 p-6">
            <div class="bg-white p-6 rounded shadow">
                <h2 class="text-2xl font-semibold text-red-600 mb-4">Orders Status</h2>

                <!-- Tabs & Search -->
<div class="flex flex-wrap items-center mb-4 gap-3">
    <a href="#" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">All</a>
    <a href="#" class="bg-gray-200 hover:bg-red-100 px-4 py-2 rounded">Awaiting Shipment (2)</a>
    <a href="#" class="bg-gray-200 hover:bg-red-100 px-4 py-2 rounded">Shipped (7)</a>
    <a href="#" class="bg-gray-200 hover:bg-red-100 px-4 py-2 rounded">Completed (14)</a>
    <a href="#" class="bg-gray-200 hover:bg-red-100 px-4 py-2 rounded">Cancelled (5)</a>

    <!-- Search with icon -->
    <div class="ml-auto relative">
        <input type="text" placeholder="Search..." class="border px-4 py-2 pl-10 rounded w-64 focus:outline-none focus:ring-2 focus:ring-red-400">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16.65 11a5.65 5.65 0 11-11.3 0 5.65 5.65 0 0111.3 0z" />
        </svg>
    </div>
</div>


                <!-- Orders Table -->
                <div class="overflow-x-auto border-t">
                    <table class="w-full text-sm mt-2">
                        <thead>
                            <tr class="bg-gray-50 text-left">
                                <th class="p-3 font-medium">Status</th>
                                <th class="p-3 font-medium">Orders</th>
                                <th class="p-3 font-medium">Shipment</th>
                                <th class="p-3 font-medium">View Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Order 1 -->
                            <tr class="border-t">
                                <td class="p-3">
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">Awaiting Shipment</span>
                                </td>
                                <td class="p-3">
                                    Gracesia Romauli Marbun<br>
                                    <small>gracesiaromauli10@gmail.com</small><br>
                                    <small>Order Date: 11 Juni 2025</small>
                                </td>
                                <td class="p-3 text-sm">
                                    Mulia business park gedung JJ.<br>
                                    Letjen MT. Haryono kav SB-60<br>
                                    Jakarta Selatan Pancoran, 12780<br>
                                    Telp: 081318600027
                                </td>
                                <td class="p-3">
                                    <a href="#" class="bg-blue-500 text-white px-3 py-1 rounded text-sm">View</a>
                                </td>
                            </tr>

                            <!-- Order 2 -->
                            <tr class="border-t">
                                <td class="p-3">
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs">Shipped</span>
                                </td>
                                <td class="p-3">
                                    Charlos Pardomuan Purba<br>
                                    <small>gracesiaromauli10@gmail.com</small><br>
                                    <small>Order Date: 11 Juni 2025</small>
                                </td>
                                <td class="p-3 text-sm">
                                    Mulia business park gedung JJ.<br>
                                    Letjen MT. Haryono kav SB-60<br>
                                    Jakarta Selatan Pancoran, 12780<br>
                                    Telp: 081318600027
                                </td>
                                <td class="p-3">
                                    <a href="#" class="bg-blue-500 text-white px-3 py-1 rounded text-sm">View</a>
                                </td>
                            </tr>

                            <!-- Order 3 -->
                            <tr class="border-t">
                                <td class="p-3">
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">Completed</span>
                                </td>
                                <td class="p-3">
                                    Maria Nasution<br>
                                    <small>gracesiaromauli10@gmail.com</small><br>
                                    <small>Order Date: 11 Juni 2025</small>
                                </td>
                                <td class="p-3 text-sm">
                                    Mulia business park gedung JJ.<br>
                                    Letjen MT. Haryono kav SB-60<br>
                                    Jakarta Selatan Pancoran, 12780<br>
                                    Telp: 081318600027
                                </td>
                                <td class="p-3">
                                    <a href="#" class="bg-blue-500 text-white px-3 py-1 rounded text-sm">View</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
@endsection
