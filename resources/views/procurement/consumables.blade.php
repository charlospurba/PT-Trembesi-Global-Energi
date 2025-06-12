@extends('layouts.app') 

@section('content')
    <!-- Consumables Collection -->
    <div class="collection mt-6">
        <div class="equipment-grid">
            @php
                $consumableItems = [
                    'NDT (MPT & PT)',
                    'Marker',
                    'Arc Gouging & Cutting',
                    'Flashback Arrestor',
                ];
            @endphp

            @foreach($consumableItems as $item)
                <div class="product-card">
                    <div class="product-image">
                        {{ $item }}
                        <span class="product-badge">Toko Bangunan</span>
                    </div>
                    <div class="product-info">
                        <h4>PUTIH 100</h4>
                        <p class="product-desc">Deskripsi {{ $item }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
