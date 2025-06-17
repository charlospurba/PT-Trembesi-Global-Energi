@extends('layouts.app')

@section('content')
    <!-- Include SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Include Navbar Component -->
    @include('components.navbar')

    <div class="min-h-screen bg-gray-100 pb-20">
        <div class="container mx-auto px-4 py-6">
            {{-- Breadcrumb Navigation --}}
            <h5 class="text-lg font-bold mb-6">
                <a href="{{ route('procurement.dashboardproc') }}" class="text-black hover:underline">Dashboard</a>
                <span class="text-red-500"> > Cart</span>
            </h5>

            @php
                $groupedItems = collect($cartItems)->groupBy('supplier');
            @endphp

            @foreach ($groupedItems as $supplier => $items)
                <div class="bg-white rounded-lg shadow-sm mb-4 overflow-hidden">
                    <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex items-center">
                        <input type="checkbox" class="mr-3 w-4 h-4 text-blue-600 rounded select-supplier"
                            data-supplier="{{ $supplier }}">
                        <img src="/images/store-icon.png" width="20" class="mr-2">
                        <strong class="text-gray-800">{{ $supplier }}</strong>
                    </div>

                    @foreach ($items as $item)
                        <div class="p-4 border-b border-gray-100 flex items-center justify-between"
                            data-item-id="{{ $item['id'] }}">
                            <div class="flex items-center flex-1">
                                <input type="checkbox" class="mr-4 w-4 h-4 text-blue-600 rounded item-checkbox"
                                    data-id="{{ $item['id'] }}" data-supplier="{{ $supplier }}">
                                <img src="{{ $item['image'] ? asset('storage/' . $item['image']) : '/images/pipa-besi.png' }}"
                                    width="60" height="60" class="mr-4 rounded-md border border-gray-200 object-cover">
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-800 mb-1">{{ $item['name'] }}</div>
                                    <div class="text-gray-600 mb-2">
                                        Rp. {{ number_format($item['price'], 0, ',', '.') }}
                                        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded ml-2">bid</span>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        Varian:
                                        <select class="ml-1 text-xs border border-gray-300 rounded px-2 py-1"
                                            onchange="updateVariant({{ $item['id'] }}, this.value)">
                                            <option selected>{{ $item['variant'] }}</option>
                                            <!-- Add more variant options as needed -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="flex items-center mr-4">
                                    <span class="text-sm text-gray-600 mr-2">QTY</span>
                                    <button
                                        class="w-8 h-8 border border-gray-300 rounded-l-md flex items-center justify-center hover:bg-gray-50 qty-btn"
                                        onclick="updateCartQuantity({{ $item['id'] }}, -1)">−</button>
                                    <input type="text" class="w-12 h-8 border-t border-b border-gray-300 text-center text-sm"
                                        value="{{ $item['quantity'] }}" id="quantity-{{ $item['id'] }}"
                                        onchange="updateCartQuantity({{ $item['id'] }}, this.value)">
                                    <button
                                        class="w-8 h-8 border border-gray-300 rounded-r-md flex items-center justify-center hover:bg-gray-50 qty-btn"
                                        onclick="updateCartQuantity({{ $item['id'] }}, 1)">+</button>
                                </div>
                                <button class="text-red-500 hover:text-red-700 text-lg" onclick="removeFromCart({{ $item['id'] }})">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach

            {{-- Sticky Bottom Summary --}}
            <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 py-3 shadow-lg z-10">
                <div class="container mx-auto flex justify-between items-center">
                    <div class="flex items-center">
                        <input type="checkbox" class="mr-3 w-5 h-5 text-blue-600 rounded" id="select-all">
                        <strong class="text-gray-800">Select All</strong>
                    </div>
                    <div class="flex items-center">
                        <strong class="text-gray-800 mr-4" id="total-text">
                            Total (<span id="total-item-count">{{ count($cartItems) }}</span> Products):
                            <span class="text-red-500" id="total-price">
                                Rp. {{ number_format($totalPrice, 0, ',', '.') }}
                            </span>
                        </strong>
                        <a href="{{ route('procurement.checkout') }}">
                            <button
                                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                                Check Out
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function updateCartQuantity(productId, value) {
        const quantityInput = document.getElementById('quantity-' + productId);
        if (!quantityInput) {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Cart item not found' });
            return;
        }

        const buttons = document.querySelectorAll(`[data-item-id="${productId}"] .qty-btn`);
        buttons.forEach(btn => btn.disabled = true);

        let quantity = typeof value === 'string' ? parseInt(value) : parseInt(quantityInput.value) + value;
        if (isNaN(quantity) || quantity <= 0) {
            quantity = 1;
            quantityInput.value = 1;
            buttons.forEach(btn => btn.disabled = false);
            Swal.fire({ icon: 'warning', title: 'Invalid Quantity', text: 'Quantity must be a positive number' });
            return;
        }

        fetch('/cart/update/' + productId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            buttons.forEach(btn => btn.disabled = false);
            if (data.success) {
                quantityInput.value = quantity;
                updateCartBadge(data.cart_count);
                updateTotalPrice();
                Swal.fire({ icon: 'success', title: 'Success', text: data.message, timer: 1500, showConfirmButton: false });

                if (quantity <= 0) {
                    const itemElement = quantityInput.closest('[data-item-id]');
                    if (itemElement) itemElement.remove();
                }
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'Failed to update cart' });
            }
        })
        .catch(error => {
            buttons.forEach(btn => btn.disabled = false);
            Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to update cart: ' + error.message });
        });
    }

    function removeFromCart(productId) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to remove this item from cart?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
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
                        Swal.fire({ icon: 'success', title: 'Removed', text: data.message, timer: 1500, showConfirmButton: false });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'Failed to remove product' });
                    }
                })
                .catch(error => {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to remove product: ' + error.message });
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

            const priceElement = item.querySelector('.text-gray-600');
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

    document.addEventListener('DOMContentLoaded', function () {
        const selectAllCheckbox = document.getElementById('select-all');

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function () {
                const checked = this.checked;
                document.querySelectorAll('.item-checkbox, .select-supplier').forEach(cb => cb.checked = checked);
                updateTotalPrice();
            });
        }

        document.querySelectorAll('.select-supplier').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const supplier = this.dataset.supplier;
                const isChecked = this.checked;
                document.querySelectorAll(`.item-checkbox[data-supplier="${supplier}"]`).forEach(item => {
                    item.checked = isChecked;
                });
                updateTotalPrice();
            });
        });

        document.querySelectorAll('.item-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                updateTotalPrice();
                if (selectAllCheckbox) {
                    const all = document.querySelectorAll('.item-checkbox').length;
                    const checked = document.querySelectorAll('.item-checkbox:checked').length;
                    selectAllCheckbox.checked = (all === checked);
                }
            });
        });

        // Hitung total awal saat halaman dimuat
        updateTotalPrice();
    });
</script>


@endsection