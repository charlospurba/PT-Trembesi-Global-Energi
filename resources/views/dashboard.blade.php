<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Trembesi Global Energi</title>
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
</head>

<body>
    <!-- Memanggil komponen navbar -->
    @component('components.navbar')
    @endcomponent

    <div class="dashboard-container">
        <!-- Bagian Kategori -->
        <div class="section-title">Kategori</div>
        <div class="categories-grid">
            <a href="/category/equipment" class="category-card">
                <i class="fas fa-tools"></i>
                <span>Equipment</span>
            </a>
            <a href="/category/construction" class="category-card">
                <i class="fas fa-building"></i>
                <span>Peralatan Konstruksi</span>
            </a>
            <a href="/category/pipe-fitting" class="category-card">
                <i class="fas fa-tape"></i>
                <span>Pipa dan Fitting</span>
            </a>
            <a href="/category/paint-coating" class="category-card">
                <i class="fas fa-paint-roller"></i>
                <span>Cat dan Pelapis</span>
            </a>
            <a href="/category/hand-power-tools" class="category-card">
                <i class="fas fa-hammer"></i>
                <span>Perkakas Tangan dan Power Tools</span>
            </a>
            <a href="/category/electricity-lighting" class="category-card">
                <i class="fas fa-plug"></i>
                <span>Listrik & Pencahayaan</span>
            </a>
            <a href="/category/ventilation-ac" class="category-card">
                <i class="fas fa-fan"></i>
                <span>Sistem Ventilasi dan AC</span>
            </a>
            <a href="/category/ceiling-partition" class="category-card">
                <i class="fas fa-th-large"></i>
                <span>Plafon dan Partisi</span>
            </a>
            <a href="/category/floor-wall" class="category-card">
                <i class="fas fa-square"></i>
                <span>Lantai dan Dinding</span>
            </a>
            <a href="/category/safety-equipment" class="category-card">
                <i class="fas fa-traffic-cone"></i>
                <span>Peralatan Keamanan Konstruksi</span>
            </a>
        </div>

        <!-- Bagian Rekomendasi -->
        <div class="section-title">REKOMENDASI</div>

        <!-- Koleksi Bahan Bangunan -->
        <div class="recommendation-section">
            <div class="recommendation-header">
                <div class="section-subtitle">Koleksi Bahan Bangunan</div>
                <a href="/collection/bahan-bangunan" class="view-all">
                    Lihat Semua
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
            <div class="product-scroll-container">
                @foreach ([['name' => 'Pipa PVC 6 meter', 'price' => 'Rp110.199', 'shop' => 'Toko Beringin', 'stock' => '1500'], ['name' => 'Pipa Besi', 'price' => 'Rp110.400', 'shop' => 'Jakarta Selatan', 'stock' => '1200'], ['name' => 'Gypsum', 'price' => 'Rp110.119', 'shop' => 'Toko Beringin', 'stock' => '1500'], ['name' => 'Pipa PVC 6 meter', 'price' => 'Rp110.198', 'shop' => 'Toko Beringin', 'stock' => '1500'], ['name' => 'Pipa PVC 6 meter', 'price' => 'Rp110.198', 'shop' => 'Toko Beringin', 'stock' => '1500'], ['name' => 'Pipa PVC 6 meter', 'price' => 'Rp110.198', 'shop' => 'Toko Beringin', 'stock' => '1500']] as $index => $product)
                    <a href="/product/{{ $index + 1 }}" class="product-card">
                        <div class="product-card-image-wrapper">
                            <img src="https://placehold.co/200x150/f0f2f5/E82929?text={{ $product['name'] }}"
                                alt="{{ $product['name'] }}" class="product-card-image">
                            <span class="shop-name-overlay">{{ $product['shop'] }}</span>
                        </div>
                        <div class="product-card-content">
                            <h3 class="product-name">{{ $product['name'] }}</h3>
                            <div class="product-price">{{ $product['price'] }}</div>
                            <div class="product-stock">Stok: {{ $product['stock'] }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Koleksi Peralatan -->
        <div class="recommendation-section">
            <div class="recommendation-header">
                <div class="section-subtitle">Koleksi Peralatan Konstruksi</div>
                <a href="/collection/peralatan" class="view-all">
                    Lihat Semua
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
            <div class="product-scroll-container">
                @foreach ([['name' => 'Pipa Besi', 'price' => 'Rp110.400', 'shop' => 'Jakarta Selatan', 'stock' => '1200'], ['name' => 'Gypsum', 'price' => 'Rp110.119', 'shop' => 'Toko Beringin', 'stock' => '1500'], ['name' => 'Pipa PVC 6 meter', 'price' => 'Rp110.198', 'shop' => 'Toko Beringin', 'stock' => '1500'], ['name' => 'Pipa PVC 6 meter', 'price' => 'Rp110.198', 'shop' => 'Toko Beringin', 'stock' => '1500'], ['name' => 'Pipa PVC 6 meter', 'price' => 'Rp110.198', 'shop' => 'Toko Beringin', 'stock' => '1500'], ['name' => 'Pipa PVC 6 meter', 'price' => 'Rp110.198', 'shop' => 'Toko Beringin', 'stock' => '1500']] as $index => $product)
                    <a href="/product/{{ $index + 1 }}" class="product-card">
                        <div class="product-card-image-wrapper">
                            <img src="https://placehold.co/200x150/f0f2f5/E82929?text={{ $product['name'] }}"
                                alt="{{ $product['name'] }}" class="product-card-image">
                            <span class="shop-name-overlay">{{ $product['shop'] }}</span>
                        </div>
                        <div class="product-card-content">
                            <h3 class="product-name">{{ $product['name'] }}</h3>
                            <div class="product-price">{{ $product['price'] }}</div>
                            <div class="product-stock">Stok: {{ $product['stock'] }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</body>

</html>
