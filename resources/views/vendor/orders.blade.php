@extends('layouts.app')

@section('content')
@include('components.navvendor')

<div class="flex min-h-screen bg-gray-100">
    @include('components.sidevendor')

    <main class="flex-1 p-6">
        <div class="bg-white p-6 rounded shadow-md">
            <h2 class="text-2xl font-semibold text-red-600 mb-6">Orders Status</h2>

            <!-- Tabs & Search -->
            <div class="flex flex-wrap items-center mb-4 gap-3">
                <a href="#" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">All</a>
                <a href="#" class="bg-gray-200 hover:bg-red-100 text-gray-800 px-4 py-2 rounded transition">Awaiting Shipment (2)</a>
                <a href="#" class="bg-gray-200 hover:bg-red-100 text-gray-800 px-4 py-2 rounded transition">Shipped (7)</a>
                <a href="#" class="bg-gray-200 hover:bg-red-100 text-gray-800 px-4 py-2 rounded transition">Completed (14)</a>
                <a href="#" class="bg-gray-200 hover:bg-red-100 text-gray-800 px-4 py-2 rounded transition">Cancelled (5)</a>

                <!-- Search Box -->
                <div class="ml-auto relative w-64">
                    <input type="text" placeholder="Search..." class="w-full border border-gray-300 rounded pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16.65 11a5.65 5.65 0 11-11.3 0 5.65 5.65 0 0111.3 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto border-t border-gray-300">
                <table class="w-full text-sm mt-2 table-auto">
                    <thead>
                        <tr class="bg-gray-50 text-left text-gray-700">
                            <th class="p-3 font-medium w-1/6">Status</th>
                            <th class="p-3 font-medium w-1/3">Orders</th>
                            <th class="p-3 font-medium w-1/2">Shipment</th>
                            <th class="p-3 font-medium w-1/6">View Detail</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <!-- Repeatable Order Rows -->
                        <tr class="border-t border-gray-200">
                            <td class="p-3"><span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-medium">Awaiting Shipment</span></td>
                            <td class="p-3">Gracesia Romauli Marbun<br><small class="text-gray-500">gracesiaromauli10@gmail.com</small><br><small class="text-gray-500">Order Date: 11 Juni 2025</small></td>
                            <td class="p-3 text-sm leading-6">Mulia business park gedung JJ.<br>Letjen MT. Haryono kav SB-60<br>Jakarta Selatan Pancoran, Jakarta 12780<br>Telepon: 081318600027</td>
                            <td class="p-3">
                                <a href="{{ route('vendor.view') }}" class="bg-blue-500 text-white px-4 py-1.5 rounded text-sm hover:bg-blue-600 transition">View</a>
                            </td>
                        </tr>

                        <tr class="border-t border-gray-200">
                            <td class="p-3"><span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-medium">Shipped</span></td>
                            <td class="p-3">Charlos Pardomuan Purba<br><small class="text-gray-500">gracesiaromauli10@gmail.com</small><br><small class="text-gray-500">Order Date: 11 Juni 2025</small></td>
                            <td class="p-3 text-sm leading-6">Mulia business park gedung JJ.<br>Letjen MT. Haryono kav SB-60<br>Jakarta Selatan Pancoran, Jakarta 12780<br>Telepon: 081318600027</td>
                            <td class="p-3">
                                <a href="{{ route('vendor.view') }}" class="bg-blue-500 text-white px-4 py-1.5 rounded text-sm hover:bg-blue-600 transition">View</a>
                            </td>
                        </tr>

                        <tr class="border-t border-gray-200">
                            <td class="p-3"><span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-medium">Completed</span></td>
                            <td class="p-3">Maria Nasution<br><small class="text-gray-500">gracesiaromauli10@gmail.com</small><br><small class="text-gray-500">Order Date: 11 Juni 2025</small></td>
                            <td class="p-3 text-sm leading-6">Mulia business park gedung JJ.<br>Letjen MT. Haryono kav SB-60<br>Jakarta Selatan Pancoran, Jakarta 12780<br>Telepon: 081318600027</td>
                            <td class="p-3">
                                <a href="{{ route('vendor.view') }}" class="bg-blue-500 text-white px-4 py-1.5 rounded text-sm hover:bg-blue-600 transition">View</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
@endsection
