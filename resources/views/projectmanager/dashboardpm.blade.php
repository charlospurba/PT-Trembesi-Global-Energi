@extends('layouts.app')

@section('content')
    @include('components.navpm')

    <div class="flex min-h-screen">
        @include('components.sidepm')

        <div class="flex-1 p-6 lg:p-8">
            <div class="max-w-7xl mx-auto space-y-8">

                {{-- Dashboard Header --}}
                <div
                    class="bg-gradient-to-r from-red-600 to-rose-600 rounded-2xl shadow-lg p-6 text-white mb-6 animate-fade-in">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-extrabold tracking-tight">
                                Welcome Back, {{ Auth::user()->name }}!
                            </h1>
                            <p class="text-red-100 mt-1 text-lg">
                                Here's a quick overview of your procurement requests.
                            </p>
                        </div>
                        <div class="hidden md:block">
                            <svg class="w-20 h-20 text-red-300 opacity-70" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z" />
                            </svg>
                        </div>
                    </div>
                </div>


                {{-- Material Status (Dengan Hover, Tanpa Link) --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 animate-fade-in-up">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Material Status</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        {{-- Awaiting Shipment --}}
                        <div
                            class="bg-white rounded-lg shadow-sm border-l-4 border-yellow-400 p-4 transition-transform duration-200 hover:scale-105 hover:shadow-lg">
                            <p class="text-sm font-medium text-gray-500">Awaiting Shipment</p>
                            <p class="mt-1 text-2xl font-bold text-gray-900">{{ $materialStatus['awaiting_shipment'] }}</p>
                        </div>

                        {{-- Shipped --}}
                        <div
                            class="bg-white rounded-lg shadow-sm border-l-4 border-blue-400 p-4 transition-transform duration-200 hover:scale-105 hover:shadow-lg">
                            <p class="text-sm font-medium text-gray-500">Shipped</p>
                            <p class="mt-1 text-2xl font-bold text-gray-900">{{ $materialStatus['shipped'] }}</p>
                        </div>

                        {{-- Completed --}}
                        <div
                            class="bg-white rounded-lg shadow-sm border-l-4 border-green-400 p-4 transition-transform duration-200 hover:scale-105 hover:shadow-lg">
                            <p class="text-sm font-medium text-gray-500">Completed</p>
                            <p class="mt-1 text-2xl font-bold text-gray-900">{{ $materialStatus['completed'] }}</p>
                        </div>

                        {{-- Cancelled --}}
                        <div
                            class="bg-white rounded-lg shadow-sm border-l-4 border-red-400 p-4 transition-transform duration-200 hover:scale-105 hover:shadow-lg">
                            <p class="text-sm font-medium text-gray-500">Cancelled</p>
                            <p class="mt-1 text-2xl font-bold text-gray-900">{{ $materialStatus['cancelled'] }}</p>
                        </div>
                    </div>
                </div>

                {{-- Summary Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in-up">
                    <div
                        class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-yellow-400 hover:shadow-xl transition-shadow duration-300">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Pending Requests</p>
                                <p class="mt-1 text-3xl font-bold text-gray-900">{{ $summary['pending'] }}</p>
                            </div>
                            <div class="flex-shrink-0 bg-yellow-100 rounded-full p-3">
                                <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-green-400 hover:shadow-xl transition-shadow duration-300">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Approved Requests</p>
                                <p class="mt-1 text-3xl font-bold text-gray-900">{{ $summary['approved'] }}</p>
                            </div>
                            <div class="flex-shrink-0 bg-green-100 rounded-full p-3">
                                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-red-400 hover:shadow-xl transition-shadow duration-300">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Rejected Requests</p>
                                <p class="mt-1 text-3xl font-bold text-gray-900">{{ $summary['rejected'] }}</p>
                            </div>
                            <div class="flex-shrink-0 bg-red-100 rounded-full p-3">
                                <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    {{-- Recent Purchase Requests Section --}}
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 flex items-center justify-between border-b">
                            <h2 class="text-lg font-semibold text-gray-800">Recent Purchase Requests</h2>
                            <a href="{{ route('projectmanager.purchase_requests') }}"
                                class="text-sm text-red-600 hover:underline">View All</a>
                        </div>
                        <ul role="list" class="divide-y divide-gray-200">
                            @forelse ($recentRequests as $request)
                                <li class="p-4 sm:p-6 hover:bg-gray-50 transition-colors duration-200">
                                    <div class="flex items-center justify-between space-x-4">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                {{ $request->product->name ?? 'N/A' }}
                                            </p>
                                            <p class="text-sm text-gray-500 truncate">
                                                Requested by: {{ $request->user->name ?? 'N/A' }}
                                            </p>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span
                                                class="px-2 py-0.5 rounded-full text-xs font-semibold
                                                @switch($request->status)
                                                    @case('Approved') bg-green-100 text-green-700 @break
                                                    @case('Rejected') bg-red-100 text-red-700 @break
                                                    @default bg-yellow-100 text-yellow-700 @endswitch">
                                                {{ $request->status }}
                                            </span>
                                            <a href="{{ route('projectmanager.purchase_requests.detail', $request->id) }}"
                                                class="text-red-600 hover:text-red-800 transition-colors duration-200">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="p-6 text-center text-gray-500">No recent requests found.</li>
                            @endforelse
                        </ul>
                    </div>

                    {{-- Monthly Status Chart --}}
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Monthly Request Status</h2>
                        <div class="h-96">
                            <canvas id="monthlyStatusChart"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 text-center">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h2>
                    <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('projectmanager.formadd') }}"
                            class="inline-flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition duration-200 ease-in-out transform hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Add New Request
                        </a>
                        <a href="{{ route('projectmanager.addrequest') }}"
                            class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition duration-200 ease-in-out transform hover:scale-105">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                            View All My Requests
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('monthlyStatusChart').getContext('2d');
        const monthlyStatusChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    label: 'Approved',
                    data: @json($chartData['approved']),
                    backgroundColor: 'rgba(52, 211, 153, 0.8)',
                    borderColor: 'rgba(52, 211, 153, 1)',
                    borderWidth: 1
                }, {
                    label: 'Pending',
                    data: @json($chartData['pending']),
                    backgroundColor: 'rgba(251, 191, 36, 0.8)',
                    borderColor: 'rgba(251, 191, 36, 1)',
                    borderWidth: 1
                }, {
                    label: 'Rejected',
                    data: @json($chartData['rejected']),
                    backgroundColor: 'rgba(248, 113, 113, 0.8)',
                    borderColor: 'rgba(248, 113, 113, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Requests'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                }
            }
        });
    </script>
@endpush
