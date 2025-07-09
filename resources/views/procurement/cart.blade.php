@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@include('components.navbar')

<div class="bg-gray-50 min-h-screen py-2">
    <div class="container mx-auto px-4 max-w-2xl">
        <!-- Compact Header -->
        <div class="mb-3 bg-white p-3 rounded-lg shadow-sm max-w-2xl mx-auto">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-lg font-bold text-gray-800">🛒 Cart</h1>
                    <p class="text-xs text-gray-600">{{ count($cartItems) }} items</p>
                </div>
                <a href="{{ route('procurement.dashboardproc') }}" class="text-sm text-blue-600 hover:text-blue-800">← Back</a>
            </div>
        </div>

        @php $groupedItems = collect($cartItems)->groupBy('supplier'); @endphp

        <!-- Cart Items -->
        <div class="space-y-3 pb-20 max-w-2xl mx-auto">
            @foreach ($groupedItems as $supplier => $items)
            <div class="bg-white rounded-lg shadow-sm border" data-supplier="{{ $supplier }}">
                <!-- Supplier Header -->
                <div class="bg-red-500 text-white px-3 py-2 rounded-t-lg">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" class="mr-2 select-supplier" data-supplier="{{ $supplier }}">
                        <span class="text-sm font-medium">{{ $supplier }}</span>
                        <span class="ml-auto text-xs opacity-75">{{ count($items) }} items</span>
                    </label>
                </div>

                <!-- Items -->
                <div class="divide-y">
                    @foreach ($items as $item)
                    @php
                        $bids = App\Models\Bid::where('product_id', $item['id'])->where('user_id', Auth::id())->latest()->take(3)->get();
                        $acceptedBid = $bids->where('status', 'Accepted')->first();
                    @endphp
                    <div class="p-3 hover:bg-gray-50" data-item-id="{{ $item['id'] }}">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" class="item-checkbox flex-shrink-0" data-id="{{ $item['id'] }}" data-supplier="{{ $supplier }}">
                            
                            <!-- Product Image -->
                            <img src="{{ $item['image'] ? asset('storage/' . $item['image']) : '/images/pipa-besi.png' }}" 
                                 class="w-12 h-12 rounded object-cover flex-shrink-0">
                            
                            <!-- Product Info -->
                            <div class="flex-1 min-w-0">
                                <h4 class="font-medium text-sm truncate">{{ $item['name'] }}</h4>
                                < class="flex items-center gap-2 mt-1">
                                    @if ($acceptedBid)
                                        <span class="text-xs text-gray-500 line-through">Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                                        <span class="text-sm font-bold text-red-600">Rp {{ number_format($acceptedBid->bid_price, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-sm font-bold text-red-600">Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                                    @endif
                                </ div>
                                
                                <!-- Bid Info -->
                                @if ($bids->isNotEmpty())
                                <div class="flex gap-1 mt-1">
                                    @foreach ($bids as $bid)
                                    <span class="text-xs px-2 py-1 rounded-full {{ $bid->status === 'Accepted' ? 'bg-green-100 text-green-700' : ($bid->status === 'Rejected' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700') }}">
                                        {{ $bid->status }}
                                    </span>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <button class="text-xs bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600" 
                                        onclick="showBidModal({{ $item['id'] }})" 
                                        {{ $bids->count() >= 3 ? 'disabled' : '' }}>
                                    BID
                                </button>
                                
                                <!-- Quantity -->
                                <div class="flex items-center bg-gray-100 rounded">
                                    <button class="w-6 h-6 flex items-center justify-center text-gray-600 hover:text-red-600" 
                                            onclick="updateQuantity({{ $item['id'] }}, -1)">-</button>
                                    <input type="text" class="w-8 h-6 text-center text-xs border-0 bg-transparent" 
                                           value="{{ $item['quantity'] }}" id="qty-{{ $item['id'] }}" 
                                           onchange="updateQuantity({{ $item['id'] }}, this.value)">
                                    <button class="w-6 h-6 flex items-center justify-center text-gray-600 hover:text-red-600" 
                                            onclick="updateQuantity({{ $item['id'] }}, 1)">+</button>
                                </div>
                                
                                <button class="w-6 h-6 flex items-center justify-center text-gray-400 hover:text-red-500" 
                                        onclick="removeItem({{ $item['id'] }})">🗑️</button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <!-- Bottom Summary -->
        <div class="fixed bottom-0 left-0 right-0 bg-white border-t px-4 py-3 shadow-lg">
            <div class="container mx-auto max-w-2xl">
                <div class="flex justify-between items-center">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" class="mr-2" id="select-all">
                        <span class="text-sm font-medium">Select All</span>
                    </label>
                    
                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <div class="text-xs text-gray-600">Total (<span id="item-count">0</span> items)</div>
                            <div class="text-lg font-bold text-red-600" id="total-price">Rp 0</div>
                        </div>
                        <button class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded text-sm" 
                                onclick="checkout()">
                            Checkout
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bid Modal -->
        <div id="bidModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-lg p-4 w-full max-w-sm">
                <h3 class="text-lg font-bold mb-3">Submit Bid</h3>
                <form id="bidForm">
                    <input type="hidden" id="bidProductId">
                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1">Bid Price (Rp)</label>
                        <input type="number" id="bidPrice" class="w-full border rounded px-3 py-2 text-sm" required>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="closeBidModal()" class="px-3 py-2 bg-gray-300 rounded text-sm">Cancel</button>
                        <button type="submit" class="px-3 py-2 bg-red-500 text-white rounded text-sm">Submit</button>
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

function updateQuantity(productId, value) {
    const input = document.getElementById('qty-' + productId);
    let qty = typeof value === 'string' ? parseInt(value) : parseInt(input.value) + value;
    if (qty < 1) qty = 1;
    
    fetch('/cart/update/' + productId, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({quantity: qty})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            input.value = qty;
            updateTotals();
        }
    });
}

function removeItem(productId) {
    if (confirm('Remove this item?')) {
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
                document.querySelector(`[data-item-id="${productId}"]`).remove();
                updateTotals();
            }
        });
    }
}

