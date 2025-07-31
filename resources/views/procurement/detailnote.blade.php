@extends('layouts.app')
@section('content')
    @include('components.procnav')

    <!-- Header Section -->
    <section class="bg-white border-b border-gray-200 py-4 px-4 mt-4 mx-2 lg:mx-4">
        <div class="max-w-5xl mx-auto">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-semibold text-gray-900 mb-1">Procurement Details</h1>
                    <p class="text-gray-600 text-sm">Project: {{ $request->project_name }} • Code:
                        {{ $request->procurement_kode }}</p>
                </div>
                <div>
                    <a href="{{ route('procurement.notes') }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="bg-gray-50 py-4 px-4 min-h-screen">
        <div class="max-w-5xl mx-auto">
            <!-- Main Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">

                <!-- Item Header -->
                <div class="bg-white p-6 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="flex items-center space-x-4">
                            <div>
                                <h2 class="text-2xl font-semibold text-gray-900 mb-2">{{ $request->item }}</h2>
                                <p class="text-sm text-gray-600 bg-gray-100 px-3 py-1 rounded-md inline-block">ID:
                                    #{{ $request->id }}</p>
                            </div>
                        </div>
                        @php
                            $remarkClass = match ($request->remark) {
                                'Top Urgent' => 'bg-red-600 text-white',
                                'Urgent' => 'bg-orange-500 text-white',
                                'Average' => 'bg-green-500 text-white',
                                default => 'bg-gray-500 text-white',
                            };
                            $remarkText = $request->remark ?? 'N/A';
                        @endphp
                        <div class="{{ $remarkClass }} px-4 py-2 rounded-md">
                            <span class="text-sm font-medium">{{ $remarkText }} Priority</span>
                        </div>
                    </div>
                    <!-- Additional Project Info -->
                    <div class="mt-4 text-sm text-gray-600">
                        <p>Requested by: User ID {{ $request->user_id }}</p>
                        <p>Procurement Code: {{ $request->procurement_kode }}</p>
                    </div>
                </div>

                <!-- Information Content -->
                <div class="p-6">
                    <!-- Information Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                        <!-- Quantity -->
                        <div class="border border-gray-200 rounded-lg p-4 bg-white">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Quantity Required</span>
                                </div>
                                <span class="text-xl font-semibold text-gray-900">{{ $request->qty }} <span
                                        class="text-base text-gray-600">{{ $request->unit }}</span></span>
                            </div>
                        </div>

                        <!-- ETA -->
                        <div class="border border-gray-200 rounded-lg p-4 bg-white">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">Expected Delivery</span>
                                </div>
                                <span
                                    class="text-xl font-semibold text-gray-900">{{ \Carbon\Carbon::parse($request->eta)->translatedFormat('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Specification Section -->
                    <div class="border border-gray-200 rounded-lg p-6 mb-8 bg-white">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Product Specifications</h3>
                                <p class="text-sm text-gray-600">Detailed requirements and features</p>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <p class="text-gray-800 text-sm leading-relaxed">
                                {{ $request->specification ?? 'No specification provided.' }}
                            </p>
                        </div>
                    </div>

                    <!-- Price Section -->
                    <div class="border border-gray-200 rounded-lg p-6 mb-8 bg-white">
                        <div class="flex flex-col sm:flex-row justify-between items-center">
                            <div class="flex items-center mb-4 sm:mb-0">
                                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-lg font-semibold text-gray-900 block">Price</span>
                                    <span class="text-sm text-gray-600">All costs included</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span
                                    class="text-3xl font-bold text-gray-900 block">Rp{{ number_format($request->price, 0, ',', '.') }}</span>
                                <span class="text-sm text-gray-600">Final price</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <a href="{{ route('procurement.dashboardproc') }}"
                            class="inline-flex items-center px-8 py-3 bg-red-600 text-white text-base font-semibold rounded-lg hover:bg-red-700 transition-colors duration-200 shadow-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Buy Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
