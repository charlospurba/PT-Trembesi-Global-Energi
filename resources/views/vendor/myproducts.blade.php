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
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Product List</h3>
                        <p class="text-sm text-gray-600">Manage and view your products</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <select id="sortSelect"
                            class="border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 min-w-48">
                            <option value="">All Products</option>
                            <option value="material">Material</option>
                            <option value="equipment">Equipment</option>
                            <option value="electrical tools">Electrical Tools</option>
                            <option value="consumables">Consumables</option>
                            <option value="personal protective equipment">Personal Protective Equipment</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="productGrid">
                    @forelse ($products as $product)
                        @php
                            // Debug invalid image_paths
                            if (!empty($product->image_paths) && !is_array($product->image_paths)) {
                                \Illuminate\Support\Facades\Log::warning('Invalid image_paths for product', [
                                    'product_id' => $product->id,
                                    'image_paths' => $product->image_paths,
                                    'type' => gettype($product->image_paths),
                                ]);
                            }
                        @endphp
                        <div class="border rounded-lg p-4 hover:shadow-md transition-shadow product-item"
                            data-name="{{ $product->name }}" data-category="{{ $product->category }}"
                            data-created-at="{{ $product->created_at->timestamp }}">
                            @if (!empty($product->image_paths) && is_array($product->image_paths) && !empty($product->image_paths[0]))
                                <img src="{{ asset('storage/' . $product->image_paths[0]) }}" alt="{{ $product->name }}"
                                    class="w-24 h-24 object-cover rounded mx-auto mb-4" />
                            @else
                                <img src="https://via.placeholder.com/150" alt="{{ $product->name }}"
                                    class="w-24 h-24 object-cover rounded mx-auto mb-4" />
                            @endif
                            <a href="{{ route('vendor.product_detail', $product->id) }}"
                                class="text-lg font-semibold text-red-600 hover:text-red-800">{{ $product->name }}</a>
                            <p class="text-gray-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <div class="mt-4 flex justify-between gap-4">
                                <a href="{{ route('vendor.edit_product', $product->id) }}"
                                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-1 py-1 rounded-md transition-colors duration-200 text-center">
                                    Edit
                                </a>
                                <button type="button"
                                    class="delete-product flex-1 bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-1 py-1 rounded-md transition-colors duration-200"
                                    data-id="{{ $product->id }}"
                                    data-url="{{ route('vendor.destroy_product', $product->id) }}">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.delete-product').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-id');
                const deleteUrl = this.getAttribute('data-url');
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
                        fetch(deleteUrl, {
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
                                    Swal.fire('Error!', data.message ||
                                        'Failed to delete the product.', 'error');
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
            const productItems = Array.from(document.querySelectorAll('.product-item'));

            if (sortValue === 'newest' || sortValue === 'oldest') {
                productItems.sort((a, b) => {
                    const timeA = parseInt(a.getAttribute('data-created-at'));
                    const timeB = parseInt(b.getAttribute('data-created-at'));
                    return sortValue === 'newest' ? timeB - timeA : timeA - timeB;
                });
                const productGrid = document.getElementById('productGrid');
                productItems.forEach(item => productGrid.appendChild(item));
            } else {
                productItems.forEach(item => {
                    const category = item.getAttribute('data-category').toLowerCase();
                    item.style.display = (sortValue === '' || category === sortValue) ? 'block' : 'none';
                });
            }
        });
    </script>
@endpush
