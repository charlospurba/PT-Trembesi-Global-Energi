<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product Detail | Trembesi Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-red-50 font-sans">
    <header class="bg-gradient-to-r from-red-600 to-red-400 shadow-md p-4 flex justify-between items-center text-white">
        <div class="flex items-center gap-2">
            <img src="{{ asset('assets/images/logo_trembesi.png') }}" alt="Logo Trembesi" class="w-10 h-auto" />
            <h1 class="text-xl font-bold">Trembesi Shop</h1>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-gray-200">Halo, Vendor</span>
            <img src="https://via.placeholder.com/40" class="rounded-full w-10 h-10" />
        </div>
    </header>

    <div class="flex min-h-screen">
        <aside class="w-64 bg-white p-6 shadow hidden md:block">
            <nav class="space-y-4 font-medium">
                <a href="{{ route('vendor.dashboardvendor') }}" class="block text-gray-700 hover:text-red-500">📦
                    Dashboard</a>
                <a href="{{ route('vendor.myproducts') }}" class="block text-gray-700 hover:text-red-500">🛍️ My
                    Products</a>
                <a href="{{ route('vendor.add_product') }}" class="block text-gray-700 hover:text-red-500">➕ Add
                    Products</a>
                <a href="{{ route('vendor.orders') }}" class="block text-gray-700 hover:text-red-500">📋 Orders</a>
                <a href="#" class="block text-gray-700 hover:text-red-500">💬 Review</a>
            </nav>
        </aside>

        <main class="flex-1 p-6 space-y-6">
            <div class="bg-red-500 text-white px-6 py-4 rounded-md shadow">
                <h2 class="text-xl font-bold">Product Detail</h2>
                <p class="text-sm">View details of {{ $product->name }}</p>
            </div>

            <div class="bg-white p-6 rounded shadow">
                <div class="max-w-2xl mx-auto">
                    @if ($product->image_paths && is_array($product->image_paths) && count($product->image_paths) > 0)
                        <div class="mb-4">
                            <p class="text-gray-600 mb-2">Images:</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($product->image_paths as $imagePath)
                                    <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ $product->name }}"
                                        class="w-full h-64 object-cover rounded-md mb-4" />
                                @endforeach
                            </div>
                        </div>
                    @else
                        <img src="https://via.placeholder.com/300" alt="{{ $product->name }}"
                            class="w-full h-64 object-cover rounded-md mb-4" />
                    @endif
                    <h3 class="text-2xl font-semibold text-red-600 mb-2">{{ $product->name }}</h3>
                    <p class="text-gray-600 mb-2">Category: {{ $product->category ?? 'N/A' }}</p>
                    <p class="text-gray-600 mb-2">Brand: {{ $product->brand ?? 'N/A' }}</p>
                    <p class="text-gray-600 mb-2">Supplier: {{ $product->supplier ?? 'N/A' }}</p>
                    <p class="text-gray-600 mb-2">Specification: {{ $product->specification ?? 'N/A' }}</p>
                    <p class="text-gray-600 mb-2">Unit: {{ $product->unit ?? 'N/A' }}</p>
                    <p class="text-gray-600 mb-2">Quantity: {{ $product->quantity ?? 'N/A' }}</p>
                    <p class="text-gray-600 mb-2">Price: Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}</p>
                    <p class="text-gray-600 mb-2">Description: {{ $product->description ?? 'No description' }}</p>
                    <p class="text-gray-600 mb-2">Address: {{ $product->address ?? 'N/A' }}</p>
                    <p class="text-gray-600 mb-2">Created At: {{ $product->created_at->format('d M Y H:i') }} WIB</p>
                    <p class="text-gray-600 mb-2">Last Updated: {{ $product->updated_at->format('d M Y H:i') }} WIB</p>
                    <div class="mt-4">
                        <a href="{{ route('vendor.edit_product', $product->id) }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1 rounded">Edit</a>
                        <a href="{{ route('vendor.myproducts') }}"
                            class="bg-gray-200 hover:bg-gray-300 text-red-600 text-sm px-3 py-1 rounded ml-2">Back to
                            List</a>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <footer class="bg-white text-center p-4 text-sm text-gray-500">
        © 2025 Trembesi Shop
    </footer>
</body>

</html>
