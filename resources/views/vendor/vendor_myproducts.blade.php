@extends('layouts.app')

@section('content')
    @include('components.navvendor')

    <div class="flex min-h-screen">
        @include('components.sidevendor')
        <main class="flex-1 p-6 space-y-6">
            <div class="bg-red-500 text-white px-6 py-4 rounded-md shadow">
                <h2 class="text-xl font-bold">My Products</h2>
                <p class="text-sm">Manage your product listings here</p>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

<div class="bg-white p-6 rounded shadow">
                <!-- Header section with filter on the right -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Product List</h3>
                        <p class="text-sm text-gray-600">Manage and view your products</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <select id="sortSelect"
                            class="border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 min-w-48">
                            <option value="">All Products</option>
                            <option value="Material">Material</option>
                            <option value="Equipment">Equipment</option>
                            <option value="Electrical Tools">Electrical Tools</option>
                            <option value="Consumables">Consumables</option>
                            <option value="Personal Protective Equipment">Personal Protective Equipment</option>
                        </select>
                    </div>
                </div>

                <!-- Product Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="productGrid">
                    @forelse ($products as $product)
                        <div class="border rounded-lg p-4 hover:shadow-md transition-shadow product-item"
                            data-name="{{ $product->name }}" data-category="{{ $product->category }}">
                            @if ($product->image_paths && is_array($product->image_paths) && count($product->image_paths) > 0)
                                <img src="{{ asset('storage/' . $product->image_paths[0]) }}" alt="{{ $product->name }}"
                                    class="w-24 h-24 object-cover rounded mx-auto mb-4" />
                            @else
                                <img src="https://via.placeholder.com/150" alt="{{ $product->name }}"
                                    class="w-24 h-24 object-cover rounded mx-auto mb-4" />
                            @endif
                            <a href="{{ route('vendor.product_detail', $product->id) }}"
                                class="text-lg font-semibold text-red-600 hover:text-red-800">{{ $product->name }}</a>
                            <p class="text-gray-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <div class="mt-4 flex justify-between">
                                <a href="{{ route('vendor.edit_product', $product->id) }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1 rounded">Edit</a>
                                <button type="button"
                                    class="delete-product bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1 rounded"
                                    data-id="{{ $product->id }}">
                                    Delete
                                </button>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500">No products available.</p>
                    @endforelse
                </div>
            </div>
        </main>
    </div>

    <footer class="bg-white text-center p-4 text-sm text-gray-500">
        © 2025 Trembesi Shop
    </footer>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.delete-product').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you really want to delete this product? This process cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#FF0000',
                    cancelButtonColor: '#1361F2',
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`{{ route('vendor.destroy_product', '') }}/${productId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json',
                                },
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire('Deleted!', 'The product has been deleted.',
                                            'success')
                                        .then(() => location.reload());
                                } else {
                                    Swal.fire('Error!', 'Failed to delete the product.',
                                        'error');
                                }
                            })
                            .catch(error => {
                                Swal.fire('Error!', 'An unexpected error occurred.', 'error');
                                console.error('Error:', error);
                            });
                    }
                });
            });
        });

        document.getElementById('sortSelect').addEventListener('change', function(e) {
            const sortValue = e.target.value.toLowerCase();
            document.querySelectorAll('.product-item').forEach(item => {
                const category = item.getAttribute('data-category').toLowerCase();
                if (sortValue === '' || category.includes(sortValue)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
@endpush
