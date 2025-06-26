@extends('layouts.app')

@section('content')
@include('components.navbar')

<!-- Header Section -->
<section class="bg-red-600 text-white py-6 px-6 md:px-12 shadow-md rounded-b-xl mt-4 md:mt-6">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold">Procurement Notes</h1>
            <p class="text-sm md:text-base">Manage your team's procurement needs</p>
        </div>
    </div>
</section>

<!-- Main Content -->
<main class="bg-gray-100 py-10 px-6 md:px-12">
    <div class="max-w-7xl mx-auto bg-white rounded-xl shadow-lg p-8">
        <p class="text-gray-600 text-base md:text-lg mb-6">
            Manage procurement requests efficiently. View and act on requested items with detailed information below.
        </p>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead class="bg-gray-100 border-b border-gray-300 uppercase text-gray-600 text-xs">
                    <tr>
                        <th class="py-4 px-6 font-semibold">Item Name</th>
                        <th class="py-4 px-6 font-semibold">Category</th>
                        <th class="py-4 px-6 font-semibold">Priority</th>
                        <th class="py-4 px-6 font-semibold">Budget</th>
                        <th class="py-4 px-6 font-semibold">Quantity</th>
                        <th class="py-4 px-6 font-semibold">Start Date</th>
                        <th class="py-4 px-6 font-semibold">End Date</th>
                        <th class="py-4 px-6 font-semibold text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 divide-y divide-gray-200">
                    <!-- Excavator Item -->
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-4 px-6 font-medium">Excavator</td>
                        <td class="py-4 px-6">Equipment</td>
                        <td class="py-4 px-6">
                            <span class="inline-block px-3 py-1 text-xs font-bold bg-red-100 text-red-700 rounded-full">High</span>
                        </td>
                        <td class="py-4 px-6">Rp840,000,000</td>
                        <td class="py-4 px-6">5 Units</td>
                        <td class="py-4 px-6">2025-06-12</td>
                        <td class="py-4 px-6">2025-06-30</td>
                        <td class="py-4 px-6 text-center">
                            <a href="{{ route('procurement.detailnote') }}" 
                               class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 text-xs rounded-full font-semibold shadow transition-all duration-150">
                               Detail
                            </a>
                        </td>
                    </tr>

                    <!-- Cement Item -->
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-4 px-6 font-medium">Cement</td>
                        <td class="py-4 px-6">Material</td>
                        <td class="py-4 px-6">
                            <span class="inline-block px-3 py-1 text-xs font-bold bg-red-100 text-red-700 rounded-full">High</span>
                        </td>
                        <td class="py-4 px-6">Rp10,000,000</td>
                        <td class="py-4 px-6">500 Bags</td>
                        <td class="py-4 px-6">2025-06-20</td>
                        <td class="py-4 px-6">2025-06-25</td>
                        <td class="py-4 px-6 text-center">
                            <a href="{{ route('procurement.detailnote') }}" 
                               class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 text-xs rounded-full font-semibold shadow transition-all duration-150">
                               Detail
                            </a>
                        </td>
                    </tr>

                    <!-- Safety Helmet Item -->
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-4 px-6 font-medium">Safety Helmet</td>
                        <td class="py-4 px-6">PPE</td>
                        <td class="py-4 px-6">
                            <span class="inline-block px-3 py-1 text-xs font-bold bg-yellow-100 text-yellow-700 rounded-full">Medium</span>
                        </td>
                        <td class="py-4 px-6">Rp2,500,000</td>
                        <td class="py-4 px-6">100 Pcs</td>
                        <td class="py-4 px-6">2025-06-15</td>
                        <td class="py-4 px-6">2025-06-20</td>
                        <td class="py-4 px-6 text-center">
                            <a href="{{ route('procurement.detailnote') }}" 
                               class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 text-xs rounded-full font-semibold shadow transition-all duration-150">
                               Detail
                            </a>
                        </td>
                    </tr>

                    <!-- Steel Beams Item -->
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-4 px-6 font-medium">Steel Beams</td>
                        <td class="py-4 px-6">Material</td>
                        <td class="py-4 px-6">
                            <span class="inline-block px-3 py-1 text-xs font-bold bg-green-100 text-green-700 rounded-full">Low</span>
                        </td>
                        <td class="py-4 px-6">Rp25,000,000</td>
                        <td class="py-4 px-6">200 Units</td>
                        <td class="py-4 px-6">2025-06-18</td>
                        <td class="py-4 px-6">2025-06-28</td>
                        <td class="py-4 px-6 text-center">
                            <a href="{{ route('procurement.detailnote') }}" 
                               class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 text-xs rounded-full font-semibold shadow transition-all duration-150">
                               Detail
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection
