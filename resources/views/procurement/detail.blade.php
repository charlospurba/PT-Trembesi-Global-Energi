@extends('layouts.app')

@section('content')
    <!-- Include Navbar Component -->
    @include('components.navbar')

    <div class="max-w-7xl mx-auto px-6 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- LEFT IMAGE & THUMBNAIL -->
            <div class="lg:col-span-1">
                <img src="{{ $product->image_path ? asset('storage/' . $product->image_path . '?' . time()) : 'https://via.placeholder.com/300' }}"
                    alt="{{ $product->name }}" class="w-full h-64 object-cover rounded-md mb-4" />
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('storage/' . $product->image) }}"
                        class="w-24 h-24 object-cover rounded border cursor-pointer" />
                    <img src="https://via.placeholder.com/80"
                        class="w-24 h-24 object-cover rounded border cursor-pointer" />
                    <img src="https://via.placeholder.com/80"
                        class="w-24 h-24 object-cover rounded border cursor-pointer" />
                </div>
            </div>

            <!-- CENTER PRODUCT DETAIL -->
            <div class="lg:col-span-1">
                <nav class="text-sm text-gray-500 mb-3">
                    <a href="{{ route('procurement.dashboardproc') }}" class="hover:underline">Beranda</a> >
                    <a href="/category/{{ strtolower($product->category) }}"
                        class="hover:underline">{{ $product->category }}</a> >
                    <span class="text-red-600 font-semibold">{{ $product->name }}</span>
                </nav>

                <h1 class="text-3xl font-bold">{{ $product->name }}</h1>
                <p class="text-red-600 text-2xl font-bold mt-2">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                <p class="text-sm text-gray-600 mt-1">15 Terjual</p>

                <div class="mt-6 border-t border-b py-4">
                    <h2 class="text-lg font-semibold text-red-600 mb-2">Informasi Produk</h2>
                    <div class="grid grid-cols-2 gap-y-2 text-sm">
                        <p><span class="font-semibold">Kategori:</span> {{ $product->category }}</p>
                        <p><span class="font-semibold">Minimal Pembelian:</span> {{ $product->min_order ?? '1' }} pcs</p>
                        <p><span class="font-semibold">Berat Satuan:</span> {{ $product->weight ?? '-' }} kg</p>
                        <p><span class="font-semibold">Dimensi Ukuran:</span> {{ $product->dimension ?? '-' }}</p>
                        <p><span class="font-semibold">Brand:</span> {{ $product->brand ?? '-' }}</p>
                    </div>
                </div>

                <div class="mt-4">
                    <h2 class="text-lg font-semibold text-red-600 mb-1">Pengiriman</h2>
                    <p class="text-sm text-gray-600 flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-red-500"></i>
                        Dikirim dari <span class="font-semibold">{{ $product->location ?? 'Lokasi tidak tersedia' }}</span>
                    </p>
                </div>
            </div>

            <!-- RIGHT PURCHASE BOX -->
            <div>
                <div class="border border-red-300 rounded-lg p-4 bg-red-50 shadow">
                    <h3 class="font-semibold mb-2">Atur Pembelian</h3>
                    <label class="text-sm">Jumlah Pembelian</label>
                    <div class="flex items-center mt-1 gap-2">
                        <button class="px-3 py-1 bg-red-200 text-red-700 rounded">-</button>
                        <input type="number" value="1" min="{{ $product->min_order ?? 1 }}"
                            class="w-14 text-center border rounded" />
                        <button class="px-3 py-1 bg-red-200 text-red-700 rounded">+</button>
                    </div>
                    <p class="text-xs mt-1 text-gray-600">Stok: {{ $product->stock ?? '-' }}</p>

                    <div class="mt-2 text-sm">
                        <p>Total Harga:</p>
                        <p class="text-lg font-bold">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>

                    <div class="mt-3 flex gap-2">
                        <button class="bg-red-600 text-white w-full py-2 rounded hover:bg-red-700">Masukkan
                            Keranjang</button>
                        <button class="border border-red-600 text-red-600 w-full py-2 rounded hover:bg-red-100">Beli
                            Sekarang</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- VENDOR INFO (BOTTOM FULL WIDTH) -->
        <div class="mt-10 border-t pt-6">
            <p class="text-sm font-semibold">Toko {{ $product->supplier ?? 'Nama Toko' }}</p>
            <p class="text-xs text-gray-600">{{ $product->location ?? '-' }}</p>
            <div class="mt-2">
                <span class="text-yellow-500">★</span> <span class="text-sm">5 Rating</span>
            </div>
        </div>
    </div>
@endsection