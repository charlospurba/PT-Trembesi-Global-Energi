@extends('layouts.app')

@section('content')
    <!-- Include Navbar Component -->
    @include('components.navbar')


    <!-- Main Content -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Categories Section -->
        <div class="section-title text-2xl font-bold text-gray-800 mb-6">Category</div>
        <div class="categories-grid grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach([
                ['href' => '/material', 'icon' => 'fas fa-cube', 'label' => 'Material'],
                ['href' => '/equipment', 'icon' => 'fas fa-tools', 'label' => 'Equipment'],
                ['href' => '/electrical', 'icon' => 'fas fa-bolt', 'label' => 'Electrical Tools'],
                ['href' => '/consumables', 'icon' => 'fas fa-shopping-bag', 'label' => 'Consumables'],
                ['href' => '/personal', 'icon' => 'fas fa-hard-hat', 'label' => 'Personal Protective Equipment']
            ] as $category)
                <a href="{{ $category['href'] }}" class="category-card bg-white rounded-lg shadow-md p-4 flex flex-col items-center justify-center hover:shadow-lg">
                    <i class="{{ $category['icon'] }} text-3xl text-red-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700 text-center">{{ $category['label'] }}</span>
                </a>
            @endforeach
        </div>

        <!-- Recommendations Section -->
        <div class="recommendations-section mt-12">
            <div class="recommendations-title text-2xl font-bold text-gray-800 mb-6">Recommendations</div>

            @foreach([
                ['title' => 'Material Collection', 'route' => 'procurement.material', 'products' => $randomMaterials],
                ['title' => 'Equipment Collection', 'route' => 'procurement.equipment', 'products' => $randomEquipments],
                ['title' => 'Electrical Collection', 'route' => 'procurement.electrical', 'products' => $randomElectricals],
                ['title' => 'Consumables Collection', 'route' => 'procurement.consumables', 'products' => $randomConsumables],
                ['title' => 'Personal Protective Equipment Collection', 'route' => 'procurement.personal', 'products' => $randomPPEs]
            ] as $collection)
                <div class="collection mb-12">
                    <div class="collection-header flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $collection['title'] }}</h3>
                        <a href="{{ route($collection['route']) }}" class="text-sm text-red-600 hover:underline">See all ></a>
                    </div>
                    <div class="products-grid grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
                        @forelse($collection['products'] as $product)
                            <a href="{{ route('product.detail', $product->id) }}" class="block group">
                                <div class="bg-white rounded-lg overflow-hidden w-full transition-all duration-300 shadow-[0_1px_4px_rgba(220,38,38,0.2)] hover:shadow-[0_4px_12px_rgba(220,38,38,0.3)] hover:-translate-y-1 border border-gray-100">
                                    
                                    <!-- Responsive Image Container -->
                                    <div class="w-full aspect-square bg-gray-50 overflow-hidden">
                                        <img src="{{ !empty($product->image_paths) && is_array($product->image_paths) && count($product->image_paths) > 0
                                            ? asset('storage/' . $product->image_paths[0] . '?' . time())
                                            : 'https://via.placeholder.com/200' }}"
                                            alt="{{ $product->name }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                                    </div>

                                    <!-- Content -->
                                    <div class="p-2 space-y-1">
                                        <!-- Supplier -->
                                        <span class="inline-block px-1.5 py-0.5 bg-gray-100 text-gray-700 text-xs rounded font-medium">
                                            {{ $product->supplier }}
                                        </span>
                                        
                                        <!-- Product Name (Red) -->
                                        <h3 class="text-xs font-semibold text-red-600 line-clamp-2 leading-tight">{{ $product->name }}</h3>

                                        <!-- Price -->
                                        <p class="text-gray-900 font-bold text-sm">Rp{{ number_format($product->price, 0, ',', '.') }}</p>

                                        <!-- Address -->
                                        <div class="flex items-start text-xs text-gray-600">
                                            <svg class="w-2.5 h-2.5 text-red-500 mr-1 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 2a6 6 0 016 6c0 4.418-6 10-6 10S4 12.418 4 8a6 6 0 016-6zM8 8a2 2 0 114 0 2 2 0 01-4 0z" />
                                            </svg>
                                            <span class="line-clamp-1 text-xs">{{ $product->address ?? '-' }}</span>
                                        </div>

                                        <!-- Stock -->
                                        <div class="text-xs text-red-600 font-medium">
                                            Stock: {{ $product->quantity }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <p class="text-center text-gray-500 text-sm col-span-full py-8">There are no {{ $collection['title'] }} products available.</p>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    <!-- Footer Harus Di Sini -->
    @include('components.footer')
@endsection