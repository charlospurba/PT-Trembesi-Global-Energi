@extends('layouts.app')

@section('content')
    @include('components.navbar')

    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-red-50 to-rose-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center space-x-2 text-xs mb-4 glass-effect px-4 py-2 rounded-xl shadow-lg">
                <a href="{{ route('procurement.dashboardproc') }}"
                    class="flex items-center text-gray-600 hover:text-red-600 transition-all duration-300">
                    <i class="fas fa-home mr-1"></i>Dashboard
                </a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                {{-- Modifikasi: Tambahkan parameter note_id ke breadcrumb jika ada --}}
                <a href="{{ route('procurement.material', ['note_id' => $note_id ?? null]) }}"><span class="text-red-600 font-semibold">Material</span></a>
            </nav>

            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border-l-4 border-red-600">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="bg-gradient-to-r from-red-600 to-red-700 text-white p-3 rounded-xl shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h2l1 2h13l1-2h2M5 12h14l-1.5 9h-11L5 12zM10 21h4" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold text-gray-800 mb-1">Material Collection</h1>
                            <p class="text-gray-600">Discover the best materials for your needs</p>
                        </div>
                    </div>
                    <div class="hidden md:flex items-center gap-2 bg-gray-100 px-4 py-2 rounded-full">
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-sm text-gray-600 font-medium">{{ count($products) }} Products Available</span>
                    </div>
                </div>
            </div>

            <form method="GET" action="{{ route('procurement.material') }}" class="bg-white rounded-lg shadow-sm p-3 mb-6">
                <div class="flex flex-wrap items-center gap-3">
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-medium text-gray-700">Sort:</span>
                    </div>
                    <select name="sort" onchange="this.form.submit()"
                        class="bg-gray-100 text-gray-600 text-xs font-medium rounded-full cursor-pointer hover:bg-gray-200 transition-colors px-3 py-1">
                        <option value="">All</option>
                        <option value="lowest" {{ request('sort') == 'lowest' ? 'selected' : '' }}>Lowest Price</option>
                        <option value="highest" {{ request('sort') == 'highest' ? 'selected' : '' }}>Highest Price</option>
                    </select>
                </div>
                @if(request('query'))
                    <input type="hidden" name="query" value="{{ request('query') }}">
                @endif
                {{-- PENTING: Tambahkan input hidden untuk note_id agar tetap diteruskan saat filter/sort --}}
                @if(isset($note_id))
                    <input type="hidden" name="note_id" value="{{ $note_id }}">
                @endif
            </form>

            @if(isset($query))
                <div class="text-sm text-gray-500 mb-2">
                    Search results for: <strong>{{ $query }}</strong>
                </div>
            @endif

            <p class="text-gray-600 mb-4">Showing {{ count($products) }} of {{ count($products) }} products</p>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
                @forelse($products as $product)
                    {{-- PENTING: Kirim note_id ke halaman detail produk --}}
                    <a href="{{ route('product.detail', ['id' => $product->id, 'note_id' => $note_id ?? null]) }}" class="block group">
                        <div class="bg-white rounded-lg overflow-hidden w-full transition-all duration-300 shadow-[0_1px_4px_rgba(220,38,38,0.2)] hover:shadow-[0_4px_12px_rgba(220,38,38,0.3)] hover:-translate-y-1 border border-gray-100">

                            <div class="w-full aspect-square bg-gray-50 overflow-hidden">
                                <img src="{{ !empty($product->image_paths) && is_array($product->image_paths) && count($product->image_paths) > 0
                                        ? asset('storage/' . $product->image_paths[0] . '?' . time())
                                        : 'https://via.placeholder.com/200' }}"
                                        alt="{{ $product->name }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                            </div>

                            <div class="p-2 space-y-1">
                                <span class="inline-block px-1.5 py-0.5 bg-gray-100 text-gray-700 text-xs rounded font-medium">
                                    {{ $product->supplier }}
                                </span>

                                <h3 class="text-xs font-semibold text-red-600 line-clamp-2 leading-tight">{{ $product->name }}</h3>

                                <p class="text-gray-900 font-bold text-sm">Rp{{ number_format($product->price, 0, ',', '.') }}</p>

                                <div class="flex items-start text-xs text-gray-600">
                                    <svg class="w-2.5 h-2.5 text-red-500 mr-1 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 2a6 6 0 016 6c0 4.418-6 10-6 10S4 12.418 4 8a6 6 0 016-6zM8 8a2 2 0 114 0 2 2 0 01-4 0z" />
                                    </svg>
                                    <span class="line-clamp-1 text-xs">{{ $product->address ?? '-' }}</span>
                                </div>

                                <div class="text-xs text-red-600 font-medium">
                                    Stock: {{ $product->quantity }}
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                            <div class="bg-gray-100 rounded-full p-4 w-16 h-16 mx-auto mb-3">
                                <svg class="w-8 h-8 text-gray-400 mx-auto" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                            </div>
                            <h3 class="text-base font-semibold text-gray-800 mb-2">No Products Available</h3>
                            <p class="text-sm text-gray-500 mb-3">There are currently no material products available.</p>
                            <button
                                class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700 transition-colors">
                                Add Product
                            </button>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-12 text-center">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex justify-center gap-2">
                        <button class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors">
                            Previous
                        </button>
                        <button class="px-4 py-2 bg-red-600 text-white rounded-lg">
                            1
                        </button>
                        <button class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.footer')

@endsection