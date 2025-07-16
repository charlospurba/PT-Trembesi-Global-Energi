@extends('layouts.app')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    @include('components.navbar')

    <div class="min-h-screen bg-white pb-24">
        <div class="container mx-auto max-w-5xl px-4 py-6">
            <div class="mb-6">
                <nav class="flex items-center space-x-2 text-xs mb-4 glass-effect px-4 py-2 rounded-xl shadow-lg">
                    <a href="{{ route('procurement.dashboardproc') }}"
                        class="flex items-center text-red-600 hover:text-red-700 transition">
                        <i class="fas fa-home mr-1"></i>Dashboard
                    </a>
                    <i class="fas fa-chevron-right text-red-400 text-xs"></i>
                    <span class="text-red-700 font-semibold">Cart</span>
                </nav>
                <div class="mt-4">
                    <h1 class="text-3xl font-extrabold text-red-600">🛒 Your Shopping Cart</h1>
                    <p class="text-red-400">Manage your selected products before proceeding</p>
                </div>
            </div>

            @php $groupedItems = collect($cartItems)->groupBy('supplier'); @endphp

            @if ($groupedItems->isEmpty())
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded-lg" role="alert">
                    <p class="font-bold">Your cart is empty</p>
                    <p>Looks like you haven’t added any items yet. Start shopping to fill your cart.</p>
                </div>
            @else
                @foreach ($groupedItems as $supplier => $items)
                    <div class="bg-white shadow-md rounded-xl border border-red-200 mb-6">
                        <div class="bg-red-600 text-white px-4 py-3 rounded-t-xl flex items-center">
                            <input type="checkbox" class="mr-3 select-supplier" data-supplier="{{ $supplier }}">
                            <h2 class="font-semibold text-lg">{{ $supplier }}</h2>
                            <span class="ml-auto text-sm">{{ count($items) }} item(s)</span>
                        </div>
                        <div class="divide-y">
                            @foreach ($items as $item)
                                @php
                                    $bids = App\Models\Bid::where('product_id', $item['id'])
                                        ->where('user_id', Auth::id())
                                        ->latest()
                                        ->take(3)
                                        ->get();
                                    $acceptedBid = $bids->where('status', 'Accepted')->first();
                                    $purchaseRequests = App\Models\PurchaseRequest::where('product_id', $item['id'])
                                        ->where('user_id', Auth::id())
                                        ->latest()
                                        ->get();
                                @endphp
                                <div class="p-4" data-item-id="{{ $item['id'] }}">
                                    <div class="flex items-center space-x-4">
                                        <input type="checkbox" class="item-checkbox" data-id="{{ $item['id'] }}"
                                            data-supplier="{{ $item['supplier'] }}" data-status="{{ $item['status'] }}">
                                        <img src="{{ $item['image'] ? asset('storage/' . $item['image']) : '/images/pipa-besi.png' }}"
                                            class="w-16 h-16 rounded object-cover border border-red-200">
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-red-700">{{ $item['name'] }}</h3>
                                            <div class="flex space-x-2 items-center mt-1">
                                                @if ($acceptedBid)
                                                    <span class="line-through text-gray-400 text-sm">Rp
                                                        {{ number_format($item['price'], 0, ',', '.') }}</span>
                                                    <span class="font-bold text-red-600 price-value"
                                                        data-price="{{ $acceptedBid->bid_price }}">Rp
                                                        {{ number_format($acceptedBid->bid_price, 0, ',', '.') }}</span>
                                                @else
                                                    <span class="font-bold text-red-600 price-value"
                                                        data-price="{{ $item['price'] }}">Rp
                                                        {{ number_format($item['price'], 0, ',', '.') }}</span>
                                                @endif
                                            </div>
                                            <div class="flex gap-2 mt-2">
                                                @foreach ($bids as $bid)
                                                    <span
                                                        class="px-2 py-0.5 rounded-full text-xs {{ $bid->status === 'Accepted' ? 'bg-green-100 text-green-700' : ($bid->status === 'Rejected' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700') }}">
                                                        Bid: {{ $bid->status }}
                                                    </span>
                                                @endforeach
                                            </div>
                                            <p class="text-gray-500 text-sm mt-1">Cart Status: {{ $item['status'] }}</p>
                                            <p class="text-gray-500 text-sm mt-1">Purchase Request:
                                                {{ $purchaseRequests->isNotEmpty() ? $purchaseRequests->first()->status : 'None' }}
                                            </p>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <button type="button" onclick="updateQuantity({{ $item['id'] }}, -1)"
                                                class="bg-red-100 px-2 py-1 rounded hover:bg-red-200 text-red-600 transition-all duration-200">-</button>
                                            <input type="text" id="qty-{{ $item['id'] }}"
                                                class="w-12 text-center border rounded focus:outline-none focus:ring-2 focus:ring-red-400"
                                                value="{{ $item['quantity'] }}"
                                                onchange="updateQuantity({{ $item['id'] }}, this.value)">
                                            <button type="button" onclick="updateQuantity({{ $item['id'] }}, 1)"
                                                class="bg-red-100 px-2 py-1 rounded hover:bg-red-200 text-red-600 transition-all duration-200">+</button>
                                        </div>
                                        <button onclick="removeItem({{ $item['id'] }})"
                                            class="text-red-500 hover:text-red-700 ml-4 transition-all duration-200">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <button onclick="showBidModal({{ $item['id'] }})"
                                            class="ml-3 px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700 transition-all duration-200"
                                            {{ $bids->count() >= 3 ? 'disabled' : '' }}>BID</button>
                                    </div>
                                    <!-- History Table -->
                                    <div class="mt-4">
                                        <h4 class="text-sm font-semibold text-red-600 mb-2">History</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <!-- Bid History -->
                                            <div>
                                                <h5 class="text-sm font-semibold text-red-600 mb-1">Bid History</h5>
                                                @if ($bids->isEmpty())
                                                    <p class="text-gray-500 text-sm">No bids submitted for this item.</p>
                                                @else
                                                    <div class="border border-gray-200 rounded-lg">
                                                        <table class="w-full text-sm text-gray-600">
                                                            <thead>
                                                                <tr class="bg-gray-50">
                                                                    <th class="p-2 text-left">Price</th>
                                                                    <th class="p-2 text-left">Status</th>
                                                                    <th class="p-2 text-left">Submitted</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($bids as $bid)
                                                                    <tr class="border-t">
                                                                        <td class="p-2">Rp
                                                                            {{ number_format($bid->bid_price, 0, ',', '.') }}
                                                                        </td>
                                                                        <td class="p-2">{{ $bid->status }}</td>
                                                                        <td class="p-2">
                                                                            {{ $bid->created_at->format('d M Y H:i') }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endif
                                            </div>
                                            <!-- Purchase Request History -->
                                            <div>
                                                <h5 class="text-sm font-semibold text-red-600 mb-1">Purchase Request History
                                                </h5>
                                                @if ($purchaseRequests->isEmpty())
                                                    <p class="text-gray-500 text-sm">No purchase requests submitted for this
                                                        item.</p>
                                                @else
                                                    <div class="border border-gray-200 rounded-lg">
                                                        <table class="w-full text-sm text-gray-600">
                                                            <thead>
                                                                <tr class="bg-gray-50">
                                                                    <th class="p-2 text-left">Quantity</th>
                                                                    <th class="p-2 text-left">Price</th>
                                                                    <th class="p-2 text-left">Status</th>
                                                                    <th class="p-2 text-left">Submitted</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($purchaseRequests as $request)
                                                                    <tr class="border-t">
                                                                        <td class="p-2">{{ $request->quantity }}</td>
                                                                        <td class="p-2">Rp
                                                                            {{ number_format($request->price, 0, ',', '.') }}
                                                                        </td>
                                                                        <td class="p-2">{{ $request->status }}</td>
                                                                        <td class="p-2">
                                                                            {{ $request->submitted_at->format('d M Y H:i') }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif

            @if (!$groupedItems->isEmpty())
                <div
                    class="fixed bottom-0 left-0 right-0 bg-white border-t border-red-200 shadow-lg px-6 py-4 flex justify-between items-center">
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" id="select-all" class="mr-2">
                            <span class="text-red-700 font-medium">Select All</span>
                        </label>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div>
                            <div class="text-sm text-red-500">Total (<span id="item-count">0</span> items)</div>
                            <div class="text-2xl font-bold text-red-600" id="total-price">Rp
                                {{ number_format($totalPrice, 0, ',', '.') }}</div>
                        </div>
                        <button
                            class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-2 px-5 rounded-xl transition-all duration-200 transform hover:scale-105 hover:shadow-2xl flex items-center space-x-2 shadow-xl request-purchase-btn"
                            onclick="requestPurchase()">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.5 3.5 0 105.33 4.606 3.5 3.5 0 015.33 4.606M12 2v1m0 18v1m10-10h-1M3 12H2m17.413 5.413l-.707-.707M5.294 6.706l-.707-.707M18.706 5.294l.707.707M6.706 17.294l.707.707" />
                            </svg>
                            <span class="text-sm">📩 Request Purchase</span>
                        </button>
                        <button onclick="checkout()"
                            class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-bold py-2 px-5 rounded-xl transition-all duration-200 transform hover:scale-105 hover:shadow-2xl flex items-center space-x-2 shadow-xl"
                            id="checkout-btn" disabled>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.5 3.5 0 105.33 4.606 3.5 3.5 0 015.33 4.606M12 2v1m0 18v1m10-10h-1M3 12H2m17.413 5.413l-.707-.707M5.294 6.706l-.707-.707M18.706 5.294l.707.707M6.706 17.294l.707.707" />
                            </svg>
                            <span class="text-sm">🛒 Checkout</span>
                        </button>
                    </div>
                </div>
            @endif

            <div id="bidModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm">
                    <h3 class="text-lg font-bold mb-3">Submit Bid</h3>
                    <form id="bidForm">
                        <input type="hidden" id="bidProductId">
                        <div class="mb-3">
                            <label class="block mb-1 text-sm font-medium">Bid Price (Rp)</label>
                            <input type="number" id="bidPrice"
                                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400"
                                required min="1">
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="closeBidModal()"
                                class="bg-gray-300 px-3 py-1 rounded hover:bg-gray-400 transition-all duration-200">Cancel</button>
                            <button type="submit"
                                class="bg-red-600 text-white px-4 py-1 rounded hover:bg-red-700 transition-all duration-200">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function updateQuantity(id, value) {
            const input = document.getElementById(`qty-${id}`);
            let qty = typeof value === 'string' ? parseInt(value) : parseInt(input.value) + value;
            if (isNaN(qty) || qty < 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Quantity',
                    text: 'Quantity must be at least 1',
                    confirmButtonColor: '#dc2626'
                });
                qty = 1;
                input.value = qty;
                return;
            }

            const buttons = input.closest('.flex').querySelectorAll('button');
            buttons.forEach(btn => btn.classList.add('opacity-50', 'cursor-not-allowed'));
            input.classList.add('opacity-50');

            try {
                const response = await fetch(`/cart/update/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        quantity: qty
                    })
                });
                const data = await response.json();
                if (data.success) {
                    input.value = qty;
                    // Reset status to Pending if quantity changes
                    const checkbox = document.querySelector(`.item-checkbox[data-id="${id}"]`);
                    if (checkbox.getAttribute('data-status') === 'Approved') {
                        checkbox.setAttribute('data-status', 'Pending');
                        await resetCartItemStatus(id);
                    }
                    updateTotals();
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated',
                        text: 'Quantity updated successfully, awaiting re-approval.',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Failed to update quantity',
                        confirmButtonColor: '#dc2626'
                    });
                }
            } catch (error) {
                console.error('Update Quantity Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update quantity: ' + error.message,
                    confirmButtonColor: '#dc2626'
                });
            } finally {
                buttons.forEach(btn => btn.classList.remove('opacity-50', 'cursor-not-allowed'));
                input.classList.remove('opacity-50');
            }
        }

        async function resetCartItemStatus(id) {
            try {
                const response = await fetch(`/cart/update/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: 'Pending'
                    })
                });
                const data = await response.json();
                if (!data.success) {
                    console.error('Failed to reset cart item status:', data.message);
                }
            } catch (error) {
                console.error('Error resetting cart item status:', error);
            }
        }

        async function removeItem(id) {
            Swal.fire({
                title: 'Remove Item',
                text: 'Are you sure you want to remove this item?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, remove it!'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const response = await fetch(`/cart/remove/${id}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });
                        const data = await response.json();
                        if (data.success) {
                            document.querySelector(`[data-item-id="${id}"]`).remove();
                            updateTotals();
                            Swal.fire({
                                icon: 'success',
                                title: 'Removed',
                                text: 'Item removed from cart',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || 'Failed to remove item',
                                confirmButtonColor: '#dc2626'
                            });
                        }
                    } catch (error) {
                        console.error('Remove Item Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to remove item: ' + error.message,
                            confirmButtonColor: '#dc2626'
                        });
                    }
                }
            });
        }

        function updateTotals() {
            let total = 0,
                count = 0;
            document.querySelectorAll('.item-checkbox:checked').forEach(cb => {
                const row = cb.closest('[data-item-id]');
                const qty = parseInt(row.querySelector('input[id^="qty-"]').value) || 0;
                const priceElement = row.querySelector('[data-price]');
                const price = parseFloat(priceElement.getAttribute('data-price')) || 0;
                const status = cb.getAttribute('data-status');
                if (status === 'Approved') {
                    total += qty * price;
                    count++;
                }
            });
            document.getElementById('total-price').textContent = `Rp ${total.toLocaleString('id-ID')}`;
            document.getElementById('item-count').textContent = count;
            document.getElementById('checkout-btn').disabled = count === 0;
        }

        function showBidModal(id) {
            document.getElementById('bidProductId').value = id;
            document.getElementById('bidModal').classList.remove('hidden');
        }

        function closeBidModal() {
            document.getElementById('bidModal').classList.add('hidden');
            document.getElementById('bidForm').reset();
        }

        async function requestPurchase() {
            const checkedItems = document.querySelectorAll('.item-checkbox:checked');
            if (checkedItems.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Items Selected',
                    text: 'Please select at least one item to request purchase',
                    confirmButtonColor: '#dc2626'
                });
                return;
            }

            const requestButton = document.querySelector('.request-purchase-btn');
            requestButton.classList.add('opacity-50', 'cursor-not-allowed');
            requestButton.disabled = true;

            try {
                const response = await fetch('/cart/request-purchase', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        selected_ids: Array.from(checkedItems).map(cb => cb.getAttribute('data-id'))
                    })
                });

                if (!response.ok) {
                    const text = await response.text();
                    console.error('Request Purchase Response:', text);
                    throw new Error(`Server returned status ${response.status}: ${text}`);
                }

                const data = await response.json();
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Purchase Requested',
                        text: 'Your purchase request has been submitted',
                        confirmButtonColor: '#dc2626',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Failed to request purchase',
                        confirmButtonColor: '#dc2626'
                    });
                }
            } catch (error) {
                console.error('Request Purchase Error:', error);
                if (error.message.includes('Unauthenticated')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Authentication Error',
                        text: 'Your session has expired. Please log in again.',
                        confirmButtonColor: '#dc2626'
                    }).then(() => {
                        window.location.href = '{{ route('login.form') }}';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to request purchase: ' + error.message,
                        confirmButtonColor: '#dc2626'
                    });
                }
            } finally {
                requestButton.classList.remove('opacity-50', 'cursor-not-allowed');
                requestButton.disabled = false;
            }
        }

        async function checkout() {
            const checkedItems = document.querySelectorAll('.item-checkbox:checked[data-status="Approved"]');
            if (checkedItems.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Approved Items Selected',
                    text: 'Please select at least one approved item to checkout',
                    confirmButtonColor: '#dc2626'
                });
                return;
            }

            const checkoutButton = document.getElementById('checkout-btn');
            checkoutButton.classList.add('opacity-50', 'cursor-not-allowed');
            checkoutButton.disabled = true;

            try {
                const response = await fetch('/procurement/checkout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        selected_ids: Array.from(checkedItems).map(cb => cb.getAttribute('data-id'))
                    })
                });

                const data = await response.json();
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Proceeding to Checkout',
                        text: 'Redirecting to checkout page...',
                        confirmButtonColor: '#dc2626',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = '/procurement/checkout';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Failed to proceed to checkout',
                        confirmButtonColor: '#dc2626'
                    });
                }
            } catch (error) {
                console.error('Checkout Error:', error);
                if (error.message.includes('Unauthenticated')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Authentication Error',
                        text: 'Your session has expired. Please log in again.',
                        confirmButtonColor: '#dc2626'
                    }).then(() => {
                        window.location.href = '{{ route('login.form') }}';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to proceed to checkout: ' + error.message,
                        confirmButtonColor: '#dc2626'
                    });
                }
            } finally {
                checkoutButton.classList.remove('opacity-50', 'cursor-not-allowed');
                checkoutButton.disabled = false;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('select-all');
            const supplierCheckboxes = document.querySelectorAll('.select-supplier');
            const itemCheckboxes = document.querySelectorAll('.item-checkbox');

            // Debugging: Log all item statuses
            console.log('Item Checkboxes:', itemCheckboxes.length);
            itemCheckboxes.forEach(cb => {
                console.log(
                    `Item ID: ${cb.getAttribute('data-id')}, Status: ${cb.getAttribute('data-status')}`);
            });

            // Update Select All and Supplier checkboxes based on item selections
            function updateParentCheckboxes() {
                const allItems = document.querySelectorAll('.item-checkbox');
                const checkedItems = document.querySelectorAll('.item-checkbox:checked');
                selectAllCheckbox.checked = allItems.length > 0 && checkedItems.length === allItems.length;

                supplierCheckboxes.forEach(supplierCb => {
                    const supplier = supplierCb.getAttribute('data-supplier');
                    const supplierItems = document.querySelectorAll(
                        `.item-checkbox[data-supplier="${supplier}"]`);
                    const checkedSupplierItems = document.querySelectorAll(
                        `.item-checkbox[data-supplier="${supplier}"]:checked`);
                    supplierCb.checked = supplierItems.length > 0 && checkedSupplierItems.length ===
                        supplierItems.length;
                });
                console.log('Updated parent checkboxes:', {
                    selectAll: selectAllCheckbox.checked
                });
            }

            // Select All checkbox logic
            selectAllCheckbox.addEventListener('change', function() {
                const checked = this.checked;
                console.log('Select All clicked, checked:', checked);
                itemCheckboxes.forEach(cb => {
                    cb.checked = checked;
                    console.log(`Item ID: ${cb.getAttribute('data-id')} checked: ${cb.checked}`);
                });
                supplierCheckboxes.forEach(cb => {
                    const supplier = cb.getAttribute('data-supplier');
                    const supplierItems = document.querySelectorAll(
                        `.item-checkbox[data-supplier="${supplier}"]`);
                    if (supplierItems.length > 0) {
                        cb.checked = checked;
                    }
                });
                updateTotals();
            });

            // Supplier checkbox logic
            supplierCheckboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    const supplier = this.getAttribute('data-supplier');
                    const checked = this.checked;
                    console.log(`Supplier ${supplier} clicked, checked:`, checked);
                    document.querySelectorAll(`.item-checkbox[data-supplier="${supplier}"]`)
                        .forEach(itemCb => {
                            itemCb.checked = checked;
                            console.log(
                                `Item ID: ${itemCb.getAttribute('data-id')} checked: ${itemCb.checked}`
                                );
                        });
                    updateParentCheckboxes();
                    updateTotals();
                });
            });

            // Item checkbox logic
            itemCheckboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    console.log(
                        `Item ID: ${cb.getAttribute('data-id')} changed, checked: ${cb.checked}`
                        );
                    updateParentCheckboxes();
                    updateTotals();
                });
            });

            // Bid form submission
            document.getElementById('bidForm').addEventListener('submit', async function(e) {
                e.preventDefault();
                const id = document.getElementById('bidProductId').value;
                const price = document.getElementById('bidPrice').value;

                try {
                    const response = await fetch('/cart/bid/' + id, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            bid_price: price
                        })
                    });

                    if (!response.ok) {
                        const text = await response.text();
                        console.error('Bid Submission Response:', text);
                        throw new Error(`Server returned status ${response.status}: ${text}`);
                    }

                    const data = await response.json();
                    if (data.success) {
                        closeBidModal();
                        Swal.fire({
                            icon: 'success',
                            title: 'Bid Submitted',
                            text: 'Your bid has been submitted successfully',
                            confirmButtonColor: '#dc2626'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Failed to submit bid',
                            confirmButtonColor: '#dc2626'
                        });
                    }
                } catch (error) {
                    console.error('Bid Submission Error:', error);
                    if (error.message.includes('Unauthenticated')) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Authentication Error',
                            text: 'Your session has expired. Please log in again.',
                            confirmButtonColor: '#dc2626'
                        }).then(() => {
                            window.location.href = '{{ route('login.form') }}';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to submit bid: ' + error.message,
                            confirmButtonColor: '#dc2626'
                        });
                    }
                }
            });

            updateTotals();
            updateParentCheckboxes();
        });
    </script>
@endsection
