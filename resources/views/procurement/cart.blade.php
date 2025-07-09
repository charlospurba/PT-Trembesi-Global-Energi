
@extends('layouts.app')

@section('content')
    <!-- Include SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Include Navbar Component -->
    @include('components.navbar')

    <div class="min-h-screen bg-gradient-to-br from-red-50 via-pink-50 to-rose-50 pb-20">
        <div class="container mx-auto px-4 py-8">
            {{-- Clean Breadcrumb Navigation --}}
            <div class="mb-8">
                <nav class="flex items-center space-x-3 text-sm bg-gray-100 px-4 py-3 rounded-lg border">
                    <span class="text-gray-600">♦</span>
                    <a href="{{ route('procurement.dashboardproc') }}"
                        class="text-gray-600 hover:text-red-600 transition-colors duration-200 font-medium">
                        Home
                    </a>
                    <span class="text-gray-400">></span>
                    <span class="text-red-600 font-medium">
                        Cart
                    </span>
                </nav>
                <div class="mt-6">
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-red-600 to-pink-600 bg-clip-text text-transparent">
                        🛒 Shopping Cart
                    </h1>
                    <p class="text-gray-600 mt-2 text-lg">Review your selected items before checkout</p>
                </div>
            </div>

            @php
                $groupedItems = collect($cartItems)->groupBy('supplier');
            @endphp

            @foreach ($groupedItems as $supplier => $items)
                <div
                    class="bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-300 mb-8 overflow-hidden border-2 border-red-100 hover:border-red-200">
                    {{-- Enhanced Supplier Header --}}
                    <div
                        class="bg-gradient-to-r from-red-500 via-red-600 to-pink-600 px-8 py-6 border-b border-red-200 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-red-400/20 to-pink-400/20"></div>
                        <div class="relative flex items-center">
                            <div class="mr-6">
                                <div class="relative">
                                    <input type="checkbox"
                                        class="w-6 h-6 text-red-600 rounded-xl border-3 border-white bg-white/30 backdrop-blur-sm focus:ring-3 focus:ring-white/50 select-supplier shadow-lg"
                                        data-supplier="{{ $supplier }}">
                                    <div class="absolute inset-0 rounded-xl bg-white/10 pointer-events-none"></div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="bg-white/20 backdrop-blur-sm p-3 rounded-2xl mr-4 shadow-lg">
                                    <svg class="w-6 h-6 text-white drop-shadow-sm" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1ital-2 h6m0 0v5m-4 0h4" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-white font-bold text-xl drop-shadow-sm">🏪 {{ $supplier }}</h3>
                                    <p class="text-red-100 text-sm font-medium">{{ count($items) }} item(s) available</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Enhanced Items List --}}
                    <div2019-06-17_074403_create_carts_table.php class="divide-y divide-red-100">
                        @foreach ($items as $item)
                            @php
                                // Fetch bid history for the product
                                $bids = App\Models\Bid::where('product_id', $item['id'])
                                    ->where('user_id', Auth::id())
                                    ->orderBy('created_at', 'desc')
                                    ->take(3)
                                    ->get();
                                $acceptedBid = $bids->where('status', 'Accepted')->sortByDesc('created_at')->first();
                            @endphp
                            <div class="p-8 hover:bg-gradient-to-r hover:from-red-50 hover:to-pink-50 transition-all duration-300 border-l-4 border-transparent hover:border-red-300"
                                data-item-id="{{ $item['id'] }}">
                                <div class="flex items-center space-x-6">
                                    {{-- Enhanced Checkbox --}}
                                    <div class="flex-shrink-0">
                                        <div class="relative">
                                            <input type="checkbox"
                                                class="w-6 h-6 text-red-600 rounded-lg border-2 border-red-300 focus:ring-3 focus:ring-red-500/30 item-checkbox shadow-md"
                                                data-id="{{ $item['id'] }}" data-supplier="{{ $supplier }}">
                                            <div
                                                class="absolute inset-0 rounded-lg bg-red-50 opacity-0 hover:opacity-100 transition-opacity pointer-events-none">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Enhanced Product Image --}}
                                    <div class="flex-shrink-0">
                                        <div class="relative group">
                                            <div
                                                class="absolute inset-0 bg-gradient-to-r from-red-400 to-pink-400 rounded-2xl blur opacity-20 group-hover:opacity-40 transition-opacity">
                                            </div>
                                            <img src="{{ $item['image'] ? asset('storage/' . $item['image']) : '/images/pipa-besi.png' }}"
                                                class="relative w-24 h-24 rounded-2xl border-3 border-red-200 object-cover group-hover:scale-105 transition-transform duration-300 shadow-lg">
                                            <div
                                                class="absolute inset-0 bg-gradient-to-t from-red-900/20 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Enhanced Product Details --}}
                                    <div class="flex-1 min-w-0">
                                        <div class="mb-4">
                                            <h4 class="text-xl font-bold text-gray-800 mb-3 leading-tight">
                                                {{ $item['name'] }}</h4>
                                            <div class="flex items-center space-x-4">
                                                <div class="flex items-center space-x-2">
                                                    @if ($acceptedBid)
                                                        <span class="text-2xl font-bold text-gray-500 line-through">Rp.
                                                            {{ number_format($item['price'], 0, ',', '.') }}</span>
                                                        <span
                                                            class="text-2xl font-bold bg-gradient-to-r from-red-600 to-pink-600 bg-clip-text text-transparent">Rp.
                                                            {{ number_format($acceptedBid->bid_price, 0, ',', '.') }}</span>
                                                    @else
                                                        <span
                                                            class="text-2xl font-bold bg-gradient-to-r from-red-600 to-pink-600 bg-clip-text text-transparent">Rp.
                                                            {{ number_format($item['price'], 0, ',', '.') }}</span>
                                                    @endif
                                                </div>
                                                <button
                                                    class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg hover:shadow-xl transition-shadow bid-item-btn"
                                                    data-id="{{ $item['id'] }}"
                                                    onclick="showBidModal({{ $item['id'] }})"
                                                    {{ $bids->count() >= 3 ? 'disabled' : '' }}>
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                    </svg>
                                                    BID ITEM
                                                </button>
                                            </div>
                                        </div>
                                        <div class="flex items-center text-sm text-gray-700">
                                            <span class="mr-3 font-semibold text-red-600">🏷️ Variant:</span>
                                            <select
                                                class="border-2 border-red-300 rounded-xl px-4 py-2 text-sm focus:ring-3 focus:ring-red-500/30 focus:border-red-500 bg-white shadow-md hover:shadow-lg transition-all"
                                                onchange="updateVariant({{ $item['id'] }}, this.value)">
                                                <option selected>{{ $item['variant'] }}</option>
                                                <!-- Add more variant options as needed -->
                                            </select>
                                        </div>
                                        {{-- Bid History Section --}}
                                        <div class="mt-4">
                                            <h5 class="text-sm font-semibold text-gray-700 mb-2">Bid History (Max 3):</h5>
                                            @if ($bids->isEmpty())
                                                <p class="text-sm text-gray-500">No bids placed yet.</p>
                                            @else
                                                <ul class="space-y-2">
                                                    @foreach ($bids as $bid)
                                                        <li class="text-sm text-gray-600 flex items-center space-x-2">
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $bid->status === 'Accepted' ? 'bg-green-100 text-green-800' : ($bid->status === 'Rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                                                {{ $bid->status }}
                                                            </span>
                                                            <span>Rp.
                                                                {{ number_format($bid->bid_price, 0, ',', '.') }}</span>
                                                            <span>on {{ $bid->created_at->format('d M Y H:i') }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Enhanced Quantity Controls & Actions --}}
                                    <div class="flex items-center space-x-6">
                                        {{-- Enhanced Quantity Controls --}}
                                        <div
                                            class="flex items-center bg-gradient-to-r from-red-50 to-pink-50 rounded-2xl p-2 border-2 border-red-200 shadow-md">
                                            <span class="text-sm font-bold text-red-600 px-3">QTY</span>
                                            <div class="flex items-center ml-3">
                                                <button
                                                    class="w-10 h-10 rounded-xl border-2 border-red-300 bg-white hover:bg-red-50 hover:border-red-400 hover:text-red-600 flex items-center justify-center transition-all duration-200 qty-btn shadow-md hover:shadow-lg transform hover:scale-105"
                                                    onclick="updateCartQuantity({{ $item['id'] }}, -1)">
                                                    <svg class="w-5 h-5 font-bold" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="3" d="M20 12H4" />
                                                    </svg>
                                                </button>
                                                <input type="text"
                                                    class="w-16 h-10 border-t-2 border-b-2 border-red-300 text-center text-sm font-bold bg-white focus:bg-red-50 focus:outline-none focus:border-red-500 transition-all"
                                                    value="{{ $item['quantity'] }}" id="quantity-{{ $item['id'] }}"
                                                    onchange="updateCartQuantity({{ $item['id'] }}, this.value)">
                                                <button
                                                    class="w-10 h-10 rounded-xl border-2 border-red-300 bg-white hover:bg-red-50 hover:border-red-400 hover:text-red-600 flex items-center justify-center transition-all duration-200 qty-btn shadow-md hover:shadow-lg transform hover:scale-105"
                                                    onclick="updateCartQuantity({{ $item['id'] }}, 1)">
                                                    <svg class="w-5 h-5 font-bold" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="3" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        {{-- Enhanced Delete Button --}}
                                        <button
                                            class="p-3 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-2xl transition-all duration-200 group shadow-md hover:shadow-lg transform hover:scale-105"
                                            onclick="removeFromCart({{ $item['id'] }})">
                                            <svg class="w-6 h-6 group-hover:scale-110 transition-transform duration-200"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                </div>
        </div>
        @endforeach

        {{-- Enhanced Sticky Bottom Summary --}}
        <div
            class="fixed bottom-0 left-0 right-0 bg-white/95 backdrop-blur-lg border-t-2 border-red-200 px-6 py-6 shadow-2xl z-10">
            <div class="container mx-auto">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center">
                            <div class="relative">
                                <input type="checkbox"
                                    class="w-6 h-6 text-red-600 rounded-lg border-2 border-red-300 focus:ring-3 focus:ring-red-500/30 mr-4 shadow-md"
                                    id="select-all">
                                <div
                                    class="absolute inset-0 rounded-lg bg-red-50 opacity-0 hover:opacity-100 transition-opacity pointer-events-none">
                                </div>
                            </div>
                            <span class="font-bold text-gray-800 text-lg">🛍️ Select All Items</span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-8">
                        <div class="text-right">
                            <div class="text-sm text-gray-600 font-medium" id="total-text">
                                Total (<span id="total-item-count"
                                    class="font-bold text-red-600">{{ count($cartItems) }}</span> Products)
                            </div>
                            <div class="text-3xl font-bold bg-gradient-to-r from-red-600 to-pink-600 bg-clip-text text-transparent"
                                id="total-price">
                                Rp. {{ number_format($totalPrice, 0, ',', '.') }}
                            </div>
                        </div>
                        <button
                            class="bg-gradient-to-r from-red-500 via-red-600 to-pink-600 hover:from-red-600 hover:via-red-700 hover:to-pink-700 text-white font-bold py-4 px-10 rounded-2xl transition-all duration-200 transform hover:scale-105 hover:shadow-2xl flex items-center space-x-3 shadow-xl"
                            onclick="proceedToCheckout()">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01" />
                            </svg>
                            <span class="text-lg">🚀 Proceed to Checkout</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bid Modal -->
        <div id="bidModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h2 class="text-xl font-bold mb-4">Submit Bid</h2>
                <form id="bidForm">
                    <input type="hidden" id="bidProductId">
                    <div class="mb-4">
                        <label for="bidPrice" class="block text-sm font-medium text-gray-700">Bid Price (Rp)</label>
                        <input type="number" id="bidPrice" name="bid_price"
                            class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400"
                            required min="1">
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeBidModal()"
                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Submit
                            Bid</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    <script>
        let selectedVendor = null;

        function showBidModal(productId) {
            document.getElementById('bidProductId').value = productId;
            document.getElementById('bidModal').classList.remove('hidden');
        }

        function closeBidModal() {
            document.getElementById('bidModal').classList.add('hidden');
            document.getElementById('bidForm').reset();
        }

        document.getElementById('bidForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const productId = document.getElementById('bidProductId').value;
            const bidPrice = document.getElementById('bidPrice').value;

            fetch('/cart/bid/' + productId, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        bid_price: bidPrice
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false,
                            confirmButtonColor: '#dc2626'
                        });
                        closeBidModal();
                        location.reload(); // Reload to update bid history and price
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Failed to submit bid',
                            confirmButtonColor: '#dc2626'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to submit bid: ' + error.message,
                        confirmButtonColor: '#dc2626'
                    });
                });
        });

        function updateCartQuantity(productId, value) {
            const quantityInput = document.getElementById('quantity-' + productId);
            if (!quantityInput) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Cart item not found',
                    confirmButtonColor: '#dc2626'
                });
                return;
            }

            const buttons = document.querySelectorAll(`[data-item-id="${productId}"] .qty-btn`);
            buttons.forEach(btn => btn.disabled = true);

            let quantity = typeof value === 'string' ? parseInt(value) : parseInt(quantityInput.value) + value;
            if (isNaN(quantity) || quantity <= 0) {
                quantity = 1;
                quantityInput.value = 1;
                buttons.forEach(btn => btn.disabled = false);
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Quantity',
                    text: 'Quantity must be a positive number',
                    confirmButtonColor: '#dc2626'
                });
                return;
            }

            fetch('/cart/update/' + productId, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    buttons.forEach(btn => btn.disabled = false);
                    if (data.success) {
                        quantityInput.value = quantity;
                        updateCartBadge(data.cart_count);
                        updateTotalPrice();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false,
                            confirmButtonColor: '#dc2626'
                        });

                        if (quantity <= 0) {
                            const itemElement = quantityInput.closest('[data-item-id]');
                            if (itemElement) itemElement.remove();
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Failed to update cart',
                            confirmButtonColor: '#dc2626'
                        });
                    }
                })
                .catch(error => {
                    buttons.forEach(btn => btn.disabled = false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update cart: ' + error.message,
                        confirmButtonColor: '#dc2626'
                    });
                });
        }

        function removeFromCart(productId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to remove this item from cart?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/cart/remove/' + productId, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                updateCartBadge(data.cart_count);
                                updateTotalPrice();
                                const itemElement = document.querySelector(`[data-item-id="${productId}"]`);
                                if (itemElement) itemElement.remove();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Removed',
                                    text: data.message,
                                    timer: 1500,
                                    showConfirmButton: false,
                                    confirmButtonColor: '#dc2626'
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.message || 'Failed to remove product',
                                    confirmButtonColor: '#dc2626'
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to remove product: ' + error.message,
                                confirmButtonColor: '#dc2626'
                            });
                        });
                }
            });
        }

        function updateCartBadge(count) {
            const badge = document.getElementById('cartBadge');
            if (badge) {
                badge.textContent = count;
                badge.style.display = count > 0 ? 'inline-block' : 'none';
            }
        }

        function updateTotalPrice() {
            let total = 0;
            let itemCount = 0;

            document.querySelectorAll('.item-checkbox:checked').forEach(checkbox => {
                const item = checkbox.closest('[data-item-id]');
                const quantityInput = item.querySelector('input[id^="quantity-"]');
                const quantity = parseInt(quantityInput.value) || 0;

                const priceElement = item.querySelector('.text-2xl:not(.line-through)');
                const priceText = priceElement ? priceElement.textContent.match(/Rp\.\s*([\d\.]+)/) : null;
                const price = priceText ? parseFloat(priceText[1].replace(/\./g, '')) : 0;

                total += price * quantity;
                itemCount++;
            });

            const totalPriceElement = document.getElementById('total-price');
            if (totalPriceElement) {
                totalPriceElement.textContent = 'Rp. ' + total.toLocaleString('id-ID');
            }

            const totalItemCountElement = document.getElementById('total-item-count');
            if (totalItemCountElement) {
                totalItemCountElement.textContent = itemCount;
            }
        }

        function proceedToCheckout() {
            const selectedItems = document.querySelectorAll('.item-checkbox:checked');
            if (selectedItems.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Items Selected',
                    text: 'Please select at least one item to proceed to checkout.',
                    confirmButtonColor: '#dc2626'
                });
                return;
            }

            const selectedIds = Array.from(selectedItems).map(item => item.dataset.id);
            const vendors = Array.from(selectedItems).map(item => item.dataset.supplier);
            const uniqueVendors = [...new Set(vendors)];

            if (uniqueVendors.length > 1) {
                Swal.fire({
                    icon: 'error',
                    title: 'Multiple Vendors',
                    text: 'Please select items from only one vendor for checkout.',
                    confirmButtonColor: '#dc2626'
                });
                return;
            }

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('procurement.checkout') }}';

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);

            selectedIds.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'selected_ids[]';
                input.value = id;
                form.appendChild(input);
            });

            document.body.appendChild(form);
            form.submit();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('select-all');

            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    if (this.checked && !selectedVendor) {
                        const firstSupplier = document.querySelector('.select-supplier');
                        if (firstSupplier) {
                            selectedVendor = firstSupplier.dataset.supplier;
                            firstSupplier.checked = true;
                            document.querySelectorAll(`.item-checkbox[data-supplier="${selectedVendor}"]`)
                                .forEach(cb => cb.checked = true);
                        }
                    } else if (!this.checked) {
                        selectedVendor = null;
                        document.querySelectorAll('.item-checkbox, .select-supplier').forEach(cb => cb
                            .checked = false);
                    }
                    updateTotalPrice();
                });
            }

            document.querySelectorAll('.select-supplier').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const supplier = this.dataset.supplier;
                    const isChecked = this.checked;

                    if (isChecked) {
                        if (!selectedVendor || selectedVendor === supplier) {
                            selectedVendor = supplier;
                            document.querySelectorAll(`.item-checkbox[data-supplier="${supplier}"]`)
                                .forEach(item => {
                                    item.checked = true;
                                });
                        } else {
                            this.checked = false;
                            Swal.fire({
                                icon: 'warning',
                                title: 'Single Vendor Only',
                                text: 'You can only select items from one vendor at a time.',
                                confirmButtonColor: '#dc2626'
                            });
                            return;
                        }
                    } else {
                        document.querySelectorAll(`.item-checkbox[data-supplier="${supplier}"]`)
                            .forEach(item => {
                                item.checked = false;
                            });
                        if (!document.querySelector('.select-supplier:checked')) {
                            selectedVendor = null;
                        }
                    }
                    selectAllCheckbox.checked = document.querySelectorAll('.item-checkbox')
                        .length === document.querySelectorAll('.item-checkbox:checked').length;
                    updateTotalPrice();
                });
            });

            document.querySelectorAll('.item-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    const supplier = checkbox.dataset.supplier;
                    if (checkbox.checked && selectedVendor && selectedVendor !== supplier) {
                        checkbox.checked = false;
                        Swal.fire({
                            icon: 'warning',
                            title: 'Single Vendor Only',
                            text: 'You can only select items from one vendor at a time.',
                            confirmButtonColor: '#dc2626'
                        });
                        return;
                    }
                    if (checkbox.checked && !selectedVendor) {
                        selectedVendor = supplier;
                        document.querySelector(`.select-supplier[data-supplier="${supplier}"]`)
                            .checked = true;
                    }
                    const supplierCheckbox = document.querySelector(
                        `.select-supplier[data-supplier="${supplier}"]`);
                    if (supplierCheckbox) {
                        supplierCheckbox.checked = document.querySelectorAll(
                            `.item-checkbox[data-supplier="${supplier}"]:checked`).length > 0;
                    }
                    if (!document.querySelector('.item-checkbox:checked')) {
                        selectedVendor = null;
                    }
                    selectAllCheckbox.checked = document.querySelectorAll('.item-checkbox')
                        .length === document.querySelectorAll('.item-checkbox:checked').length;
                    updateTotalPrice();
                });
            });

            updateTotalPrice();
        });
    </script>
@endsection