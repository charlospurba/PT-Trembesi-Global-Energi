@extends('layouts.app')

@section('content')
    <!-- Include Navbar Component -->
    @include('components.navbar')

    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-red-50 to-rose-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <!-- Compact Breadcrumb -->
            <nav class="flex items-center space-x-2 text-xs mb-4 glass-effect px-4 py-2 rounded-xl shadow-lg">
                <a href="{{ route('procurement.dashboardproc') }}" class="flex items-center text-gray-600 hover:text-red-600 transition-all duration-300">
                    <i class="fas fa-home mr-1"></i>dashboard
                </a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span class="text-red-600 font-semibold">Material</span>
            </nav>
            
            <!-- Header Section -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border-l-4 border-red-600">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="bg-gradient-to-r from-red-600 to-red-700 text-white p-3 rounded-xl shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 10h2l1 2h13l1-2h2M5 12h14l-1.5 9h-11L5 12zM10 21h4"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold text-gray-800 mb-1">Koleksi Material</h1>
                            <p class="text-gray-600">Temukan berbagai material terbaik untuk kebutuhan Anda</p>
                        </div>
                    </div>
                    <div class="hidden md:flex items-center gap-2 bg-gray-100 px-4 py-2 rounded-full">
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-sm text-gray-600 font-medium">{{ count($products) }} Produk Tersedia</span>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="bg-white rounded-lg shadow-sm p-3 mb-6">
                <div class="flex flex-wrap items-center gap-3">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-700">Urutkan:</span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded-full cursor-pointer hover:bg-gray-200 transition-colors">
                            Harga Terendah
                        </span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded-full cursor-pointer hover:bg-gray-200 transition-colors">
                            Harga Tertinggi
                        </span>
                    </div>
                </div>
            </div>

            <!-- Grid Produk -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                @forelse($products as $product)
                    <a href="{{ route('product.detail', $product->id) }}" class="block group">
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden max-w-[250px] w-full transition-all duration-300 hover:shadow-md hover:-translate-y-1 border border-gray-100">
                            <!-- Gambar Produk -->
                            <div class="relative bg-gradient-to-br from-red-600 to-red-700 p-3 flex justify-center items-center h-32">
                                @php
                                    $imagePath = 'https://via.placeholder.com/200';
                                    if (!empty($product->image_paths)) {
                                        if (is_array($product->image_paths) && count($product->image_paths) > 0) {
                                            $imagePath = asset('storage/' . $product->image_paths[0] . '?' . time());
                                        } elseif (is_string($product->image_paths)) {
                                            $imagePath = asset('storage/' . $product->image_paths . '?' . time());
                                        }
                                    }
                                @endphp
                                <img src="{{ $imagePath }}" alt="{{ $product->name }}" class="object-contain h-full rounded-md transition-transform duration-300 group-hover:scale-105" />
                            </div>

                            <!-- Informasi Produk -->
                            <div class="p-3 space-y-2">
                                <!-- Supplier Badge -->
                                <div class="flex items-center justify-between">
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-full">
                                        {{ $product->supplier ?? 'Supplier' }}
                                    </span>
                                    <div class="flex items-center gap-1">
                                        <svg class="w-3 h-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        <span class="text-xs text-gray-500">{{ $product->rating ?? '4.5' }}</span>
                                    </div>
                                </div>

                                <!-- Nama Produk -->
                                <h3 class="text-sm font-semibold text-gray-900 line-clamp-2 leading-tight group-hover:text-red-600 transition-colors">
                                    {{ $product->name }}
                                </h3>

                                <!-- Harga -->
                                <div class="flex items-center justify-between">
                                    <span class="text-base font-bold text-red-600">
                                        Rp{{ number_format($product->price ?? 0, 0, ',', '.') }}
                                    </span>
                                </div>

                                <!-- Lokasi -->
                                <div class="flex items-center text-xs text-gray-600 bg-gray-50 p-2 rounded-lg">
                                    <svg class="w-3 h-3 text-red-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 2a6 6 0 016 6c0 4.418-6 10-6 10S4 12.418 4 8a6 6 0 016-6zM8 8a2 2 0 114 0 2 2 0 01-4 0z" />
                                    </svg>
                                    <span class="truncate">{{ $product->address ?? 'Lokasi tidak tersedia' }}</span>
                                </div>

                                <!-- Stok -->
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-600">Stok:</span>
                                    @php
                                        $quantity = $product->quantity ?? 0;
                                        $stockClass = $quantity > 10 ? 'text-green-600' : ($quantity > 5 ? 'text-yellow-600' : 'text-red-600');
                                    @endphp
                                    <span class="text-xs font-semibold {{ $stockClass }}">
                                        {{ $quantity }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                            <div class="bg-gray-100 rounded-full p-4 w-16 h-16 mx-auto mb-3">
                                <svg class="w-8 h-8 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                            </div>
                            <h3 class="text-base font-semibold text-gray-800 mb-2">Belum Ada Produk</h3>
                            <p class="text-sm text-gray-500 mb-3">Tidak ada produk material yang tersedia saat ini.</p>
                            <button class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700 transition-colors">
                                Tambah Produk
                            </button>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-12 text-center">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <p class="text-gray-600 mb-4">Menampilkan {{ count($products) }} dari {{ count($products) }} produk</p>
                    <div class="flex justify-center gap-2">
                        <button class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors">
                            Previous
                        </button>
                        <button class="px-4 py-2 bg-red-600 text-white rounded-lg">
                            1
                        </button>
                        <button class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
