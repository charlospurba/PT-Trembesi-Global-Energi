@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @include('components.navvendor')

    <div class="flex min-h-screen bg-gray-100">
        @include('components.sidevendor')

        <main class="flex-1 p-6">
            <div class="bg-white p-6 rounded shadow-md">
                <h2 class="text-2xl font-semibold text-red-600 mb-6">Vendor Dashboard</h2>

                <div class="flex border-b border-gray-200 mb-6">
                    <a href="{{ route('vendor.orders', ['tab' => 'orders']) }}"
                        class="px-4 py-2 text-sm font-medium transition-colors duration-200 
                        {{ request('tab', 'orders') === 'orders' ? 'border-b-2 border-red-600 text-red-600' : 'text-gray-500 hover:text-red-600' }}">
                        Orders
                    </a>
                    <a href="{{ route('vendor.orders', ['tab' => 'bids']) }}"
                        class="px-4 py-2 text-sm font-medium transition-colors duration-200 
                        {{ request('tab') === 'bids' ? 'border-b-2 border-red-600 text-red-600' : 'text-gray-500 hover:text-red-600' }}">
                        Bids
                    </a>
                </div>

                <div id="orders-tab" class="{{ request('tab', 'orders') === 'orders' ? '' : 'hidden' }}">
                    <h2 class="text-2xl font-semibold text-red-600 mb-6">Orders Status</h2>
                    <div class="flex flex-wrap items-center mb-4 gap-3">
                        <a href="{{ route('vendor.orders', ['tab' => 'orders']) }}"
                            class="px-4 py-2 rounded transition {{ !request('status') && request('tab', 'orders') === 'orders' ? 'bg-red-600 text-white' : 'bg-gray-200 hover:bg-red-100 text-gray-800' }}">
                            All ({{ $orderCounts['all'] ?? 0 }})
                        </a>
                        <a href="{{ route('vendor.orders', ['status' => 'Awaiting Shipment', 'tab' => 'orders']) }}"
                            class="px-4 py-2 rounded transition {{ request('status') === 'Awaiting Shipment' ? 'bg-red-600 text-white' : 'bg-gray-200 hover:bg-red-100 text-gray-800' }}">
                            Awaiting Shipment ({{ $orderCounts['awaiting_shipment'] ?? 0 }})
                        </a>
                        <a href="{{ route('vendor.orders', ['status' => 'Shipped', 'tab' => 'orders']) }}"
                            class="px-4 py-2 rounded transition {{ request('status') === 'Shipped' ? 'bg-red-600 text-white' : 'bg-gray-200 hover:bg-red-100 text-gray-800' }}">
                            Shipped ({{ $orderCounts['shipped'] ?? 0 }})
                        </a>
                        <a href="{{ route('vendor.orders', ['status' => 'Completed', 'tab' => 'orders']) }}"
                            class="px-4 py-2 rounded transition {{ request('status') === 'Completed' ? 'bg-red-600 text-white' : 'bg-gray-200 hover:bg-red-100 text-gray-800' }}">
                            Completed ({{ $orderCounts['completed'] ?? 0 }})
                        </a>
                        <a href="{{ route('vendor.orders', ['status' => 'Cancelled', 'tab' => 'orders']) }}"
                            class="px-4 py-2 rounded transition {{ request('status') === 'Cancelled' ? 'bg-red-600 text-white' : 'bg-gray-200 hover:bg-red-100 text-gray-800' }}">
                            Cancelled ({{ $orderCounts['cancelled'] ?? 0 }})
                        </a>

                        <div class="ml-auto relative w-64">
                            <input type="text" placeholder="Search orders..." id="searchInput"
                                class="w-full border border-gray-300 rounded pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-400"
                                value="{{ request('search') }}">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-4.35-4.35M16.65 11a5.65 5.65 0 11-11.3 0 5.65 5.65 0 0111.3 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    @if (request('status') || request('search'))
                        <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-blue-700">
                                    @if (request('status'))
                                        Showing orders with status: <strong>{{ request('status') }}</strong>
                                    @endif
                                    @if (request('search'))
                                        @if (request('status'))
                                            |
                                        @endif
                                        Search: <strong>"{{ request('search') }}"</strong>
                                    @endif
                                    - Total: {{ $orders->total() }} orders
                                </div>
                                <a href="{{ route('vendor.orders', ['tab' => 'orders']) }}"
                                    class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Clear Filters
                                </a>
                            </div>
                        </div>
                    @endif

                    <div class="overflow-x-auto border-t border-gray-300">
                        <table class="w-full text-sm mt-2 table-auto">
                            <thead>
                                <tr class="bg-gray-50 text-left text-gray-700">
                                    <th class="p-3 font-medium w-1/6">Status</th>
                                    <th class="p-3 font-medium w-1/3">Orders</th>
                                    <th class="p-3 font-medium w-1/2">Shipment</th>
                                    <th class="p-3 font-medium w-1/6">View Detail</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700" id="orderTable">
                                @forelse ($orders as $order)
                                    <tr class="border-t border-gray-200 hover:bg-gray-50 transition-colors"
                                        data-order-id="{{ $order->id }}">
                                        <td class="p-3">
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-medium 
                                                @switch($order->status)
                                                    @case('Awaiting Shipment')
                                                        bg-yellow-100 text-yellow-700
                                                        @break
                                                    @case('Shipped')
                                                        bg-blue-100 text-blue-700
                                                        @break
                                                    @case('Completed')
                                                        bg-green-100 text-green-700
                                                        @break
                                                    @case('Cancelled')
                                                        bg-red-100 text-red-700
                                                        @break
                                                    @default
                                                        bg-gray-100 text-gray-700
                                                @endswitch">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td class="p-3">
                                            <div class="font-medium text-gray-900">{{ $order->full_name }}</div>
                                            <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                                            <div class="text-sm text-gray-500">Order Date:
                                                {{ $order->created_at->format('d M Y') }}</div>
                                            <div class="text-sm font-medium text-gray-700">Total: Rp
                                                {{ number_format($order->total_price, 0, ',', '.') }}</div>
                                        </td>
                                        <td class="p-3 text-sm leading-6">
                                            <div class="text-gray-900">{{ $order->street_address }},
                                                {{ $order->city ?? '' }},
                                                {{ $order->postal_code }}, {{ $order->country }}</div>
                                            <div class="text-gray-500">Phone: {{ $order->phone_number ?? 'N/A' }}</div>
                                        </td>
                                        <td class="p-3">
                                            <a href="{{ route('vendor.order_detail', $order->id) }}"
                                                class="bg-blue-500 text-white px-4 py-1.5 rounded text-sm hover:bg-blue-600 transition">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-8 text-center text-gray-500">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                                <div class="text-lg font-medium">No orders found</div>
                                                @if (request('status') || request('search'))
                                                    <div class="text-sm text-gray-400 mt-1">Try adjusting your filters</div>
                                                @else
                                                    <div class="text-sm text-gray-400 mt-1">Orders will appear here when
                                                        customers place them</div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($orders->hasPages())
                        <div class="mt-4">
                            {{ $orders->appends(request()->except('page'))->links() }}
                        </div>
                    @endif
                </div>

                <div id="bids-tab" class="{{ request('tab') === 'bids' ? '' : 'hidden' }}">
                    <h2 class="text-2xl font-semibold text-red-600 mt-8 mb-6">Bid Status</h2>
                    <div class="flex flex-wrap items-center mb-4 gap-3">
                        <a href="{{ route('vendor.orders', ['tab' => 'bids']) }}"
                            class="px-4 py-2 rounded transition {{ !request('bid_status') && request('tab') === 'bids' ? 'bg-red-600 text-white' : 'bg-gray-200 hover:bg-red-100 text-gray-800' }}">
                            All ({{ $bidCounts['all'] ?? 0 }})
                        </a>
                        <a href="{{ route('vendor.orders', ['bid_status' => 'Pending', 'tab' => 'bids']) }}"
                            class="px-4 py-2 rounded transition {{ request('bid_status') === 'Pending' ? 'bg-red-600 text-white' : 'bg-gray-200 hover:bg-red-100 text-gray-800' }}">
                            Pending ({{ $bidCounts['pending'] ?? 0 }})
                        </a>
                        <a href="{{ route('vendor.orders', ['bid_status' => 'Accepted', 'tab' => 'bids']) }}"
                            class="px-4 py-2 rounded transition {{ request('bid_status') === 'Accepted' ? 'bg-red-600 text-white' : 'bg-gray-200 hover:bg-red-100 text-gray-800' }}">
                            Accepted ({{ $bidCounts['accepted'] ?? 0 }})
                        </a>
                        <a href="{{ route('vendor.orders', ['bid_status' => 'Rejected', 'tab' => 'bids']) }}"
                            class="px-4 py-2 rounded transition {{ request('bid_status') === 'Rejected' ? 'bg-red-600 text-white' : 'bg-gray-200 hover:bg-red-100 text-gray-800' }}">
                            Rejected ({{ $bidCounts['rejected'] ?? 0 }})
                        </a>

                        <div class="ml-auto relative w-64">
                            <input type="text" placeholder="Search bids..." id="bidSearchInput"
                                class="w-full border border-gray-300 rounded pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-400"
                                value="{{ request('search') }}">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-4.35-4.35M16.65 11a5.65 5.65 0 11-11.3 0 5.65 5.65 0 0111.3 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    @if (request('bid_status') || request('search'))
                        <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-blue-700">
                                    @if (request('bid_status'))
                                        Showing bids with status: <strong>{{ request('bid_status') }}</strong>
                                    @endif
                                    @if (request('search'))
                                        @if (request('bid_status'))
                                            |
                                        @endif
                                        Search: <strong>"{{ request('search') }}"</strong>
                                    @endif
                                    - Total: {{ $bids->total() }} bids
                                </div>
                                <a href="{{ route('vendor.orders', ['tab' => 'bids']) }}"
                                    class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Clear Filters
                                </a>
                            </div>
                        </div>
                    @endif

                    <div class="overflow-x-auto border-t border-gray-300">
                        <table class="w-full text-sm mt-2 table-auto">
                            <thead>
                                <tr class="bg-gray-50 text-left text-gray-700">
                                    <th class="p-3 font-medium w-1/6">Status</th>
                                    <th class="p-3 font-medium w-1/3">Product</th>
                                    <th class="p-3 font-medium w-1/3">Bid Details</th>
                                    <th class="p-3 font-medium w-1/6">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700" id="bidTable">
                                @forelse ($bids as $bid)
                                    <tr class="border-t border-gray-200 hover:bg-gray-50 transition-colors"
                                        data-bid-id="{{ $bid->id }}">
                                        <td class="p-3">
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-medium 
                                                @switch($bid->status)
                                                    @case('Pending')
                                                        bg-yellow-100 text-yellow-700
                                                        @break
                                                    @case('Accepted')
                                                        bg-green-100 text-green-700
                                                        @break
                                                    @case('Rejected')
                                                        bg-red-100 text-red-700
                                                        @break
                                                    @default
                                                        bg-gray-100 text-gray-700
                                                @endswitch">
                                                {{ $bid->status }}
                                            </span>
                                        </td>
                                        <td class="p-3">
                                            <div class="font-medium text-gray-900">{{ optional($bid->product)->name }}
                                            </div>
                                        </td>
                                        <td class="p-3 text-sm leading-6">
                                            <div class="text-gray-900">Bidder: {{ optional($bid->user)->name }}</div>
                                            <div class="text-gray-500">Email: {{ optional($bid->user)->email }}</div>
                                            <div class="text-gray-500">Bid Price: Rp
                                                {{ number_format($bid->bid_price, 0, ',', '.') }}</div>
                                            @if ($bid->purchaseRequest)
                                                <div class="text-gray-500 mt-1">Status Purchase Request:
                                                    {{ $bid->purchaseRequest->status }}</div>
                                            @endif
                                            <div class="text-gray-500">Bid Date: {{ $bid->created_at->format('d M Y') }}
                                            </div>
                                        </td>
                                        <td class="p-3">
                                            @if ($bid->status == 'Pending')
                                                <button onclick="updateBidStatus({{ $bid->id }}, 'Accepted')"
                                                    class="bg-green-500 text-white px-4 py-1.5 rounded text-sm hover:bg-green-600 transition mr-2">
                                                    Accept
                                                </button>
                                                <button onclick="updateBidStatus({{ $bid->id }}, 'Rejected')"
                                                    class="bg-red-500 text-white px-4 py-1.5 rounded text-sm hover:bg-red-600 transition">
                                                    Reject
                                                </button>
                                            @else
                                                <span class="text-gray-500">Action Completed</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-8 text-center text-gray-500">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                                <div class="text-lg font-medium">No bids found</div>
                                                @if (request('bid_status') || request('search'))
                                                    <div class="text-sm text-gray-400 mt-1">Try adjusting your filters
                                                    </div>
                                                @else
                                                    <div class="text-sm text-gray-400 mt-1">Bids will appear here when
                                                        customers submit them</div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($bids->hasPages())
                        <div class="mt-4">
                            {{ $bids->appends(request()->except('page'))->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <script>
        // Tab switching logic
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('a[href*="tab="]');
            const initialTab = new URL(window.location.href).searchParams.get('tab') || 'orders';
            const initialTabElement = document.getElementById(initialTab + '-tab');

            if (initialTabElement) {
                document.getElementById('orders-tab').classList.add('hidden');
                document.getElementById('bids-tab').classList.add('hidden');
                initialTabElement.classList.remove('hidden');
            }

            tabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = new URL(this.href);
                    const tabName = url.searchParams.get('tab');

                    document.getElementById('orders-tab').classList.add('hidden');
                    document.getElementById('bids-tab').classList.add('hidden');
                    document.getElementById(tabName + '-tab').classList.remove('hidden');

                    tabs.forEach(t => t.classList.remove('border-b-2', 'border-red-600',
                        'text-red-600'));
                    this.classList.add('border-b-2', 'border-red-600', 'text-red-600');

                    window.history.pushState({}, '', this.href);
                });
            });
        });

        // Ajax for updating bid status
        function updateBidStatus(bidId, status) {
            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to ${status.toLowerCase()} this bid?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: `Yes, ${status.toLowerCase()} it!`
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/bids/' + bidId + '/status', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                status: status
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
                                setTimeout(() => location.reload(), 1500);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.message || 'Failed to update bid status',
                                    confirmButtonColor: '#dc2626'
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to update bid status: ' + error.message,
                                confirmButtonColor: '#dc2626'
                            });
                        });
                }
            });
        }
    </script>
@endsection
