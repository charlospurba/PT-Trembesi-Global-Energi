@extends('layouts.app')

@section('content')
    <!-- Include Navbar Component -->
    @include('components.navbar')

    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-red-50 to-rose-50 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-gradient-to-br from-red-500/5 via-transparent to-rose-500/5"></div>
        <div class="absolute top-0 left-0 w-full h-80 bg-gradient-to-br from-red-600 to-rose-600 transform -skew-y-2 origin-top-left scale-110"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
 
            <!-- Page Header -->
            <div class="flex justify-between items-start mb-8 flex-wrap md:flex-nowrap gap-6">
                <div class="flex-1">
                    <h1 class="text-4xl font-bold text-white mb-2 flex items-center gap-3">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-shopping-bag text-2xl"></i>
                        </div>
                        My Order History
                    </h1>
                    <p class="text-white/90 text-lg font-medium">
                        Track and manage all your orders in one place
                    </p>
                </div>

                <div class="text-right mt-6 md:mt-12">
                    <a href="{{ route('dashboard') }}" 
                    class="inline-flex items-center bg-white text-red-600 px-4 py-2 text-sm rounded-full font-semibold shadow hover:bg-gray-100 transition-all duration-150">
                        ← Back to Dashboard
                    </a>
                </div>
            </div>


            <!-- Enhanced Tabs -->
            <div class="bg-white/90 backdrop-blur-lg rounded-2xl shadow-xl p-6 mb-8 border border-white/20">
                <div class="grid grid-cols-2 lg:grid-cols-5 gap-3">
                    <button class="tab-button group relative overflow-hidden bg-slate-100 hover:bg-slate-200 border-2 border-slate-200 hover:border-slate-300 rounded-xl px-4 py-4 transition-all duration-300 hover:scale-105 hover:shadow-lg" data-status="all">
                        <div class="flex flex-col items-center gap-2 relative z-10">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-list-ul text-lg group-hover:scale-110 transition-transform duration-300"></i>
                                <span class="bg-slate-300 text-slate-700 px-2 py-1 rounded-full text-xs font-bold min-w-6 text-center">{{ $orders->flatten()->count() }}</span>
                            </div>
                            <span class="font-semibold text-sm text-center">All Orders</span>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/50 to-transparent transform -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                    </button>
                    <button class="tab-button group relative overflow-hidden bg-slate-100 hover:bg-slate-200 border-2 border-slate-200 hover:border-slate-300 rounded-xl px-4 py-4 transition-all duration-300 hover:scale-105 hover:shadow-lg" data-status="Awaiting Shipment">
                        <div class="flex flex-col items-center gap-2 relative z-10">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-clock text-lg group-hover:scale-110 transition-transform duration-300"></i>
                                <span class="bg-yellow-300 text-yellow-800 px-2 py-1 rounded-full text-xs font-bold min-w-6 text-center">{{ $orders->get('Awaiting Shipment', collect())->count() }}</span>
                            </div>
                            <span class="font-semibold text-sm text-center">Awaiting Shipment</span>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/50 to-transparent transform -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                    </button>
                    <button class="tab-button group relative overflow-hidden bg-slate-100 hover:bg-slate-200 border-2 border-slate-200 hover:border-slate-300 rounded-xl px-4 py-4 transition-all duration-300 hover:scale-105 hover:shadow-lg" data-status="Shipped">
                        <div class="flex flex-col items-center gap-2 relative z-10">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-shipping-fast text-lg group-hover:scale-110 transition-transform duration-300"></i>
                                <span class="bg-blue-300 text-blue-800 px-2 py-1 rounded-full text-xs font-bold min-w-6 text-center">{{ $orders->get('Shipped', collect())->count() }}</span>
                            </div>
                            <span class="font-semibold text-sm text-center">Shipped</span>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/50 to-transparent transform -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                    </button>
                    <button class="tab-button group relative overflow-hidden bg-slate-100 hover:bg-slate-200 border-2 border-slate-200 hover:border-slate-300 rounded-xl px-4 py-4 transition-all duration-300 hover:scale-105 hover:shadow-lg" data-status="Completed">
                        <div class="flex flex-col items-center gap-2 relative z-10">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-check-circle text-lg group-hover:scale-110 transition-transform duration-300"></i>
                                <span class="bg-green-300 text-green-800 px-2 py-1 rounded-full text-xs font-bold min-w-6 text-center">{{ $orders->get('Completed', collect())->count() }}</span>
                            </div>
                            <span class="font-semibold text-sm text-center">Completed</span>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/50 to-transparent transform -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                    </button>
                    <button class="tab-button group relative overflow-hidden bg-slate-100 hover:bg-slate-200 border-2 border-slate-200 hover:border-slate-300 rounded-xl px-4 py-4 transition-all duration-300 hover:scale-105 hover:shadow-lg" data-status="Cancelled">
                        <div class="flex flex-col items-center gap-2 relative z-10">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-times-circle text-lg group-hover:scale-110 transition-transform duration-300"></i>
                                <span class="bg-red-300 text-red-800 px-2 py-1 rounded-full text-xs font-bold min-w-6 text-center">{{ $orders->get('Cancelled', collect())->count() }}</span>
                            </div>
                            <span class="font-semibold text-sm text-center">Cancelled</span>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/50 to-transparent transform -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                    </button>
                </div>
            </div>

            <!-- Orders -->
            <div id="order-content" class="animate-fadeInUp">
                @if ($orders->isEmpty())
                    <div class="bg-white/90 backdrop-blur-lg rounded-2xl shadow-xl p-12 text-center border border-white/20">
                        <div class="w-24 h-24 bg-gradient-to-br from-slate-200 to-slate-300 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-shopping-bag text-slate-500 text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800 mb-3">No orders found</h3>
                        <p class="text-slate-600 mb-6 text-lg">You haven't placed any orders yet. Start shopping to see your orders here!</p>
                        <a href="{{ route('procurement.dashboardproc') }}" 
                           class="inline-flex items-center gap-3 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-semibold px-8 py-4 rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                            <i class="fas fa-shopping-cart text-lg"></i>
                            Start Shopping
                        </a>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach ($orders as $status => $orderGroup)
                            @if (
                                $orderGroup->isNotEmpty() &&
                                    (request()->query('status') === $status || request()->query('status') === 'all' || !request()->has('status')))
                                @foreach ($orderGroup as $order)
                                    <div class="bg-white/90 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 group">
                                        <!-- Gradient Top Border -->
                                        <div class="h-1 bg-gradient-to-r from-red-500 via-rose-500 to-pink-500"></div>
                                        
                                        <!-- Order Header -->
                                        <div class="p-6 bg-gradient-to-r from-slate-50 to-slate-100 border-b border-slate-200">
                                            <div class="flex justify-between items-start">
                                                <div class="space-y-3">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-rose-500 rounded-lg flex items-center justify-center shadow-lg">
                                                            <i class="fas fa-receipt text-white"></i>
                                                        </div>
                                                        <span class="text-2xl font-bold text-slate-800">#{{ $order->id }}</span>
                                                    </div>
                                                    <div class="space-y-2">
                                                        <div class="flex items-center gap-2 text-slate-600">
                                                            <i class="fas fa-calendar-alt w-4"></i>
                                                            <span class="font-medium">{{ $order->created_at->format('d M Y') }}</span>
                                                        </div>
                                                        <div class="flex items-center gap-2 text-slate-600">
                                                            <i class="fas fa-store w-4"></i>
                                                            <span class="font-medium">{{ $order->vendor }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-bold shadow-lg
                                                        {{ $order->status === 'Completed' ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white' : 
                                                           ($order->status === 'Cancelled' ? 'bg-gradient-to-r from-red-500 to-rose-500 text-white' : 
                                                            ($order->status === 'Shipped' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white' : 
                                                             'bg-gradient-to-r from-yellow-500 to-orange-500 text-white')) }}">
                                                        @switch($order->status)
                                                            @case('Completed')
                                                                <i class="fas fa-check-circle"></i>
                                                                @break
                                                            @case('Cancelled')
                                                                <i class="fas fa-times-circle"></i>
                                                                @break
                                                            @case('Shipped')
                                                                <i class="fas fa-shipping-fast"></i>
                                                                @break
                                                            @default
                                                                <i class="fas fa-clock"></i>
                                                        @endswitch
                                                        {{ $order->status }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Order Summary -->
                                        <div class="p-6 space-y-4">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div class="bg-gradient-to-r from-slate-50 to-slate-100 p-4 rounded-xl border border-slate-200">
                                                    <div class="text-sm text-slate-600 font-medium mb-1">Total Amount</div>
                                                    <div class="text-2xl font-bold text-slate-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                                                </div>
                                                <div class="bg-gradient-to-r from-slate-50 to-slate-100 p-4 rounded-xl border border-slate-200">
                                                    <div class="text-sm text-slate-600 font-medium mb-2">Shipping Address</div>
                                                    <div class="flex items-start gap-2 text-slate-700">
                                                        <i class="fas fa-map-marker-alt text-red-500 mt-1"></i>
                                                        <span class="font-medium">{{ $order->street_address }}, {{ $order->city }}, {{ $order->country }} {{ $order->postal_code }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Order Items -->
                                            <div class="mt-6">
                                                <div class="flex items-center gap-3 mb-4">
                                                    <div class="w-8 h-8 bg-gradient-to-br from-red-500 to-rose-500 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-box-open text-white text-sm"></i>
                                                    </div>
                                                    <h4 class="text-lg font-bold text-slate-800">Order Items ({{ $order->orderItems->count() }})</h4>
                                                </div>
                                                <div class="bg-gradient-to-r from-slate-50 to-slate-100 rounded-xl p-1 border border-slate-200">
                                                    <div class="bg-white rounded-lg overflow-hidden shadow-sm">
                                                        <div class="overflow-x-auto">
                                                            <table class="w-full">
                                                                <thead class="bg-gradient-to-r from-slate-100 to-slate-200">
                                                                    <tr>
                                                                        <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Product</th>
                                                                        <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Variant</th>
                                                                        <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Qty</th>
                                                                        <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Price</th>
                                                                        <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Total</th>
                                                                        @if ($order->status === 'Completed')
                                                                            <th class="px-4 py-3 text-left text-sm font-bold text-slate-700">Rating</th>
                                                                        @endif
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="divide-y divide-slate-200">
                                                                    @foreach ($order->orderItems as $item)
                                                                        <tr class="hover:bg-slate-50 transition-colors duration-200">
                                                                            <td class="px-4 py-4">
                                                                                <div class="font-semibold text-slate-800">{{ $item->name }}</div>
                                                                            </td>
                                                                            <td class="px-4 py-4">
                                                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-slate-200 text-slate-700">
                                                                                    {{ $item->variant }}
                                                                                </span>
                                                                            </td>
                                                                            <td class="px-4 py-4">
                                                                                <span class="inline-flex items-center justify-center w-8 h-8 bg-gradient-to-br from-red-500 to-rose-500 text-white text-sm font-bold rounded-lg">
                                                                                    {{ $item->quantity }}
                                                                                </span>
                                                                            </td>
                                                                            <td class="px-4 py-4">
                                                                                <span class="font-semibold text-slate-800">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                                                            </td>
                                                                            <td class="px-4 py-4">
                                                                                <span class="font-bold text-lg text-slate-800">
                                                                                    Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                                                                </span>
                                                                            </td>
                                                                            @if ($order->status === 'Completed')
                                                                                <td class="px-4 py-4">
                                                                                    @php
                                                                                        $rating = $order
                                                                                            ->ratings()
                                                                                            ->where('product_id', $item->product_id)
                                                                                            ->first();
                                                                                    @endphp
                                                                                    @if ($rating)
                                                                                        <div class="flex items-center gap-2">
                                                                                            <div class="flex">
                                                                                                @for ($i = 1; $i <= 5; $i++)
                                                                                                    <i class="fas fa-star {{ $i <= $rating->rating ? 'text-yellow-400' : 'text-slate-300' }} text-lg"></i>
                                                                                                @endfor
                                                                                            </div>
                                                                                            <span class="text-sm font-medium text-slate-600">({{ $rating->rating }}/5)</span>
                                                                                        </div>
                                                                                    @else
                                                                                        <div class="space-y-1">
                                                                                            <div class="flex rating-stars" 
                                                                                                 data-product-id="{{ $item->product_id }}"
                                                                                                 data-order-id="{{ $order->id }}">
                                                                                                @for ($i = 1; $i <= 5; $i++)
                                                                                                    <i class="fas fa-star text-slate-300 cursor-pointer hover:text-yellow-400 text-lg transition-colors duration-200 transform hover:scale-110" 
                                                                                                       data-rating="{{ $i }}"
                                                                                                       onclick="submitRating({{ $order->id }}, {{ $item->product_id }}, {{ $i }})"></i>
                                                                                                @endfor
                                                                                            </div>
                                                                                            <div class="text-xs text-slate-500 font-medium">Click to rate</div>
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
                                                </div>
                                            </div>

                                            <!-- Order Actions -->
                                            <div class="flex justify-end pt-4">
                                                <button onclick="generateEBilling({{ $order->id }})"
                                                    class="inline-flex items-center gap-3 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl group">
                                                    <i class="fas fa-file-invoice text-lg group-hover:rotate-12 transition-transform duration-300"></i>
                                                    <span>Generate E-Billing</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab functionality
            const tabButtons = document.querySelectorAll('.tab-button');
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all tabs
                    tabButtons.forEach(btn => {
                        btn.classList.remove('bg-gradient-to-r', 'from-red-600', 'to-rose-600', 'text-white', 'border-red-600', 'shadow-xl', 'scale-105');
                        btn.classList.add('bg-slate-100', 'hover:bg-slate-200', 'border-slate-200', 'hover:border-slate-300');
                    });
                    
                    // Add active class to clicked tab
                    this.classList.remove('bg-slate-100', 'hover:bg-slate-200', 'border-slate-200', 'hover:border-slate-300');
                    this.classList.add('bg-gradient-to-r', 'from-red-600', 'to-rose-600', 'text-white', 'border-red-600', 'shadow-xl', 'scale-105');
                    
                    const status = this.getAttribute('data-status');
                    window.location.href = `{{ route('procurement.order_history') }}?status=${status}`;
                });
            });

            // Set active tab based on URL parameter
            const urlParams = new URLSearchParams(window.location.search);
            const currentStatus = urlParams.get('status') || 'all';
            const activeTab = document.querySelector(`.tab-button[data-status="${currentStatus}"]`);
            if (activeTab) {
                tabButtons.forEach(btn => {
                    btn.classList.remove('bg-gradient-to-r', 'from-red-600', 'to-rose-600', 'text-white', 'border-red-600', 'shadow-xl', 'scale-105');
                    btn.classList.add('bg-slate-100', 'hover:bg-slate-200', 'border-slate-200', 'hover:border-slate-300');
                });
                activeTab.classList.remove('bg-slate-100', 'hover:bg-slate-200', 'border-slate-200', 'hover:border-slate-300');
                activeTab.classList.add('bg-gradient-to-r', 'from-red-600', 'to-rose-600', 'text-white', 'border-red-600', 'shadow-xl', 'scale-105');
            }

            // Rating stars hover effect
            const ratingStars = document.querySelectorAll('.rating-stars');
            ratingStars.forEach(ratingContainer => {
                const stars = ratingContainer.querySelectorAll('i[data-rating]');
                stars.forEach((star, index) => {
                    star.addEventListener('mouseenter', () => {
                        stars.forEach((s, i) => {
                            if (i <= index) {
                                s.classList.remove('text-slate-300');
                                s.classList.add('text-yellow-400');
                            } else {
                                s.classList.remove('text-yellow-400');
                                s.classList.add('text-slate-300');
                            }
                        });
                    });
                    
                    ratingContainer.addEventListener('mouseleave', () => {
                        stars.forEach(s => {
                            s.classList.remove('text-yellow-400');
                            s.classList.add('text-slate-300');
                        });
                    });
                });
            });

            // Add fade in animation
            const orderCards = document.querySelectorAll('.bg-white\\/90');
            orderCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });

        function generateEBilling(orderId) {
            Swal.fire({
                title: 'Generating E-Billing',
                text: 'Please wait while we generate your e-billing...',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                background: '#ffffff',
                customClass: {
                    popup: 'rounded-2xl shadow-2xl border-0',
                    title: 'text-xl font-bold text-slate-800',
                    content: 'text-slate-600'
                },
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
                            title: 'Thank you!',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false,
                            background: '#ffffff',
                            customClass: {
                                popup: 'rounded-2xl shadow-2xl border-0',
                                title: 'text-xl font-bold text-slate-800',
                                content: 'text-slate-600'
                            }
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.message,
                            background: '#ffffff',
                            customClass: {
                                popup: 'rounded-2xl shadow-2xl border-0',
                                title: 'text-xl font-bold text-slate-800',
                                content: 'text-slate-600'
                            }
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: `Failed to submit rating: ${error.message}`,
                        background: '#ffffff',
                        customClass: {
                            popup: 'rounded-2xl shadow-2xl border-0',
                            title: 'text-xl font-bold text-slate-800',
                            content: 'text-slate-600'
                        }
                    });
                });
        }
    </script>
@endsection