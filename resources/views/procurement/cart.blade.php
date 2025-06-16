@extends('layouts.app')

@section('content')
<!-- Include Navbar Component -->
@include('components.navbar')

<div class="min-h-screen bg-gray-100 pb-20">
    <div class="container mx-auto px-4 py-6">
        {{-- Breadcrumb Navigation --}}
        <h5 class="text-lg font-bold mb-6">
            <a href="{{ route('procurement.dashboardproc') }}" class="text-black hover:underline">Dashboard</a>
            <span class="text-red-500"> > Cart</span>
        </h5>


        {{-- Group: Harapan Mitra Sejati --}}
        <div class="bg-white rounded-lg shadow-sm mb-4 overflow-hidden">
            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex items-center">
                <input type="checkbox" class="mr-3 w-4 h-4 text-blue-600 rounded">
                <img src="/images/store-icon.png" width="20" class="mr-2">
                <strong class="text-gray-800">Harapan Mitra Sejati</strong>
            </div>

            {{-- Product 1 --}}
            <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center flex-1">
                    <input type="checkbox" class="mr-4 w-4 h-4 text-blue-600 rounded">
                    <img src="/images/pipa-besi.png" width="60" height="60" class="mr-4 rounded-md border border-gray-200 object-cover">
                    <div class="flex-1">
                        <div class="font-semibold text-gray-800 mb-1">Pipa Besi Anti Karat</div>
                        <div class="text-gray-600 mb-2">
                            Rp. 810,000 
                            <span class="bg-red-500 text-white text-xs px-2 py-1 rounded ml-2">bid</span>
                        </div>
                        <div class="text-sm text-gray-500">
                            Varian: 
                            <select class="ml-1 text-xs border border-gray-300 rounded px-2 py-1">
                                <option selected>20mm</option>
                                <option>25mm</option>
                                <option>30mm</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center mr-4">
                        <span class="text-sm text-gray-600 mr-2">QTY</span>
                        <button class="w-8 h-8 border border-gray-300 rounded-l-md flex items-center justify-center hover:bg-gray-50">−</button>
                        <input type="text" class="w-12 h-8 border-t border-b border-gray-300 text-center text-sm" value="1">
                        <button class="w-8 h-8 border border-gray-300 rounded-r-md flex items-center justify-center hover:bg-gray-50">+</button>
                    </div>
                    <button class="text-red-500 hover:text-red-700 text-lg">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Product 2 --}}
            <div class="p-4 flex items-center justify-between">
                <div class="flex items-center flex-1">
                    <input type="checkbox" class="mr-4 w-4 h-4 text-blue-600 rounded">
                    <img src="/images/pipa-pvc.png" width="60" height="60" class="mr-4 rounded-md border border-gray-200 object-cover">
                    <div class="flex-1">
                        <div class="font-semibold text-gray-800 mb-1">Pipa PVC</div>
                        <div class="text-gray-600 mb-2">
                            Rp. 110,000 
                            <span class="bg-red-500 text-white text-xs px-2 py-1 rounded ml-2">bid</span>
                        </div>
                        <div class="text-sm text-gray-500">
                            Varian: 
                            <select class="ml-1 text-xs border border-gray-300 rounded px-2 py-1">
                                <option selected>60m</option>
                                <option>80m</option>
                                <option>100m</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center mr-4">
                        <span class="text-sm text-gray-600 mr-2">QTY</span>
                        <button class="w-8 h-8 border border-gray-300 rounded-l-md flex items-center justify-center hover:bg-gray-50">−</button>
                        <input type="text" class="w-12 h-8 border-t border-b border-gray-300 text-center text-sm" value="1">
                        <button class="w-8 h-8 border border-gray-300 rounded-r-md flex items-center justify-center hover:bg-gray-50">+</button>
                    </div>
                    <button class="text-red-500 hover:text-red-700 text-lg">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Group: Mitra Kita Bersama --}}
        <div class="bg-white rounded-lg shadow-sm mb-4 overflow-hidden">
            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex items-center">
                <input type="checkbox" class="mr-3 w-4 h-4 text-blue-600 rounded">
                <img src="/images/store-icon.png" width="20" class="mr-2">
                <strong class="text-gray-800">Mitra Kita Bersama</strong>
            </div>

            <div class="p-4 flex items-center justify-between">
                <div class="flex items-center flex-1">
                    <input type="checkbox" class="mr-4 w-4 h-4 text-blue-600 rounded">
                    <img src="/images/pipa-besi.png" width="60" height="60" class="mr-4 rounded-md border border-gray-200 object-cover">
                    <div class="flex-1">
                        <div class="font-semibold text-gray-800 mb-1">Pipa Besi Anti Karat</div>
                        <div class="text-gray-600 mb-2">
                            Rp. 620,000 
                            <span class="bg-red-500 text-white text-xs px-2 py-1 rounded ml-2">bid</span>
                        </div>
                        <div class="text-sm text-gray-500">
                            Varian: 
                            <select class="ml-1 text-xs border border-gray-300 rounded px-2 py-1">
                                <option selected>20mm</option>
                                <option>25mm</option>
                                <option>30mm</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center mr-4">
                        <span class="text-sm text-gray-600 mr-2">QTY</span>
                        <button class="w-8 h-8 border border-gray-300 rounded-l-md flex items-center justify-center hover:bg-gray-50">−</button>
                        <input type="text" class="w-12 h-8 border-t border-b border-gray-300 text-center text-sm" value="1">
                        <button class="w-8 h-8 border border-gray-300 rounded-r-md flex items-center justify-center hover:bg-gray-50">+</button>
                    </div>
                    <button class="text-red-500 hover:text-red-700 text-lg">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Add more dummy products --}}
        <div class="bg-white rounded-lg shadow-sm mb-4 overflow-hidden">
            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex items-center">
                <input type="checkbox" class="mr-3 w-4 h-4 text-blue-600 rounded">
                <img src="/images/store-icon.png" width="20" class="mr-2">
                <strong class="text-gray-800">Sumber Makmur</strong>
            </div>

            <div class="p-4 flex items-center justify-between">
                <div class="flex items-center flex-1">
                    <input type="checkbox" class="mr-4 w-4 h-4 text-blue-600 rounded">
                    <img src="/images/pipa-galvanis.png" width="60" height="60" class="mr-4 rounded-md border border-gray-200 object-cover">
                    <div class="flex-1">
                        <div class="font-semibold text-gray-800 mb-1">Pipa Galvanis</div>
                        <div class="text-gray-600 mb-2">
                            Rp. 450,000 
                            <span class="bg-red-500 text-white text-xs px-2 py-1 rounded ml-2">bid</span>
                        </div>
                        <div class="text-sm text-gray-500">
                            Varian: 
                            <select class="ml-1 text-xs border border-gray-300 rounded px-2 py-1">
                                <option selected>15mm</option>
                                <option>20mm</option>
                                <option>25mm</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center mr-4">
                        <span class="text-sm text-gray-600 mr-2">QTY</span>
                        <button class="w-8 h-8 border border-gray-300 rounded-l-md flex items-center justify-center hover:bg-gray-50">−</button>
                        <input type="text" class="w-12 h-8 border-t border-b border-gray-300 text-center text-sm" value="2">
                        <button class="w-8 h-8 border border-gray-300 rounded-r-md flex items-center justify-center hover:bg-gray-50">+</button>
                    </div>
                    <button class="text-red-500 hover:text-red-700 text-lg">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Sticky Bottom Summary --}}
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 py-3 shadow-lg z-10">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <input type="checkbox" class="mr-3 w-5 h-5 text-blue-600 rounded">
                <strong class="text-gray-800">Select All</strong>
            </div>
            <div class="flex items-center">
                <strong class="text-gray-800 mr-4">
                    Total (4 Products): <span class="text-red-500">Rp. 1,990,000</span>
                </strong>
                <a href="{{ route('procurement.checkout') }}">
    <button class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
        Check Out
    </button>
</a>
            </div>
        </div>
    </div>
</div>
@endsection