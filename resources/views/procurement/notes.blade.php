@extends('layouts.app')
@section('content')
    @include('components.procnav')

    <!-- Header Section -->
    <section class="bg-red-600 text-white py-6 px-6 md:px-12 shadow-md rounded-b-xl mt-4 md:mt-6 mx-4 md:mx-8 lg:mx-16">
        <div class="max-w-5xl mx-auto flex justify-between items-center">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold">Office Building Construction</h1>
                <p class="text-sm md:text-base">Jakarta Pusat • Active Project</p>
            </div>
            <div class="text-right">
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center bg-white text-red-600 px-4 py-2 text-sm rounded-full font-semibold shadow hover:bg-gray-100 transition-all duration-150">
                    ← Back to Dashboard
                </a>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="bg-gray-100 py-10 px-6 md:px-12">
        <div class="max-w-7xl mx-auto">
            <p class="text-gray-600 text-base md:text-lg mb-8 text-center">
                Manage procurement requests for this project. View and act on requested items with detailed information
                below.
            </p>

            @php
                $groupedRequests = $requests->groupBy('user_id');
            @endphp

            @if($requests->isEmpty())
                <div class="text-center text-gray-500">No procurement requests found.</div>
            @else
                @php
                    $projectColors = [
                        ['from' => 'from-red-600', 'to' => 'to-red-700', 'light' => 'bg-red-500', 'hover' => 'hover:bg-red-700', 'muted' => 'text-red-100', 'progress' => 'bg-red-200', 'text' => 'text-red-700'],
                        ['from' => 'from-blue-600', 'to' => 'to-blue-700', 'light' => 'bg-blue-500', 'hover' => 'hover:bg-blue-700', 'muted' => 'text-blue-100', 'progress' => 'bg-blue-200', 'text' => 'text-blue-700'],
                        ['from' => 'from-green-600', 'to' => 'to-green-700', 'light' => 'bg-green-500', 'hover' => 'hover:bg-green-700', 'muted' => 'text-green-100', 'progress' => 'bg-green-200', 'text' => 'text-green-700'],
                        ['from' => 'from-purple-600', 'to' => 'to-purple-700', 'light' => 'bg-purple-500', 'hover' => 'hover:bg-purple-700', 'muted' => 'text-purple-100', 'progress' => 'bg-purple-200', 'text' => 'text-purple-700'],
                    ];
                @endphp

                <!-- Project Items -->
                @foreach($groupedRequests as $userId => $userRequests)
                    @php
                        $colors = $projectColors[$loop->index % count($projectColors)];
                    @endphp
                    <div class="mb-12">
                        <!-- Header -->
                        <div
                            class="bg-gradient-to-r {{ $colors['from'] }} {{ $colors['to'] }} text-white px-6 py-4 rounded-t-xl shadow-lg">
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <h2 class="text-xl font-bold">Project - {{ $userRequests->first()->project_name }}</h2>
                                    <p class="{{ $colors['muted'] }} text-sm">Requested by User ID: {{ $userId }}</p>
                                </div>
                            </div>

                            <!-- Summary Stats -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                                <!-- Total Items -->
                                <div
                                    class="text-center {{ $colors['light'] }} bg-opacity-30 rounded-xl p-4 shadow-md ring-1 ring-white/10 transition">
                                    <h4 class="text-sm font-semibold text-red-100 uppercase tracking-wide">Items</h4>
                                    <p class="text-2xl font-bold text-white mt-1">{{ $userRequests->count() }}</p>
                                </div>

                                <!-- High Priority -->
                                <div
                                    class="text-center {{ $colors['light'] }} bg-opacity-30 rounded-xl p-4 shadow-md ring-1 ring-white/10 transition">
                                    <h4 class="text-sm font-semibold text-red-100 uppercase tracking-wide">High Priority</h4>
                                    <p class="text-2xl font-bold text-white mt-1">
                                        {{ $userRequests->where('remark', 'Top Urgent')->count() + $userRequests->where('remark', 'Urgent')->count() }}
                                    </p>
                                </div>

                                <!-- Status -->
                                <div
                                    class="text-center {{ $colors['light'] }} bg-opacity-30 rounded-xl p-4 shadow-md ring-1 ring-white/10 transition">
                                    <h4 class="text-sm font-semibold text-red-100 uppercase tracking-wide">Status</h4>
                                    <span
                                        class="inline-block mt-2 px-3 py-1 text-xs font-bold bg-white {{ $colors['text'] }} rounded-full">
                                        Active
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Item Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 bg-white p-6 rounded-b-xl shadow-lg">
                            @foreach($userRequests as $request)
                                @php
                                    $remarkClass = match ($request->remark) {
                                        'Top Urgent' => 'bg-red-100 text-red-700',
                                        'Urgent' => 'bg-orange-100 text-orange-700',
                                        'Regular' => 'bg-yellow-100 text-yellow-700',
                                        'Termination' => 'bg-purple-100 text-purple-700',
                                        default => 'bg-gray-100 text-gray-700',
                                    };
                                @endphp

                                <div
                                    class="bg-white border border-gray-200 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden">
                                    <div class="p-6">
                                        <!-- Header with Item + Remark -->
                                        <div class="flex justify-between items-start mb-4">
                                            <h3 class="text-lg font-bold text-gray-800">{{ $request->item }}</h3>
                                            <span class="inline-block px-3 py-1 text-xs font-bold {{ $remarkClass }} rounded-full">
                                                {{ $request->remark }}
                                            </span>
                                        </div>

                                        <!-- Detail Info -->
                                        <div class="space-y-3 text-sm">
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Qty:</span>
                                                <span>{{ $request->qty }} {{ $request->uom }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">ETA:</span>
                                                <span>{{ \Carbon\Carbon::parse($request->eta)->translatedFormat('d M Y') }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Specification:</span>
                                                <span>{{ $request->specification }}</span>
                                            </div>
                                        </div>

                                        <!-- Detail Button -->
                                        <div class="mt-6">
                                            <a href="{{ route('procurement.detailnote', $request->id) }}"
                                                class="w-full inline-flex justify-center items-center {{ $colors['light'] }} {{ $colors['hover'] }} text-white px-4 py-2 text-sm rounded-lg font-semibold shadow transition-all duration-150">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </main>

@endsection