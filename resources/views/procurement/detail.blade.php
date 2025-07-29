@extends('layouts.app')

@section('content')
    <!-- Include SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Include Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Include Navbar Component -->
    @include('components.procnav')

    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-red-50 to-rose-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <!-- Breadcrumb -->
            <nav id="breadcrumb" class="flex items-center space-x-2 text-sm mb-6 px-4 py-3 rounded-xl shadow-lg">
                <a href="{{ route('procurement.dashboardproc') }}"
                    class="flex items-center text-gray-600 hover:text-red-600 transition-all duration-300">
                    <i class="fas fa-home mr-2"></i>Dashboard
                </a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span class="text-red-600 font-semibold">{{ $product->name }}</span>
            </nav>

            <!-- Main Product Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <!-- Image Section -->
                <div class="lg:col-span-4 equal-height" id="imageSection">
                    <div class="relative floating-card h-full">
                        <div id="imageCard" class="rounded-2xl shadow-xl overflow-hidden h-full flex flex-col">

                            <!-- Main Image Container -->
                            <div class="relative group flex-1" id="productImageContainer">
                                <div id="imageLoader"
                                    class="absolute inset-0 bg-gray-50 hidden items-center justify-center z-10">
                                    <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-red-600"></div>
                                </div>

                                <img id="mainImage"
                                    src="{{ !empty($product->image_paths) && is_array($product->image_paths) && count($product->image_paths) > 0 ? asset('storage/' . $product->image_paths[0] . '?' . time()) : 'https://via.placeholder.com/400x300/dc2626/ffffff?text=Premium+Product' }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-contain transition-all duration-500"
                                    onload="hideImageLoader()" onerror="handleImageError(this)" />

                                <!-- Subtle overlay -->
                                <div id="imageOverlay" class="absolute inset-0 opacity-0 transition-all duration-300"></div>
                            </div>

                            <!-- Thumbnail Gallery Section -->
                            <div id="thumbnailSection" class="flex-shrink-0">
                                <div id="thumbnailGallery" class="flex gap-2 overflow-x-auto p-3">
                                    @php
                                        $images =
                                            !empty($product->image_paths) && is_array($product->image_paths)
                                                ? $product->image_paths
                                                : [
                                                    'https://via.placeholder.com/400x300/dc2626/ffffff?text=Image+1',
                                                    'https://via.placeholder.com/400x300/991b1b/ffffff?text=Image+2',
                                                    'https://via.placeholder.com/400x300/b91c1c/ffffff?text=Image+3',
                                                    'https://via.placeholder.com/400x300/7f1d1d/ffffff?text=Image+4',
                                                ];
                                    @endphp

                                    @foreach ($images as $index => $image)
                                        <div class="thumbnail-item {{ $index === 0 ? 'active' : '' }}"
                                            onclick="changeMainImage('{{ is_string($image) && str_starts_with($image, 'http') ? $image : asset('storage/' . $image . '?' . time()) }}', this)">
                                            <img src="{{ is_string($image) && str_starts_with($image, 'http') ? $image : asset('storage/' . $image . '?' . time()) }}"
                                                alt="Product Image {{ $index + 1 }}" loading="lazy" />
                                        </div>
                                    @endforeach

                                    @if (count($images) < 6)
                                        @for ($i = count($images); $i < 6; $i++)
                                            <div class="thumbnail-item thumbnail-placeholder opacity-50">
                                                <i class="fas fa-plus text-gray-400"></i>
                                            </div>
                                        @endfor
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="lg:col-span-4 equal-height" id="productDetailsSection">
                    <div id="productDetailsCard" class="rounded-2xl shadow-xl h-full p-5">
                        <div class="h-full flex flex-col">

                            <!-- Product Title -->
                            <h1 class="text-2xl font-bold text-gray-900 leading-tight mb-4">
                                {{ $product->name }}
                            </h1>

                            <!-- Price & Rating Section -->
                            <div id="priceSection" class="rounded-xl p-4 mb-4">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-3xl font-bold text-red-600">
                                        Rp{{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </div>

                                <!-- Rating & Sales -->
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center bg-white px-3 py-2 rounded-full shadow-sm">
                                        <div class="flex text-yellow-400 mr-2 text-sm">
                                            @php
                                                $averageRating = $product->average_rating ?? 0;
                                                $fullStars = floor($averageRating);
                                                $halfStar = $averageRating - $fullStars >= 0.5;
                                            @endphp
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $fullStars)
                                                    <i class="fas fa-star"></i>
                                                @elseif ($halfStar && $i == $fullStars + 1)
                                                    <i class="fas fa-star-half-alt"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="font-medium text-gray-700 text-sm">
                                            {{ $averageRating > 0 ? number_format($averageRating, 1) : 'No Ratings' }}
                                        </span>
                                    </div>
                                    <div
                                        class="bg-white text-gray-700 px-3 py-2 rounded-full text-sm font-medium shadow-sm">
                                        <i class="fas fa-shopping-bag mr-2 text-red-500"></i>
                                        {{ $soldQuantity > 100 ? '100+ Sold' : $soldQuantity . ' Sold' }}
                                    </div>
                                </div>
                            </div>

                            <!-- Product Information -->
                            <div class="flex-1">
                                <h2 class="text-lg font-semibold text-gray-900 mb-3">
                                    <i class="fas fa-info-circle mr-2 text-red-600"></i>
                                    Product Information
                                </h2>
                                <div id="productInfoGrid" class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                                    <div class="info-item p-3 bg-white rounded-lg shadow-sm border">
                                        <div class="text-xs text-gray-600 font-medium mb-1 uppercase">Category</div>
                                        <div class="text-sm text-gray-900 font-semibold">{{ $product->category }}</div>
                                    </div>
                                    <div class="info-item p-3 bg-white rounded-lg shadow-sm border">
                                        <div class="text-xs text-gray-600 font-medium mb-1 uppercase">Unit</div>
                                        <div class="text-sm text-gray-900 font-semibold">{{ $product->unit ?? '-' }}</div>
                                    </div>
                                    <div class="info-item p-3 bg-white rounded-lg shadow-sm border">
                                        <div class="text-xs text-gray-600 font-medium mb-1 uppercase">Brand</div>
                                        <div class="text-sm text-gray-900 font-semibold">{{ $product->brand ?? '-' }}</div>
                                    </div>
                                    <div class="info-item p-3 bg-white rounded-lg shadow-sm border">
                                        <div class="text-xs text-gray-600 font-medium mb-1 uppercase">Specification</div>
                                        <div class="text-sm text-gray-900 font-semibold">
                                            {{ $product->specification ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Purchase Box -->
                <div class="lg:col-span-4 equal-height" id="purchaseSection">
                    <div id="purchaseCard" class="rounded-2xl shadow-xl overflow-hidden h-full">
                        <div class="h-full flex flex-col">

                            <!-- Header -->
                            <div id="purchaseHeader" class="text-white p-4 flex-shrink-0">
                                <h3 class="font-semibold text-lg flex items-center">
                                    <i id="cartIcon" class="fas fa-shopping-cart mr-2"></i>
                                    Make Purchase
                                </h3>
                                <p class="text-white/90 text-sm mt-1">Fast & Secure Checkout</p>
                            </div>

                            <div class="p-5 flex-1 flex flex-col">
                                <form id="add-to-cart-form" class="h-full flex flex-col">
                                    @csrf

                                    <div class="flex-1 flex flex-col justify-between">
                                        <!-- Quantity Selector -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                                <i class="fas fa-sort-numeric-up mr-2 text-red-600"></i>
                                                Quantity
                                            </label>
                                            <div class="flex items-center justify-center gap-3">
                                                <button type="button" id="decreaseBtn" onclick="updateQuantity(-1)"
                                                    class="w-10 h-10 bg-gray-200 hover:bg-red-500 hover:text-white text-gray-700 font-medium rounded-lg transition-all duration-300">
                                                    <i class="fas fa-minus text-sm"></i>
                                                </button>
                                                <input type="number" id="quantity" name="quantity" value="1"
                                                    min="{{ $product->min_order ?? 1 }}"
                                                    max="{{ $product->quantity ?? 9999 }}"
                                                    class="w-20 h-10 text-center border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 font-medium"
                                                    oninput="validateQuantity(this)" />
                                                <button type="button" id="increaseBtn" onclick="updateQuantity(1)"
                                                    class="w-10 h-10 bg-gray-200 hover:bg-red-500 hover:text-white text-gray-700 font-medium rounded-lg transition-all duration-300">
                                                    <i class="fas fa-plus text-sm"></i>
                                                </button>
                                            </div>
                                            <p class="text-center mt-3 text-sm text-gray-600">
                                                <i class="fas fa-box mr-1 text-red-500"></i>
                                                <span class="font-medium">{{ $product->quantity ?? 'Many' }}</span>
                                                Available
                                            </p>
                                        </div>

                                        <!-- Total Price -->
                                        <div id="totalPriceSection" class="mb-4 rounded-xl p-4 border-2">
                                            <div class="text-center">
                                                <div class="text-sm text-gray-600 mb-2">Total Price</div>
                                                <div class="text-2xl font-bold text-red-600" id="total-price">
                                                    Rp{{ number_format($product->price, 0, ',', '.') }}
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" id="addToCartBtn"
                                            onclick="addToCart({{ $product->id }})"
                                            class="w-full border-2 border-red-500 text-red-600 py-3 px-4 rounded-xl font-semibold hover:bg-red-500 hover:text-white transition-all duration-300 transform">
                                            <i class="fas fa-cart-plus mr-2"></i>Add to Cart
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vendor Section -->
            <div id="vendorSection" class="mt-6">
                <div id="vendorCard" class="rounded-2xl shadow-xl p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">
                        <i class="fas fa-store mr-2 text-red-600"></i>
                        Vendor Information
                    </h2>
                    <div class="flex items-center gap-6">
                        <div id="vendorIcon" class="w-16 h-16 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-store text-white text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <a href="{{ route('store.show', ['store' => urlencode($product->supplier ?? 'Premium Store')]) }}"
                                class="text-2xl font-bold text-gray-900 hover:text-red-600 transition-all duration-300">
                                {{ $product->supplier ?? 'Premium Store' }}
                            </a>
                            <div class="flex items-center gap-4 mt-2">
                                <div
                                    class="flex items-center bg-yellow-50 px-4 py-2 rounded-full border border-yellow-200">
                                    <div class="flex text-yellow-500 mr-2" id="vendor-rating-stars">
                                        @php
                                            $storeRating = 5.0; // Initial placeholder
                                            $fullStars = floor($storeRating);
                                            $halfStar = $storeRating - $fullStars >= 0.5;
                                        @endphp
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $fullStars)
                                                <i class="fas fa-star"></i>
                                            @elseif ($halfStar && $i == $fullStars + 1)
                                                <i class="fas fa-star-half-alt"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="font-medium text-gray-700" id="vendor-rating-text">
                                        {{ number_format($storeRating, 1) }} Store Rating
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <a href="{{ route('store.show', ['store' => urlencode($product->supplier ?? 'Premium Store')]) }}"
                                class="inline-flex items-center px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-300 transform">
                                <i class="fas fa-external-link-alt mr-2"></i>
                                Visit Store
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Dynamic styling functions
        function applyStyles() {
            // Apply glass effect
            const glassElements = [
                document.getElementById('breadcrumb'),
                document.getElementById('imageCard'),
                document.getElementById('productDetailsCard'),
                document.getElementById('purchaseCard'),
                document.getElementById('vendorCard')
            ];

            glassElements.forEach(element => {
                if (element) {
                    element.style.backdropFilter = 'blur(10px)';
                    element.style.background = 'rgba(255, 255, 255, 0.95)';
                    element.style.border = '1px solid rgba(255, 255, 255, 0.2)';
                }
            });

            // Apply product image styling
            const productImageContainer = document.getElementById('productImageContainer');
            if (productImageContainer) {
                productImageContainer.style.height = '320px';
                productImageContainer.style.maxHeight = '340px';
                productImageContainer.style.minHeight = '300px';
                productImageContainer.style.background = 'linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%)';
                productImageContainer.style.borderRadius = '12px';
                productImageContainer.style.overflow = 'hidden';
            }

            // Apply thumbnail section styling
            const thumbnailSection = document.getElementById('thumbnailSection');
            if (thumbnailSection) {
                thumbnailSection.style.background = 'white';
                thumbnailSection.style.borderTop = '1px solid #f1f5f9';
                thumbnailSection.style.padding = '12px';
                thumbnailSection.style.marginTop = '8px';
            }

            // Apply thumbnail gallery styling
            const thumbnailGallery = document.getElementById('thumbnailGallery');
            if (thumbnailGallery) {
                thumbnailGallery.style.cursor = 'grab';

                // Custom scrollbar
                const style = document.createElement('style');
                style.textContent = `
                    #thumbnailGallery::-webkit-scrollbar {
                        height: 4px;
                    }
                    #thumbnailGallery::-webkit-scrollbar-track {
                        background: #f1f1f1;
                        border-radius: 4px;
                    }
                    #thumbnailGallery::-webkit-scrollbar-thumb {
                        background: #dc2626;
                        border-radius: 4px;
                    }
                    #thumbnailGallery::-webkit-scrollbar-thumb:hover {
                        background: #991b1b;
                    }
                `;
                document.head.appendChild(style);
            }

            // Apply price section styling
            const priceSection = document.getElementById('priceSection');
            if (priceSection) {
                priceSection.style.background = 'linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%)';
                priceSection.style.border = '1px solid #f3c6c6';
                priceSection.style.position = 'relative';
                priceSection.style.overflow = 'hidden';

                // Add top border effect
                const topBorder = document.createElement('div');
                topBorder.style.position = 'absolute';
                topBorder.style.top = '0';
                topBorder.style.left = '0';
                topBorder.style.right = '0';
                topBorder.style.height = '2px';
                topBorder.style.background = 'linear-gradient(90deg, #dc2626, #ef4444, #dc2626)';
                priceSection.appendChild(topBorder);
            }

            // Apply purchase header styling
            const purchaseHeader = document.getElementById('purchaseHeader');
            if (purchaseHeader) {
                purchaseHeader.style.background = 'linear-gradient(135deg, #dc2626 0%, #991b1b 100%)';
            }

            // Apply total price section styling
            const totalPriceSection = document.getElementById('totalPriceSection');
            if (totalPriceSection) {
                totalPriceSection.style.background = 'linear-gradient(to right, #f9fafb, #fef2f2)';
                totalPriceSection.style.borderColor = '#fecaca';
            }

            // Apply vendor icon styling
            const vendorIcon = document.getElementById('vendorIcon');
            if (vendorIcon) {
                vendorIcon.style.background = 'linear-gradient(135deg, #dc2626 0%, #991b1b 100%)';
            }

            // Apply equal height styling
            const equalHeightElements = document.querySelectorAll('.equal-height');
            equalHeightElements.forEach(element => {
                element.style.height = '100%';
                element.style.minHeight = '500px';
            });

            // Apply thumbnail item styling
            applyThumbnailStyling();

            // Apply floating card animation
            applyFloatingAnimation();

            // Apply hover effects
            applyHoverEffects();

            // Apply info item hover effects
            applyInfoItemHoverEffects();

            // Apply responsive design
            applyResponsiveDesign();
        }

        function applyThumbnailStyling() {
            const thumbnailItems = document.querySelectorAll('.thumbnail-item');
            thumbnailItems.forEach(item => {
                item.style.flexShrink = '0';
                item.style.width = '60px';
                item.style.height = '60px';
                item.style.borderRadius = '8px';
                item.style.overflow = 'hidden';
                item.style.border = '2px solid transparent';
                item.style.cursor = 'pointer';
                item.style.transition = 'all 0.3s ease';
                item.style.background = '#f8fafc';
                item.style.position = 'relative';

                if (item.classList.contains('active')) {
                    item.style.borderColor = '#dc2626';
                    item.style.boxShadow = '0 0 12px rgba(220, 38, 38, 0.3)';
                    item.style.transform = 'scale(1.02)';
                }

                if (item.classList.contains('thumbnail-placeholder')) {
                    item.style.background = 'linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%)';
                    item.style.display = 'flex';
                    item.style.alignItems = 'center';
                    item.style.justifyContent = 'center';
                }

                const img = item.querySelector('img');
                if (img) {
                    img.style.width = '100%';
                    img.style.height = '100%';
                    img.style.objectFit = 'contain';
                    img.style.objectPosition = 'center';
                }
            });
        }

        function applyFloatingAnimation() {
            const floatingCards = document.querySelectorAll('.floating-card');
            floatingCards.forEach(card => {
                let direction = 1;
                let position = 0;

                setInterval(() => {
                    position += direction * 0.5;
                    if (position >= 5 || position <= -5) {
                        direction *= -1;
                    }
                    card.style.transform = `translateY(${position}px)`;
                }, 50);
            });
        }

        function applyHoverEffects() {
            // Thumbnail hover effects
            const thumbnailItems = document.querySelectorAll('.thumbnail-item');
            thumbnailItems.forEach(item => {
                if (!item.classList.contains('thumbnail-placeholder')) {
                    item.addEventListener('mouseenter', () => {
                        item.style.borderColor = '#dc2626';
                        item.style.transform = 'scale(1.05)';
                        item.style.boxShadow = '0 4px 12px rgba(220, 38, 38, 0.15)';
                    });

                    item.addEventListener('mouseleave', () => {
                        if (!item.classList.contains('active')) {
                            item.style.borderColor = 'transparent';
                            item.style.transform = 'scale(1)';
                            item.style.boxShadow = 'none';
                        }
                    });
                }
            });

            // Card hover effects
            const hoverCards = [
                document.getElementById('imageCard'),
                document.getElementById('productDetailsCard'),
                document.getElementById('purchaseCard'),
                document.getElementById('vendorCard')
            ];

            hoverCards.forEach(card => {
                if (card) {
                    card.addEventListener('mouseenter', () => {
                        card.style.transform = 'translateY(-2px)';
                        card.style.boxShadow = '0 8px 25px rgba(0, 0, 0, 0.1)';
                    });

                    card.addEventListener('mouseleave', () => {
                        card.style.transform = 'translateY(0)';
                        card.style.boxShadow = '';
                    });
                }
            });

            // Button hover effects
            const buttons = [
                document.getElementById('decreaseBtn'),
                document.getElementById('increaseBtn'),
                document.getElementById('addToCartBtn')
            ];

            buttons.forEach(button => {
                if (button) {
                    button.addEventListener('mouseenter', () => {
                        button.style.transform = 'scale(1.05)';
                    });

                    button.addEventListener('mouseleave', () => {
                        button.style.transform = 'scale(1)';
                    });
                }
            });

            // Image overlay effect
            const productImageContainer = document.getElementById('productImageContainer');
            const imageOverlay = document.getElementById('imageOverlay');

            if (productImageContainer && imageOverlay) {
                imageOverlay.style.background = 'linear-gradient(to top, rgba(0,0,0,0.05), transparent, transparent)';

                productImageContainer.addEventListener('mouseenter', () => {
                    imageOverlay.style.opacity = '1';
                });

                productImageContainer.addEventListener('mouseleave', () => {
                    imageOverlay.style.opacity = '0';
                });
            }
        }

        function applyInfoItemHoverEffects() {
            const infoItems = document.querySelectorAll('.info-item');
            infoItems.forEach(item => {
                item.addEventListener('mouseenter', () => {
                    item.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.1)';
                    item.style.transform = 'translateY(-1px)';
                });

                item.addEventListener('mouseleave', () => {
                    item.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.1)';
                    item.style.transform = 'translateY(0)';
                });
            });
        }

        function applyResponsiveDesign() {
            function handleResize() {
                const width = window.innerWidth;
                const productImageContainer = document.getElementById('productImageContainer');
                const equalHeightElements = document.querySelectorAll('.equal-height');
                const thumbnailItems = document.querySelectorAll('.thumbnail-item');
                const productInfoGrid = document.getElementById('productInfoGrid');

                if (width <= 768) {
                    // Mobile styles
                    if (productImageContainer) {
                        productImageContainer.style.height = '250px';
                        productImageContainer.style.maxHeight = '270px';
                        productImageContainer.style.minHeight = '230px';
                    }

                    equalHeightElements.forEach(element => {
                        element.style.minHeight = 'auto';
                    });

                    thumbnailItems.forEach(item => {
                        item.style.width = '50px';
                        item.style.height = '50px';
                    });

                    if (productInfoGrid) {
                        productInfoGrid.style.gridTemplateColumns = '1fr';
                    }

                    const thumbnailGallery = document.getElementById('thumbnailGallery');
                    if (thumbnailGallery) {
                        thumbnailGallery.style.gap = '6px';
                    }
                } else if (width <= 1024) {
                    // Tablet styles
                    if (productImageContainer) {
                        productImageContainer.style.height = '280px';
                        productImageContainer.style.maxHeight = '300px';
                        productImageContainer.style.minHeight = '260px';
                    }

                    equalHeightElements.forEach(element => {
                        element.style.minHeight = '450px';
                    });

                    thumbnailItems.forEach(item => {
                        item.style.width = '55px';
                        item.style.height = '55px';
                    });
                } else {
                    // Desktop styles
                    if (productImageContainer) {
                        productImageContainer.style.height = '320px';
                        productImageContainer.style.maxHeight = '340px';
                        productImageContainer.style.minHeight = '300px';
                    }

                    equalHeightElements.forEach(element => {
                        element.style.minHeight = '500px';
                    });

                    thumbnailItems.forEach(item => {
                        item.style.width = '60px';
                        item.style.height = '60px';
                    });

                    if (productInfoGrid) {
                        productInfoGrid.style.gridTemplateColumns = '1fr 1fr';
                    }
                }
            }

            window.addEventListener('resize', handleResize);
            handleResize(); // Initial call
        }

        function applyGlowingAnimation() {
            // Apply bounce animation to cart icon
            const cartIcon = document.getElementById('cartIcon');
            if (cartIcon) {
                let bouncePosition = 0;
                let bounceDirection = 1;
                let bounceSpeed = 0.1;

                setInterval(() => {
                    bouncePosition += bounceDirection * bounceSpeed;
                    if (bouncePosition >= 2) {
                        bounceDirection = -0.6;
                    } else if (bouncePosition <= 0) {
                        bounceDirection = 1;
                        bounceSpeed = Math.random() * 0.1 + 0.05;
                    }
                    cartIcon.style.transform = `translateY(${-bouncePosition}px)`;
                }, 50);
            }
        }

        function applySlideInAnimation() {
            const sections = [{
                    element: document.getElementById('imageSection'),
                    delay: 0
                },
                {
                    element: document.getElementById('productDetailsSection'),
                    delay: 200
                },
                {
                    element: document.getElementById('purchaseSection'),
                    delay: 400
                },
                {
                    element: document.getElementById('vendorSection'),
                    delay: 600
                }
            ];

            sections.forEach(({
                element,
                delay
            }) => {
                if (element) {
                    element.style.opacity = '0';
                    element.style.transform = 'translateX(30px)';
                    element.style.transition = 'all 0.8s ease-out';

                    setTimeout(() => {
                        element.style.opacity = '1';
                        element.style.transform = 'translateX(0)';
                    }, delay);
                }
            });
        }

        // Image handling functions
        function hideImageLoader() {
            const loader = document.getElementById('imageLoader');
            if (loader) {
                loader.style.display = 'none';
            }
        }

        function showImageLoader() {
            const loader = document.getElementById('imageLoader');
            if (loader) {
                loader.style.display = 'flex';
            }
        }

        function handleImageError(img) {
            img.src = 'https://via.placeholder.com/400x300/dc2626/ffffff?text=Image+Not+Found';
            hideImageLoader();
        }

        function changeMainImage(imageSrc, thumbnailElement) {
            const mainImage = document.getElementById('mainImage');

            showImageLoader();

            const newImg = new Image();
            newImg.onload = function() {
                mainImage.style.opacity = '0.7';
                setTimeout(() => {
                    mainImage.src = imageSrc;
                    mainImage.style.opacity = '1';
                    hideImageLoader();
                }, 150);
            };
            newImg.onerror = function() {
                handleImageError(mainImage);
            };
            newImg.src = imageSrc;

            // Update thumbnail states
            document.querySelectorAll('.thumbnail-item').forEach(item => {
                item.classList.remove('active');
                item.style.borderColor = 'transparent';
                item.style.boxShadow = 'none';
                item.style.transform = 'scale(1)';
            });

            thumbnailElement.classList.add('active');
            thumbnailElement.style.borderColor = '#dc2626';
            thumbnailElement.style.boxShadow = '0 0 12px rgba(220, 38, 38, 0.3)';
            thumbnailElement.style.transform = 'scale(1.02)';
        }

        // Quantity and price functions
        function validateQuantity(input) {
            let min = parseInt(input.min);
            let max = parseInt(input.max);
            let value = parseInt(input.value);
            if (value < min || isNaN(value)) input.value = min;
            if (value > max) input.value = max;
            updateTotalPrice();
        }

        function updateQuantity(change) {
            let quantityInput = document.getElementById('quantity');
            let currentQuantity = parseInt(quantityInput.value);
            let newQuantity = currentQuantity + change;
            let minOrder = {{ $product->min_order ?? 1 }};
            let availableQuantity = {{ $product->quantity ?? 9999 }};

            if (newQuantity >= minOrder && newQuantity <= availableQuantity) {
                quantityInput.value = newQuantity;
                updateTotalPrice();

                // Add visual feedback
                quantityInput.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    quantityInput.style.transform = 'scale(1)';
                }, 200);
            } else if (newQuantity > availableQuantity) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Stock Limited!',
                    text: `Only ${availableQuantity} items available in stock.`,
                    confirmButtonColor: '#dc2626'
                });
            }
        }

        function updateTotalPrice() {
            let quantity = parseInt(document.getElementById('quantity').value);
            let price = {{ $product->price }};
            let total = quantity * price;

            const priceElement = document.getElementById('total-price');
            priceElement.style.transform = 'scale(1.1)';
            priceElement.textContent = 'Rp' + total.toLocaleString('id-ID', {
                minimumFractionDigits: 0
            });

            setTimeout(() => {
                priceElement.style.transform = 'scale(1)';
            }, 200);
        }

        // Cart functions
        function addToCart(productId) {
            let quantity = document.getElementById('quantity').value;

            Swal.fire({
                title: 'Adding to Cart...',
                html: '<div class="animate-spin rounded-full h-12 w-12 border-b-2 border-red-600 mx-auto"></div>',
                allowOutsideClick: false,
                showConfirmButton: false
            });

            fetch('{{ route('cart.add', ['id' => ':id']) }}'.replace(':id', productId), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('#add-to-cart-form input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        quantity: quantity
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Added to Cart!',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = '{{ route('procurement.cart') }}';
                        });
                        updateCartBadge(data.cart_count);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: data.message || 'Failed to add product to cart',
                            confirmButtonColor: '#dc2626'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Connection Error',
                        text: 'Failed to add product to cart: ' + error.message,
                        confirmButtonColor: '#dc2626'
                    });
                });
        }

        function updateCartBadge(count) {
            let badge = document.getElementById('cartBadge');
            if (badge) {
                badge.textContent = count;
                badge.style.display = count > 0 ? 'inline-block' : 'none';

                // Add animation
                badge.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    badge.style.transform = 'scale(1)';
                }, 200);
            }
        }

        function setupThumbnailScrolling() {
            const thumbnailGallery = document.getElementById('thumbnailGallery');
            if (thumbnailGallery) {
                let isDown = false;
                let startX;
                let scrollLeft;

                thumbnailGallery.addEventListener('mousedown', (e) => {
                    isDown = true;
                    thumbnailGallery.style.cursor = 'grabbing';
                    startX = e.pageX - thumbnailGallery.offsetLeft;
                    scrollLeft = thumbnailGallery.scrollLeft;
                });

                thumbnailGallery.addEventListener('mouseleave', () => {
                    isDown = false;
                    thumbnailGallery.style.cursor = 'grab';
                });

                thumbnailGallery.addEventListener('mouseup', () => {
                    isDown = false;
                    thumbnailGallery.style.cursor = 'grab';
                });

                thumbnailGallery.addEventListener('mousemove', (e) => {
                    if (!isDown) return;
                    e.preventDefault();
                    const x = e.pageX - thumbnailGallery.offsetLeft;
                    const walk = (x - startX) * 2;
                    thumbnailGallery.scrollLeft = scrollLeft - walk;
                });
            }
        }

        // Real-time rating update function
        function updateVendorRating() {
            const supplier = '{{ urlencode($product->supplier ?? 'Premium Store') }}';
            fetch('{{ route('store.reviews', ':supplier') }}'.replace(':supplier', supplier))
                .then(response => response.json())
                .then(data => {
                    const ratingStarsElement = document.getElementById('vendor-rating-stars');
                    const ratingTextElement = document.getElementById('vendor-rating-text');
                    if (ratingStarsElement && ratingTextElement) {
                        // Calculate star display
                        const averageRating = data.averageRating;
                        const fullStars = Math.floor(averageRating);
                        const halfStar = averageRating - fullStars >= 0.5;
                        let starsHtml = '';
                        for (let i = 1; i <= 5; i++) {
                            if (i <= fullStars) {
                                starsHtml += '<i class="fas fa-star"></i>';
                            } else if (halfStar && i === fullStars + 1) {
                                starsHtml += '<i class="fas fa-star-half-alt"></i>';
                            } else {
                                starsHtml += '<i class="far fa-star"></i>';
                            }
                        }
                        // Update stars and text with animation
                        ratingStarsElement.style.opacity = '0.7';
                        ratingTextElement.style.opacity = '0.7';
                        setTimeout(() => {
                            ratingStarsElement.innerHTML = starsHtml;
                            ratingTextElement.textContent =
                                `${averageRating.toFixed(1)} Store Rating (${data.totalReviews} reviews)`;
                            ratingStarsElement.style.opacity = '1';
                            ratingTextElement.style.opacity = '1';
                        }, 150);
                    }
                })
                .catch(error => console.error('Error fetching vendor rating:', error));
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            // Apply all styling
            applyStyles();

            // Apply animations
            applySlideInAnimation();
            applyGlowingAnimation();

            // Setup interactions
            setupThumbnailScrolling();

            // Hide initial loader
            hideImageLoader();

            // Initialize real-time rating updates
            updateVendorRating();
            setInterval(updateVendorRating, 30000); // Update every 30 seconds

            console.log('Product detail page initialized with JavaScript styling and real-time rating updates!');
        });
    </script>
@endsection
