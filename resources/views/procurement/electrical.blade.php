@extends('layouts.app')

@section('content')
    <!-- Electrical Collection -->
    <div class="collection mt-6">
        <div class="equipment-grid">
            @php
                $electricalItems = [
                    'Contuinity & Current Tester / Data Logging Multimeter',
                    'Insulation Resistance Tester',
                    'Electrical Bulk Material',
                ];
            @endphp

            @foreach($electricalItems as $category)
                <div class="product-card">
                    <div class="product-image">
                        {{ $category }}
                        <span class="product-badge">Toko Bangunan</span>
                    </div>
                    <div class="product-info">
                        <h4>PUTIH 100</h4>
                        <p class="product-desc">Deskripsi {{ $category }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
