@extends('layouts.app')

@section('content')
@include('components.navvendor')

<div class="flex min-h-screen bg-gray-100">
    @include('components.sidevendor')

    <main class="flex-1 py-6 px-8">
        <div class="bg-white rounded-lg shadow-md flex flex-col justify-between min-h-[85vh] overflow-hidden">

            <!-- Header -->
            <div class="bg-red-600 text-white px-6 py-4">
                <h2 class="text-xl font-bold">Order Details</h2>
                <div class="mt-2">
                    <span class="bg-yellow-300 text-yellow-900 text-xs font-semibold px-3 py-1 rounded-full inline-block">
                        Awaiting Shipment
                    </span>
                </div>
                <p class="text-sm mt-2">
                    Please arrange the shipment before <strong>13 June 2025</strong>.<br>
                    <span class="text-orange-100">Order Date: <strong>11 June 2025</strong></span>
                </p>
            </div>

            <!-- Konten Utama -->
            <div class="px-6 py-6 space-y-6 flex-1">

                <!-- Orders -->
                <div>
                    <h3 class="text-md font-semibold text-red-600 mb-2">📦 Orders</h3>
                    <div class="bg-gray-100 rounded px-4 py-3">
                        <p class="font-medium">Gracesia Romauli Marbun</p>
                        <p class="text-sm text-gray-600">gracesiaromauli10@gmail.com</p>
                    </div>
                </div>

                <!-- Shipment -->
                <div>
                    <h3 class="text-md font-semibold text-red-600 mb-2">📍 Shipment</h3>
                    <div class="bg-gray-100 rounded px-4 py-3 text-sm leading-6">
                        Mulia business park gedung JJ. Letjen MT. Haryono kav SB-60 Jakarta Selatan Pancoran, 12780 Pancoran Jakarta<br>
                        Telepon/Handphone: 081318600027
                    </div>
                </div>

                <!-- Avatar -->
                <div class="flex items-center space-x-4">
                    <img src="https://ui-avatars.com/api/?name=Gracesia+Romauli+Marbun&background=cccccc" class="w-10 h-10 rounded-full">
                    <span class="font-semibold text-sm">Gracesia Romauli Marbun</span>
                </div>

                <!-- Daftar Produk -->
                <div class="space-y-4">
                    <!-- Produk 1 -->
                    <div class="bg-gray-50 p-4 rounded flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <img src="https://via.placeholder.com/60" alt="Pipa Besi" class="rounded w-12 h-12">
                            <div>
                                <p class="font-semibold">Pipa Besi Anti Karat</p>
                                <p class="text-sm text-gray-500">
                                    Rp. 810.000 
                                    <span class="ml-2 bg-red-100 text-red-600 text-xs px-2 py-0.5 rounded">bid</span>
                                </p>
                                <p class="text-xs text-gray-600">Unit: 20mm</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <label class="text-xs text-gray-500 block mb-1">QTY</label>
                            <select class="border border-gray-300 rounded px-2 py-1 text-sm">
                                <option selected>2</option>
                            </select>
                        </div>
                    </div>

                    <!-- Produk 2 -->
                    <div class="bg-gray-50 p-4 rounded flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <img src="https://via.placeholder.com/60" alt="Pipa PVC" class="rounded w-12 h-12">
                            <div>
                                <p class="font-semibold">Pipa PVC</p>
                                <p class="text-sm text-gray-500">
                                    Rp. 190.000 
                                    <span class="ml-2 bg-red-100 text-red-600 text-xs px-2 py-0.5 rounded">bid</span>
                                </p>
                                <p class="text-xs text-gray-600">Unit: 60m</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <label class="text-xs text-gray-500 block mb-1">QTY</label>
                            <select class="border border-gray-300 rounded px-2 py-1 text-sm">
                                <option selected>1</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Total -->
                <div class="text-right font-semibold text-sm pt-4">
                    Total: <span class="text-black">Rp. 2,000,000</span>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="border-t px-6 py-4 bg-white flex justify-end space-x-4">
                <!-- Cancel -->
                <button class="bg-[#EB5757] text-white hover:bg-[#C0392B] text-sm font-semibold px-6 py-2.5 rounded-full shadow-sm transition duration-200">
                    Cancel
                </button>

                <!-- Process Shipment -->
                <button class="bg-[#2F80ED] text-white hover:bg-[#1C6DD0] text-sm font-semibold px-6 py-2.5 rounded-full shadow-sm transition duration-200">
                    Process Shipment
                </button>
            </div>
        </div>
    </main>
</div>
@endsection
