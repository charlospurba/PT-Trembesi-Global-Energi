@extends('layouts.app')

@section('content')
  <!-- Include Navbar Component -->
  @include('components.navbar')

  <div class="container py-6">
    <h2 class="text-xl font-bold mb-4">
    Search Results for: <span class="text-red-600">"{{ $query }}"</span>
    </h2>

    @if ($results->isEmpty())
    <p class="text-gray-600">No matching products were found.</p>
    @else
    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    @foreach ($results as $product)
    <a href="{{ route('product.detail', $product->id) }}" class="block">
      <div class="bg-white rounded-xl shadow-md overflow-hidden transition-transform hover:scale-105">
      <!-- Product Image -->
      <div class="bg-red-600 p-3 flex justify-center items-center h-32">
      <img src="{{ !empty($product->image_paths) && is_array($product->image_paths) && count($product->image_paths) > 0
      ? asset('storage/' . $product->image_paths[0])
      : 'https://via.placeholder.com/300' }}" class="w-full h-full object-contain rounded-md"
      alt="{{ $product->name }}">
      </div>

      <!-- Product Info -->
      <div class="px-4 py-3 text-xs space-y-1.5">
      <span class="inline-block px-2 py-0.5 bg-gray-200 text-gray-800 text-[11px] rounded-full">
      {{ $product->supplier }}
      </span>
      <h3 class="text-sm font-semibold">{{ $product->name }}</h3>
      <p class="text-black font-bold text-sm">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
      <div class="text-[11px] text-gray-600">{{ $product->address ?? '-' }}</div>
      <div class="text-[11px] text-red-600 font-medium">Stock: {{ $product->quantity }}</div>
      </div>
      </div>
    </a>
    @endforeach
    </div>
    @endif
  </div>
@endsection