@extends('layouts.app') 

@section('content')
    <!-- Include Navbar Component -->
     @include('components.navbar')

    <!-- Main Content -->
    <div class="container">
        <!-- Categories Section -->
        <div class="section-title">Kategori</div>
        <div class="categories-grid">
            <a href="/login" class="category-card">
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
            <div class="recommendations-title">REKOMENDASI</div>
            
            <!-- Material Collection -->
            <div class="collection">
                <div class="collection-header">
                    <h3>Koleksi Material</h3>
                    <a href="#" class="view-all">Lihat Semua ></a>
                </div>
                <div class="products-grid">
                    @for($i = 0; $i < 6; $i++)
                    <div class="product-card">
                        <div class="product-image">
                            @if($i == 1)
                                Steel
                            @elseif($i == 2)
                                Gyp
                            @else
                                PVC
                            @endif
                            <span class="product-badge">Toko Bangunan</span>
                        </div>
                        <div class="product-info">
                            <h4>
                                @if($i == 1)
                                    HITAM 450
                                @else
                                    PUTIH 100
                                @endif
                            </h4>
                            <p class="product-desc">
                                @if($i == 1)
                                    Pipa Steel 3 inch
                                @elseif($i == 2)
                                    Gypsum Board Standard
                                @elseif($i == 3)
                                    Pipa PVC 6 inch
                                @elseif($i == 4)
                                    Pipa PVC 2 inch
                                @elseif($i == 5)
                                    Pipa PVC 8 inch
                                @else
                                    Pipa PVC 4 inch
                                @endif
                            </p>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>

            <!-- Equipment Collection -->
            <div class="collection">
                <div class="collection-header">
                    <h3>Koleksi Equipment</h3>
                    <a href="#" class="view-all">Lihat Semua ></a>
                </div>
                <div class="equipment-grid">
                    @for($row = 0; $row < 2; $row++)
                        @for($col = 0; $col < 6; $col++)
                        <div class="product-card">
                            <div class="product-image">
                                @if($col == 1)
                                    Steel
                                @elseif($col == 2)
                                    Gyp
                                @else
                                    PVC
                                @endif
                                <span class="product-badge">Toko Bangunan</span>
                            </div>
                            <div class="product-info">
                                <h4>
                                    @if($col == 1)
                                        HITAM 450
                                    @else
                                        PUTIH 100
                                    @endif
                                </h4>
                                <p class="product-desc">
                                    @if($col == 1)
                                        Pipa Steel 3 inch
                                    @elseif($col == 2)
                                        Gypsum Board Standard
                                    @elseif($col == 3)
                                        Pipa PVC 6 inch
                                    @elseif($col == 4)
                                        Pipa PVC 2 inch
                                    @elseif($col == 5)
                                        Pipa PVC 8 inch
                                    @else
                                        Pipa PVC 4 inch
                                    @endif
                                </p>
                            </div>
                        </div>
                        @endfor
                    @endfor
                </div>
            </div>
        </div>
    </div>

    