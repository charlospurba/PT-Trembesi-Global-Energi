@extends('layouts.app')

@section('content')
    <!-- Include Navbar Component -->
    @include('components.navbar')

    <div class="container mx-auto px-4 py-8">
        <!-- Store Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex items-center space-x-6">
                <!-- Store Logo/Avatar -->
                <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h3M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>

                <!-- Store Info -->
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $store->name }}</h1>
                    <div class="flex items-center space-x-4 text-sm text-gray-600">
                        <div class="flex items-center">
                            <span class="text-yellow-500 mr-1">★</span>
                            <span>{{ $averageRating }} ({{ $totalReviews }} reviews)</span>
                        </div>
                        <div>{{ $totalProducts }} Products</div>
                        <div>Store</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Store Products -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Products from {{ $store->name }}</h2>
            
            @if($products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            <!-- Product Image -->
                            <div class="aspect-square bg-gray-200">
                                @if($product->image)
                                    <img src="{{ asset('storage/products/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <span class="text-gray-400">No Image</span>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Product Info -->
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">{{ $product->name }}</h3>
                                <p class="text-gray-600 text-sm mb-2 line-clamp-2">{{ $product->description }}</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-lg font-bold text-red-600">
                                        ${{ number_format($product->price, 2) }}
                                    </span>
                                    @if($product->id)
                                        <span class="text-gray-500 text-sm">ID: {{ $product->id }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500 text-lg">No products found for this store.</p>
                </div>
            @endif
        </div>
    </div>
@endsection