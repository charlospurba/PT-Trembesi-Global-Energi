@extends('layouts.app')

@section('content')
    <!-- Include SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Include Navbar Component -->
    @include('components.navbar')

    <div class="max-w-7xl mx-auto px-6 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- LEFT IMAGE -->
            <div>
                <img src="{{ !empty($product->image_paths) && is_array($product->image_paths) && count($product->image_paths) > 0 ? asset('storage/' . $product->image_paths[0] . '?' . time()) : 'https://via.placeholder.com/300' }}"
                    alt="{{ $product->name }}" class="w-full h-64 object-cover rounded-lg shadow-sm mb-4" />
            </div>

            <!-- CENTER PRODUCT DETAIL -->
            <div>
                <nav class="text-sm text-gray-500 mb-3 space-x-1">
                    <a href="{{ route('procurement.dashboardproc') }}" class="hover:underline">Home</a> >
                    <a href="/category/{{ strtolower($product->category) }}" class="hover:underline">{{ $product->category }}</a> >
                    <span class="text-red-600 font-semibold">{{ $product->name }}</span>
                </nav>

                <h1 class="text-3xl font-bold text-gray-800 leading-tight">{{ $product->name }}</h1>
                <p class="text-red-600 text-2xl font-bold mt-2">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                <p class="text-sm text-gray-600 mt-1">15 Sold</p>

                <div class="mt-6 border-t border-b py-4">
                    <h2 class="text-lg font-semibold text-red-600 mb-3">Product Information</h2>
                    <div class="grid grid-cols-2 gap-y-2 text-sm text-gray-700">
                        <p><span class="font-semibold">Category:</span> {{ $product->category }}</p>
                        <p><span class="font-semibold">Minimum Order:</span> {{ $product->min_order ?? '1' }} pcs</p>
                        <p><span class="font-semibold">Unit Weight:</span> {{ $product->weight ?? '-' }} kg</p>
                        <p><span class="font-semibold">Dimensions:</span> {{ $product->dimension ?? '-' }}</p>
                        <p><span class="font-semibold">Brand:</span> {{ $product->brand ?? '-' }}</p>
                    </div>
                </div>

                <div class="mt-4">
                    <h2 class="text-lg font-semibold text-red-600 mb-1">Shipping</h2>
                    <p class="text-sm text-gray-600 flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-red-500"></i>
                        Shipped from <span class="font-semibold">{{ $product->address ?? 'Location not available' }}</span>
                    </p>
                </div>
            </div>

            <!-- RIGHT PURCHASE BOX -->
            <div>
                <div class="border border-red-300 rounded-lg p-5 bg-red-50 shadow-md">
                    <h3 class="font-semibold text-gray-800 mb-4">Purchase Settings</h3>
                    <form id="add-to-cart-form">
                        @csrf
                        <label class="text-sm text-gray-700">Quantity</label>
                        <div class="flex items-center mt-2 gap-2">
                            <button type="button" onclick="updateQuantity(-1)"
                                class="px-3 py-1 bg-red-200 text-red-700 font-bold rounded hover:bg-red-300 transition">-</button>
                            <input type="number" id="quantity" name="quantity" value="1"
                                min="{{ $product->min_order ?? 1 }}" max="{{ $product->quantity ?? 9999 }}"
                                class="w-16 text-center border border-gray-300 rounded focus:ring-red-500 focus:border-red-500"
                                oninput="validateQuantity(this)" />
                            <button type="button" onclick="updateQuantity(1)"
                                class="px-3 py-1 bg-red-200 text-red-700 font-bold rounded hover:bg-red-300 transition">+</button>
                        </div>
                        <p class="text-xs mt-1 text-gray-500">Available: {{ $product->quantity ?? 'Unlimited' }}</p>

                        <div class="mt-3 text-sm text-gray-700">
                            <p>Total Price:</p>
                            <p class="text-lg font-bold text-gray-900" id="total-price">
                                Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>

                        <div class="mt-4 flex flex-col gap-2">
                            <button type="button" onclick="addToCart({{ $product->id }})"
                                class="bg-red-600 text-white w-full py-2 rounded-md hover:bg-red-700 font-semibold transition">
                                Add to Cart
                            </button>
                            <button type="button" onclick="buyNow({{ $product->id }})"
                                class="border border-red-600 text-red-600 w-full py-2 rounded-md hover:bg-red-100 font-semibold transition">
                                Buy Now
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- VENDOR INFO -->
        <div class="mt-12 pt-6 border-t">
            <a href="{{ route('store.show', ['store' => urlencode($product->supplier ?? 'Store Name')]) }}" 
                class="text-sm font-semibold text-blue-600 hover:underline transition-colors duration-200">
                Store {{ $product->supplier ?? 'Store Name' }}
            </a>
            <div class="mt-1 flex items-center gap-1 text-sm text-gray-600">
                <span class="text-yellow-500">★</span>
                <span>5 Ratings</span>
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
            } else if (newQuantity > availableQuantity) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Out of Stock',
                    text: 'Requested quantity exceeds available quantity (' + availableQuantity + ').'
                });
            }
        }

        function updateTotalPrice() {
            let quantity = parseInt(document.getElementById('quantity').value);
            let price = {{ $product->price }};
            let total = quantity * price;
            document.getElementById('total-price').textContent =
                'Rp' + total.toLocaleString('id-ID', {
                    minimumFractionDigits: 0
                });
        }

        function addToCart(productId) {
            let quantity = document.getElementById('quantity').value;
            console.log('Add to Cart - Quantity:', quantity, 'Product ID:', productId);

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
                            title: 'Success',
                            text: data.message,
                            timer: 1500
                        });
                        updateCartBadge(data.cart_count);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Failed to add product to cart'
                        });
                    }
                })
                .catch(error => {
                    console.error('Fetch Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to add product to cart: ' + error.message
                    });
                });
        }

        function buyNow(productId) {
            let quantity = document.getElementById('quantity').value;
            console.log('Buy Now - Quantity:', quantity, 'Product ID:', productId);

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
                        title: 'Error',
                        text: 'Failed to process Buy Now: ' + error.message
                    });
                });
        }

        function updateCartBadge(count) {
            let badge = document.getElementById('cartBadge');
            if (badge) {
                badge.textContent = count;
                badge.style.display = count > 0 ? 'inline-block' : 'none';
            }
        }
    </script>
@endsection
