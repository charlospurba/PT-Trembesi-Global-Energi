@extends('layouts.app')

@section('content')
    <!-- Include SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Include Navbar Component -->
    @include('components.navpm')

    <div class="min-h-screen bg-gradient-to-br from-red-50 via-pink-50 to-rose-50 pb-20">
        <div class="container mx-auto px-4 py-8">
            <!-- Breadcrumb Navigation -->
            <div class="mb-8">
                <nav class="flex items-center space-x-3 text-sm bg-gray-100 px-4 py-3 rounded-lg border">
                    <span class="text-gray-600">♦</span>
                    <a href="{{ route('dashboard.productmanager') }}"
                        class="text-gray-600 hover:text-red-600 transition-colors duration-200 font-medium">
                        Dashboard
                    </a>
                    <span class="text-gray-400">></span>
                    <span class="text-red-600 font-medium">
                        Purchase Requests
                    </span>
                </nav>
                <div class="mt-6">
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-red-600 to-pink-600 bg-clip-text text-transparent">
                        🛒 Purchase Requests
                    </h1>
                    <p class="text-gray-600 mt-2 text-lg">Review and manage pending purchase requests</p>
                </div>
            </div>

            <!-- Purchase Requests List -->
            <div
                class="bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-300 mb-8 overflow-hidden border-2 border-red-100 hover:border-red-200">
                <div
                    class="bg-gradient-to-r from-red-500 via-red-600 to-pink-600 px-8 py-6 border-b border-red-200 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-red-400/20 to-pink-400/20"></div>
                    <div class="relative flex items-center">
                        <div class="bg-white/20 backdrop-blur-sm p-3 rounded-2xl mr-4 shadow-lg">
                            <svg class="w-6 h-6 text-white drop-shadow-sm" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-bold text-xl drop-shadow-sm">Pending Purchase Requests</h3>
                            <p class="text-red-100 text-sm font-medium">{{ count($cartItems) }} request(s) awaiting approval
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Items List -->
                <div class="divide-y divide-red-100">
                    @forelse ($cartItems as $item)
                        @php
                            $acceptedBid = App\Models\Bid::where('product_id', $item->product_id)
                                ->where('user_id', $item->user_id)
                                ->where('status', 'Accepted')
                                ->latest()
                                ->first();
                            $price = $acceptedBid ? $acceptedBid->bid_price : $item->product->price;
                        @endphp
                        <div class="p-8 hover:bg-gradient-to-r hover:from-red-50 hover:to-pink-50 transition-all duration-300 border-l-4 border-transparent hover:border-red-300"
                            data-item-id="{{ $item->id }}">
                            <div class="flex items-center space-x-6">
                                <!-- Product Image -->
                                <div class="flex-shrink-0">
                                    <div class="relative group">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-r from-red-400 to-pink-400 rounded-2xl blur opacity-20 group-hover:opacity-40 transition-opacity">
                                        </div>
                                        <img src="{{ $item->product->image_paths && is_array($item->product->image_paths) ? asset('storage/' . $item->product->image_paths[0]) : '/images/pipa-besi.png' }}"
                                            class="relative w-24 h-24 rounded-2xl border-3 border-red-200 object-cover group-hover:scale-105 transition-transform duration-300 shadow-lg">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-red-900/20 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        </div>
                                    </div>
                                </div>

                                <!-- Product Details -->
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-xl font-bold text-gray-800 mb-3 leading-tight">
                                        {{ $item->product->name }}
                                    </h4>
                                    <div class="flex items-center space-x-4">
                                        <div class="flex items-center space-x-2">
                                            @if ($acceptedBid)
                                                <span class="text-2xl font-bold text-gray-500 line-through">Rp.
                                                    {{ number_format($item->product->price, 0, ',', '.') }}</span>
                                                <span
                                                    class="text-2xl font-bold bg-gradient-to-r from-red-600 to-pink-600 bg-clip-text text-transparent">Rp.
                                                    {{ number_format($acceptedBid->bid_price, 0, ',', '.') }}</span>
                                            @else
                                                <span
                                                    class="text-2xl font-bold bg-gradient-to-r from-red-600 to-pink-600 bg-clip-text text-transparent">Rp.
                                                    {{ number_format($item->product->price, 0, ',', '.') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                            {{ $item->status === 'Approved' ? 'bg-green-100 text-green-800' : ($item->status === 'Rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                            Status: {{ $item->status }}
                                        </span>
                                    </div>
                                    <div class="mt-2 text-sm text-gray-700">
                                        <p><span class="font-semibold text-red-600">Quantity:</span> {{ $item->quantity }}
                                        </p>
                                        <p><span class="font-semibold text-red-600">Variant:</span>
                                            {{ $item->variant ?? 'default' }}</p>
                                        <p><span class="font-semibold text-red-600">Requested by:</span>
                                            {{ $item->user->name }}</p>
                                        <p><span class="font-semibold text-red-600">Supplier:</span>
                                            {{ $item->product->supplier }}</p>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                @if ($item->status === 'Pending')
                                    <div class="flex items-center space-x-4">
                                        <button
                                            class="bg-gradient-to-r from-green-500 to-green-600 text-white font-bold py-2 px-4 rounded-2xl transition-all duration-200 transform hover:scale-105 hover:shadow-xl approve-btn"
                                            data-id="{{ $item->id }}" onclick="approveRequest({{ $item->id }})">
                                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Approve
                                        </button>
                                        <button
                                            class="bg-gradient-to-r from-red-500 to-red-600 text-white font-bold py-2 px-4 rounded-2xl transition-all duration-200 transform hover:scale-105 hover:shadow-xl reject-btn"
                                            data-id="{{ $item->id }}" onclick="rejectRequest({{ $item->id }})">
                                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Reject
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-600">
                            No pending purchase requests found.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
        function approveRequest(cartId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to approve this purchase request?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#16a34a',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/productmanager/purchase-requests/' + cartId + '/approve', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Approved',
                                    text: data.message,
                                    timer: 1500,
                                    showConfirmButton: false,
                                    confirmButtonColor: '#16a34a'
                                });
                                location.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.message || 'Failed to approve request',
                                    confirmButtonColor: '#dc2626'
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to approve request: ' + error.message,
                                confirmButtonColor: '#dc2626'
                            });
                        });
                }
            });
        }

        function rejectRequest(cartId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to reject this purchase request?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, reject it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/productmanager/purchase-requests/' + cartId + '/reject', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Rejected',
                                    text: data.message,
                                    timer: 1500,
                                    showConfirmButton: false,
                                    confirmButtonColor: '#dc2626'
                                });
                                location.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.message || 'Failed to reject request',
                                    confirmButtonColor: '#dc2626'
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to reject request: ' + error.message,
                                confirmButtonColor: '#dc2626'
                            });
                        });
                }
            });
        }
    </script>
@endsection
