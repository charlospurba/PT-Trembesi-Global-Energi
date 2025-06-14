<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Produk Saya | Trembesi Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-red-50 font-sans">
    <!-- Navbar -->
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
        <!-- Sidebar -->
        <aside class="w-64 bg-white p-6 shadow hidden md:block">
            <nav class="space-y-4 font-medium">
                <a href="{{ route('vendor.dashboardvendor') }}" class="block text-gray-700 hover:text-red-500">📦
                    Dashboard</a>
                <a href="{{ route('vendor.myproducts') }}" class="block text-red-700 font-semibold">🛍️ My Products</a>
                <a href="{{ route('vendor.add_product') }}" class="block text-gray-700 hover:text-red-500">➕ Add
                    Products</a>
                <a href="{{ route('vendor.orders') }}" class="block text-gray-700 hover:text-red-500">📋 Orders</a>
                <a href="#" class="block text-gray-700 hover:text-red-500">💬 Review</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 space-y-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-red-600">My Products</h2>
                <a href="{{ route('vendor.add_product') }}"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm font-medium">
                    ➕ Add Product
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <div class="bg-white rounded shadow hover:shadow-lg transition p-4 flex flex-col">
                        <img src="{{ $product->image_path ? asset('storage/' . $product->image_path) : asset('images/placeholder-300x200.png') }}"
                            alt="{{ $product->name }}" class="rounded mb-4 object-cover h-48 w-full">
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ $product->name }}</h3>
                        <p class="text-red-500 font-bold mb-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-500 mb-4">Stok: {{ $product->quantity }}</p>
                        <div class="mt-auto flex justify-between gap-2">
                            <a href="{{ route('vendor.edit_product', $product->id) }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1 rounded">Edit</a>
                            <form method="POST" action="{{ route('vendor.destroy_product', $product->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1 rounded"
                                    onclick="return confirm('Are you sure you want to delete this product?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </main>
    </div>

    <footer class="bg-white text-center p-4 text-sm text-gray-500">
        © 2025 Trembesi Shop
    </footer>
</body>

</html>