function updateTotals() {
    let total = 0, count = 0;
    document.querySelectorAll('.item-checkbox:checked').forEach(checkbox => {
        const item = checkbox.closest('[data-item-id]');
        const qty = parseInt(item.querySelector('input[id^="qty-"]').value);
        const price = parseFloat(item.querySelector('.text-red-600').textContent.replace(/[^0-9]/g, ''));
        total += price * qty;
        count++;
    });
    
    document.getElementById('total-price').textContent = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('item-count').textContent = count;
}

function checkout() {
    const selected = document.querySelectorAll('.item-checkbox:checked');
    if (selected.length === 0) {
        alert('Please select items to checkout');
        return;
    }
    
    const vendors = [...new Set(Array.from(selected).map(cb => cb.dataset.supplier))];
    if (vendors.length > 1) {
        alert('Please select items from only one vendor');
        return;
    }
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route('procurement.checkout') }}';
    
    const csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_token';
    csrf.value = '{{ csrf_token() }}';
    form.appendChild(csrf);
    
    selected.forEach(cb => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'selected_ids[]';
        input.value = cb.dataset.id;
        form.appendChild(input);
    });
    
    document.body.appendChild(form);
    form.submit();
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Select all functionality
    document.getElementById('select-all').addEventListener('change', function() {
        const vendors = [...new Set(Array.from(document.querySelectorAll('.select-supplier')).map(cb => cb.dataset.supplier))];
        
        if (this.checked && vendors.length > 1) {
            const vendor = prompt('Select vendor: ' + vendors.join(', '));
            if (vendor && vendors.includes(vendor)) {
                selectedVendor = vendor;
                document.querySelectorAll('.item-checkbox').forEach(cb => {
                    cb.checked = cb.dataset.supplier === vendor;
                });
                document.querySelector(`.select-supplier[data-supplier="${vendor}"]`).checked = true;
            } else {
                this.checked = false;
            }
        } else if (this.checked && vendors.length === 1) {
            selectedVendor = vendors[0];
            document.querySelectorAll('.item-checkbox, .select-supplier').forEach(cb => cb.checked = true);
        } else {
            selectedVendor = null;
            document.querySelectorAll('.item-checkbox, .select-supplier').forEach(cb => cb.checked = false);
        }
        updateTotals();
    });
    
    // Supplier selection
    document.querySelectorAll('.select-supplier').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const supplier = this.dataset.supplier;
            if (this.checked) {
                selectedVendor = supplier;
                document.querySelectorAll('.select-supplier').forEach(cb => {
                    if (cb.dataset.supplier !== supplier) cb.checked = false;
                });
                document.querySelectorAll(`.item-checkbox[data-supplier="${supplier}"]`).forEach(cb => cb.checked = true);
                document.querySelectorAll(`.item-checkbox[data-supplier!="${supplier}"]`).forEach(cb => cb.checked = false);
            } else {
                document.querySelectorAll(`.item-checkbox[data-supplier="${supplier}"]`).forEach(cb => cb.checked = false);
            }
            updateTotals();
        });
    });
    
    // Item selection
    document.querySelectorAll('.item-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const supplier = this.dataset.supplier;
            if (this.checked && selectedVendor && selectedVendor !== supplier) {
                this.checked = false;
                alert('You can only select items from one vendor');
                return;
            }
            if (this.checked && !selectedVendor) {
                selectedVendor = supplier;
                document.querySelectorAll('.item-checkbox').forEach(cb => {
                    if (cb.dataset.supplier !== supplier) cb.checked = false;
                });
                document.querySelector(`.select-supplier[data-supplier="${supplier}"]`).checked = true;
            }
            updateTotals();
        });
    });
    
    // Bid form
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
            body: JSON.stringify({bid_price: bidPrice})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeBidModal();
                location.reload();
            } else {
                alert(data.message || 'Failed to submit bid');
            }
        });
    });
    
    updateTotals();
});
</script>
@endsection