@extends('layouts.app')

@section('content')
    @include('components.navvendor')

    <div class="flex min-h-screen">
        @include('components.sidevendor')
        <main class="flex-1 p-6 space-y-6">
            <div class="bg-red-500 text-white px-6 py-4 rounded-md shadow">
                <h2 class="text-xl font-bold">Add Product</h2>
                <p class="text-sm">Fill in the product details below</p>
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

            <form method="POST" action="{{ route('vendor.store_product') }}" enctype="multipart/form-data"
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
                            <select name="category" required
                                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-red-500 focus:border-red-500">
                                <option value="" {{ old('category') == '' ? 'selected' : '' }}>Select Category
                                </option>
                                <option value="material" {{ old('category') == 'material' ? 'selected' : '' }}>Material
                                </option>
                                <option value="equipment" {{ old('category') == 'equipment' ? 'selected' : '' }}>Equipment
                                </option>
                                <option value="electrical tools" {{ old('category') == 'electrical tools' ? 'selected' : '' }}>
                                    Electrical Tools</option>
                                <option value="consumables" {{ old('category') == 'consumables' ? 'selected' : '' }}>
                                    Consumables</option>
                                <option value="personal protective equipment" {{ old('category') == 'personal protective equipment' ? 'selected' : '' }}>
                                    Personal Protective Equipment</option>
                            </select>
                            @error('category')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Brand</label>
                            <input name="brand" type="text" value="{{ old('brand') }}"
                                placeholder="Ex: Magnaflux, Konecranes, Perkins..."
                                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-red-500 focus:border-red-500" />
                            @error('brand')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Supplier <span
                                        class="text-red-500">*</span></label>
                                <input name="supplier" type="text" value="{{ old('supplier', Auth::user()->name) }}"
                                    class="w-full border border-gray-300 rounded-md px-4 py-2 bg-gray-100 focus:ring-red-500 focus:border-red-500"
                                    readonly required />
                                @error('supplier')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Product Name <span
                                        class="text-red-500">*</span></label>
                                <input name="name" type="text" value="{{ old('name') }}"
                                    placeholder="Ex: PIPA SCAFFOLDING, Excavator"
                                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-red-500 focus:border-red-500"
                                    required />
                                @error('name')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
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
                                <label class="block font-semibold text-gray-800 mb-1">Specification</label>
                                <input name="specification" type="text" value="{{ old('specification') }}"
                                    placeholder="Ex: Type A, 1-inch diameter"
                                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-red-500 focus:border-red-500" />
                                @error('specification')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Unit <span
                                        class="text-red-500">*</span></label>
                                <input name="unit" type="text" value="{{ old('unit') }}" placeholder="Ex: kg, meter"
                                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-red-500 focus:border-red-500"
                                    required />
                                @error('unit')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Quantity <span
                                        class="text-red-500">*</span></label>
                                <input name="quantity" type="number" value="{{ old('quantity') }}" min="0"
                                    placeholder="Quantity"
                                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-red-500 focus:border-red-500"
                                    required />
                                @error('quantity')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-800 mb-1">Price (Rp) <span
                                        class="text-red-500">*</span></label>
                                <input name="price" type="number" value="{{ old('price') }}" min="0" step="0.01"
                                    placeholder="Price"
                                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-red-500 focus:border-red-500"
                                    required />
                                @error('price')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
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
                            <label class="block font-semibold text-gray-800 mb-1">Description</label>
                            <textarea name="description" placeholder="Product Description..."
                                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-red-500 focus:border-red-500" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-800 mb-1">Address</label>
                            <textarea name="address" placeholder="Address..."
                                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-red-500 focus:border-red-500"
                                rows="4">{{ old('address') }}</textarea>
                            @error('address')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="border rounded-md">
                    <div class="bg-gray-100 px-4 py-2 flex items-center gap-2 border-b">
                        <span class="text-red-600 text-xl">🖼️</span>
                        <h3 class="font-semibold text-lg">Product Image</h3>
                    </div>
                    <div class="p-4">
                        <label for="images"
                            class="cursor-pointer border-2 border-dashed border-red-300 bg-white rounded-md flex flex-col items-center justify-center py-10 text-center text-gray-500 hover:border-red-500">
                            <svg class="w-6 h-6 mb-2 text-red-400" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <p>Drop images here or click to upload</p>
                            <p class="text-sm text-gray-400">Supports: JPG, PNG, GIF (Max 2MB each)</p>
                            <input id="images" name="images[]" type="file" class="hidden" accept="image/*"
                                multiple />
                        </label>
                        @error('images.*')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        <div id="image-preview" class="mt-4 hidden">
                            <div id="preview-container" class="flex flex-wrap gap-2"></div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('vendor.myproducts') }}"
                        class="bg-gray-200 hover:bg-gray-300 text-red-600 font-semibold px-6 py-2 rounded-md">Cancel</a>
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white font-semibold px-6 py-2 rounded-md">Add
                        Product</button>
                </div>
            </form>

            <div class="border rounded-md mt-10 bg-white">
                <div class="bg-gray-100 px-4 py-2 flex items-center gap-2 border-b">
                    <span class="text-red-600 text-xl">📂</span>
                    <h3 class="font-semibold text-lg">Upload Produk Massal via Excel + ZIP Gambar</h3>
                </div>
                <div class="p-4">
                    <div class="text-right mb-4">
                        <a href="{{ asset('templates/template-produk.xlsx') }}"
                            class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-semibold text-sm"
                            download>
                            Download Template Excel
                        </a>
                    </div>

                    <form action="{{ route('vendor.upload_bulk_with_images') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-4">
                        @csrf
                        <div>
                            <label class="font-semibold block mb-1">Excel File</label>
                            <input type="file" name="excel_file" accept=".xlsx,.xls" required
                                class="w-full border px-4 py-2 rounded" />
                            <p class="text-xs text-gray-500 italic mt-2">
                                * Fill in all required columns in the Excel file and make sure the image file names match
                                the names listed in the Zip file.
                            </p>
                        </div>
                        <div>
                            <label class="font-semibold block mb-1">ZIP Image File</label>
                            <input type="file" name="zip_file" accept=".zip" required
                                class="w-full border px-4 py-2 rounded" />
                            <p class="text-xs text-gray-500 italic mt-2">
                                * Compress all product images into a ZIP file. Each image file name must match the name
                                specified in the Excel sheet.
                            </p>
                        </div>
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded font-semibold">
                            Upload Products
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <footer class="bg-white text-center p-4 text-sm text-gray-500">
        © 2025 Trembesi Shop
    </footer>

    @push('scripts')
        <script>
            document.getElementById('images').addEventListener('change', function(event) {
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

            document.querySelector('form').addEventListener('submit', function() {
                const files = document.getElementById('images').files;
                console.log('Files selected for submission:', files.length, Array.from(files).map(f => ({
                    name: f.name,
                    size: f.size,
                    type: f.type
                })));
            });
        </script>
    @endpush
@endsection