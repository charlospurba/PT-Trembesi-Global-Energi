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

    <!-- Charts Section -->
    <section class="bg-white py-8 px-6 md:px-12 shadow-sm">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800">Project Spending</h2>

                <!-- Project Selector Dropdown -->
                <div class="relative">
                    <select id="projectSelector"
                        class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 text-sm font-medium text-gray-700 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Projects</option>
                        <option value="project1">Project 1 - Heavy Equipment & Materials</option>
                        <option value="project2">Project 2 - Safety & Finishing Materials</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Monthly Spending Bar Chart -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Monthly Spending Analysis</h3>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center space-x-2 text-sm">
                                <div class="w-3 h-3 bg-blue-500 rounded"></div>
                                <span>Monthly Spend (IDR)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Chart Container -->
                    <div class="relative" style="height: 400px;">
                        <canvas id="monthlySpendChart"></canvas>
                    </div>
                </div>
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

    <!-- Chart.js Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('monthlySpendChart').getContext('2d');
            let monthlySpendChart;

            function formatIDR(value) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(value);
            }

            function createChart(labels, data) {
                if (monthlySpendChart) {
                    monthlySpendChart.destroy();
                }

                monthlySpendChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Monthly Spend (IDR)',
                            data: data,
                            backgroundColor: 'rgba(59, 130, 246, 0.6)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Monthly Spending by Project',
                                font: { size: 16, weight: 'bold' }
                            },
                            legend: {
                                display: true,
                                position: 'top'
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        return formatIDR(context.parsed.y);
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Month'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Spending (IDR)'
                                },
                                ticks: {
                                    callback: function (value) {
                                        return formatIDR(value);
                                    }
                                }
                            }
                        }
                    }
                });
            }

            function fetchChartData(project = '') {
                fetch(`{{ route('procurement.monthly-data') }}?project=${encodeURIComponent(project)}`)
                    .then(response => response.json())
                    .then(data => {
                        createChart(data.labels, data.data);
                    })
                    .catch(error => {
                        console.error('Error fetching chart data:', error);
                        createChart([], []);
                    });
            }

            // Initial fetch
            fetchChartData();

            // Listen to project change
            document.getElementById('projectSelector').addEventListener('change', (e) => {
                const selectedProject = e.target.value;
                fetchChartData(selectedProject);
            });
        });
    </script>

@endsection