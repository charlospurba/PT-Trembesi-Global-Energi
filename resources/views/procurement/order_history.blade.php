@extends('layouts.app')

@section('content')
    <!-- Include SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Include Font Awesome for star icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Include Navbar Component -->
    @include('components.procnav')

    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-red-50 to-rose-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <!-- Breadcrumb -->
            <nav class="flex items-center space-x-2 text-sm mb-6 px-4 py-3 bg-white rounded-xl shadow-lg">
                <a href="{{ route('procurement.dashboardproc') }}"
                    class="flex items-center text-gray-600 hover:text-red-600 transition-all duration-300">
                    <i class="fas fa-home mr-2"></i>Dashboard
                </a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span class="text-red-600 font-semibold">Order History</span>
            </nav>

            <!-- Tabs -->
            <div class="bg-white rounded-xl shadow-lg p-4 mb-6">
                <div class="flex flex-wrap gap-2">
                    <button class="tab-button" data-status="all">
                        <span><i class="fas fa-list"></i> All Orders</span>
                    </button>
                    <button class="tab-button" data-status="Awaiting Shipment">
                        <span><i class="fas fa-clock"></i> Awaiting Shipment</span>
                    </button>
                    <button class="tab-button" data-status="Shipped">
                        <span><i class="fas fa-shipping-fast"></i> Shipped</span>
                    </button>
                    <button class="tab-button" data-status="Completed">
                        <span><i class="fas fa-check-circle"></i> Completed</span>
                    </button>
                    <button class="tab-button" data-status="Cancelled">
                        <span><i class="fas fa-times-circle"></i> Cancelled</span>
                    </button>
                </div>
            </div>

            <!-- Orders -->
            <div id="order-content">
                @if ($orders->isEmpty())
                    <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                        <i class="fas fa-shopping-bag text-gray-400 text-3xl mb-4"></i>
                        <p class="text-gray-600 font-medium">No orders found.</p>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach ($orders as $status => $orderGroup)
                            @if (
                                $orderGroup->isNotEmpty() &&
                                    (request()->query('status') === $status || request()->query('status') === 'all' || !request()->has('status')))
                                <div class="bg-white rounded-xl shadow-lg p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                        {{ $status }}
                                    </h3>
                                    @foreach ($orderGroup as $order)
                                        <div class="border border-gray-200 rounded-lg p-4 mb-4">
                                            <div class="flex justify-between items-center mb-3">
                                                <div>
                                                    <p class="text-sm text-gray-600">Order ID: {{ $order->id }}</p>
                                                    <p class="text-sm text-gray-600">Order Date:
                                                        {{ $order->created_at->format('d M Y') }}</p>
                                                    <p class="text-sm text-gray-600">Vendor: {{ $order->vendor }}</p>
                                                </div>
                                                <span
                                                    class="px-3 py-1 text-sm font-medium rounded-full {{ $order->status === 'Completed' ? 'bg-green-100 text-green-800' : ($order->status === 'Cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                    {{ $order->status }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-600">Total Price: Rp
                                                    {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                                <p class="text-sm text-gray-600">Shipping Address:
                                                    {{ $order->street_address }}, {{ $order->city }},
                                                    {{ $order->country }} {{ $order->postal_code }}</p>
                                            </div>
                                            <div class="mt-2">
                                                <h4 class="text-sm font-semibold text-red-600 mb-2">Order Items</h4>
                                                <div class="border border-gray-200 rounded-lg">
                                                    <table class="w-full text-sm text-gray-600">
                                                        <thead>
                                                            <tr class="bg-gray-50">
                                                                <th class="p-2 text-left">Product</th>
                                                                <th class="p-2 text-left">Variant</th>
                                                                <th class="p-2 text-left">Quantity</th>
                                                                <th class="p-2 text-left">Price</th>
                                                                <th class="p-2 text-left">Total</th>
                                                                @if ($order->status === 'Completed')
                                                                    <th class="p-2 text-left">Rating</th>
                                                                @endif
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($order->orderItems as $item)
                                                                <tr class="border-t">
                                                                    <td class="p-2">{{ $item->name }}</td>
                                                                    <td class="p-2">{{ $item->variant }}</td>
                                                                    <td class="p-2">{{ $item->quantity }}</td>
                                                                    <td class="p-2">Rp
                                                                        {{ number_format($item->price, 0, ',', '.') }}</td>
                                                                    <td class="p-2">Rp
                                                                        {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                                                    </td>
                                                                    @if ($order->status === 'Completed')
                                                                        <td class="p-2">
                                                                            @php
                                                                                $rating = $order
                                                                                    ->ratings()
                                                                                    ->where(
                                                                                        'product_id',
                                                                                        $item->product_id,
                                                                                    )
                                                                                    ->first();
                                                                            @endphp
                                                                            @if ($rating)
                                                                                <div class="flex">
                                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                                        <i
                                                                                            class="fas fa-star {{ $i <= $rating->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                                                                    @endfor
                                                                                </div>
                                                                            @else
                                                                                <div class="flex rating-stars"
                                                                                    data-product-id="{{ $item->product_id }}"
                                                                                    data-order-id="{{ $order->id }}">
                                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                                        <i class="fas fa-star text-gray-300 cursor-pointer hover:text-yellow-400"
                                                                                            data-rating="{{ $i }}"
                                                                                            onclick="submitRating({{ $order->id }}, {{ $item->product_id }}, {{ $i }})"></i>
                                                                                    @endfor
                                                                                </div>
                                                                            @endif
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="mt-4 flex justify-end space-x-2">
                                                <button onclick="generateEBilling({{ $order->id }})"
                                                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1.5 px-4 rounded text-sm">
                                                    Generate E-Billing
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-button');
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    const status = this.getAttribute('data-status');
                    window.location.href =
                        `{{ route('procurement.order_history') }}?status=${status}`;
                });
            });

            const urlParams = new URLSearchParams(window.location.search);
            const currentStatus = urlParams.get('status') || 'all';
            document.querySelector(`.tab-button[data-status="${currentStatus}"]`)?.classList.add('active');
        });

        function generateEBilling(orderId) {
            Swal.fire({
                title: 'Generating E-Billing',
                text: 'Please wait while we generate your e-billing...',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch('/checkout/e-billing', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        order_id: orderId
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
                            confirmButtonColor: '#dc2626'
                        }).then(() => {
                            window.open(data.pdf_path, '_blank');
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message,
                            confirmButtonColor: '#dc2626'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to generate E-Billing: ' + error.message,
                        confirmButtonColor: '#dc2626'
                    });
                });
        }

        function submitRating(orderId, productId, rating) {
            Swal.fire({
                title: 'Submitting Rating...',
                text: 'Please wait while we submit your rating...',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch(`/orders/${orderId}/rate`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        ratings: [{
                            product_id: productId,
                            rating: rating
                        }]
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw new Error(data.message || 'Failed to submit rating');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message,
                            timer: 1500,
                            confirmButtonColor: '#dc2626'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message,
                            confirmButtonColor: '#dc2626'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: `Failed to submit rating: ${error.message}`,
                        confirmButtonColor: '#dc2626'
                    });
                });
        }
    </script>

    <style>
        .tab-button {
            @apply px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 flex items-center transition-all duration-200;
        }

        .tab-button.active {
            @apply bg-red-600 text-white border-red-600 shadow-md;
        }

        .tab-button span {
            @apply flex items-center;
        }

        .tab-button i {
            @apply mr-1;
        }

        .rating-stars .fa-star {
            margin-right: 4px;
        }
    </style>
@endsection
