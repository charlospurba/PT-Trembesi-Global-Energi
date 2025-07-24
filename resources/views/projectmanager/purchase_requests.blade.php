@extends('layouts.app')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    @include('components.navpm')

    <div class="flex min-h-screen">
        @include('components.sidepm')
        <div class="bg-gray-100 min-h-screen p-6 flex-1">
            <div class="mb-6">
            <div class="bg-red-500 text-white px-6 py-4 rounded-md shadow">
                <h2 class="text-xl font-bold">Purchase Requests </h2>
                <p class="text-sm">Review and manage purchase requests from procurement team</p>
            </div>
            </div>

            @if ($purchaseRequests->isEmpty())
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded-lg" role="alert">
                    <p class="font-bold">No Purchase Requests</p>
                    <p>There are no purchase requests to review at this time.</p>
                </div>
            @else
                <div class="bg-white shadow-md rounded-xl border border-red-200 mb-6">
                    <div class="divide-y">
                        @foreach ($purchaseRequests as $request)
                            <div class="p-4 flex items-center space-x-4" data-item-id="{{ $request->id }}">
                                <img src="{{ $request->product->image_paths && is_array($request->product->image_paths) ? asset('storage/' . $request->product->image_paths[0]) : '/images/pipa-besi.png' }}"
                                    class="w-16 h-16 rounded object-cover border border-red-200">
                                <div class="flex-1">
                                    <a href="{{ route('projectmanager.purchase_requests.detail', $request->id) }}"
                                        class="font-semibold text-red-700 hover:text-red-800 hover:underline">
                                        {{ $request->product->name }}
                                    </a>
                                    <p class="text-gray-500 text-sm">Quantity: {{ $request->quantity }}</p>
                                    <p class="text-gray-500 text-sm">Price: Rp
                                        {{ number_format($request->price, 0, ',', '.') }}</p>
                                    <p class="text-gray-500 text-sm">Variant: {{ $request->cart->variant ?? 'default' }}</p>
                                    <p class="text-gray-500 text-sm">Supplier: {{ $request->supplier }}</p>
                                    <p class="text-gray-500 text-sm">Requested by: {{ $request->user->name }}
                                        ({{ $request->user->email }})
                                    </p>
                                    <p class="text-gray-500 text-sm">Submitted:
                                        {{ $request->submitted_at->format('Y-m-d H:i:s') }}</p>
                                    @if ($request->notes)
                                        <p class="text-gray-500 text-sm">Notes: {{ $request->notes }}</p>
                                    @endif
                                    <p class="text-sm">
                                        <span
                                            class="px-2 py-0.5 rounded-full text-xs {{ $request->status === 'Approved' ? 'bg-green-100 text-green-700' : ($request->status === 'Rejected' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700') }}">
                                            {{ $request->status }}
                                        </span>
                                    </p>
                                </div>
                                @if ($request->status === 'Pending')
                                    <div class="flex items-center space-x-2">
                                        <button onclick="approveRequest({{ $request->id }})"
                                            class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition-all duration-200">
                                            <i class="fas fa-check mr-1"></i> Approve
                                        </button>
                                        <button onclick="rejectRequest({{ $request->id }})"
                                            class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition-all duration-200">
                                            <i class="fas fa-times mr-1"></i> Reject
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        async function approveRequest(id) {
            Swal.fire({
                title: 'Approve Request',
                text: 'Are you sure you want to approve this purchase request?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#16a34a',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, approve!'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const response = await fetch(`/projectmanager/purchase-requests/${id}/approve`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content
                            }
                        });

                        if (!response.ok) {
                            const text = await response.text();
                            throw new Error(`Server returned status ${response.status}: ${text}`);
                        }

                        const data = await response.json();
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Approved',
                                text: 'Purchase request approved successfully',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || 'Failed to approve request',
                                confirmButtonColor: '#dc2626'
                            });
                        }
                    } catch (error) {
                        console.error('Approve Request Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to approve request: ' + error.message,
                            confirmButtonColor: '#dc2626'
                        });
                    }
                }
            });
        }

        async function rejectRequest(id) {
            Swal.fire({
                title: 'Reject Request',
                text: 'Are you sure you want to reject this purchase request?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, reject!'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const response = await fetch(`/projectmanager/purchase-requests/${id}/reject`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content
                            }
                        });

                        if (!response.ok) {
                            const text = await response.text();
                            throw new Error(`Server returned status ${response.status}: ${text}`);
                        }

                        const data = await response.json();
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Rejected',
                                text: 'Purchase request rejected successfully',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || 'Failed to reject request',
                                confirmButtonColor: '#dc2626'
                            });
                        }
                    } catch (error) {
                        console.error('Reject Request Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to reject request: ' + error.message,
                            confirmButtonColor: '#dc2626'
                        });
                    }
                }
            });
        }
    </script>
@endsection
