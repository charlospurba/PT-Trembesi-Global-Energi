@extends('layouts.app')

@section('content')
<!-- Include Navbar Component -->
@include('components.navbar')

<div class="collection mt-6 px-4 max-w-7xl">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
            <a href="{{ route('product.detail', $product->id) }}" class="block">
                <div class="bg-white rounded-xl shadow-md overflow-hidden max-w-[300px] sm:max-w-[340px] w-full transition-transform hover:scale-105 duration-200">
                    <div class="bg-red-600 p-4 flex justify-center h-40">
                        <img src="{{ $product->image_path ? asset('storage/' . $product->image_path . '?' . time()) : 'https://via.placeholder.com/150' }}"
                            alt="{{ $product->name }}" class="h-full object-contain rounded" />
                    </div>
                    <div class="p-4">
                        <!-- Supplier -->
                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-gray-200 text-gray-800 rounded-full mb-2">
                            {{ $product->supplier }}
                        </span>
                        <!-- Name -->
                        <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                        <!-- Price -->
                        <p class="text-black font-bold">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                        <!-- Address -->
                        <div class="flex items-center text-sm text-gray-600 mt-1">
                            <svg class="w-4 h-4 text-red-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a6 6 0 016 6c0 4.418-6 10-6 10S4 12.418 4 8a6 6 0 016-6zM8 8a2 2 0 114 0 2 2 0 01-4 0z" />
                            </svg>
                            {{ $product->address ?? '-' }}
                        </div>
                        <!-- Stock -->
                        <div class="text-sm text-red-600 font-medium mt-1">
                            Stok : {{ $product->quantity }}
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <p class="col-span-4 text-center text-gray-500">Tidak ada produk kategori Material.</p>
        @endforelse
    </div>
</div>

@endsection
