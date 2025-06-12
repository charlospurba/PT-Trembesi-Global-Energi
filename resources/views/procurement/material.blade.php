@extends('layouts.app')

@section('content')

<div class="collection mt-6">
    <div class="equipment-grid">
        @php
            $safetyItems = [
                ['name' => 'Wearpack', 'desc' => 'Wearpack Safety'],
                ['name' => 'Polo Shirt', 'desc' => 'Seragam Polo Safety'],
                ['name' => 'Sarung Tangan', 'desc' => 'Pelindung Tangan'],
                ['name' => 'Safety Shoes', 'desc' => 'Sepatu Pelindung'],
                ['name' => 'Wearpack Tahan Api', 'desc' => 'Anti Api'],
                ['name' => 'Safety Helmet c/w chin strap', 'desc' => 'Pelindung Kepala'],
                ['name' => 'Earplug', 'desc' => 'Pelindung Telinga'],
                ['name' => 'Earmuf', 'desc' => 'Headset Safety'],
                ['name' => 'Respirator', 'desc' => 'Masker Safety'],
                ['name' => 'Filter Cartridge', 'desc' => 'Filter Udara'],
                ['name' => 'Safety Glasses Clear Lens', 'desc' => 'Kacamata Pelindung'],
                ['name' => 'Full Body Harness with double lanyard (and absorber)', 'desc' => 'Harness Konstruksi'],
                ['name' => 'Standard/specific face shield', 'desc' => 'Pelindung Wajah'],
                ['name' => 'Welding Google', 'desc' => 'Kacamata Las'],
            ];
        @endphp

        @foreach($safetyItems as $item)
        <div class="product-card">
            <div class="product-image">
                {{ $item['name'] }}
                <span class="product-badge">Toko Safety</span>
            </div>
            <div class="product-info">
                <h4>SAFETY</h4>
                <p class="product-desc">{{ $item['desc'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
