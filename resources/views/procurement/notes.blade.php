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
        // Data management class
        class ProcurementDataManager {
            constructor() {
                this.allData = this.generateSampleData();
                this.filteredData = [...this.allData];
                this.projectFilter = '';
            }

            generateSampleData() {
                const project1Items = [
                    {
                        id: 1,
                        name: "Excavator 5 unit",
                        supplier: "PT Heavy Equipment",
                        category: "Equipment",
                        eta: new Date('2024-06-30'),
                        budget: 840000000,
                        unit: "Units",
                        project: "project1"
                    },
                    {
                        id: 2,
                        name: "Cement 500 Bags",
                        supplier: "PT Semen Indonesia",
                        category: "Material",
                        eta: new Date('2024-06-25'),
                        budget: 10000000,
                        unit: "Bags",
                        project: "project1"
                    },
                    {
                        id: 3,
                        name: "Concrete Mixer 2 Units",
                        supplier: "CV Machinery",
                        category: "Equipment",
                        eta: new Date('2024-06-22'),
                        budget: 30000000,
                        unit: "Units",
                        project: "project1"
                    },
                    {
                        id: 4,
                        name: "Tower Crane 1 Unit",
                        supplier: "PT Crane Solutions",
                        category: "Equipment",
                        eta: new Date('2024-07-10'),
                        budget: 150000000,
                        unit: "Unit",
                        project: "project1"
                    },
                    {
                        id: 5,
                        name: "Rebar Steel 3000 kg",
                        supplier: "PT Krakatau Steel",
                        category: "Material",
                        eta: new Date('2024-07-05'),
                        budget: 25500000,
                        unit: "kg",
                        project: "project1"
                    },
                    {
                        id: 6,
                        name: "Scaffolding 100 Sets",
                        supplier: "UD Construction",
                        category: "Equipment",
                        eta: new Date('2024-07-15'),
                        budget: 39000000,
                        unit: "Sets",
                        project: "project1"
                    }
                ];

                const project2Items = [
                    {
                        id: 7,
                        name: "Safety Helmet 100 Pcs",
                        supplier: "PT Safety Gear",
                        category: "PPE",
                        eta: new Date('2024-06-20'),
                        budget: 2500000,
                        unit: "Pcs",
                        project: "project2"
                    },
                    {
                        id: 8,
                        name: "Steel Beams 200 Units",
                        supplier: "PT Baja Prima",
                        category: "Material",
                        eta: new Date('2024-06-28'),
                        budget: 25000000,
                        unit: "Units",
                        project: "project2"
                    },
                    {
                        id: 9,
                        name: "Safety Vest 50 Pcs",
                        supplier: "CV Safety Supplies",
                        category: "PPE",
                        eta: new Date('2024-06-21'),
                        budget: 3750000,
                        unit: "Pcs",
                        project: "project2"
                    },
                    {
                        id: 10,
                        name: "Fire Extinguisher 20 Units",
                        supplier: "PT Fire Safety",
                        category: "Safety",
                        eta: new Date('2024-06-18'),
                        budget: 17000000,
                        unit: "Units",
                        project: "project2"
                    },
                    {
                        id: 11,
                        name: "Paint Materials 200 Liters",
                        supplier: "PT Propan Raya",
                        category: "Finishing",
                        eta: new Date('2024-07-05'),
                        budget: 15000000,
                        unit: "Liters",
                        project: "project2"
                    },
                    {
                        id: 12,
                        name: "First Aid Kit 50 Sets",
                        supplier: "CV Medika",
                        category: "Safety",
                        eta: new Date('2024-06-17'),
                        budget: 25500000,
                        unit: "Sets",
                        project: "project2"
                    }
                ];

                const materials = [
                    "Besi Beton 10mm", "Semen Portland", "Pasir Beton", "Keramik 40x40",
                    "Bata Merah", "Pipa PVC 4in", "Genteng Beton", "Kayu Meranti",
                    "Kaca Tempered", "Cat Tembok", "Keramik Granite", "Baja Ringan",
                    "Pintu Panel", "Jendela UPVC", "Atap Spandek", "Wire Mesh",
                    "Besi Hollow", "Triplek 18mm", "Plafon Gypsum", "Lantai Parket"
                ];
                const suppliers = [
                    "PT Krakatau Steel", "PT Semen Indonesia", "CV Sumber Alam", "PT Roman Ceramics",
                    "UD Bata Mandiri", "PT Rucika", "PT Genteng Mas", "CV Kayu Jati",
                    "PT Asahimas", "PT Propan Raya", "PT Granito Tiles", "PT Baja Ringan Prima"
                ];
                const categories = ["Material", "Equipment", "Electrical Tools", "Consumables", "PPE", "Safety", "Finishing"];
                const projects = ["project1", "project2"];

                const additionalData = [];
                for (let i = 13; i <= 50; i++) {
                    const etaDate = new Date();
                    etaDate.setDate(etaDate.getDate() + Math.floor(Math.random() * 42) + 14);

                    additionalData.push({
                        id: i,
                        name: `${materials[Math.floor(Math.random() * materials.length)]} ${Math.floor(Math.random() * 100) + 10} unit`,
                        supplier: suppliers[Math.floor(Math.random() * suppliers.length)],
                        category: categories[Math.floor(Math.random() * categories.length)],
                        eta: etaDate,
                        budget: Math.floor(Math.random() * 50000000) + 5000000,
                        unit: ['unit', 'sak', 'm³', 'lembar', 'batang'][Math.floor(Math.random() * 5)],
                        project: projects[Math.floor(Math.random() * projects.length)]
                    });
                }

                return [...project1Items, ...project2Items, ...additionalData];
            }

            applyFilters() {
                this.filteredData = this.allData.filter(item => {
                    return this.projectFilter === '' || item.project === this.projectFilter;
                });
            }
        }

        // Chart Manager for Monthly Spending
        class ChartManager {
            constructor() {
                this.dataManager = new ProcurementDataManager();
                this.projectFilter = '';
                this.monthlySpendChart = null;
                this.initChart();
                this.initFilters();
            }

            initFilters() {
                // Project selector
                document.getElementById('projectSelector').addEventListener('change', (e) => {
                    this.projectFilter = e.target.value;
                    this.applyFiltersAndUpdate();
                });
            }

            initChart() {
                // Monthly Spending Chart
                const monthlySpendCtx = document.getElementById('monthlySpendChart').getContext('2d');
                this.monthlySpendChart = new Chart(monthlySpendCtx, {
                    type: 'bar',
                    data: {
                        labels: [],
                        datasets: [{
                            label: 'Monthly Spend (IDR)',
                            data: [],
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
                            legend: { display: true, position: 'top' },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        return new Intl.NumberFormat('id-ID', {
                                            style: 'currency',
                                            currency: 'IDR',
                                            minimumFractionDigits: 0
                                        }).format(context.parsed.y);
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                title: { display: true, text: 'Month' }
                            },
                            y: {
                                title: { display: true, text: 'Spending (IDR)' },
                                ticks: {
                                    callback: function (value) {
                                        return new Intl.NumberFormat('id-ID', {
                                            style: 'currency',
                                            currency: 'IDR',
                                            minimumFractionDigits: 0
                                        }).format(value);
                                    }
                                }
                            }
                        }
                    }
                });
            }

            applyFiltersAndUpdate() {
                this.dataManager.projectFilter = this.projectFilter;
                this.dataManager.applyFilters();
                this.updateMonthlySpendChart();
            }

            updateMonthlySpendChart() {
                const today = new Date();
                const months = [];
                const spendData = new Array(12).fill(0);

                // Generate 12 months of labels (6 months before and after current month)
                for (let i = -5; i <= 6; i++) {
                    const date = new Date(today.getFullYear(), today.getMonth() + i, 1);
                    months.push(date.toLocaleDateString('id-ID', { month: 'short', year: 'numeric' }));
                }

                this.dataManager.filteredData.forEach(item => {
                    const itemMonth = new Date(item.eta).getMonth();
                    const itemYear = new Date(item.eta).getFullYear();
                    const monthIndex = months.findIndex(month => {
                        const [monthName, year] = month.split(' ');
                        const monthNum = new Date(Date.parse(monthName + " 1, " + year)).getMonth();
                        return monthNum === itemMonth && parseInt(year) === itemYear;
                    });

                    if (monthIndex !== -1) {
                        spendData[monthIndex] += item.budget;
                    }
                });

                this.monthlySpendChart.data.labels = months;
                this.monthlySpendChart.data.datasets[0].data = spendData;
                this.monthlySpendChart.update();
            }
        }

        // Initialize chart
        document.addEventListener('DOMContentLoaded', function () {
            console.log('DOM loaded, initializing chart...');
            setTimeout(() => {
                try {
                    window.chartManager = new ChartManager();
                    console.log('Chart initialized successfully');
                    window.chartManager.applyFiltersAndUpdate();
                    console.log('Chart updated with data');
                } catch (error) {
                    console.error('Error initializing chart:', error);
                }
            }, 500);
        });
    </script>
@endsection