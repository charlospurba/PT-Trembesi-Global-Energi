@extends('layouts.app')

@section('content')

    @include('components.navold')

    <div class="container">
        <!-- Categories Section -->
        <div class="section-title">Categories</div>
        <div class="categories-grid">
            <a href="/login" class="category-card"><i class="fas fa-cube"></i><span>Material</span></a>
            <a href="/login" class="category-card"><i class="fas fa-tools"></i><span>Equipment</span></a>
            <a href="/login" class="category-card"><i class="fas fa-bolt"></i><span>Electrical Tools</span></a>
            <a href="/login" class="category-card"><i class="fas fa-shopping-bag"></i><span>Consumables</span></a>
            <a href="/login" class="category-card"><i class="fas fa-hard-hat"></i><span>Personal Protective
                    Equipment</span></a>
        </div>

        <!-- Recommendations Section -->
        <div class="recommendations-section">
            <div class="recommendations-title">RECOMMENDATIONS</div>

            <!-- Material Collection -->
            <div class="collection mb-10">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Material Collection</h3>
                    <a href="{{ route('procurement.material') }}" class="text-sm text-red-600">See all ></a>
                </div>
                <div class="products-grid grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @forelse($randomMaterials as $product)
                                <a href="{{ route('product.detail', $product->id) }}" class="block">
                                    <div
                                        class="bg-white rounded-xl shadow-md overflow-hidden max-w-[280px] w-full transition-transform hover:scale-105">
                                        <!-- Gambar -->
                                        <div class="bg-red-600 p-3 flex justify-center items-center h-32">
                                            <img src="{{ !empty($product->image_paths) && is_array($product->image_paths) && count($product->image_paths) > 0
                        ? asset('storage/' . $product->image_paths[0] . '?' . time())
                        : 'https://via.placeholder.com/300' }}" alt="{{ $product->name }}"
                                                class="w-full h-full object-contain rounded-md" />
                                        </div>

                                        <!-- Konten -->
                                        <div class="px-4 py-3 space-y-1.5 text-xs leading-relaxed">
                                            <!-- Supplier -->
                                            <span class="inline-block px-2 py-0.5 bg-gray-200 text-gray-800 text-[11px] rounded-full">
                                                {{ $product->supplier }}
                                            </span>

                                            <!-- Nama Produk -->
                                            <h3 class="text-sm font-semibold">{{ $product->name }}</h3>

                                            <!-- Harga -->
                                            <p class="text-black font-bold text-sm">Rp{{ number_format($product->price, 0, ',', '.') }}
                                            </p>

                                            <!-- Alamat -->
                                            <div class="flex items-start text-[11px] text-gray-600">
                                                <svg class="w-4 h-4 text-red-500 mr-1 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 2a6 6 0 016 6c0 4.418-6 10-6 10S4 12.418 4 8a6 6 0 016-6zM8 8a2 2 0 114 0 2 2 0 01-4 0z" />
                                                </svg>
                                                {{ $product->address ?? '-' }}
                                            </div>

                                            <!-- Stok -->
                                            <div class="text-[11px] text-red-600 font-medium">
                                                Stock: {{ $product->quantity }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                    @empty
                        <p class="text-center text-gray-500 text-sm">There are no Material products available.</p>
                    @endforelse
                </div>
            </div>

            <!-- Equipment Collection -->
            <div class="collection mb-10">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Equipment Collection</h3>
                    <a href="{{ route('procurement.equipment') }}" class="text-sm text-red-600">See all ></a>
                </div>
                <div class="products-grid grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @forelse($randomEquipments as $product)
                                <a href="{{ route('product.detail', $product->id) }}" class="block">
                                    <div
                                        class="bg-white rounded-xl shadow-md overflow-hidden max-w-[280px] w-full transition-transform hover:scale-105">
                                        <!-- Gambar -->
                                        <div class="bg-red-600 p-3 flex justify-center items-center h-32">
                                            <img src="{{ !empty($product->image_paths) && is_array($product->image_paths) && count($product->image_paths) > 0
                        ? asset('storage/' . $product->image_paths[0] . '?' . time())
                        : 'https://via.placeholder.com/300' }}" alt="{{ $product->name }}"
                                                class="w-full h-full object-contain rounded-md" />
                                        </div>

                                        <!-- Konten -->
                                        <div class="px-4 py-3 space-y-1.5 text-xs leading-relaxed">
                                            <!-- Supplier -->
                                            <span class="inline-block px-2 py-0.5 bg-gray-200 text-gray-800 text-[11px] rounded-full">
                                                {{ $product->supplier }}
                                            </span>

                                            <!-- Nama Produk -->
                                            <h3 class="text-sm font-semibold">{{ $product->name }}</h3>

                                            <!-- Harga -->
                                            <p class="text-black font-bold text-sm">Rp{{ number_format($product->price, 0, ',', '.') }}
                                            </p>

                                            <!-- Alamat -->
                                            <div class="flex items-start text-[11px] text-gray-600">
                                                <svg class="w-4 h-4 text-red-500 mr-1 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 2a6 6 0 016 6c0 4.418-6 10-6 10S4 12.418 4 8a6 6 0 016-6zM8 8a2 2 0 114 0 2 2 0 01-4 0z" />
                                                </svg>
                                                {{ $product->address ?? '-' }}
                                            </div>

                                            <!-- Stok -->
                                            <div class="text-[11px] text-red-600 font-medium">
                                                Stock: {{ $product->quantity }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                    @empty
                        <p class="text-center text-gray-500 text-sm">There are no Equipment products available.</p>
                    @endforelse
                </div>
            </div>

            <!-- Electrical Collection -->
            <div class="collection mb-10">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Electrical Collection</h3>
                    <a href="{{ route('procurement.electrical') }}" class="text-sm text-red-600">See all ></a>
                </div>
                <div class="products-grid grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @forelse($randomElectricals as $product)
                                <a href="{{ route('product.detail', $product->id) }}" class="block">
                                    <div
                                        class="bg-white rounded-xl shadow-md overflow-hidden max-w-[280px] w-full transition-transform hover:scale-105">
                                        <!-- Gambar -->
                                        <div class="bg-red-600 p-3 flex justify-center items-center h-32">
                                            <img src="{{ !empty($product->image_paths) && is_array($product->image_paths) && count($product->image_paths) > 0
                        ? asset('storage/' . $product->image_paths[0] . '?' . time())
                        : 'https://via.placeholder.com/300' }}" alt="{{ $product->name }}"
                                                class="w-full h-full object-contain rounded-md" />
                                        </div>

                                        <!-- Konten -->
                                        <div class="px-4 py-3 space-y-1.5 text-xs leading-relaxed">
                                            <!-- Supplier -->
                                            <span class="inline-block px-2 py-0.5 bg-gray-200 text-gray-800 text-[11px] rounded-full">
                                                {{ $product->supplier }}
                                            </span>

                                            <!-- Nama Produk -->
                                            <h3 class="text-sm font-semibold">{{ $product->name }}</h3>

                                            <!-- Harga -->
                                            <p class="text-black font-bold text-sm">Rp{{ number_format($product->price, 0, ',', '.') }}
                                            </p>

                                            <!-- Alamat -->
                                            <div class="flex items-start text-[11px] text-gray-600">
                                                <svg class="w-4 h-4 text-red-500 mr-1 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 2a6 6 0 016 6c0 4.418-6 10-6 10S4 12.418 4 8a6 6 0 016-6zM8 8a2 2 0 114 0 2 2 0 01-4 0z" />
                                                </svg>
                                                {{ $product->address ?? '-' }}
                                            </div>

                                            <!-- Stok -->
                                            <div class="text-[11px] text-red-600 font-medium">
                                                Stock: {{ $product->quantity }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                    @empty
                        <p class="text-center text-gray-500 text-sm">There are no Electrical products available.</p>
                    @endforelse
                </div>
            </div>

            <!-- Consumables Collection -->
            <div class="collection mb-10">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Consumables Collection</h3>
                    <a href="{{ route('procurement.consumables') }}" class="text-sm text-red-600">See all ></a>
                </div>
                <div class="products-grid grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @forelse($randomConsumables as $product)
                                <a href="{{ route('product.detail', $product->id) }}" class="block">
                                    <div
                                        class="bg-white rounded-xl shadow-md overflow-hidden max-w-[280px] w-full transition-transform hover:scale-105">
                                        <!-- Gambar -->
                                        <div class="bg-red-600 p-3 flex justify-center items-center h-32">
                                            <img src="{{ !empty($product->image_paths) && is_array($product->image_paths) && count($product->image_paths) > 0
                        ? asset('storage/' . $product->image_paths[0] . '?' . time())
                        : 'https://via.placeholder.com/300' }}" alt="{{ $product->name }}"
                                                class="w-full h-full object-contain rounded-md" />
                                        </div>

                                        <!-- Konten -->
                                        <div class="px-4 py-3 space-y-1.5 text-xs leading-relaxed">
                                            <!-- Supplier -->
                                            <span class="inline-block px-2 py-0.5 bg-gray-200 text-gray-800 text-[11px] rounded-full">
                                                {{ $product->supplier }}
                                            </span>

                                            <!-- Nama Produk -->
                                            <h3 class="text-sm font-semibold">{{ $product->name }}</h3>

                                            <!-- Harga -->
                                            <p class="text-black font-bold text-sm">Rp{{ number_format($product->price, 0, ',', '.') }}
                                            </p>

                                            <!-- Alamat -->
                                            <div class="flex items-start text-[11px] text-gray-600">
                                                <svg class="w-4 h-4 text-red-500 mr-1 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 2a6 6 0 016 6c0 4.418-6 10-6 10S4 12.418 4 8a6 6 0 016-6zM8 8a2 2 0 114 0 2 2 0 01-4 0z" />
                                                </svg>
                                                {{ $product->address ?? '-' }}
                                            </div>

                                            <!-- Stok -->
                                            <div class="text-[11px] text-red-600 font-medium">
                                                Stock: {{ $product->quantity }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                    @empty
                        <p class="text-center text-gray-500 text-sm">There are no Consumables products available.</p>
                    @endforelse
                </div>
            </div>

            <!-- PPE Collection -->
            <div class="collection mb-10">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Personal Protective Equipment Collection</h3>
                    <a href="{{ route('procurement.personal') }}" class="text-sm text-red-600">See all ></a>
                </div>
                <div class="products-grid grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @forelse($randomPPEs as $product)
                                <a href="{{ route('product.detail', $product->id) }}" class="block">
                                    <div
                                        class="bg-white rounded-xl shadow-md overflow-hidden max-w-[280px] w-full transition-transform hover:scale-105">
                                        <!-- Gambar -->
                                        <div class="bg-red-600 p-3 flex justify-center items-center h-32">
                                            <img src="{{ !empty($product->image_paths) && is_array($product->image_paths) && count($product->image_paths) > 0
                        ? asset('storage/' . $product->image_paths[0] . '?' . time())
                        : 'https://via.placeholder.com/300' }}" alt="{{ $product->name }}"
                                                class="w-full h-full object-contain rounded-md" />
                                        </div>

                                        <!-- Konten -->
                                        <div class="px-4 py-3 space-y-1.5 text-xs leading-relaxed">
                                            <!-- Supplier -->
                                            <span class="inline-block px-2 py-0.5 bg-gray-200 text-gray-800 text-[11px] rounded-full">
                                                {{ $product->supplier }}
                                            </span>

                                            <!-- Nama Produk -->
                                            <h3 class="text-sm font-semibold">{{ $product->name }}</h3>

                                            <!-- Harga -->
                                            <p class="text-black font-bold text-sm">Rp{{ number_format($product->price, 0, ',', '.') }}
                                            </p>

                                            <!-- Alamat -->
                                            <div class="flex items-start text-[11px] text-gray-600">
                                                <svg class="w-4 h-4 text-red-500 mr-1 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 2a6 6 0 016 6c0 4.418-6 10-6 10S4 12.418 4 8a6 6 0 016-6zM8 8a2 2 0 114 0 2 2 0 01-4 0z" />
                                                </svg>
                                                {{ $product->address ?? '-' }}
                                            </div>

                                            <!-- Stok -->
                                            <div class="text-[11px] text-red-600 font-medium">
                                                Stock: {{ $product->quantity }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                    @empty
                        <p class="text-center text-gray-500 text-sm">There are no Personal Protective Equipment products
                            available.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Harus Di Sini -->
    @include('components.footer')
@endsection