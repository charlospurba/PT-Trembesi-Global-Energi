@extends('layouts.app')

@section('content')
    <!-- Include SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Include Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Include Navbar Component -->
    @include('components.navbar')

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
        }
        
        @keyframes glow {
            0%, 100% { box-shadow: 0 0 15px rgba(220, 38, 38, 0.2); }
            50% { box-shadow: 0 0 25px rgba(220, 38, 38, 0.4); }
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-5px); }
            60% { transform: translateY(-3px); }
        }
        
        .floating-card {
            animation: float 3s ease-in-out infinite;
        }
        
        .glowing-button {
            animation: glow 2s ease-in-out infinite;
        }
        
        .slide-in {
            animation: slideIn 0.8s ease-out;
        }
        
        .bounce-icon {
            animation: bounce 2s infinite;
        }
        
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .red-gradient {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
        }
        
        .red-gradient-soft {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        }

        /* Single screen optimizations with fixed bottom spacing */
        .single-screen-container {
            min-height: calc(100vh - 4rem);
            padding-bottom: 2rem; /* Added bottom padding */
        }

        .compact-card {
            padding: 1rem !important;
        }

        .compact-spacing {
            margin-bottom: 1rem !important;
        }

        .compact-text {
            font-size: 0.875rem;
        }

        .compact-button {
            padding: 0.75rem 1rem !important;
            font-size: 0.875rem !important;
        }

        /* Ensure grid columns have proper height */
        .grid-equal-height {
            display: grid;
            grid-template-rows: 1fr;
        }

        /* Responsive height adjustments */
        @media (min-width: 1024px) {
            .lg-fixed-height {
                height: calc(100vh - 8rem);
                max-height: 600px;
            }
        }

        @media (max-width: 1023px) {
            .single-screen-container {
                min-height: auto;
                padding-bottom: 1rem;
            }
        }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-red-50 to-rose-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 single-screen-container">
            <!-- Compact Breadcrumb -->
            <nav class="flex items-center space-x-2 text-xs mb-4 glass-effect px-4 py-2 rounded-xl shadow-lg">
                <a href="{{ route('procurement.dashboardproc') }}" class="flex items-center text-gray-600 hover:text-red-600 transition-all duration-300">
                    <i class="fas fa-home mr-1"></i>Home
                </a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <a href="/category/{{ strtolower($product->category) }}" class="text-gray-600 hover:text-red-600 transition-all duration-300">
                    {{ $product->category }}
                </a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span class="text-red-600 font-semibold">{{ $product->name }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 grid-equal-height">
                <!-- Compact Image Section -->
                <div class="lg:col-span-4 slide-in">
                    <div class="relative floating-card lg-fixed-height">
                        <div class="glass-effect rounded-2xl shadow-xl overflow-hidden h-full">
                            <div class="relative group h-full">
                                <img src="{{ !empty($product->image_paths) && is_array($product->image_paths) && count($product->image_paths) > 0 ? asset('storage/' . $product->image_paths[0] . '?' . time()) : 'https://via.placeholder.com/400x300/dc2626/ffffff?text=Premium+Product' }}"
                                    alt="{{ $product->name }}" 
                                    class="w-full h-full object-cover transition-all duration-500 group-hover:scale-105" />
                                
                                <!-- Subtle overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300"></div>
                                
                                <!-- Compact badges -->
                                <div class="absolute top-3 left-3">
                                    <div class="bg-red-600 text-white px-3 py-1 rounded-full text-xs font-medium shadow-lg">
                                        <i class="fas fa-fire mr-1"></i>Popular
                                    </div>
                                </div>
                                
                                <!-- Zoom indicator -->
                                <div class="absolute top-3 right-3 bg-white/80 backdrop-blur-sm rounded-full p-2 opacity-0 group-hover:opacity-100 transition-all duration-300">
                                    <i class="fas fa-expand text-gray-700 text-sm"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Compact Product Details -->
                <div class="lg:col-span-5 slide-in" style="animation-delay: 0.2s;">
                    <div class="glass-effect rounded-2xl shadow-xl compact-card lg-fixed-height">
                        <div class="h-full overflow-y-auto scrollbar-thin scrollbar-thumb-red-300 scrollbar-track-gray-100">
                            <h1 class="text-2xl font-bold text-gray-900 leading-tight compact-spacing">
                                {{ $product->name }}
                            </h1>
                            
                            <!-- Compact Price Display -->
                            <div class="compact-spacing p-4 red-gradient-soft rounded-xl border border-red-100">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-2xl font-bold text-red-600">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                                    <div class="bg-red-600 text-white px-2 py-1 rounded-full text-xs font-medium">
                                        Best Price
                                    </div>
                                </div>
                                
                                <!-- Compact Rating -->
                                <div class="flex items-center gap-2">
                                    <div class="flex items-center bg-white px-3 py-1 rounded-full shadow-sm">
                                        <div class="flex text-yellow-400 mr-1 text-sm">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <span class="font-medium text-gray-700 text-sm">5.0</span>
                                    </div>
                                    <div class="bg-white text-gray-700 px-3 py-1 rounded-full text-xs font-medium shadow-sm">
                                        <i class="fas fa-shopping-bag mr-1 text-red-500"></i>15+ Sold
                                    </div>
                                </div>
                            </div>

                            <!-- Compact Product Info -->
                            <div class="compact-spacing">
                                <h2 class="text-lg font-semibold text-gray-900 mb-3">Product Information</h2>
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="flex flex-col p-3 bg-white rounded-lg shadow-sm border border-gray-100">
                                        <span class="text-gray-600 font-medium text-xs">Category</span>
                                        <span class="font-semibold text-gray-900 text-sm">{{ $product->category }}</span>
                                    </div>
                                    <div class="flex flex-col p-3 bg-white rounded-lg shadow-sm border border-gray-100">
                                        <span class="text-gray-600 font-medium text-xs">Min Order</span>
                                        <span class="font-semibold text-gray-900 text-sm">{{ $product->min_order ?? '1' }} pcs</span>
                                    </div>
                                    <div class="flex flex-col p-3 bg-white rounded-lg shadow-sm border border-gray-100">
                                        <span class="text-gray-600 font-medium text-xs">Weight</span>
                                        <span class="font-semibold text-gray-900 text-sm">{{ $product->weight ?? '-' }} kg</span>
                                    </div>
                                    <div class="flex flex-col p-3 bg-white rounded-lg shadow-sm border border-gray-100">
                                        <span class="text-gray-600 font-medium text-xs">Brand</span>
                                        <span class="font-semibold text-gray-900 text-sm">{{ $product->brand ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Compact Shipping -->
                            <div class="compact-spacing bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="bg-red-100 rounded-full p-2">
                                        <i class="fas fa-truck text-red-600"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900 text-sm">Free Shipping</div>
                                        <div class="text-xs text-gray-600">From: {{ $product->address ?? 'Store Location' }}</div>
                                    </div>
                                </div>
                                <div class="flex gap-2 text-xs">
                                    <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full font-medium">
                                        <i class="fas fa-clock mr-1"></i>1-2 Days
                                    </span>
                                    <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full font-medium">
                                        <i class="fas fa-shield-alt mr-1"></i>Insured
                                    </span>
                                </div>
                            </div>

                            <!-- Compact Vendor Section -->
                            <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 red-gradient rounded-lg flex items-center justify-center shadow-lg">
                                        <i class="fas fa-store text-white text-sm"></i>
                                    </div>
                                    <div>
                                        <a href="{{ route('store.show', ['store' => urlencode($product->supplier ?? 'Premium Store')]) }}" 
                                            class="text-lg font-semibold text-gray-900 hover:text-red-600 transition-all duration-300">
                                            {{ $product->supplier ?? 'Premium Store' }}
                                        </a>
                                        <div class="flex items-center mt-1">
                                            <div class="flex items-center bg-yellow-50 px-2 py-1 rounded-full border border-yellow-200">
                                                <div class="flex text-yellow-500 mr-1 text-xs">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                                <span class="font-medium text-gray-700 text-xs">5.0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Compact Purchase Box -->
                <div class="lg:col-span-3 slide-in" style="animation-delay: 0.4s;">
                    <div class="glass-effect rounded-2xl shadow-xl overflow-hidden lg-fixed-height">
                        <!-- Compact Header -->
                        <div class="red-gradient text-white p-4">
                            <h3 class="font-semibold text-lg flex items-center">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Make Purchase
                            </h3>
                            <p class="text-white/90 text-xs mt-1">Fast & Secure Checkout</p>
                        </div>

                        <div class="compact-card h-full overflow-y-auto scrollbar-thin scrollbar-thumb-red-300 scrollbar-track-gray-100">
                            <form id="add-to-cart-form">
                                @csrf
                                
                                <!-- Compact Quantity Selector -->
                                <div class="compact-spacing">
                                    <label class="block text-sm font-medium text-gray-700 mb-3">Quantity</label>
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" onclick="updateQuantity(-1)"
                                            class="w-8 h-8 bg-gray-200 hover:bg-red-500 hover:text-white text-gray-700 font-medium rounded-lg transition-all duration-300">
                                            <i class="fas fa-minus text-xs"></i>
                                        </button>
                                        <input type="number" id="quantity" name="quantity" value="1"
                                            min="{{ $product->min_order ?? 1 }}" max="{{ $product->quantity ?? 9999 }}"
                                            class="w-16 h-8 text-center border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 font-medium text-sm"
                                            oninput="validateQuantity(this)" />
                                        <button type="button" onclick="updateQuantity(1)"
                                            class="w-8 h-8 bg-gray-200 hover:bg-red-500 hover:text-white text-gray-700 font-medium rounded-lg transition-all duration-300">
                                            <i class="fas fa-plus text-xs"></i>
                                        </button>
                                    </div>
                                    <p class="text-center mt-2 text-xs text-gray-600">
                                        <i class="fas fa-box mr-1 text-red-500"></i>
                                        <span class="font-medium">{{ $product->quantity ?? 'Many' }}</span> Available
                                    </p>
                                </div>

                                <!-- Compact Total Price -->
                                <div class="compact-spacing bg-gray-50 rounded-xl p-3 border border-gray-200">
                                    <div class="text-center">
                                        <div class="text-xs text-gray-600 mb-1">Total Price</div>
                                        <div class="text-xl font-bold text-red-600" id="total-price">
                                            Rp{{ number_format($product->price, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Compact Action Buttons -->
                                <div class="space-y-2 compact-spacing">
                                    <button type="button" onclick="buyNow({{ $product->id }})"
                                        class="w-full red-gradient text-white compact-button rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg glowing-button">
                                        <i class="fas fa-bolt mr-2"></i>Buy Now
                                    </button>
                                    <button type="button" onclick="addToCart({{ $product->id }})"
                                        class="w-full border-2 border-red-500 text-red-600 compact-button rounded-xl font-semibold hover:bg-red-500 hover:text-white transition-all duration-300 transform hover:scale-105">
                                        <i class="fas fa-cart-plus mr-2"></i>Add to Cart
                                    </button>
                                </div>

                                <!-- Compact Trust Indicator -->
                                <div class="pt-3 border-t border-gray-200">
                                    <div class="text-center">
                                        <div class="inline-flex items-center gap-2 bg-green-50 px-3 py-2 rounded-full border border-green-200">
                                            <i class="fas fa-shield-check text-green-600 text-sm"></i>
                                            <span class="text-xs font-medium text-gray-700">Secure Payment</span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
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
                quantityInput.style.transform = 'scale(1.05)';
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
            priceElement.style.transform = 'scale(1.05)';
            priceElement.textContent = 'Rp' + total.toLocaleString('id-ID', {
                minimumFractionDigits: 0
            });
            
            setTimeout(() => {
                priceElement.style.transform = 'scale(1)';
            }, 200);
        }

        function addToCart(productId) {
            let quantity = document.getElementById('quantity').value;
            console.log('Add to Cart - Quantity:', quantity, 'Product ID:', productId);

            Swal.fire({
                title: 'Adding to Cart...',
                html: '<div class="animate-spin rounded-full h-12 w-12 border-b-2 border-red-600 mx-auto"></div>',
                allowOutsideClick: false,
                showConfirmButton: false
            });

            fetch('/cart/add/' + productId, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('#add-to-cart-form input[name="_token"]').value
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
                            timer: 2000,
                            confirmButtonColor: '#dc2626'
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
                    console.error('Fetch Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Connection Error',
                        text: 'Failed to add product to cart: ' + error.message,
                        confirmButtonColor: '#dc2626'
                    });
                });
        }

        function buyNow(productId) {
            let quantity = document.getElementById('quantity').value;
            console.log('Buy Now - Quantity:', quantity, 'Product ID:', productId);

            Swal.fire({
                title: 'Processing Order...',
                html: '<div class="animate-pulse text-center"><i class="fas fa-shopping-bag text-4xl text-red-600 mb-4"></i><br>Preparing your order...</div>',
                allowOutsideClick: false,
                showConfirmButton: false
            });

            fetch('/cart/buy-now/' + productId, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('#add-to-cart-form input[name="_token"]').value
                    },
                    body: JSON.stringify({
                        quantity: quantity
                    })
                })
                .then(response => {
                    console.log('Buy Now Response Status:', response.status);
                    if (response.redirected) {
                        window.location.href = response.url;
                        return;
                    }
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw new Error(data.message || 'Network response was not ok: ' + response.status);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data && data.success) {
                        updateCartBadge(data.cart_count);
                    }
                })
                .catch(error => {
                    console.error('Buy Now Fetch Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Process Failed',
                        text: 'Failed to process order: ' + error.message,
                        confirmButtonColor: '#dc2626'
                    });
                });
        }

        function updateCartBadge(count) {
            let badge = document.getElementById('cartBadge');
            if (badge) {
                badge.textContent = count;
                badge.style.display = count > 0 ? 'inline-block' : 'none';
                
                // Add subtle animation
                badge.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    badge.style.transform = 'scale(1)';
                }, 200);
            }
        }
    </script>
@endsection