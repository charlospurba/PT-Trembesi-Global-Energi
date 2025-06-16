<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Produk | Trembesi Shop</title>
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
                <h2 class="text-xl font-bold">Edit Product</h2>
                <p class="text-sm">Update the product details below</p>
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

            <form method="POST" action="{{ route('vendor.update_product', $product->id) }}"
                enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded shadow">
                @csrf
                @method('PUT')

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
                                <option value="Equipment"
                                    {{ old('category', $product->category) == 'Equipment' ? 'selected' : '' }}>Equipment
                                </option>
                                <option value="Material"
                                    {{ old('category', $product->category) == 'Material' ? 'selected' : '' }}>Material
                                </option>
                                <option value="Electrical Tools"
                                    {{ old('category', $product->category) == 'Electrical Tools' ? 'selected' : '' }}>
                                    Electrical Tools</option>
                                <option value="Consumables"
                                    {{ old('category', $product->category) == 'Consumables' ? 'selected' : '' }}>
                                    Consumables</option>
                                <option value="Personal Protective Equipment"
                                    {{ old('category', $product->category) == 'Personal Protective Equipment' ? 'selected' : '' }}>
                                    Personal Protective Equipment</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Brand (optional)</label>
                            <input name="brand" type="text" value="{{ old('brand', $product->brand) }}"
                                placeholder="Ex: Magnaflux, Konecranes, Perkins..."
                                class="w-full border border-gray-300 rounded-md px-4 py-2" />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Fabric/Supplier <span
                                        class="text-red-500">*</span></label>
                                <input name="supplier" type="text" value="{{ old('supplier', $product->supplier) }}"
                                    placeholder="Ex: Surya Patria Crane, PT Konecranes Material Handling Indonesia"
                                    class="w-full border border-gray-300 rounded-md px-4 py-2" required />
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Product Name <span
                                        class="text-red-500">*</span></label>
                                <input name="name" type="text" value="{{ old('name', $product->name) }}"
                                    placeholder="Ex: PIPA SCAFFOLDING, Excavator"
                                    class="w-full border border-gray-300 rounded-md px-4 py-2" required />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border rounded-md">
                    <div class="bg-red-50 px-4 py-2 flex items-center gap-2 border-b">
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
                                    <option value="Type A"
                                        {{ old('specification', $product->specification) == 'Type A' ? 'selected' : '' }}>
                                        Type A</option>
                                    <option value="Type B"
                                        {{ old('specification', $product->specification) == 'Type B' ? 'selected' : '' }}>
                                        Type B</option>
                                </select>
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Unit <span
                                        class="text-red-500">*</span></label>
                                <input name="unit" type="text" value="{{ old('unit', $product->unit) }}"
                                    placeholder="Ex: Surya Patria Crane, PT Konecranes Material Handling Indonesia"
                                    class="w-full border border-gray-300 rounded-md px-4 py-2" required />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Quantity <span
                                        class="text-red-500">*</span></label>
                                <input name="quantity" type="number" min="1"
                                    value="{{ old('quantity', $product->quantity) }}"
                                    placeholder="Ex: Magnaflux, Konecranes, Perkins..."
                                    class="w-full border border-gray-300 rounded-md px-4 py-2" required />
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Price (Rp) <span
                                        class="text-red-500">*</span></label>
                                <input name="price" type="number" min="0"
                                    value="{{ old('price', $product->price) }}"
                                    placeholder="Ex: PIPA SCAFFOLDING, Excavator"
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
                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Product Description</label>
                            <textarea name="description" placeholder="Product Description..."
                                class="w-full border border-gray-300 rounded-md px-4 py-2" rows="4">{{ old('description', $product->description) }}</textarea>
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Address</label>
                            <textarea name="address" placeholder="Address..." class="w-full border border-gray-300 rounded-md px-4 py-2"
                                rows="4">{{ old('address', $product->address) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="border rounded-md">
                    <div class="bg-red-50 px-4 py-2 flex items-center gap-2 border-b">
                        <span class="text-red-600 text-xl">🖼️</span>
                        <h3 class="font-semibold text-lg">Product Image</h3>
                    </div>
                    <div class="p-4">
                        @if ($product->image_paths && is_array($product->image_paths))
                            <div class="mb-4" id="current-image-container">
                                <p class="text-gray-600 mb-2">Current Images:</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($product->image_paths as $index => $imagePath)
                                        <div class="relative inline-block">
                                            <img src="{{ asset('storage/' . $imagePath) }}"
                                                alt="Current Product Image" class="max-w-xs h-auto rounded-md"
                                                style="max-height: 200px;" />
                                            <button type="button"
                                                class="remove-image absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600"
                                                data-index="{{ $index }}">×</button>
                                        </div>
                                    @endforeach
                                </div>
                                <input type="hidden" name="remove_image" id="remove-image-input" value="0" />
                            </div>
                        @endif
                        <label for="image_paths"
                            class="cursor-pointer border-2 border-dashed border-red-300 bg-white rounded-md flex flex-col items-center justify-center py-10 text-center text-gray-500 hover:border-red-500">
                            <svg class="w-10 h-10 mb-2 text-red-400" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <p>Drop new images here or click to upload</p>
                            <p class="text-sm text-gray-400">Supports: JPG, PNG, GIF (Max 5MB each)</p>
                            <p class="text-sm text-gray-400">Recommended size: 800x800px or higher</p>
                            <input id="image_paths" name="image_paths[]" type="file" class="hidden"
                                accept="image/*" multiple />
                        </label>
                        <div id="image-preview" class="mt-4 hidden">
                            <p class="text-gray-600 mb-2">Image Preview:</p>
                            <div id="preview-container" class="flex flex-wrap gap-2"></div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('vendor.myproducts') }}"
                        class="bg-gray-200 hover:bg-gray-300 text-red-600 font-semibold px-6 py-2 rounded-md">Cancel</a>
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white font-semibold px-6 py-2 rounded-md">Update</button>
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
            if (files) {
                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = 'Image Preview';
                        img.className = 'max-w-xs h-auto rounded-md';
                        previewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
                document.getElementById('image-preview').classList.remove('hidden');
            }
        });

        document.querySelectorAll('.remove-image').forEach(button => {
            button.addEventListener('click', function() {
                const index = this.getAttribute('data-index');
                const currentImageContainer = document.getElementById('current-image-container');
                const removeImageInput = document.getElementById('remove-image-input');
                removeImageInput.value = '1'; // Mark for removal
                this.parentElement.remove(); // Remove image from display
            });
        });
    </script>
</body>

</html>
