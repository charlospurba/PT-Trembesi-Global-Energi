<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tambah Produk | Trembesi Shop</title>
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
                <a href="{{ route('vendor.dashboardvendor') }}" class="block text-gray-700 hover:text-red-500">📦 Dashboard</a>
                <a href="/myproducts" class="block text-gray-700 hover:text-red-500">🛍️ My Products</a>
                <a href="{{ route('vendor.add_product') }}" class="block text-red-700 font-semibold">➕ Add Products</a>
                <a href="#" class="block text-gray-700 hover:text-red-500">📋 Orders</a>
                <a href="#" class="block text-gray-700 hover:text-red-500">💬 Review</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 space-y-6">
            <!-- Header -->
            <div class="bg-red-500 text-white px-6 py-4 rounded-md shadow">
                <h2 class="text-xl font-bold">Add New Product</h2>
                <p class="text-sm">Fill in the product details to publish</p>
            </div>

            <!-- Form -->
            <form class="space-y-6 bg-white p-6 rounded shadow">

                <!-- Info Dasar -->
                <div class="border rounded-md">
                    <div class="bg-gray-100 px-4 py-2 flex items-center gap-2 border-b">
                        <span class="text-red-600 text-xl">📄</span>
                        <h3 class="font-semibold text-lg">Basic Product Information</h3>
                    </div>
                    <div class="p-4 space-y-4">
                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Category <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select class="appearance-none w-full bg-white border border-gray-300 rounded-md px-4 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-red-400">
                                    <option>Select Category</option>
                                    <option>Equipment</option>
                                    <option>Material</option>
                                    <option>Electrical Tools</option>
                                    <option>Cosumables</option>
                                    <option>PPE</option>
                                </select>
                                <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.58l3.71-4.35a.75.75 0 111.14.98l-4.25 5a.75.75 0 01-1.14 0l-4.25-5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Brand</label>
                            <input type="text" placeholder="Ex: Konecranes"
                                class="w-full border border-gray-300 rounded-md px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-red-400" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Supplier <span class="text-red-500">*</span></label>
                                <input type="text" placeholder="Ex: PT. ABC"
                                    class="w-full border border-gray-300 rounded-md px-4 py-2" />
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Product Name</label>
                                <input type="text" placeholder="Excavator, Scaffolding"
                                    class="w-full border border-gray-300 rounded-md px-4 py-2" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Spesifikasi -->
                <div class="border rounded-md">
                    <div class="bg-red-50 px-4 py-2 flex items-center gap-2 border-b">
                        <span class="text-red-600 text-xl">⚙️</span>
                        <h3 class="font-semibold text-lg">Specification & Stock</h3>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Specification</label>
                                <div class="relative">
                                    <select class="appearance-none w-full bg-white border border-gray-300 rounded-md px-4 py-2 pr-10">
                                        <option>Type A</option>
                                        <option>Type B</option>
                                    </select>
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.58l3.71-4.35a.75.75 0 111.14.98l-4.25 5a.75.75 0 01-1.14 0l-4.25-5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Custom Spec</label>
                                <input type="text" placeholder="Add specification"
                                    class="w-full border border-gray-300 rounded-md px-4 py-2" />
                            </div>
                        </div>

                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Quantity</label>
                            <input type="number" min="1" class="w-full border border-gray-300 rounded-md px-4 py-2" />
                        </div>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="border rounded-md">
                    <div class="bg-gray-100 px-4 py-2 flex items-center gap-2 border-b">
                        <span class="text-red-600 text-xl">📝</span>
                        <h3 class="font-semibold text-lg">Product Description</h3>
                    </div>
                    <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <textarea placeholder="Description..."
                            class="w-full border border-gray-300 rounded-md px-4 py-2" rows="4"></textarea>
                        <textarea placeholder="Address..."
                            class="w-full border border-gray-300 rounded-md px-4 py-2" rows="4"></textarea>
                    </div>
                </div>

                <!-- Gambar -->
                <div class="border rounded-md">
                    <div class="bg-red-50 px-4 py-2 flex items-center gap-2 border-b">
                        <span class="text-red-600 text-xl">🖼️</span>
                        <h3 class="font-semibold text-lg">Product Image</h3>
                    </div>
                    <div class="p-4">
                        <label for="productImage"
                            class="cursor-pointer border-2 border-dashed border-red-300 bg-white rounded-md flex flex-col items-center justify-center py-10 text-center text-gray-500 hover:border-red-500">
                            <svg class="w-10 h-10 mb-2 text-red-400" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <p>Drop images here or click to upload</p>
                            <input id="productImage" type="file" class="hidden" multiple accept="image/*" />
                        </label>
                    </div>
                </div>

                <!-- Tombol -->
                <div class="flex justify-end gap-4">
                    <button type="reset"
                        class="bg-gray-200 hover:bg-gray-300 text-red-600 font-semibold px-6 py-2 rounded-md">Reset</button>
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white font-semibold px-6 py-2 rounded-md">Save</button>
                </div>
            </form>
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-white text-center p-4 text-sm text-gray-500">
        © 2025 Trembesi Shop
    </footer>
</body>
</html>
