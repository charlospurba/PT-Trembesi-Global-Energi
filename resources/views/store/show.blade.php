@extends('layouts.app')

@section('content')
    <!-- Include Navbar Component -->
    @include('components.navbar')

    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-red-50 to-rose-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <!-- Compact Breadcrumb -->
            <nav class="flex items-center space-x-2 text-xs mb-4 glass-effect px-4 py-2 rounded-xl shadow-lg">
                <a href="{{ route('procurement.dashboardproc') }}"
                    class="flex items-center text-gray-600 hover:text-red-600 transition-all duration-300">
                    <i class="fas fa-home mr-1"></i>Dashboard
                </a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <a href="{{ route('procurement.material') }}"
                    class="text-gray-600 hover:text-red-600 transition-all duration-300">Material</a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span class="text-red-600 font-semibold">{{ $store->name }}</span>
            </nav>

            <!-- Store Header Section -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border-l-4 border-red-600">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <!-- Store Logo/Avatar -->
                    @php
                        $profilePicture = $store->profile_picture
                            ? asset('storage/profile_picture/' . $store->profile_picture)
                            : asset('assets/images/default-profile.png');
                    @endphp
                    <div
                        class="w-24 h-24 bg-gradient-to-r from-red-600 to-red-700 rounded-2xl overflow-hidden shadow-lg border-4 border-white">
                        <img src="{{ $profilePicture }}" alt="Profile" class="w-full h-full object-cover">
                    </div>

                    <!-- Store Info -->
                    <div class="flex-1 text-center md:text-left">
                        <h1 class="text-4xl font-bold text-gray-800 mb-2">{{ $store->name }}</h1>
                        <p class="text-gray-600 mb-3">Premium quality materials and supplies</p>
                        <div class="flex flex-wrap justify-center md:justify-start items-center gap-4 text-sm">
                            <div class="flex items-center bg-yellow-50 px-3 py-1 rounded-full review-data">
                                <span class="text-yellow-500 mr-1">★</span>
                                <span class="font-medium text-gray-700" id="average-rating">{{ $averageRating }}
                                    ({{ $totalReviews }} reviews)</span>
                            </div>
                            <div class="flex items-center bg-blue-50 px-3 py-1 rounded-full">
                                <i class="fas fa-box text-blue-500 mr-1"></i>
                                <span class="font-medium text-gray-700">{{ $totalProducts }} Products</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Header with Filters -->
            <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Products from {{ $store->name }}</h2>
                        <p class="text-sm text-gray-500 mt-1">Discover high-quality materials and supplies</p>
                    </div>

                    <!-- Filter Controls -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                        <!-- Products per page selector -->
                        <div class="flex items-center gap-2">
                            <label class="text-sm text-gray-600 whitespace-nowrap">Show:</label>
                            <form method="GET" action="{{ request()->url() }}" class="inline">
                                @foreach (request()->except('per_page') as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                                <select name="per_page" onchange="this.form.submit()"
                                    class="text-sm border border-gray-200 rounded px-2 py-1 focus:border-red-300 focus:ring-1 focus:ring-red-200">
                                    <option value="12" {{ request('per_page', 12) == 12 ? 'selected' : '' }}>12
                                    </option>
                                    <option value="24" {{ request('per_page') == 24 ? 'selected' : '' }}>24</option>
                                    <option value="36" {{ request('per_page') == 36 ? 'selected' : '' }}>36</option>
                                    <option value="48" {{ request('per_page') == 48 ? 'selected' : '' }}>48</option>
                                </select>
                            </form>
                        </div>

                        <!-- Status indicator -->
                        <div class="flex items-center gap-2 bg-gray-100 px-4 py-2 rounded-full">
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                            <span class="text-sm text-gray-600 font-medium">{{ $products->total() }} Products
                                Available</span>
                        </div>
                    </div>
                </div>
            </div>

            @if ($products->count() > 0)
                <!-- Products Count Info -->
                <div class="mb-6">
                    <div class="bg-white rounded-lg shadow-sm p-3 border-l-4 border-red-600">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                            <p class="text-gray-700 font-medium">
                                <i class="fas fa-cube text-red-600 mr-2"></i>
                                Showing {{ $products->firstItem() }} - {{ $products->lastItem() }} of
                                {{ $products->total() }} products
                            </p>

                            @if ($products->hasPages())
                                <div class="text-sm text-gray-500">
                                    Page {{ $products->currentPage() }} of {{ $products->lastPage() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Product Grid - Matching Material Card Style -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
                    @foreach ($products as $product)
                        <a href="{{ route('product.detail', $product->id) }}" class="block group">
                            <div
                                class="bg-white rounded-lg overflow-hidden w-full transition-all duration-300 shadow-[0_1px_4px_rgba(220,38,38,0.2)] hover:shadow-[0_4px_12px_rgba(220,38,38,0.3)] hover:-translate-y-1 border border-gray-100">

                                <!-- Responsive Image Container -->
                                <div class="w-full aspect-square bg-gray-50 overflow-hidden relative">
                                    @if (!empty($product->image_paths) && is_array($product->image_paths) && !empty($product->image_paths[0]))
                                        <img src="{{ asset('storage/' . $product->image_paths[0] . '?' . time()) }}"
                                            alt="{{ $product->name }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                            loading="lazy" />
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif

                                    <!-- Stock status badge -->
                                    @if ($product->quantity && $product->quantity < 10)
                                        <div
                                            class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                            Low Stock
                                        </div>
                                    @endif
                                </div>

                                <!-- Content -->
                                <div class="p-2 space-y-1">
                                    <!-- Store Badge -->
                                    <span
                                        class="inline-block px-1.5 py-0.5 bg-gray-100 text-gray-700 text-xs rounded font-medium">
                                        {{ $store->name }}
                                    </span>

                                    <!-- Product Name (Red) -->
                                    <h3 class="text-xs font-semibold text-red-600 line-clamp-2 leading-tight">
                                        {{ $product->name }}</h3>

                                    <!-- Price -->
                                    <p class="text-gray-900 font-bold text-sm">
                                        Rp{{ number_format($product->price, 0, ',', '.') }}</p>

                                    <!-- Description -->
                                    @if ($product->description)
                                        <div class="flex items-start text-xs text-gray-600">
                                            <svg class="w-2.5 h-2.5 text-red-500 mr-1 mt-0.5 flex-shrink-0"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
                                            </svg>
                                            <span
                                                class="line-clamp-1 text-xs">{{ Str::limit($product->description, 30) }}</span>
                                        </div>
                                    @endif

                                    <!-- Stock -->
                                    <div class="flex items-center justify-between">
                                        <div class="text-xs text-red-600 font-medium">
                                            Stock: {{ $product->quantity ?? 'Available' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Enhanced Pagination Section -->
                @if ($products->hasPages())
                    <div class="mt-10">
                        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                            <!-- Pagination Header -->
                            <div class="bg-gradient-to-r from-red-50 to-rose-50 px-6 py-4 border-b border-gray-100">
                                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-list text-red-500 mr-2"></i>
                                        <span class="text-sm font-medium text-gray-700">Page Navigation</span>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <div class="text-xs text-gray-500 bg-white px-3 py-1 rounded-full">
                                            Page {{ $products->currentPage() }} of {{ $products->lastPage() }}
                                        </div>
                                        <div class="text-xs text-gray-500 bg-white px-3 py-1 rounded-full">
                                            {{ $products->total() }} total items
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pagination Content -->
                            <div class="p-6">
                                <!-- Mobile Pagination (Simple) -->
                                <div class="flex sm:hidden items-center justify-between mb-4">
                                    @if ($products->onFirstPage())
                                        <span
                                            class="px-4 py-2 text-sm bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed">
                                            <i class="fas fa-chevron-left mr-1"></i>Previous
                                        </span>
                                    @else
                                        <a href="{{ $products->previousPageUrl() }}"
                                            class="px-4 py-2 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200">
                                            <i class="fas fa-chevron-left mr-1"></i>Previous
                                        </a>
                                    @endif

                                    <span class="text-sm text-gray-600 font-medium">
                                        {{ $products->currentPage() }} / {{ $products->lastPage() }}
                                    </span>

                                    @if ($products->hasMorePages())
                                        <a href="{{ $products->nextPageUrl() }}"
                                            class="px-4 py-2 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200">
                                            Next<i class="fas fa-chevron-right ml-1"></i>
                                        </a>
                                    @else
                                        <span
                                            class="px-4 py-2 text-sm bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed">
                                            Next<i class="fas fa-chevron-right ml-1"></i>
                                        </span>
                                    @endif
                                </div>

                                <!-- Desktop Pagination (Detailed) -->
                                <div class="hidden sm:block">
                                    <div
                                        class="flex flex-col lg:flex-row items-center justify-between space-y-4 lg:space-y-0">
                                        <!-- Pagination Info -->
                                        <div class="text-sm text-gray-600">
                                            Showing <span
                                                class="font-medium text-red-600">{{ $products->firstItem() }}</span> to
                                            <span class="font-medium text-red-600">{{ $products->lastItem() }}</span> of
                                            <span class="font-medium text-red-600">{{ $products->total() }}</span> results
                                        </div>

                                        <!-- Pagination Controls -->
                                        <div class="flex items-center space-x-1">
                                            {{-- First Page --}}
                                            @if ($products->currentPage() > 3)
                                                <a href="{{ $products->url(1) }}"
                                                    class="px-3 py-2 text-sm bg-white text-gray-500 border border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-300 hover:text-red-600 transition-all duration-200 flex items-center">
                                                    <i class="fas fa-angle-double-left mr-1"></i>
                                                    First
                                                </a>
                                                @if ($products->currentPage() > 4)
                                                    <span class="px-2 text-gray-400">...</span>
                                                @endif
                                            @endif

                                            {{-- Previous Page --}}
                                            @if ($products->onFirstPage())
                                                <span
                                                    class="px-3 py-2 text-sm bg-gray-50 text-gray-400 rounded-lg cursor-not-allowed border border-gray-200 flex items-center">
                                                    <i class="fas fa-chevron-left mr-1"></i>Prev
                                                </span>
                                            @else
                                                <a href="{{ $products->previousPageUrl() }}"
                                                    class="px-3 py-2 text-sm bg-white text-gray-700 border border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-300 hover:text-red-600 transition-all duration-200 flex items-center">
                                                    <i class="fas fa-chevron-left mr-1"></i>Prev
                                                </a>
                                            @endif

                                            {{-- Page Numbers --}}
                                            @php
                                                $start = max(1, $products->currentPage() - 2);
                                                $end = min($products->lastPage(), $products->currentPage() + 2);
                                            @endphp

                                            @for ($i = $start; $i <= $end; $i++)
                                                @if ($i == $products->currentPage())
                                                    <span
                                                        class="px-4 py-2 text-sm bg-red-600 text-white rounded-lg font-medium shadow-md border border-red-600 relative">
                                                        {{ $i }}
                                                        <span
                                                            class="absolute -top-1 -right-1 w-2 h-2 bg-red-400 rounded-full"></span>
                                                    </span>
                                                @else
                                                    <a href="{{ $products->url($i) }}"
                                                        class="px-4 py-2 text-sm bg-white text-gray-700 border border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-300 hover:text-red-600 transition-all duration-200 hover:shadow-md">
                                                        {{ $i }}
                                                    </a>
                                                @endif
                                            @endfor

                                            {{-- Next Page --}}
                                            @if ($products->hasMorePages())
                                                <a href="{{ $products->nextPageUrl() }}"
                                                    class="px-3 py-2 text-sm bg-white text-gray-700 border border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-300 hover:text-red-600 transition-all duration-200 flex items-center">
                                                    Next<i class="fas fa-chevron-right ml-1"></i>
                                                </a>
                                            @else
                                                <span
                                                    class="px-3 py-2 text-sm bg-gray-50 text-gray-400 rounded-lg cursor-not-allowed border border-gray-200 flex items-center">
                                                    Next<i class="fas fa-chevron-right ml-1"></i>
                                                </span>
                                            @endif

                                            {{-- Last Page --}}
                                            @if ($products->currentPage() < $products->lastPage() - 2)
                                                @if ($products->currentPage() < $products->lastPage() - 3)
                                                    <span class="px-2 text-gray-400">...</span>
                                                @endif
                                                <a href="{{ $products->url($products->lastPage()) }}"
                                                    class="px-3 py-2 text-sm bg-white text-gray-500 border border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-300 hover:text-red-600 transition-all duration-200 flex items-center">
                                                    Last
                                                    <i class="fas fa-angle-double-right ml-1"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Quick Page Jump & Additional Controls -->
                                @if ($products->lastPage() > 5)
                                    <div class="mt-6 pt-4 border-t border-gray-100">
                                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                                            <!-- Quick Jump -->
                                            <div class="flex items-center space-x-2">
                                                <span class="text-sm text-gray-600">Quick jump:</span>
                                                <form method="GET" action="{{ request()->url() }}"
                                                    class="flex items-center space-x-2">
                                                    @foreach (request()->except(['page']) as $key => $value)
                                                        <input type="hidden" name="{{ $key }}"
                                                            value="{{ $value }}">
                                                    @endforeach
                                                    <select name="page" onchange="this.form.submit()"
                                                        class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:border-red-300 focus:ring-2 focus:ring-red-200 transition-all duration-200">
                                                        @for ($i = 1; $i <= $products->lastPage(); $i++)
                                                            <option value="{{ $i }}"
                                                                {{ $i == $products->currentPage() ? 'selected' : '' }}>
                                                                Page {{ $i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </form>
                                            </div>

                                            <!-- Pagination Statistics -->
                                            <div class="flex items-center space-x-4 text-xs text-gray-500">
                                                <div class="flex items-center space-x-1">
                                                    <i class="fas fa-clock text-gray-400"></i>
                                                    <span>Last updated: {{ now()->format('H:i') }}</span>
                                                </div>
                                                <div class="flex items-center space-x-1">
                                                    <i class="fas fa-database text-gray-400"></i>
                                                    <span>{{ number_format($products->total()) }} records</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <!-- No Products State -->
                <div class="col-span-full">
                    <div class="bg-white rounded-xl shadow-lg p-12 text-center border border-gray-100">
                        <div class="bg-gradient-to-br from-red-50 to-rose-100 rounded-full p-8 w-24 h-24 mx-auto mb-6">
                            <svg class="w-8 h-8 text-red-400 mx-auto" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2-2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-3">No Products Available</h3>
                        <p class="text-gray-500 mb-8 max-w-md mx-auto leading-relaxed">
                            This store doesn't have any products available at the moment. Check back later or browse other
                            materials from our trusted suppliers.
                        </p>
                        <div
                            class="flex flex-col sm:flex-row items-center justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                            <a href="{{ route('procurement.material') }}"
                                class="inline-flex items-center bg-red-600 text-white px-8 py-3 rounded-lg font-medium hover:bg-red-700 transform hover:scale-105 transition-all duration-200 shadow-lg">
                                <i class="fas fa-search mr-2"></i>
                                Browse Other Materials
                            </a>
                            <button onclick="window.location.reload()"
                                class="inline-flex items-center bg-white text-gray-700 px-8 py-3 rounded-lg font-medium border border-gray-200 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 shadow-sm">
                                <i class="fas fa-refresh mr-2"></i>
                                Refresh Page
                            </button>
                        </div>

                        <!-- Additional help text -->
                        <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-info-circle text-blue-500 mr-1"></i>
                                Products are regularly updated. New items may be added soon.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Footer -->
    @include('components.footer')

    <!-- Additional JavaScript for enhanced functionality -->
    <script>
        // Smooth scroll to top when changing pages
        document.addEventListener('DOMContentLoaded', function() {
            const paginationLinks = document.querySelectorAll('a[href*="page="]');
            paginationLinks.forEach(link => {
                link.addEventListener('click', function() {
                    // Add loading state
                    this.style.opacity = '0.7';
                    this.style.pointerEvents = 'none';

                    // Scroll to top smoothly
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            });

            // Fetch and update review data every 30 seconds
            function updateReviews() {
                fetch('{{ route('store.reviews', urlencode($store->name)) }}')
                    .then(response => response.json())
                    .then(data => {
                        const reviewElement = document.getElementById('average-rating');
                        if (reviewElement) {
                            reviewElement.textContent = `${data.averageRating} (${data.totalReviews} reviews)`;
                        }
                    })
                    .catch(error => console.error('Error fetching reviews:', error));
            }

            // Initial fetch
            updateReviews();

            // Set interval for periodic updates (every 30 seconds)
            setInterval(updateReviews, 30000);
        });

        // Auto-refresh page every 5 minutes to show updated products
        setTimeout(function() {
            if (document.visibilityState === 'visible') {
                location.reload();
            }
        }, 300000); // 5 minutes
    </script>

@endsection
