@extends('layouts.app')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    @include('components.navpm')

    <div class="flex min-h-screen">
        @include('components.sidepm')
        <div class="bg-gray-100 min-h-screen p-6 flex-1">
            <div class="mb-6">
                <div class="mt-4">
                    <h1 class="text-3xl font-extrabold text-red-600">📋 Purchase Request Detail</h1>
                    <p class="text-red-400">Detailed information about the selected purchase request</p>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-xl border border-red-200 mb-6">
                <div class="bg-red-600 text-white px-4 py-3 rounded-t-xl">
                    <h2 class="font-semibold text-lg">{{ $purchaseRequest->supplier }}</h2>
                </div>
                <div class="p-4">
                    <div class="flex items-center space-x-4 mb-4">
                        <img src="{{ $purchaseRequest->product->image_paths && is_array($purchaseRequest->product->image_paths) ? asset('storage/' . $purchaseRequest->product->image_paths[0]) : '/images/pipa-besi.png' }}"
                            class="w-20 h-20 rounded object-cover border border-red-200">
                        <div>
                            <h3 class="font-semibold text-red-700 text-lg">{{ $purchaseRequest->product->name }}</h3>
                            <p class="text-gray-500 text-sm">Supplier: {{ $purchaseRequest->supplier }}</p>
                            <p class="text-gray-500 text-sm">Price: Rp
                                {{ number_format($purchaseRequest->product->price, 0, ',', '.') }}</p>
                            <p class="text-gray-500 text-sm">Requested Quantity: {{ $purchaseRequest->quantity }}</p>
                            <p class="text-gray-500 text-sm">Requested Price: Rp
                                {{ number_format($purchaseRequest->price, 0, ',', '.') }}</p>
                            <p class="text-gray-500 text-sm">Variant: {{ $purchaseRequest->cart->variant ?? 'default' }}</p>
                            <p class="text-gray-500 text-sm">Requested by: {{ $purchaseRequest->user->name }}
                                ({{ $purchaseRequest->user->email }})</p>
                            <p class="text-gray-500 text-sm">Submitted:
                                {{ $purchaseRequest->submitted_at->format('Y-m-d H:i:s') }}</p>
                            @if ($purchaseRequest->notes)
                                <p class="text-gray-500 text-sm">Notes: {{ $purchaseRequest->notes }}</p>
                            @endif
                            <p class="text-sm">
                                <span
                                    class="px-2 py-0.5 rounded-full text-xs {{ $purchaseRequest->status === 'Approved' ? 'bg-green-100 text-green-700' : ($purchaseRequest->status === 'Rejected' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700') }}">
                                    {{ $purchaseRequest->status }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <!-- History Tables -->
                    <div class="mt-4">
                        <h4 class="text-sm font-semibold text-red-600 mb-2">History</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Bid History -->
                            <div>
                                <h5 class="text-sm font-semibold text-red-600 mb-1">Bid History</h5>
                                @if ($bids->isEmpty())
                                    <p class="text-gray-500 text-sm">No bids submitted for this product.</p>
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
                                                            {{ number_format($bid->bid_price, 0, ',', '.') }}</td>
                                                        <td class="p-2">{{ $bid->status }}</td>
                                                        <td class="p-2">{{ $bid->created_at->format('Y-m-d H:i:s') }}
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
                                <h5 class="text-sm font-semibold text-red-600 mb-1">Purchase Request History</h5>
                                @if ($purchaseRequests->isEmpty())
                                    <p class="text-gray-500 text-sm">No purchase requests submitted for this product.</p>
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
                                                            {{ number_format($request->price, 0, ',', '.') }}</td>
                                                        <td class="p-2">{{ $request->status }}</td>
                                                        <td class="p-2">
                                                            {{ $request->submitted_at->format('Y-m-d H:i:s') }}</td>
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
            </div>
        </div>
    </div>
@endsection
