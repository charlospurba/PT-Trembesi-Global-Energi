@extends('layouts.app')

@section('content')
    @include('components.navbar')

    <div class="bg-gray-50 py-8">
        <div class="container mx-auto px-4">
            <!-- Judul Halaman -->
            <div class="flex items-center gap-3 mb-8">
                <div class="bg-red-600 text-white p-2 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 10h2l1 2h13l1-2h2M5 12h14l-1.5 9h-11L5 12zM10 21h4"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-800">Koleksi Material</h1>
            </div>

            <!-- Grid Produk -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($products as $product)
                    <a href="{{ route('product.detail', $product->id) }}"
                       class="group block hover:shadow-lg transition duration-300">
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm group-hover:shadow-md transition-all duration-300">
                            <!-- Gambar Produk -->
                            <div class="bg-red-600 p-4 h-40 flex justify-center items-center">
                                <img src="{{ !empty($product->image_paths) && is_array($product->image_paths) && count($product->image_paths) > 0 
                                    ? asset('storage/' . $product->image_paths[0] . '?' . time()) 
                                    : 'https://via.placeholder.com/300' }}" 
                                    alt="{{ $product->name }}" 
                                    class="object-contain h-full transition-transform duration-300 group-hover:scale-105 rounded-md" />
                            </div>

                            <!-- Informasi Produk -->
                            <div class="p-4 space-y-2 text-sm">
                                <!-- Supplier -->
                                <span class="inline-block px-2 py-0.5 bg-gray-100 text-gray-800 text-xs rounded-full">
                                    {{ $product->supplier }}
                                </span>

                                <!-- Nama Produk -->
                                <h3 class="text-base font-semibold text-gray-900 line-clamp-2">{{ $product->name }}</h3>

                                <!-- Harga -->
                                <p class="text-red-600 font-bold text-sm">Rp{{ number_format($product->price, 0, ',', '.') }}</p>

                                <!-- Lokasi -->
                                <div class="flex items-center text-xs text-gray-500">
                                    <svg class="w-4 h-4 text-red-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 2a6 6 0 016 6c0 4.418-6 10-6 10S4 12.418 4 8a6 6 0 016-6zM8 8a2 2 0 114 0 2 2 0 01-4 0z" />
                                    </svg>
                                    {{ $product->address ?? '-' }}
                                </div>

                                <!-- Stok -->
                                <div class="text-xs text-red-500 font-medium">
                                    Stok: {{ $product->quantity }}
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="col-span-4 text-center text-gray-400 text-sm">
                        Tidak ada produk kategori Material.
                    </p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
