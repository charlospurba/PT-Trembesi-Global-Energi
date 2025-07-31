@extends('layouts.app')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @include('components.procnav')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-red-50 to-rose-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <nav class="flex items-center space-x-2 text-sm mb-6 px-4 py-3 rounded-xl shadow-lg bg-white/95 backdrop-blur">
                <a href="{{ route('procurement.dashboardproc') }}"
                    class="flex items-center text-gray-600 hover:text-red-600 transition-all duration-300">
                    <i class="fas fa-home mr-2"></i>Dashboard
                </a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <a href="{{ route('procurement.notes') }}"
                    class="text-gray-600 hover:text-red-600 transition-all duration-300">Procurement Notes</a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span class="text-red-600 font-semibold">Search Results</span>
            </nav>

            <div class="bg-white rounded-2xl shadow-xl p-6 mb-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">
                    <i class="fas fa-search mr-2 text-red-600"></i>
                    Search Results for "{{ $query }}"
                </h1>
                <p class="text-gray-600 text-sm">Procurement Note ID: {{ $note_id ?? 'N/A' }}</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @if (count($products) > 0)
                    @foreach ($products as $product)
                        <div
                            class="bg-white rounded-2xl shadow-xl p-4 flex flex-col transform transition-all duration-300 hover:scale-105">
                            {{-- MODIFIED: Ensure note_id is passed to the product detail page --}}
                            <a
                                href="{{ route('product.detail', $product->id) }}@if (isset($note_id) && $note_id) ?note_id={{ $note_id }} @endif">
                                <img src="{{ !empty($product->image_paths) && is_array($product->image_paths) ? asset('storage/' . $product->image_paths[0]) : 'https://via.placeholder.com/200x200/dc2626/ffffff?text=Product' }}"
                                    alt="{{ $product->name }}" class="w-full h-48 object-contain rounded-lg mb-4">
                            </a>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                    {{-- MODIFIED: Ensure note_id is passed to the product detail page --}}
                                    <a href="{{ route('product.detail', $product->id) }}@if (isset($note_id) && $note_id) ?note_id={{ $note_id }} @endif"
                                        class="hover:text-red-600 transition-all duration-300">
                                        {{ Str::limit($product->name, 50) }}
                                    </a>
                                </h3>
                                <p class="text-sm text-gray-600 mb-2">Supplier: {{ $product->supplier ?? 'N/A' }}</p>
                                <p class="text-lg font-bold text-red-600 mb-2">
                                    Rp{{ number_format($product->price, 0, ',', '.') }}
                                </p>
                                <div class="flex items-center mb-2">
                                    <div class="flex text-yellow-400 mr-2 text-sm">
                                        @php
                                            $averageRating = $product->average_rating ?? 0;
                                            $fullStars = floor($averageRating);
                                            $halfStar = $averageRating - $fullStars >= 0.5;
                                        @endphp
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $fullStars)
                                                <i class="fas fa-star"></i>
                                            @elseif ($halfStar && $i == $fullStars + 1)
                                                <i class="fas fa-star-half-alt"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-sm text-gray-600">
                                        {{ $averageRating > 0 ? number_format($averageRating, 1) : 'No Ratings' }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                {{-- MODIFIED: Ensure note_id is passed to the product detail page --}}
                                <a href="{{ route('product.detail', $product->id) }}@if (isset($note_id) && $note_id) ?note_id={{ $note_id }} @endif"
                                    class="text-red-600 hover:text-red-800 transition-all duration-300">
                                    <i class="fas fa-eye mr-1"></i> View Details
                                </a>
                                <button type="button"
                                    onclick="addToCart({{ $product->id }}, {{ json_encode($note_id) }})"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-300">
                                    <i class="fas fa-cart-plus mr-2"></i>
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-full text-center py-10">
                        <i class="fas fa-search text-5xl text-gray-400 mb-4"></i>
                        <p class="text-lg text-gray-600">No products found matching your search.</p>
                        <a href="{{ route('procurement.notes') }}"
                            class="inline-flex items-center px-4 py-2 mt-4 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-300">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Procurement Notes
                        </a>
                    </div>
                @endif
            </div>

            @if ($products->hasPages())
                <div class="mt-6 flex justify-center">
                    {{ $products->appends(['query' => $query, 'note_id' => $note_id ?? null])->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>

    <script>
        function addToCart(productId, noteId) {
            // Convert noteId to a number if it's not null or 'null' string, otherwise keep it as null
            const finalNoteId = (noteId !== null && noteId !== 'null' && !isNaN(parseInt(noteId))) ? parseInt(noteId) :
            null;

            if (!finalNoteId) { // Check if it's truly null or 0 (after parsing)
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Adding to cart is only allowed from a procurement note. Please ensure a valid note ID is present.',
                    confirmButtonColor: '#dc2626'
                });
                return;
            }

            const quantity = 1; // Default quantity, can be modified as needed

            fetch('{{ route('cart.add', ':id') }}'.replace(':id', productId), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        quantity: quantity,
                        note_id: finalNoteId // Use the corrected finalNoteId here
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateCartBadge(data.cart_count);
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message,
                            timer: 1500, // Durasi pop-up 1.5 detik
                            showConfirmButton: false,
                            willClose: () => {
                                // Redirect ke halaman keranjang setelah pop-up hilang
                                window.location.href = '{{ route('procurement.cart') }}';
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message,
                            confirmButtonColor: '#dc2626'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to add to cart. ' + error.message,
                        confirmButtonColor: '#dc2626'
                    });
                });
        }

        function updateCartBadge(count) {
            let badge = document.getElementById('cartBadge');
            if (badge) {
                badge.textContent = count;
                badge.style.display = count > 0 ? 'inline-block' : 'none';
                badge.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    badge.style.transform = 'scale(1)';
                }, 200);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Apply glass effect
            const glassElements = document.querySelectorAll('.bg-white');
            glassElements.forEach(element => {
                element.style.backdropFilter = 'blur(10px)';
                element.style.background = 'rgba(255, 255, 255, 0.95)';
                element.style.border = '1px solid rgba(255, 255, 255, 0.2)';
            });

            // Apply floating animation
            const floatingCards = document.querySelectorAll('.bg-white');
            floatingCards.forEach(card => {
                let direction = 1;
                let position = 0;
                setInterval(() => {
                    position += direction * 0.5;
                    if (position >= 5 || position <= -5) {
                        direction *= -1;
                    }
                    card.style.transform = `translateY(${position}px)`;
                }, 50);
            });
        });
    </script>
@endsection
