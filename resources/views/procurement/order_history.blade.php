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
                    <span class="text-red-600 font-semibold">Order History</span>
                </nav>
                <div class="mt-4">
                    <h1 class="text-3xl font-extrabold text-red-600">📋 Order History</h1>
                    <p class="text-red-400">View your past and current procurement orders</p>
                </div>
            </div>

            @if ($orders->isEmpty())
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded-lg" role="alert">
                    <p class="font-bold">No Orders Found</p>
                    <p>You haven’t placed any orders yet. Start shopping to create your order history.</p>
                </div>
            @else
                <!-- Tab Navigation with Button Style -->
                <div class="mb-6">
                    <div class="flex space-x-2 border-b border-gray-200">
                        <button class="tab-button {{ !request()->has('status') ? 'active' : '' }}" data-status="all">
                            <i class="fas fa-list-ul mr-1"></i>
                            <span>All</span>
                            <span
                                class="ml-1 inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                {{ $orders->flatten()->count() }}
                            </span>
                        </button>
                        <button class="tab-button {{ request('status') == 'Awaiting Shipment' ? 'active' : '' }}"
                            data-status="Awaiting Shipment">
                            <i class="fas fa-truck-loading mr-1"></i>
                            <span>Awaiting Shipment</span>
                            <span
                                class="ml-1 inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                {{ $orders->get('Awaiting Shipment', collect())->count() }}
                            </span>
                        </button>
                        <button class="tab-button {{ request('status') == 'Shipped' ? 'active' : '' }}"
                            data-status="Shipped">
                            <i class="fas fa-shipping-fast mr-1"></i>
                            <span>Shipped</span>
                            <span
                                class="ml-1 inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $orders->get('Shipped', collect())->count() }}
                            </span>
                        </button>
                        <button class="tab-button {{ request('status') == 'Completed' ? 'active' : '' }}"
                            data-status="Completed">
                            <i class="fas fa-check-circle mr-1"></i>
                            <span>Completed</span>
                            <span
                                class="ml-1 inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $orders->get('Completed', collect())->count() }}
                            </span>
                        </button>
                        <button class="tab-button {{ request('status') == 'Cancelled' ? 'active' : '' }}"
                            data-status="Cancelled">
                            <i class="fas fa-times-circle mr-1"></i>
                            <span>Cancelled</span>
                            <span
                                class="ml-1 inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                {{ $orders->get('Cancelled', collect())->count() }}
                            </span>
                        </button>
                    </div>
                </div>

                <!-- Tab Content -->
                <div id="order-content">
                    @php
                        $activeStatus = request('status', 'all');
                        $displayOrders =
                            $activeStatus === 'all'
                                ? $orders->flatten(1)
                                : ($orders->has($activeStatus)
                                    ? $orders[$activeStatus]
                                    : collect());
                    @endphp

                    @if ($displayOrders->isEmpty())
                        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg"
                            role="alert">
                            <p class="font-bold">No Orders Found</p>
                            <p>No orders available for the selected status.</p>
                        </div>
                    @else
                        <div class="bg-white shadow-md rounded-xl border border-red-200 mb-6">
                            <div class="bg-red-600 text-white px-4 py-3 rounded-t-xl flex items-center">
                                <h2 class="font-semibold text-lg">
                                    {{ $activeStatus === 'all' ? 'All Orders' : $activeStatus }}</h2>
                                <span class="ml-auto text-sm">{{ $displayOrders->count() }} order(s)</span>
                            </div>
                            <div class="divide-y">
                                @foreach ($displayOrders as $order)
                                    <div class="p-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <h3 class="font-semibold text-red-700">Order #{{ $order->id }}</h3>
                                            <span
                                                class="text-sm text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</span>
                                        </div>
                                        <div class="text-sm text-gray-600 mb-2">
                                            <p>Vendor: {{ $order->vendor }}</p>
                                            <p>Total Price: Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                            <p>Shipping Address: {{ $order->street_address }}, {{ $order->city }},
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
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="mt-4 flex justify-end">
                                            <button onclick="generateEBilling({{ $order->id }})"
                                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1.5 px-4 rounded text-sm">
                                                Generate E-Billing
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-button');
            const orderContent = document.getElementById('order-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    const status = this.getAttribute('data-status');
                    window.location.href =
                        `{{ route('procurement.order_history') }}?status=${status}`;
                });
            });

            // Highlight active tab based on URL parameter
            const urlParams = new URLSearchParams(window.location.search);
            const currentStatus = urlParams.get('status') || 'all';
            document.querySelector(`.tab-button[data-status="${currentStatus}"]`).classList.add('active');
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
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => {
                            throw new Error(`Server returned status ${response.status}: ${text}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message || 'E-Billing generated successfully!',
                            timer: 1500,
                            confirmButtonColor: '#dc2626'
                        }).then(() => {
                            window.open(data.pdf_path, '_blank');
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Failed to generate E-Billing',
                            confirmButtonColor: '#dc2626'
                        });
                    }
                })
                .catch(error => {
                    console.error('Generate E-Billing Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message.includes('Unauthenticated') ?
                            'Your session has expired. Please log in again.' :
                            `Failed to generate E-Billing: ${error.message}`,
                        confirmButtonColor: '#dc2626'
                    }).then(() => {
                        if (error.message.includes('Unauthenticated')) {
                            window.location.href = '{{ route('login.form') }}';
                        }
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
    </style>
@endsection
