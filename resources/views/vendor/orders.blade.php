@extends('layouts.app')

@section('content')
    @include('components.navvendor')

    <div class="flex min-h-screen bg-gray-100">
        @include('components.sidevendor')

        <main class="flex-1 p-6">
            <div class="bg-white p-6 rounded shadow-md">
                <h2 class="text-2xl font-semibold text-red-600 mb-6">Orders Status</h2>

                <!-- Tabs & Search for Orders -->
                <div class="flex flex-wrap items-center mb-4 gap-3">
                    <a href="{{ route('vendor.orders') }}"
                        class="px-4 py-2 rounded transition {{ !request('status') ? 'bg-red-600 text-white' : 'bg-gray-200 hover:bg-red-100 text-gray-800' }}">
                        All ({{ $orderCounts['all'] ?? 0 }})
                    </a>
                    <a href="{{ route('vendor.orders', ['status' => 'Awaiting Shipment']) }}"
                        class="px-4 py-2 rounded transition {{ request('status') === 'Awaiting Shipment' ? 'bg-red-600 text-white' : 'bg-gray-200 hover:bg-red-100 text-gray-800' }}">
                        Awaiting Shipment ({{ $orderCounts['awaiting_shipment'] ?? 0 }})
                    </a>
                    <a href="{{ route('vendor.orders', ['status' => 'Shipped']) }}"
                        class="px-4 py-2 rounded transition {{ request('status') === 'Shipped' ? 'bg-red-600 text-white' : 'bg-gray-200 hover:bg-red-100 text-gray-800' }}">
                        Shipped ({{ $orderCounts['shipped'] ?? 0 }})
                    </a>
                    <a href="{{ route('vendor.orders', ['status' => 'Completed']) }}"
                        class="px-4 py-2 rounded transition {{ request('status') === 'Completed' ? 'bg-red-600 text-white' : 'bg-gray-200 hover:bg-red-100 text-gray-800' }}">
                        Completed ({{ $orderCounts['completed'] ?? 0 }})
                    </a>
                    <a href="{{ route('vendor.orders', ['status' => 'Cancelled']) }}"
                        class="px-4 py-2 rounded transition {{ request('status') === 'Cancelled' ? 'bg-red-600 text-white' : 'bg-gray-200 hover:bg-red-100 text-gray-800' }}">
                        Cancelled ({{ $orderCounts['cancelled'] ?? 0 }})
                    </a>

                    <!-- Search Box -->
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

                <!-- Current Filter Info for Orders -->
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
                            <a href="{{ route('vendor.orders') }}"
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Clear Filters
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Orders Table -->
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
                                        <div class="text-gray-900">{{ $order->street_address }}, {{ $order->city ?? '' }},
                                            {{ $order->postal_code }}, {{ $order->country }}</div>
                                        <div class="text-gray-500">Telepon: {{ $order->user->phone ?? 'N/A' }}</div>
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
                                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
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

                <!-- Orders Pagination -->
                @if ($orders->hasPages())
                    <div class="mt-4">
                        {{ $orders->appends(request()->except('page'))->links() }}
                    </div>
                @endif

                <!-- Bid Status Section -->
                <h2 class="text-2xl font-semibold text-red-600 mt-8 mb-6">Bid Status</h2>

                <!-- Tabs & Search for Bids -->
                <div class="flex flex-wrap items-center mb-4 gap-3">
                    <a href="{{ route('vendor.orders') }}"
                        class="px-4 py-2 rounded transition {{ !request('bid_status') ? 'bg-red-600 text-white' : 'bg-gray-200 hover:bg-red-100 text-gray-800' }}">
                        All ({{ $bidCounts['all'] ?? 0 }})
                    </a>
                    <a href="{{ route('vendor.orders', ['bid_status' => 'Pending']) }}"
                        class="px-4 py-2 rounded transition {{ request('bid_status') === 'Pending' ? 'bg-red-600 text-white' : 'bg-gray-200 hover:bg-red-100 text-gray-800' }}">
                        Pending ({{ $bidCounts['pending'] ?? 0 }})
                    </a>
                    <a href="{{ route('vendor.orders', ['bid_status' => 'Accepted']) }}"
                        class="px-4 py-2 rounded transition {{ request('bid_status') === 'Accepted' ? 'bg-red-600 text-white' : 'bg-gray-200 hover:bg-red-100 text-gray-800' }}">
                        Accepted ({{ $bidCounts['accepted'] ?? 0 }})
                    </a>
                    <a href="{{ route('vendor.orders', ['bid_status' => 'Rejected']) }}"
                        class="px-4 py-2 rounded transition {{ request('bid_status') === 'Rejected' ? 'bg-red-600 text-white' : 'bg-gray-200 hover:bg-red-100 text-gray-800' }}">
                        Rejected ({{ $bidCounts['rejected'] ?? 0 }})
                    </a>

                    <!-- Search Box -->
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

                <!-- Current Filter Info for Bids -->
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
                            <a href="{{ route('vendor.orders') }}"
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Clear Filters
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Bids Table -->
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
                                        <div class="font-medium text-gray-900">{{ $bid->product->name }}</div>
                                    </td>
                                    <td class="p-3 text-sm leading-6">
                                        <div class="text-gray-900">Bidder: {{ $bid->user->name }}</div>
                                        <div class="text-gray-500">Email: {{ $bid->user->email }}</div>
                                        <div class="text-gray-500">Bid Price: Rp
                                            {{ number_format($bid->bid_price, 0, ',', '.') }}</div>
                                        <div class="text-gray-500">Bid Date: {{ $bid->created_at->format('d M Y') }}</div>
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
                                                <div class="text-sm text-gray-400 mt-1">Try adjusting your filters</div>
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

                <!-- Bids Pagination -->
                @if ($bids->hasPages())
                    <div class="mt-4">
                        {{ $bids->appends(request()->except('page'))->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>

    <script>
        // Real-time search functionality for orders
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#orderTable tr[data-order-id]');

            rows.forEach(row => {
                const orderText = row.textContent.toLowerCase();
                row.style.display = orderText.includes(searchValue) ? '' : 'none';
            });
        });

        // Real-time search functionality for bids
        document.getElementById('bidSearchInput').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#bidTable tr[data-bid-id]');

            rows.forEach(row => {
                const bidText = row.textContent.toLowerCase();
                row.style.display = bidText.includes(searchValue) ? '' : 'none';
            });
        });

        // Auto-submit search after user stops typing
        let searchTimeout;
        document.getElementById('searchInput').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const searchValue = this.value;
                const currentUrl = new URL(window.location);

                if (searchValue) {
                    currentUrl.searchParams.set('search', searchValue);
                } else {
                    currentUrl.searchParams.delete('search');
                }

                window.history.replaceState({}, '', currentUrl);
            }, 500);
        });

        document.getElementById('bidSearchInput').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const searchValue = this.value;
                const currentUrl = new URL(window.location);

                if (searchValue) {
                    currentUrl.searchParams.set('search', searchValue);
                } else {
                    currentUrl.searchParams.delete('search');
                }

                window.history.replaceState({}, '', currentUrl);
            }, 500);
        });

        function updateBidStatus(bidId, status) {
            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to ${status.toLowerCase()} this bid?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: `Yes, ${status.toLowerCase()} it!`
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/bids/' + bidId + '/status', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
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
