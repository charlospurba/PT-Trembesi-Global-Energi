@extends('layouts.app')

@section('content')
    <!-- Safety Equipment Collection -->
    <div class="collection mt-6">
        <div class="equipment-grid grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 px-4">
            @php
                $safetyItems = [
                    'Wearpack',
                    'Polo Shirt',
                    'Sarung Tangan',
                    'Safety Shoes',
                    'Wearpack Tahan Api',
                    'Safety Helmet c/w chin strap',
                    'Earplug',
                    'Earmuf',
                    'Respirator',
                    'Filter Cartridge',
                    'Safety Glasses Clear Lens',
                    'Full Body Harness with double lanyard (and absorber)',
                    'Standard/specific face shield',
                    'Welding Google',
                ];
            @endphp

            @foreach($safetyItems as $item)
                <div class="product-card bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="product-image bg-gray-100 p-4 text-center text-lg font-semibold">
                        {{ $item }}
                        <span class="product-badge block mt-2 text-sm text-red-600">Toko Safety</span>
                    </div>
                    <div class="product-info p-4">
                        <h4 class="font-bold text-gray-800">{{ strtoupper(Str::slug($item, ' ')) }}</h4>
                        <p class="product-desc text-sm text-gray-600">Deskripsi {{ $item }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
