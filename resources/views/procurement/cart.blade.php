@extends('layouts.app')

@section('content')
@include('components.navbar')

<style>
    .cart-seller-group {
        border: 2px solid #007bff;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 24px;
        background-color: #f9f9f9;
    }
    .product-card {
        background-color: #f2efef;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .product-card img {
        border-radius: 6px;
        border: 1px solid #ddd;
    }
    .qty-control {
        display: flex;
        align-items: center;
    }
    .qty-control button {
        width: 26px;
        height: 26px;
    }
    .trash-btn {
        color: red;
        background: transparent;
        border: none;
        font-size: 18px;
    }
</style>

<div class="container py-4">
    <h5 class="fw-bold mb-3">Dashboard <span class="text-danger">> Cart</span></h5>

    {{-- Group: Harapan Mitra Sejati --}}
    <div class="cart-seller-group">
        <div class="d-flex align-items-center mb-3">
            <input type="checkbox" class="me-2">
            <img src="/images/store-icon.png" width="20" class="me-2">
            <strong>Harapan Mitra Sejati</strong>
        </div>

        {{-- Product 1 --}}
        <div class="product-card">
            <div class="d-flex align-items-center">
                <input type="checkbox" class="me-3">
                <img src="/images/pipa-besi.png" width="60" class="me-3">
                <div>
                    <div class="fw-bold">Pipa Besi Anti Karat</div>
                    <div>Rp. 810,000 <span class="badge bg-danger text-white ms-2">bid</span></div>
                    <div class="small mt-1">Variasi : 
                        <select class="form-select form-select-sm d-inline w-auto ms-1">
                            <option selected>20mm</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <div class="qty-control me-3">
                    <label class="me-1">QTY</label>
                    <button class="btn btn-sm btn-outline-secondary">−</button>
                    <input type="text" class="form-control form-control-sm text-center mx-1" value="1" style="width: 40px;">
                    <button class="btn btn-sm btn-outline-secondary">+</button>
                </div>
                <button class="trash-btn"><i class="bi bi-trash-fill"></i></button>
            </div>
        </div>

        {{-- Product 2 --}}
        <div class="product-card">
            <div class="d-flex align-items-center">
                <input type="checkbox" class="me-3">
                <img src="/images/pipa-pvc.png" width="60" class="me-3">
                <div>
                    <div class="fw-bold">Pipa PVC</div>
                    <div>Rp. 110,000 <span class="badge bg-danger text-white ms-2">bid</span></div>
                    <div class="small mt-1">Variasi : 
                        <select class="form-select form-select-sm d-inline w-auto ms-1">
                            <option selected>60m</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <div class="qty-control me-3">
                    <label class="me-1">QTY</label>
                    <button class="btn btn-sm btn-outline-secondary">−</button>
                    <input type="text" class="form-control form-control-sm text-center mx-1" value="1" style="width: 40px;">
                    <button class="btn btn-sm btn-outline-secondary">+</button>
                </div>
                <button class="trash-btn"><i class="bi bi-trash-fill"></i></button>
            </div>
        </div>
    </div>

    {{-- Group: Mitra Kita Bersama --}}
    <div class="cart-seller-group">
        <div class="d-flex align-items-center mb-3">
            <input type="checkbox" class="me-2">
            <img src="/images/store-icon.png" width="20" class="me-2">
            <strong>Mitra Kita Bersama</strong>
        </div>

        <div class="product-card">
            <div class="d-flex align-items-center">
                <input type="checkbox" class="me-3">
                <img src="/images/pipa-besi.png" width="60" class="me-3">
                <div>
                    <div class="fw-bold">Pipa Besi Anti Karat</div>
                    <div>Rp. 620,000 <span class="badge bg-danger text-white ms-2">bid</span></div>
                    <div class="small mt-1">Variasi : 
                        <select class="form-select form-select-sm d-inline w-auto ms-1">
                            <option selected>20mm</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <div class="qty-control me-3">
                    <label class="me-1">QTY</label>
                    <button class="btn btn-sm btn-outline-secondary">−</button>
                    <input type="text" class="form-control form-control-sm text-center mx-1" value="1" style="width: 40px;">
                    <button class="btn btn-sm btn-outline-secondary">+</button>
                </div>
                <button class="trash-btn"><i class="bi bi-trash-fill"></i></button>
            </div>
        </div>
    </div>

    {{-- Bottom Summary --}}
    <div class="bg-white p-3 rounded d-flex justify-content-between align-items-center">
        <div>
            <input type="checkbox" class="me-2" style="width: 20px; height: 20px;"> <strong>Select All</strong>
        </div>
        <div>
            <strong>Total (0 Product) : <span class="text-danger">Rp. 0</span></strong>
            <button class="btn btn-primary ms-3 px-4">Check Out</button>
        </div>
    </div>
</div>
@endsection
