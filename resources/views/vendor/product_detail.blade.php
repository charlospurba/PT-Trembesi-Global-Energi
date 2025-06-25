@extends('layouts.app')

@section('content')
    @include('components.navvendor')

    <div class="flex min-h-screen bg-gray-100">
        @include('components.sidevendor')

        <main class="flex-1 p-6 space-y-6">
            <div class="bg-red-500 text-white px-6 py-4 rounded-md shadow">
                <h2 class="text-xl font-bold">Product Detail</h2>
                <p class="text-sm">View details of {{ $product->name }}</p>
            </div>

            {{-- Product Detail --}}
            <div class="bg-white p-6 rounded shadow flex flex-col md:flex-row gap-6">
                {{-- Product Image --}}
                <div class="flex-1">
                    @if ($product->image_paths && is_array($product->image_paths) && count($product->image_paths) > 0)
                        <img src="{{ asset('storage/' . $product->image_paths[0]) }}" alt="{{ $product->name }}"
                            class="w-full h-[400px] object-cover rounded-xl shadow" />
                    @else
                        <img src="https://via.placeholder.com/400" alt="{{ $product->name }}"
                            class="w-full h-[400px] object-cover rounded-xl shadow" />
                    @endif
                </div>

                {{-- Product Info --}}
                <div class="flex-1 space-y-4">
                    <h2 class="text-3xl font-bold text-gray-800">{{ $product->name }}</h2>
                    <p class="text-red-600 text-2xl font-bold">Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}</p>
                    <p class="text-gray-600">Sold: {{ $product->sold_quantity ?? 0 }}</p>

                    <hr class="my-4">

                    <h3 class="text-xl font-semibold text-red-600">Product Information</h3>
                    <div class="grid grid-cols-2 gap-4 text-gray-700 text-sm">
                        <div><span class="font-semibold">Category:</span> {{ $product->category ?? 'N/A' }}</div>
                        <div><span class="font-semibold">Minimum Order:</span> 1 pcs</div>
                        <div><span class="font-semibold">Unit:</span> {{ $product->unit ?? '-' }} </div>
                        <div><span class="font-semibold">Specification:</span> {{ $product->specification ?? '-' }}</div>
                        <div><span class="font-semibold">Brand:</span> {{ $product->brand ?? 'N/A' }}</div>
                        <div><span class="font-semibold">Quantity:</span> {{ $product->quantity ?? 'N/A' }}</div>
                    </div>

                    <hr class="my-4">

                    <h3 class="text-xl font-semibold text-red-600">Shipping</h3>
                    <div class="flex items-center text-gray-700 text-sm">
                        <svg class="w-4 h-4 text-red-600 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.05 4.05a7 7 0 019.9 9.9l-4.95 4.95a.7.7 0 01-.99 0L5.05 13.95a7 7 0 010-9.9zm2.12 2.12a3 3 0 104.24 4.24 3 3 0 00-4.24-4.24z"
                                clip-rule="evenodd" />
                        </svg>
                        Shipped from {{ $product->address ?? 'N/A' }}
                    </div>

                    <hr class="my-4">

                    <h3 class="text-xl font-semibold text-red-600">Description</h3>
                    <p class="text-gray-700 text-sm">{{ $product->description ?? 'No description' }}</p>

                    <div class="text-gray-500 text-xs mt-4">
                        <p>Created At: {{ $product->created_at->format('d M Y H:i') }} WIB</p>
                        <p>Last Updated: {{ $product->updated_at->format('d M Y H:i') }} WIB</p>
                    </div>

                    <div class="mt-6 flex gap-4">
                        <a href="{{ route('vendor.edit_product', $product->id) }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">Edit</a>
                        <a href="{{ route('vendor.myproducts') }}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded shadow">Back to List</a>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <footer class="bg-white text-center p-4 text-sm text-gray-500">
        © 2025 Trembesi Shop
    </footer>
@endsection
