@extends('layouts.app')

@push('styles')
<style>
    select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: none;
    }
</style>
@endpush

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">

    <!-- Header -->
    <div class="bg-red-500 text-white px-6 py-4 rounded-md shadow mb-6">
        <h2 class="text-xl font-bold">Add New Product</h2>
        <p class="text-sm">Fill in the product details for marketplace listing</p>
    </div>

    <form class="space-y-6 bg-white p-6 rounded shadow">

        <!-- Basic Product Information -->
        <div class="border rounded-md">
            <div class="bg-gray-100 px-4 py-2 flex items-center gap-2 border-b">
                <span class="text-red-600 text-xl">❗</span>
                <h3 class="font-semibold text-lg">Basic Product Information</h3>
            </div>
            <div class="p-4 space-y-4">

                <!-- Category -->
                <div>
                    <label class="block font-semibold text-gray-800 mb-1">Category <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select
                            class="appearance-none w-full bg-white border border-gray-300 rounded-md px-4 py-2 pr-10 text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-red-400">
                            <option>Select Category</option>
                            <option>Equipment</option>
                            <option>Material</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">
                            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.584l3.71-4.355a.75.75 0 111.14.976l-4.25 5a.75.75 0 01-1.14 0l-4.25-5a.75.75 0 01.02-1.06z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Brand -->
                <div>
                    <label class="block font-semibold text-gray-800 mb-1">Brand <span class="text-gray-500 text-sm">(optional)</span></label>
                    <input type="text"
                        class="w-full border border-gray-300 rounded-md px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-red-400"
                        placeholder="Ex: Magnaflux, Konecranes, Perkins..." />
                </div>

                <!-- Supplier & Product Name -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-gray-800 mb-1">Fabric/Supplier <span class="text-red-500">*</span></label>
                        <input type="text" class="w-full border border-gray-300 rounded-md px-4 py-2 shadow-sm"
                            placeholder="Ex: PT. Konecranes Indonesia" />
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-800 mb-1">Product Name</label>
                        <input type="text" class="w-full border border-gray-300 rounded-md px-4 py-2 shadow-sm"
                            placeholder="Ex: PRIA SCAFFOLDING, Excavator" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Specification & Stock -->
        <div class="border rounded-md">
            <div class="bg-red-50 px-4 py-2 flex items-center gap-2 border-b">
                <span class="text-red-600 text-xl">🛠️</span>
                <h3 class="font-semibold text-lg">Specification & Stock</h3>
            </div>
            <div class="p-4 space-y-4">

                <!-- Specification -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-gray-800 mb-1">Specification <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select class="appearance-none w-full bg-white border border-gray-300 rounded-md px-4 py-2 pr-10 shadow-sm focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-red-400">
                                <option>Type</option>
                                <option>Heavy Duty</option>
                                <option>Medium</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">
                                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.584l3.71-4.355a.75.75 0 111.14.976l-4.25 5a.75.75 0 01-1.14 0l-4.25-5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-800 mb-1 invisible">Label</label>
                        <input type="text" class="w-full border border-gray-300 rounded-md px-4 py-2 shadow-sm"
                            placeholder="Add Specification" />
                    </div>
                </div>

                <!-- Quantity -->
                <div>
                    <label class="block font-semibold text-gray-800 mb-1">Quantity <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select class="appearance-none w-full bg-white border border-gray-300 rounded-md px-4 py-2 pr-10 shadow-sm focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-red-400">
                            <option>10</option>
                            <option>50</option>
                            <option>100</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">
                            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.584l3.71-4.355a.75.75 0 111.14.976l-4.25 5a.75.75 0 01-1.14 0l-4.25-5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="border rounded-md">
            <div class="bg-gray-100 px-4 py-2 flex items-center gap-2 border-b">
                <span class="text-red-600 text-xl">📝</span>
                <h3 class="font-semibold text-lg">Product Description</h3>
            </div>
            <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold text-gray-800 mb-1">Product Description</label>
                    <textarea class="w-full border border-gray-300 rounded-md px-4 py-2 shadow-sm" rows="4"></textarea>
                </div>
                <div>
                    <label class="block font-semibold text-gray-800 mb-1">Address</label>
                    <textarea class="w-full border border-gray-300 rounded-md px-4 py-2 shadow-sm" rows="4"></textarea>
                </div>
            </div>
        </div>

        <!-- Image Upload -->
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
                    <p class="text-sm mt-1">Supports: JPG, PNG, GIF (Max 5MB each)</p>
                    <p class="text-xs text-gray-400">Recommended size: 800x800px or higher</p>
                    <input id="productImage" name="productImage" type="file" class="hidden" multiple
                        accept="image/*" />
                </label>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex justify-end gap-4">
            <button type="reset"
                class="bg-gray-200 hover:bg-gray-300 text-red-600 font-semibold px-6 py-2 rounded-md">Reset</button>
            <button type="submit"
                class="bg-red-500 hover:bg-red-600 text-white font-semibold px-6 py-2 rounded-md">Save</button>
        </div>

    </form>
</div>
@endsection
