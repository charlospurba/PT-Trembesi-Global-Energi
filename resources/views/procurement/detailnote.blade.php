@extends('layouts.app')
@section('content')
@include('components.navbar')

<!-- Header Section -->
<section class="bg-red-600 text-white py-6 px-6 rounded-b-xl mt-4">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold">Procurement Notes</h1>
            <p class="text-base">Detailed view of the procurement item</p>
        </div>
    </div>
</section>

<!-- Main Content -->
<main class="bg-gray-100 py-10 px-6">
    <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-lg p-10 space-y-10">

        <!-- Main Item Info -->
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Left Side -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Back Button -->
                <a href="{{ route('procurement.notes') }}" 
                   class="bg-gray-300 text-gray-800 rounded-full py-2 px-5 font-semibold hover:bg-gray-400 inline-block">
                    Back
                </a>

                <h2 class="text-3xl font-bold text-gray-800">Excavator</h2>
                
                <div class="grid sm:grid-cols-2 gap-4">
                    <!-- Category -->
                    <div class="flex items-center space-x-3">
                        <span class="bg-gray-100 rounded-full p-2">📋</span>
                        <div>
                            <p class="text-gray-500 text-sm">Category</p>
                            <p class="font-semibold text-gray-800">Equipment</p>
                        </div>
                    </div>
                    <!-- Budget -->
                    <div class="flex items-center space-x-3">
                        <span class="bg-gray-100 rounded-full p-2">💵</span>
                        <div>
                            <p class="text-gray-500 text-sm">Budget</p>
                            <p class="font-bold text-red-600 text-lg">Rp. 840,000,000</p>
                        </div>
                    </div>
                    <!-- Date of Request -->
                    <div class="flex items-center space-x-3">
                        <span class="bg-gray-100 rounded-full p-2">📅</span>
                        <div>
                            <p class="text-gray-500 text-sm">Date of Request</p>
                            <p class="font-semibold text-gray-800">12/06/2025</p>
                        </div>
                    </div>
                    <!-- Quantity -->
                    <div class="flex items-center space-x-3">
                        <span class="bg-gray-100 rounded-full p-2">📦</span>
                        <div>
                            <p class="text-gray-500 text-sm">Quantity</p>
                            <p class="font-semibold text-gray-800">5 Units</p>
                        </div>
                    </div>
                    <!-- Priority -->
                    <div class="flex items-center space-x-3">
                        <span class="bg-gray-100 rounded-full p-2">⚡️</span>
                        <div>
                            <p class="text-gray-500 text-sm">Priority</p>
                            <span class="bg-red-100 text-red-600 rounded-full text-xs font-bold px-3 py-1">High</span>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="mt-6 p-4 rounded-xl bg-gray-50">
                    <h3 class="font-bold text-gray-800 text-lg">Notes</h3>
                    <p class="text-gray-600 text-sm mt-2">
                        This excavator is required for long bridge construction and needs specific specifications from trusted vendors.
                    </p>
                </div>
            </div>

            <!-- Right Side: Detail Items -->
            <div class="bg-gray-50 rounded-xl p-6 shadow space-y-6">
                <h3 class="font-bold text-gray-800 text-lg border-b pb-3">Item Details</h3>
                
                <div class="text-gray-600 space-y-4">
                    <div>
                        <h4 class="font-semibold text-gray-800">Brand: HG 250 CDG</h4>
                        <p>Specification: CUMMINS 6LTAA8.9-G2</p>
                        <p>Unit: DAIGENKO DGK274K</p>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800">Brand: HG 250 CD (6LT)</h4>
                        <p>Specification: CUMMINS 6LTAA8.9-G2</p>
                        <p>Unit: STAMFORD UCDI274K14</p>
                    </div>
                </div>

                <!-- Button for Buy Now -->
                <div class="mt-6 flex justify-end">
                  <a href="{{ route('procurement.dashboardproc') }}" 
                    class="bg-red-600 text-white rounded-full py-2 px-5 font-semibold hover:bg-red-700">
                      Buy Now
                  </a>
              </div>
            </div>
        </div>

        <!-- Detail Items & Purchase History Table -->
        <div class="bg-gray-50 rounded-xl p-6 space-y-4">
            <h3 class="font-bold text-gray-800 text-lg">Item Details & Purchase History</h3>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 text-sm">
                        <th class="py-3 px-4">Item Name</th>
                        <th class="py-3 px-4">Brand</th>
                        <th class="py-3 px-4">Specification</th>
                        <th class="py-3 px-4">Unit</th>
                        <th class="py-3 px-4">Date</th>
                        <th class="py-3 px-4">Vendor</th>
                        <th class="py-3 px-4">Quantity</th>
                        <th class="py-3 px-4">Price</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    <tr class="border-t">
                        <td class="py-3 px-4">Excavator</td>
                        <td class="py-3 px-4">HG 250 CDG</td>
                        <td class="py-3 px-4">CUMMINS 6LTAA8.9-G2</td>
                        <td class="py-3 px-4">DAIGENKO DGK274K</td>
                        <td class="py-3 px-4">15/03/2025</td>
                        <td class="py-3 px-4">PT. Alat Berat Sejahtera</td>
                        <td class="py-3 px-4">2 Units</td>
                        <td class="py-3 px-4">Rp. 336,000,000</td>
                    </tr>
                    <tr class="border-t">
                        <td class="py-3 px-4">Excavator</td>
                        <td class="py-3 px-4">HG 250 CD (6LT)</td>
                        <td class="py-3 px-4">CUMMINS 6LTAA8.9-G2</td>
                        <td class="py-3 px-4">STAMFORD UCDI274K14</td>
                        <td class="py-3 px-4">20/04/2025</td>
                        <td class="py-3 px-4">PT. Mesin Konstruksi Jaya</td>
                        <td class="py-3 px-4">3 Units</td>
                        <td class="py-3 px-4">Rp. 504,000,000</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection
