<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tambah Produk | Trembesi Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">
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
                <a href="{{ route('vendor.add_product') }}" class="block text-red-700 font-semibold">➕ Add Products</a>
                <a href="{{ route('vendor.orders') }}" class="block text-gray-700 hover:text-red-500">📋 Orders</a>
                <a href="#" class="block text-gray-700 hover:text-red-500">💬 Review</a>
            </nav>
        </aside>

        <main class="flex-1 p-6 space-y-6">
            <div class="bg-red-500 text-white px-6 py-4 rounded-md shadow">
                <h2 class="text-xl font-bold">Add New Product</h2>
                <p class="text-sm">Fill in the product details to publish</p>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('vendor.add_product.store') }}" enctype="multipart/form-data"
                class="space-y-6 bg-white p-6 rounded shadow">
                @csrf

                <div class="border rounded-md">
                    <div class="bg-gray-100 px-4 py-2 flex items-center gap-2 border-b">
                        <span class="text-red-600 text-xl">📄</span>
                        <h3 class="font-semibold text-lg">Basic Product Information</h3>
                    </div>
                    <div class="p-4 space-y-4">
                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Category <span
                                    class="text-red-500">*</span></label>
                            <select name="category" required class="w-full border border-gray-300 rounded-md px-4 py-2">
                                <option value="">Select Category</option>
                                <option>Equipment</option>
                                <option>Material</option>
                                <option>Electrical Tools</option>
                                <option>Consumables</option>
                                <option>Personal Protective Equipment</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Brand</label>
                            <input name="brand" type="text" placeholder="Ex: Magnaflux, Konecranes, Perkins..."
                                class="w-full border border-gray-300 rounded-md px-4 py-2" />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Supplier <span
                                        class="text-red-500">*</span></label>
                                <input name="supplier" type="text" placeholder="Ex: PT Supplier"
                                    class="w-full border border-gray-300 rounded-md px-4 py-2" required />
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Product Name <span
                                        class="text-red-500">*</span></label>
                                <input name="name" type="text" placeholder="Ex: PIPA SCAFFOLDING, Excavator"
                                    class="w-full border border-gray-300 rounded-md px-4 py-2" required />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border rounded-md">
                    <div class="bg-gray-100 px-4 py-2 flex items-center gap-2 border-b">
                        <span class="text-red-600 text-xl">⚙️</span>
                        <h3 class="font-semibold text-lg">Specification & Stock</h3>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Specification <span
                                        class="text-red-500">*</span></label>
                                <select name="specification" required
                                    class="w-full border border-gray-300 rounded-md px-4 py-2">
                                    <option value="">Select Specification</option>
                                    <option>Type A</option>
                                    <option>Type B</option>
                                </select>
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Unit <span
                                        class="text-red-500">*</span></label>
                                <input name="unit" type="text" placeholder="Ex: kg, meter"
                                    class="w-full border border-gray-300 rounded-md px-4 py-2" required />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Quantity <span
                                        class="text-red-500">*</span></label>
                                <input name="quantity" type="number" min="1" placeholder="Quantity"
                                    class="w-full border border-gray-300 rounded-md px-4 py-2" required />
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Price (Rp) <span
                                        class="text-red-500">*</span></label>
                                <input name="price" type="number" min="0" placeholder="Price"
                                    class="w-full border border-gray-300 rounded-md px-4 py-2" required />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border rounded-md">
                    <div class="bg-gray-100 px-4 py-2 flex items-center gap-2 border-b">
                        <span class="text-red-600 text-xl">📝</span>
                        <h3 class="font-semibold text-lg">Product Description</h3>
                    </div>
                    <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <textarea name="description" placeholder="Product Description..."
                            class="w-full border border-gray-300 rounded-md px-4 py-2" rows="4"></textarea>
                        <textarea name="address" placeholder="Address..." class="w-full border border-gray-300 rounded-md px-4 py-2"
                            rows="4"></textarea>
                    </div>
                </div>

                <div class="border rounded-md">
                    <div class="bg-gray-100 px-4 py-2 flex items-center gap-2 border-b">
                        <span class="text-red-600 text-xl">🖼️</span>
                        <h3 class="font-semibold text-lg">Product Image</h3>
                    </div>
                    <div class="p-4">
                        <label for="image_paths"
                            class="cursor-pointer border-2 border-dashed border-red-300 bg-white rounded-md flex flex-col items-center justify-center py-10 text-center text-gray-500 hover:border-red-500">
                            <svg class="w-10 h-10 mb-2 text-red-400" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <p>Drop images here or click to upload</p>
                            <p class="text-sm text-gray-400">Supports: JPG, PNG, GIF (Max 5MB each)</p>
                            <input id="image_paths" name="image_paths[]" type="file" class="hidden"
                                accept="image/*" multiple />
                        </label>
                        <div id="image-preview" class="mt-4 hidden">
                            <div id="preview-container" class="flex flex-wrap gap-2"></div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <button type="reset"
                        class="bg-gray-200 hover:bg-gray-300 text-red-600 font-semibold px-6 py-2 rounded-md">Reset</button>
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white font-semibold px-6 py-2 rounded-md">Save</button>
                </div>
            </form>
        </main>
    </div>

    <footer class="bg-white text-center p-4 text-sm text-gray-500">
        © 2025 Trembesi Shop
    </footer>

    <script>
        document.getElementById('image_paths').addEventListener('change', function(event) {
            const files = event.target.files;
            const previewContainer = document.getElementById('preview-container');
            previewContainer.innerHTML = '';
            if (files.length > 0) {
                Array.from(files).forEach(file => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.alt = 'Image Preview';
                            img.className = 'w-32 h-32 object-cover rounded border';
                            previewContainer.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    }
                });
                document.getElementById('image-preview').classList.remove('hidden');
            } else {
                document.getElementById('image-preview').classList.add('hidden');
            }
        });
    </script>
</body>

</html>
