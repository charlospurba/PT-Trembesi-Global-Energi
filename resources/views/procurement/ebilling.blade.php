@extends('layouts.app')

@section('content')
    @include('components.procnav')

    <div class="min-h-screen bg-gray-100 py-10 px-4 md:px-10">
        <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-lg p-6">
            {{-- Header --}}
            <div class="flex items-center justify-between mb-6 border-b pb-4">
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('assets/images/logo_merah.png') }}" alt="Trembesi Logo" class="h-12 w-auto">
                    <div>
                        <h1 class="text-xl font-bold text-red-600">Trembesi Global Energi</h1>
                        <p class="text-sm text-gray-500">Official E-Billing Document Preview</p>
                    </div>
                </div>
                <a href="{{ route('procurement.dashboardproc') }}"
                   class="text-sm text-red-500 hover:underline">← Back to Dashboard</a>
            </div>

            {{-- Metadata --}}
            @if(isset($pdfUrl))
                <div class="mb-6 bg-gray-50 rounded-lg p-4 border text-sm text-gray-700">
                    <p><strong>Preview Date:</strong> {{ now()->format('d M Y, H:i') }}</p>
                    <p><strong>Document Type:</strong> E-Billing PDF</p>
                </div>

                {{-- Order Summary --}}
                @isset($order)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Order Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                            <p><strong>Order ID:</strong> #{{ $order->id }}</p>
                            <p><strong>Vendor:</strong> {{ $order->vendor }}</p>
                            <p><strong>Receiver:</strong> {{ $order->full_name }}</p>
                            <p><strong>Total:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            <p><strong>Address:</strong> {{ $order->street_address }}, {{ $order->city }}, {{ $order->state ?? '-' }}, {{ $order->country }}</p>
                            <p><strong>Status:</strong> {{ $order->status }}</p>
                        </div>
                    </div>
                @endisset

                {{-- Order Items --}}
                @isset($orderItems)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Ordered Items</h3>
                        <table class="w-full border text-sm text-gray-800">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border px-4 py-2 text-left">Product</th>
                                    <th class="border px-4 py-2 text-center">Quantity</th>
                                    <th class="border px-4 py-2 text-right">Price</th>
                                    <th class="border px-4 py-2 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orderItems as $item)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $item->name }}</td>
                                        <td class="border px-4 py-2 text-center">{{ $item->quantity }}</td>
                                        <td class="border px-4 py-2 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td class="border px-4 py-2 text-right">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endisset

                {{-- Tombol Download PDF --}}
                <div class="mb-4 text-right">
                    <a href="{{ $pdfUrl }}" class="inline-block bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition-all">
                        ⬇ Download PDF
                    </a>
                </div>

                {{-- PDF Preview --}}
                <div class="w-full h-[80vh] border rounded-lg overflow-hidden shadow">
                    <iframe src="{{ $pdfUrl }}" class="w-full h-full" frameborder="0"></iframe>
                </div>
            @else
                <div class="text-center text-gray-500 py-20">
                    <p class="text-lg font-medium">E-Billing document is not available.</p>
                </div>
            @endif
        </div>

        {{-- Footer --}}
        <div class="text-center mt-6 text-xs text-gray-400">
            &copy; {{ date('Y') }} Trembesi Global Energi — All rights reserved.
        </div>
    </div>
@endsection
