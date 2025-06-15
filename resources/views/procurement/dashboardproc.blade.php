@extends('layouts.app')

@section('content')

    <!-- Main Content -->
    <div class="container">
        <!-- Categories Section -->
        <div class="section-title">Category</div>
        <div class="categories-grid">
            <a href="/material" class="category-card">
                <i class="fas fa-cube"></i>
                <span>Material</span>
            </a>
            <a href="/equipment" class="category-card">
                <i class="fas fa-tools"></i>
                <span>Equipment</span>
            </a>
            <a href="/electrical" class="category-card">
                <i class="fas fa-bolt"></i>
                <span>Electrical Tools</span>
            </a>
            <a href="/consumables" class="category-card">
                <i class="fas fa-shopping-bag"></i>
                <span>Consumables</span>
            </a>
            <a href="/personal" class="category-card">
                <i class="fas fa-hard-hat"></i>
                <span>Personal Protective Equipment</span>
            </a>
        </div>

        <!-- Recommendations Section -->
        <div class="recommendations-section">
            <div class="recommendations-title">RECOMMENDATIOS</div>

            <!-- Material Collection -->
            <!-- Contoh Koleksi Material -->
            <div class="collection">
                <div class="collection-header">
                    <h3>Koleksi Material</h3>
                    <a href="{{ route('procurement.material') }}" class="view-all">Lihat Semua ></a>
                </div>
                <div class="products-grid">
                    @forelse($randomMaterials as $product)
                        <div class="product-card">
                            <div class="product-image">
                                <img src="{{ $product->image_path ? asset('storage/' . $product->image_path) : 'https://via.placeholder.com/150' }}"
                                    class="object-cover h-32 w-full rounded-t" />
                                <span class="product-badge">{{ $product->supplier }}</span>
                            </div>
                            <div class="product-info">
                                <h4>{{ $product->name }}</h4>
                                <p class="product-desc">{{ $product->description ?? '-' }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500">Tidak ada produk Material tersedia.</p>
                    @endforelse
                </div>
            </div>


            <!-- Equipment Collection -->
            <div class="collection">
                <div class="collection-header">
                    <h3>Koleksi Equipment</h3>
                    <a href="{{ route('procurement.equipment') }}" class="view-all">Lihat Semua ></a>
                </div>
                <div class="products-grid">
                    @forelse($randomEquipments as $product)
                        <div class="product-card">
                            <div class="product-image">
                                <img src="{{ $product->image_path ? asset('storage/' . $product->image_path) : 'https://via.placeholder.com/150' }}"
                                    class="object-cover h-32 w-full rounded-t" />
                                <span class="product-badge">{{ $product->supplier }}</span>
                            </div>
                            <div class="product-info">
                                <h4>{{ $product->name }}</h4>
                                <p class="product-desc">{{ $product->description ?? '-' }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500">Tidak ada produk Material tersedia.</p>
                    @endforelse
                </div>
            </div>

            <!-- Electrical Collection -->
            <div class="collection">
                <div class="collection-header">
                    <h3>Koleksi Electrical</h3>
                    <a href="{{ route('procurement.electrical') }}" class="view-all">Lihat Semua ></a>
                </div>
                <div class="products-grid">
                    @forelse($randomElectricals as $product)
                        <div class="product-card">
                            <div class="product-image">
                                <img src="{{ $product->image_path ? asset('storage/' . $product->image_path) : 'https://via.placeholder.com/150' }}"
                                    class="object-cover h-32 w-full rounded-t" />
                                <span class="product-badge">{{ $product->supplier }}</span>
                            </div>
                            <div class="product-info">
                                <h4>{{ $product->name }}</h4>
                                <p class="product-desc">{{ $product->description ?? '-' }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500">Tidak ada produk Electrical tersedia.</p>
                    @endforelse
                </div>
            </div>

            <!-- Consumables Collection -->
            <div class="collection">
                <div class="collection-header">
                    <h3>Koleksi Consumables</h3>
                    <a href="{{ route('procurement.consumables') }}" class="view-all">Lihat Semua ></a>
                </div>
                <div class="products-grid">
                    @forelse($randomConsumables as $product)
                        <div class="product-card">
                            <div class="product-image">
                                <img src="{{ $product->image_path ? asset('storage/' . $product->image_path) : 'https://via.placeholder.com/150' }}"
                                    class="object-cover h-32 w-full rounded-t" />
                                <span class="product-badge">{{ $product->supplier }}</span>
                            </div>
                            <div class="product-info">
                                <h4>{{ $product->name }}</h4>
                                <p class="product-desc">{{ $product->description ?? '-' }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500">Tidak ada produk Consumables tersedia.</p>
                    @endforelse
                </div>
            </div>

            <!-- Personal Protective Equipment Collection -->
            <div class="collection">
                <div class="collection-header">
                    <h3>Koleksi Personal Protective Equipment</h3>
                    <a href="{{ route('procurement.personal') }}" class="view-all">Lihat Semua ></a>
                </div>
                <div class="products-grid">
                    @forelse($randomPPEs as $product)
                        <div class="product-card">
                            <div class="product-image">
                                <img src="{{ $product->image_path ? asset('storage/' . $product->image_path) : 'https://via.placeholder.com/150' }}"
                                    class="object-cover h-32 w-full rounded-t" />
                                <span class="product-badge">{{ $product->supplier }}</span>
                            </div>
                            <div class="product-info">
                                <h4>{{ $product->name }}</h4>
                                <p class="product-desc">{{ $product->description ?? '-' }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500">Tidak ada produk PPE tersedia.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
@endsection