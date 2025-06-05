<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Trembesi Global Energi</title>
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>

<body style="font-family: 'Inter', sans-serif; margin: 0; padding: 0; background-color: #f0f2f5; color: #333;">
    <!-- Memanggil komponen navbar -->
    @component('components.navbar')
    @endcomponent

    <div class="dashboard-container"
        style="padding: 20px; max-width: 1200px; margin: 20px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <!-- Bagian Kategori -->
        <div class="section-title" style="font-size: 24px; font-weight: bold; margin-bottom: 20px; color: #333;">
            Kategori
        </div>
        <div class="categories-grid"
            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin-bottom: 40px;">
            <a href="/category/equipment" class="category-card"
                style="background-color: #fff; border: 2px solid #E82929; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; text-align: center; text-decoration: none; color: #333; transition: transform 0.2s; min-height: 120px;">
                <i class="fas fa-tools" style="font-size: 40px; color: #E82929; margin-bottom: 10px;"></i>
                <span style="font-size: 14px; font-weight: 500;">Equipment</span>
            </a>
            <a href="/category/construction" class="category-card"
                style="background-color: #fff; border: 2px solid #E82929; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; text-align: center; text-decoration: none; color: #333; transition: transform 0.2s; min-height: 120px;">
                <i class="fas fa-building" style="font-size: 40px; color: #E82929; margin-bottom: 10px;"></i>
                <span style="font-size: 14px; font-weight: 500;">Peralatan Konstruksi</span>
            </a>
            <a href="/category/pipe-fitting" class="category-card"
                style="background-color: #fff; border: 2px solid #E82929; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; text-align: center; text-decoration: none; color: #333; transition: transform 0.2s; min-height: 120px;">
                <i class="fas fa-tape" style="font-size: 40px; color: #E82929; margin-bottom: 10px;"></i>
                <span style="font-size: 14px; font-weight: 500;">Pipa dan Fitting</span>
            </a>
            <a href="/category/paint-coating" class="category-card"
                style="background-color: #fff; border: 2px solid #E82929; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; text-align: center; text-decoration: none; color: #333; transition: transform 0.2s; min-height: 120px;">
                <i class="fas fa-paint-roller" style="font-size: 40px; color: #E82929; margin-bottom: 10px;"></i>
                <span style="font-size: 14px; font-weight: 500;">Cat dan Pelapis</span>
            </a>
            <a href="/category/hand-power-tools" class="category-card"
                style="background-color: #fff; border: 2px solid #E82929; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; text-align: center; text-decoration: none; color: #333; transition: transform 0.2s; min-height: 120px;">
                <i class="fas fa-hammer" style="font-size: 40px; color: #E82929; margin-bottom: 10px;"></i>
                <span style="font-size: 14px; font-weight: 500;">Perkakas Tangan dan Power Tools</span>
            </a>
            <a href="/category/electricity-lighting" class="category-card"
                style="background-color: #fff; border: 2px solid #E82929; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; text-align: center; text-decoration: none; color: #333; transition: transform 0.2s; min-height: 120px;">
                <i class="fas fa-plug" style="font-size: 40px; color: #E82929; margin-bottom: 10px;"></i>
                <span style="font-size: 14px; font-weight: 500;">Listrik & Pencahayaan</span>
            </a>
            <a href="/category/ventilation-ac" class="category-card"
                style="background-color: #fff; border: 2px solid #E82929; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; text-align: center; text-decoration: none; color: #333; transition: transform 0.2s; min-height: 120px;">
                <i class="fas fa-fan" style="font-size: 40px; color: #E82929; margin-bottom: 10px;"></i>
                <span style="font-size: 14px; font-weight: 500;">Sistem Ventilasi dan AC</span>
            </a>
            <a href="/category/ceiling-partition" class="category-card"
                style="background-color: #fff; border: 2px solid #E82929; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; text-align: center; text-decoration: none; color: #333; transition: transform 0.2s; min-height: 120px;">
                <i class="fas fa-th-large" style="font-size: 40px; color: #E82929; margin-bottom: 10px;"></i>
                <span style="font-size: 14px; font-weight: 500;">Plafon dan Partisi</span>
            </a>
            <a href="/category/floor-wall" class="category-card"
                style="background-color: #fff; border: 2px solid #E82929; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; text-align: center; text-decoration: none; color: #333; transition: transform 0.2s; min-height: 120px;">
                <i class="fas fa-square" style="font-size: 40px; color: #E82929; margin-bottom: 10px;"></i>
                <span style="font-size: 14px; font-weight: 500;">Lantai dan Dinding</span>
            </a>
            <a href="/category/safety-equipment" class="category-card"
                style="background-color: #fff; border: 2px solid #E82929; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; text-align: center; text-decoration: none; color: #333; transition: transform 0.2s; min-height: 120px;">
                <i class="fas fa-traffic-cone" style="font-size: 40px; color: #E82929; margin-bottom: 10px;"></i>
                <span style="font-size: 14px; font-weight: 500;">Peralatan Keamanan Konstruksi</span>
            </a>
        </div>

        <!-- Bagian Rekomendasi -->
        <div class="section-title" style="font-size: 24px; font-weight: bold; margin-bottom: 20px; color: #333;">
            REKOMENDASI
        </div>

        <!-- Koleksi Bahan Bangunan -->
        <div class="recommendation-section" style="margin-bottom: 40px;">
            <div class="recommendation-header"
                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; border-bottom: 2px solid #E82929; padding-bottom: 10px;">
                <div class="section-subtitle" style="font-size: 18px; font-weight: bold; color: #333;">Koleksi Bahan
                    Bangunan</div>
                <a href="/collection/bahan-bangunan"
                    style="color: #E82929; text-decoration: none; font-weight: 500; display: flex; align-items: center;">
                    Lihat Semua
                    <i class="fas fa-chevron-right" style="margin-left: 5px;"></i>
                </a>
            </div>
            <div class="product-scroll-container"
                style="display: flex; overflow-x: auto; gap: 20px; padding-bottom: 15px; -webkit-overflow-scrolling: touch; scrollbar-width: thin; scrollbar-color: #E82929 #f0f2f5;">
                @foreach ([['name' => 'Pipa PVC 6 meter', 'price' => 'Rp110.199', 'shop' => 'Toko Beringin', 'stock' => '1500'], ['name' => 'Pipa Besi', 'price' => 'Rp110.400', 'shop' => 'Jakarta Selatan', 'stock' => '1200'], ['name' => 'Gypsum', 'price' => 'Rp110.119', 'shop' => 'Toko Beringin', 'stock' => '1500'], ['name' => 'Pipa PVC 6 meter', 'price' => 'Rp110.198', 'shop' => 'Toko Beringin', 'stock' => '1500'], ['name' => 'Pipa PVC 6 meter', 'price' => 'Rp110.198', 'shop' => 'Toko Beringin', 'stock' => '1500'], ['name' => 'Pipa PVC 6 meter', 'price' => 'Rp110.198', 'shop' => 'Toko Beringin', 'stock' => '1500']] as $index => $product)
                    <a href="/product/{{ $index + 1 }}" class="product-card"
                        style="flex: 0 0 auto; width: 200px; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); overflow: hidden; text-decoration: none; color: #333; transition: transform 0.2s;">
                        <div class="product-card-image-wrapper"
                            style="position: relative; width: 100%; height: 150px; background-color: #eee; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                            <img src="https://placehold.co/200x150/f0f2f5/E82929?text={{ $product['name'] }}"
                                alt="{{ $product['name'] }}" class="product-card-image"
                                style="width: 100%; height: 100%; object-fit: cover;">
                            <span class="shop-name-overlay"
                                style="position: absolute; top: 10px; left: 10px; background-color: rgba(0,0,0,0.6); color: white; font-size: 12px; padding: 4px 8px; border-radius: 4px;">
                                {{ $product['shop'] }}
                            </span>
                        </div>
                        <div class="product-card-content" style="padding: 10px;">
                            <h3 class="product-name" style="font-size: 14px; font-weight: 600; margin: 0 0 6px 0;">
                                {{ $product['name'] }}
                            </h3>
                            <div class="product-price" style="font-size: 14px; color: #E82929; font-weight: 600;">
                                {{ $product['price'] }}
                            </div>
                            <div class="product-stock" style="font-size: 12px; color: #666; margin-top: 4px;">
                                Stok: {{ $product['stock'] }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Koleksi Peralatan -->
        <div class="recommendation-section" style="margin-bottom: 40px;">
            <div class="recommendation-header"
                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; border-bottom: 2px solid #E82929; padding-bottom: 10px;">
                <div class="section-subtitle" style="font-size: 18px; font-weight: bold; color: #333;">Koleksi
                    Peralatan Konstruksi</div>
                <a href="/collection/peralatan"
                    style="color: #E82929; text-decoration: none; font-weight: 500; display: flex; align-items: center;">
                    Lihat Semua
                    <i class="fas fa-chevron-right" style="margin-left: 5px;"></i>
                </a>
            </div>
            <div class="product-scroll-container"
                style="display: flex; overflow-x: auto; gap: 20px; padding-bottom: 15px; -webkit-overflow-scrolling: touch; scrollbar-width: thin; scrollbar-color: #E82929 #f0f2f5;">
                @foreach ([['name' => 'Pipa Besi', 'price' => 'Rp110.400', 'shop' => 'Jakarta Selatan', 'stock' => '1200'], ['name' => 'Gypsum', 'price' => 'Rp110.119', 'shop' => 'Toko Beringin', 'stock' => '1500'], ['name' => 'Pipa PVC 6 meter', 'price' => 'Rp110.198', 'shop' => 'Toko Beringin', 'stock' => '1500'], ['name' => 'Pipa PVC 6 meter', 'price' => 'Rp110.198', 'shop' => 'Toko Beringin', 'stock' => '1500'], ['name' => 'Pipa PVC 6 meter', 'price' => 'Rp110.198', 'shop' => 'Toko Beringin', 'stock' => '1500'], ['name' => 'Pipa PVC 6 meter', 'price' => 'Rp110.198', 'shop' => 'Toko Beringin', 'stock' => '1500']] as $index => $product)
                    <a href="/product/{{ $index + 1 }}" class="product-card"
                        style="flex: 0 0 auto; width: 200px; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); overflow: hidden; text-decoration: none; color: #333; transition: transform 0.2s;">
                        <div class="product-card-image-wrapper"
                            style="position: relative; width: 100%; height: 150px; background-color: #eee; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                            <img src="https://placehold.co/200x150/f0f2f5/E82929?text={{ $product['name'] }}"
                                alt="{{ $product['name'] }}" class="product-card-image"
                                style="width: 100%; height: 100%; object-fit: cover;">
                            <span class="shop-name-overlay"
                                style="position: absolute; top: 10px; left: 10px; background-color: rgba(0,0,0,0.6); color: white; font-size: 12px; padding: 4px 8px; border-radius: 4px;">
                                {{ $product['shop'] }}
                            </span>
                        </div>
                        <div class="product-card-content" style="padding: 10px;">
                            <h3 class="product-name" style="font-size: 14px; font-weight: 600; margin: 0 0 6px 0;">
                                {{ $product['name'] }}
                            </h3>
                            <div class="product-price" style="font-size: 14px; color: #E82929; font-weight: 600;">
                                {{ $product['price'] }}
                            </div>
                            <div class="product-stock" style="font-size: 12px; color: #666; margin-top: 4px;">
                                Stok: {{ $product['stock'] }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</body>

</html>
