@extends('layouts.app')

@section('content')

@include('components.navold')

<div class="container">
    <!-- Categories Section -->
    <div class="section-title">Categories</div>
    <div class="categories-grid">
        <a href="/login" class="category-card"><i class="fas fa-cube"></i><span>Material</span></a>
        <a href="/login" class="category-card"><i class="fas fa-tools"></i><span>Equipment</span></a>
        <a href="/login" class="category-card"><i class="fas fa-bolt"></i><span>Electrical Tools</span></a>
        <a href="/login" class="category-card"><i class="fas fa-shopping-bag"></i><span>Consumables</span></a>
        <a href="/login" class="category-card"><i class="fas fa-hard-hat"></i><span>Personal Protective Equipment</span></a>
    </div>

    <!-- Recommendations Section -->
    <div class="recommendations-section">
        <div class="recommendations-title">RECOMMENDATIONS</div>

        <!-- Material Collection -->
        <div class="collection mb-10">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Material Collection</h3>
                <a href="#" class="text-sm text-red-600">See all ></a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @for($i = 0; $i < 6; $i++)
                <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-transform transform hover:scale-105 duration-300 overflow-hidden">
                    <div class="bg-red-600 flex items-center justify-center h-52">
                        <img src="{{ asset('assets/images/email.png') }}" alt="Email Icon" class="h-16 w-auto">
                    </div>

                    <div class="flex justify-center mt-2">
                        <div class="bg-gray-200 px-3 py-1 rounded-full text-sm font-medium flex items-center gap-2">
                            <i class="fas fa-store text-red-600"></i>
                            <span class="text-gray-700">Toko Bangunan</span>
                        </div>
                    </div>

                    <div class="px-4 pb-4 pt-2">
                        <h4 class="font-semibold text-base text-left mb-1">
                            @if($i == 1) HITAM 450 @else PUTIH 100 @endif
                        </h4>
                        <p class="text-left text-black font-bold text-sm mb-1">Rp{{ 50000 + ($i * 10000) }}</p>
                        <p class="text-sm text-gray-700 flex items-center mb-1">
                            <i class="fas fa-map-marker-alt text-red-600 mr-2"></i>Jakarta
                        </p>
                        <p class="text-sm text-red-600 font-semibold text-left">
                            @if($i == 1)
                                Stok : 198
                            @elseif($i == 2)
                                Stok : 198
                            @elseif($i == 3)
                                Stok : 198
                            @elseif($i == 4)
                                Stok : 198
                            @elseif($i == 5)
                                Stok : 198
                            @else
                                Stok : 198
                            @endif
                        </p>
                    </div>
                </div>
                @endfor
            </div>
        </div>

        <!-- Equipment Collection -->
        <div class="collection mb-10">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Equipment Collection</h3>
                <a href="#" class="text-sm text-red-600">See all ></a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @for($i = 0; $i < 6; $i++)
                <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-transform transform hover:scale-105 duration-300 overflow-hidden">
                    <div class="bg-red-600 flex items-center justify-center h-52">
                        <img src="/images/sample-equipment.png" alt="Equipment" class="object-contain h-36 drop-shadow">
                    </div>

                    <div class="flex justify-center mt-2">
                        <div class="bg-gray-200 px-3 py-1 rounded-full text-sm font-medium flex items-center gap-2">
                            <i class="fas fa-store text-red-600"></i>
                            <span class="text-gray-700">Toko Bangunan</span>
                        </div>
                    </div>

                    <div class="px-4 pb-4 pt-2">
                        <h4 class="font-semibold text-base text-left mb-1">
                            @if($i == 1) HITAM 450 @else PUTIH 100 @endif
                        </h4>
                        <p class="text-left text-black font-bold text-sm mb-1">Rp{{ 70000 + ($i * 15000) }}</p>
                        <p class="text-sm text-gray-700 flex items-center mb-1">
                            <i class="fas fa-map-marker-alt text-red-600 mr-2"></i>Jakarta
                        </p>
                        <p class="text-sm text-red-600 font-semibold text-left">
                            @if($i == 1)
                                Stok : 198
                            @elseif($i == 2)
                                Stok : 198
                            @elseif($i == 3)
                                Stok : 198
                            @elseif($i == 4)
                                Stok : 198
                            @elseif($i == 5)
                                Stok : 198
                            @else
                                Stok : 198
                            @endif
                        </p>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>
</div>

@endsection
