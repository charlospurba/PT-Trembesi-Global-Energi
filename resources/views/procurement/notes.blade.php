@extends('layouts.app')
@section('content')
@include('components.procnav')

<!-- Header Section -->
<section class="bg-red-600 text-white py-6 px-6 md:px-12 shadow-md rounded-b-xl mt-4 md:mt-6">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
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
            <h2 class="text-2xl font-bold text-gray-800">Project Timeline & Spending</h2>
            
            <!-- Project Selector Dropdown -->
            <div class="relative">
                <select id="projectSelector" class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 text-sm font-medium text-gray-700 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">All Projects</option>
                    <option value="project1">Project 1 - Heavy Equipment & Materials</option>
                    <option value="project2">Project 2 - Safety & Finishing Materials</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- ETA vs ATA Chart -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-12">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">ETA vs ATA Analysis</h3>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2 text-sm">
                            <div class="w-3 h-3 bg-blue-500 rounded"></div>
                            <span>ETA (Estimated Arrival)</span>
                        </div>
                        <div class="flex items-center space-x-2 text-sm">
                            <div class="w-3 h-3 bg-green-500 rounded"></div>
                            <span>ATA (Actual Arrival)</span>
                        </div>
                        <div class="flex items-center space-x-2 text-sm">
                            <div class="w-3 h-3 bg-red-500 rounded"></div>
                            <span>Delayed</span>
                        </div>
                    </div>
                </div>
                
                <!-- Urgency Filter -->
                <div class="mb-4">
                    <div class="flex items-center space-x-4">
                        <label class="text-sm font-medium text-gray-700">Filter by Urgency:</label>
                        <div class="flex space-x-2">
                            <button id="filterAll" class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded-md transition-colors border-2 border-gray-300">
                                All
                            </button>
                            <button id="filterTopUrgent" class="px-3 py-1 text-sm bg-red-50 hover:bg-red-100 text-red-700 rounded-md transition-colors border-2 border-red-200">
                                🔴 Top Urgent
                            </button>
                            <button id="filterUrgent" class="px-3 py-1 text-sm bg-orange-50 hover:bg-orange-100 text-orange-700 rounded-md transition-colors border-2 border-orange-200">
                                🟠 Urgent
                            </button>
                            <button id="filterAverage" class="px-3 py-1 text-sm bg-green-50 hover:bg-green-100 text-green-700 rounded-md transition-colors border-2 border-green-200">
                                🟢 Average
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Chart Container -->
                <div class="relative" style="height: 400px;">
                    <canvas id="etaAtaChart"></canvas>
                </div>
                
                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-7 gap-4 mt-6">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="text-sm font-medium text-blue-600">On Time Deliveries</div>
                        <div id="onTimeCount" class="text-2xl font-bold text-blue-900">0</div>
                        <div id="onTimePercentage" class="text-xs text-blue-600">0%</div>
                    </div>
                    <div class="bg-yellow-50 p-4 rounded-lg">
                        <div class="text-sm font-medium text-yellow-600">Early Deliveries</div>
                        <div id="earlyCount" class="text-2xl font-bold text-yellow-900">0</div>
                        <div id="earlyPercentage" class="text-xs text-yellow-600">0%</div>
                    </div>
                    <div class="bg-red-50 p-4 rounded-lg">
                        <div class="text-sm font-medium text-red-600">Late Deliveries</div>
                        <div id="lateCount" class="text-2xl font-bold text-red-900">0</div>
                        <div id="latePercentage" class="text-xs text-red-600">0%</div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="text-sm font-medium text-gray-600">Avg Delay</div>
                        <div id="avgDelay" class="text-2xl font-bold text-gray-900">0</div>
                        <div class="text-xs text-gray-600">days</div>
                    </div>
                    <div class="bg-red-50 p-4 rounded-lg border-l-4 border-red-400">
                        <div class="text-sm font-medium text-red-600">🔴 Top Urgent</div>
                        <div id="topUrgentCount" class="text-2xl font-bold text-red-900">0</div>
                        <div id="topUrgentPercentage" class="text-xs text-red-600">0%</div>
                    </div>
                    <div class="bg-orange-50 p-4 rounded-lg border-l-4 border-orange-400">
                        <div class="text-sm font-medium text-orange-600">🟠 Urgent</div>
                        <div id="urgentCount" class="text-2xl font-bold text-orange-900">0</div>
                        <div id="urgentPercentage" class="text-xs text-orange-600">0%</div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg border-l-4 border-green-400">
                        <div class="text-sm font-medium text-green-600">🟢 Average</div>
                        <div id="averageCount" class="text-2xl font-bold text-green-900">0</div>
                        <div id="averagePercentage" class="text-xs text-green-600">0%</div>
                    </div>
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
            Manage procurement requests for this project. View and act on requested items with detailed information below.
        </p>

        <!-- Project 1 Items -->
        <div class="mb-12">
            <div class="bg-gradient-to-r from-red-600 to-red-700 text-white px-6 py-4 rounded-t-xl shadow-lg">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="text-xl font-bold">Project 1 - Heavy Equipment & Materials</h2>
                        <p class="text-red-100 text-sm">Foundation and structural work items</p>
                    </div>
                    <div class="text-right">
                        <p class="text-red-100 text-sm">Total Budget</p>
                        <p class="text-2xl font-bold">Rp1,095,000,000</p>
                    </div>
                </div>
                
                <!-- Project 1 Summary Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center bg-red-500 bg-opacity-30 rounded-lg p-3">
                        <h4 class="text-xs font-semibold text-red-100 uppercase">Items</h4>
                        <p class="text-lg font-bold text-white">6</p>
                    </div>
                    <div class="text-center bg-red-500 bg-opacity-30 rounded-lg p-3">
                        <h4 class="text-xs font-semibold text-red-100 uppercase">High Priority</h4>
                        <p class="text-lg font-bold text-white">4</p>
                    </div>
                    <div class="text-center bg-red-500 bg-opacity-30 rounded-lg p-3">
                        <h4 class="text-xs font-semibold text-red-100 uppercase">Status</h4>
                        <span class="inline-block px-2 py-1 text-xs font-bold bg-white text-red-700 rounded-full">Active</span>
                    </div>
                    <div class="text-center bg-red-500 bg-opacity-30 rounded-lg p-3">
                        <h4 class="text-xs font-semibold text-red-100 uppercase">Progress</h4>
                        <div class="w-full bg-red-200 rounded-full h-2 mt-1">
                            <div class="bg-white h-2 rounded-full" style="width: 45%"></div>
                        </div>
                        <p class="text-xs font-bold text-white mt-1">45%</p>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 bg-white p-6 rounded-b-xl shadow-lg">
                <!-- Excavator Card -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-bold text-gray-800">Excavator</h3>
                            <span class="inline-block px-3 py-1 text-xs font-bold bg-red-100 text-red-700 rounded-full">High</span>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Item:</span>
                                <span class="font-medium">Excavator</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Quantity:</span>
                                <span class="font-medium">5</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Unit:</span>
                                <span class="font-medium">Units</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">ETA:</span>
                                <span class="font-medium text-sm">30 Jun 2024</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Specification:</span>
                                <span class="font-medium text-sm">Heavy Duty</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Remarks:</span>
                                <span class="font-medium text-sm">Equipment</span>
                            </div>
                            <div class="flex justify-between border-t pt-3">
                                <span class="text-gray-600 font-semibold">Price:</span>
                                <span class="font-bold text-red-600 text-lg">Rp840,000,000</span>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <a href="{{ route('procurement.detailnote') }}" 
                               class="w-full inline-flex justify-center items-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 text-sm rounded-lg font-semibold shadow transition-all duration-150">
                               View Details
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Cement Card -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-bold text-gray-800">Cement</h3>
                            <span class="inline-block px-3 py-1 text-xs font-bold bg-red-100 text-red-700 rounded-full">High</span>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Item:</span>
                                <span class="font-medium">Cement</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Quantity:</span>
                                <span class="font-medium">500</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Unit:</span>
                                <span class="font-medium">Bags</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">ETA:</span>
                                <span class="font-medium text-sm">25 Jun 2024</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Specification:</span>
                                <span class="font-medium text-sm">Type I Portland</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Remarks:</span>
                                <span class="font-medium text-sm">Material</span>
                            </div>
                            <div class="flex justify-between border-t pt-3">
                                <span class="text-gray-600 font-semibold">Price:</span>
                                <span class="font-bold text-red-600 text-lg">Rp10,000,000</span>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <a href="{{ route('procurement.detailnote') }}" 
                               class="w-full inline-flex justify-center items-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 text-sm rounded-lg font-semibold shadow transition-all duration-150">
                               View Details
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Concrete Mixer Card -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-bold text-gray-800">Concrete Mixer</h3>
                            <span class="inline-block px-3 py-1 text-xs font-bold bg-red-100 text-red-700 rounded-full">High</span>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Item:</span>
                                <span class="font-medium">Concrete Mixer</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Quantity:</span>
                                <span class="font-medium">2</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Unit:</span>
                                <span class="font-medium">Units</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">ETA:</span>
                                <span class="font-medium text-sm">22 Jun 2024</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Specification:</span>
                                <span class="font-medium text-sm">350L Capacity</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Remarks:</span>
                                <span class="font-medium text-sm">Equipment</span>
                            </div>
                            <div class="flex justify-between border-t pt-3">
                                <span class="text-gray-600 font-semibold">Price:</span>
                                <span class="font-bold text-red-600 text-lg">Rp30,000,000</span>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <a href="{{ route('procurement.detailnote') }}" 
                               class="w-full inline-flex justify-center items-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 text-sm rounded-lg font-semibold shadow transition-all duration-150">
                               View Details
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tower Crane Card -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-bold text-gray-800">Tower Crane</h3>
                            <span class="inline-block px-3 py-1 text-xs font-bold bg-red-100 text-red-700 rounded-full">High</span>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Item:</span>
                                <span class="font-medium">Tower Crane</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Quantity:</span>
                                <span class="font-medium">1</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Unit:</span>
                                <span class="font-medium">Unit</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">ETA:</span>
                                <span class="font-medium text-sm">10 Jul 2024</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Specification:</span>
                                <span class="font-medium text-sm">50m Height</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Remarks:</span>
                                <span class="font-medium text-sm">Equipment</span>
                            </div>
                            <div class="flex justify-between border-t pt-3">
                                <span class="text-gray-600 font-semibold">Price:</span>
                                <span class="font-bold text-red-600 text-lg">Rp150,000,000</span>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <a href="{{ route('procurement.detailnote') }}" 
                               class="w-full inline-flex justify-center items-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 text-sm rounded-lg font-semibold shadow transition-all duration-150">
                               View Details
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Rebar Steel Card -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-bold text-gray-800">Rebar Steel</h3>
                            <span class="inline-block px-3 py-1 text-xs font-bold bg-yellow-100 text-yellow-700 rounded-full">Medium</span>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Item:</span>
                                <span class="font-medium">Rebar Steel</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Quantity:</span>
                                <span class="font-medium">3000</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Unit:</span>
                                <span class="font-medium">kg</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">ETA:</span>
                                <span class="font-medium text-sm">05 Jul 2024</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Specification:</span>
                                <span class="font-medium text-sm">Grade 40 Steel</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Remarks:</span>
                                <span class="font-medium text-sm">Material</span>
                            </div>
                            <div class="flex justify-between border-t pt-3">
                                <span class="text-gray-600 font-semibold">Price:</span>
                                <span class="font-bold text-red-600 text-lg">Rp25,500,000</span>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <a href="{{ route('procurement.detailnote') }}" 
                               class="w-full inline-flex justify-center items-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 text-sm rounded-lg font-semibold shadow transition-all duration-150">
                               View Details
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Scaffolding Card -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-bold text-gray-800">Scaffolding</h3>
                            <span class="inline-block px-3 py-1 text-xs font-bold bg-yellow-100 text-yellow-700 rounded-full">Medium</span>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Item:</span>
                                <span class="font-medium">Scaffolding</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Quantity:</span>
                                <span class="font-medium">100</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Unit:</span>
                                <span class="font-medium">Sets</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">ETA:</span>
                                <span class="font-medium text-sm">15 Jul 2024</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Specification:</span>
                                <span class="font-medium text-sm">Steel Frame</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Remarks:</span>
                                <span class="font-medium text-sm">Equipment</span>
                            </div>
                            <div class="flex justify-between border-t pt-3">
                                <span class="text-gray-600 font-semibold">Price:</span>
                                <span class="font-bold text-red-600 text-lg">Rp39,000,000</span>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <a href="{{ route('procurement.detailnote') }}" 
                               class="w-full inline-flex justify-center items-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 text-sm rounded-lg font-semibold shadow transition-all duration-150">
                               View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Project 2 Items -->
        <div class="mb-12">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-4 rounded-t-xl shadow-lg">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="text-xl font-bold">Project 2 - Safety & Finishing Materials</h2>
                        <p class="text-blue-100 text-sm">Safety equipment and finishing work items</p>
                    </div>
                    <div class="text-right">
                        <p class="text-blue-100 text-sm">Total Budget</p>
                        <p class="text-2xl font-bold">Rp88,750,000</p>
                    </div>
                </div>
                
                <!-- Project 2 Summary Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center bg-blue-500 bg-opacity-30 rounded-lg p-3">
                        <h4 class="text-xs font-semibold text-blue-100 uppercase">Items</h4>
                        <p class="text-lg font-bold text-white">6</p>
                    </div>
                    <div class="text-center bg-blue-500 bg-opacity-30 rounded-lg p-3">
                        <h4 class="text-xs font-semibold text-blue-100 uppercase">Medium Priority</h4>
                        <p class="text-lg font-bold text-white">4</p>
                    </div>
                    <div class="text-center bg-blue-500 bg-opacity-30 rounded-lg p-3">
                        <h4 class="text-xs font-semibold text-blue-100 uppercase">Status</h4>
                        <span class="inline-block px-2 py-1 text-xs font-bold bg-white text-blue-700 rounded-full">Active</span>
                    </div>
                    <div class="text-center bg-blue-500 bg-opacity-30 rounded-lg p-3">
                        <h4 class="text-xs font-semibold text-blue-100 uppercase">Progress</h4>
                        <div class="w-full bg-blue-200 rounded-full h-2 mt-1">
                            <div class="bg-white h-2 rounded-full" style="width: 30%"></div>
                        </div>
                        <p class="text-xs font-bold text-white mt-1">30%</p>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 bg-white p-6 rounded-b-xl shadow-lg">
                <!-- Safety Helmet Card -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-bold text-gray-800">Safety Helmet</h3>
                            <span class="inline-block px-3 py-1 text-xs font-bold bg-yellow-100 text-yellow-700 rounded-full">Medium</span>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Item:</span>
                                <span class="font-medium">Safety Helmet</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Quantity:</span>
                                <span class="font-medium">100</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Unit:</span>
                                <span class="font-medium">Pcs</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">ETA:</span>
                                <span class="font-medium text-sm">20 Jun 2024</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Specification:</span>
                                <span class="font-medium text-sm">ANSI Z89.1 Standard</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Remarks:</span>
                                <span class="font-medium text-sm">PPE</span>
                            </div>
                            <div class="flex justify-between border-t pt-3">
                                <span class="text-gray-600 font-semibold">Price:</span>
                                <span class="font-bold text-blue-600 text-lg">Rp2,500,000</span>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <a href="{{ route('procurement.detailnote') }}" 
                               class="w-full inline-flex justify-center items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 text-sm rounded-lg font-semibold shadow transition-all duration-150">
                               View Details
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Steel Beams Card -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-bold text-gray-800">Steel Beams</h3>
                            <span class="inline-block px-3 py-1 text-xs font-bold bg-green-100 text-green-700 rounded-full">Low</span>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Item:</span>
                                <span class="font-medium">Steel Beams</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Quantity:</span>
                                <span class="font-medium">200</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Unit:</span>
                                <span class="font-medium">Units</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">ETA:</span>
                                <span class="font-medium text-sm">28 Jun 2024</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Specification:</span>
                                <span class="font-medium text-sm">A36 Grade Steel</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Remarks:</span>
                                <span class="font-medium text-sm">Material</span>
                            </div>
                            <div class="flex justify-between border-t pt-3">
                                <span class="text-gray-600 font-semibold">Price:</span>
                                <span class="font-bold text-blue-600 text-lg">Rp25,000,000</span>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <a href="{{ route('procurement.detailnote') }}" 
                               class="w-full inline-flex justify-center items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 text-sm rounded-lg font-semibold shadow transition-all duration-150">
                               View Details
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Safety Vest Card -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-bold text-gray-800">Safety Vest</h3>
                            <span class="inline-block px-3 py-1 text-xs font-bold bg-yellow-100 text-yellow-700 rounded-full">Medium</span>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Item:</span>
                                <span class="font-medium">Safety Vest</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Quantity:</span>
                                <span class="font-medium">50</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Unit:</span>
                                <span class="font-medium">Pcs</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">ETA:</span>
                                <span class="font-medium text-sm">21 Jun 2024</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Specification:</span>
                                <span class="font-medium text-sm">High Visibility</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Remarks:</span>
                                <span class="font-medium text-sm">PPE</span>
                            </div>
                            <div class="flex justify-between border-t pt-3">
                                <span class="text-gray-600 font-semibold">Price:</span>
                                <span class="font-bold text-blue-600 text-lg">Rp3,750,000</span>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <a href="{{ route('procurement.detailnote') }}" 
                               class="w-full inline-flex justify-center items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 text-sm rounded-lg font-semibold shadow transition-all duration-150">
                               View Details
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Fire Extinguisher Card -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-bold text-gray-800">Fire Extinguisher</h3>
                            <span class="inline-block px-3 py-1 text-xs font-bold bg-red-100 text-red-700 rounded-full">High</span>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Item:</span>
                                <span class="font-medium">Fire Extinguisher</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Quantity:</span>
                                <span class="font-medium">20</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Unit:</span>
                                <span class="font-medium">Units</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">ETA:</span>
                                <span class="font-medium text-sm">18 Jun 2024</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Specification:</span>
                                <span class="font-medium text-sm">5kg ABC Type</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Remarks:</span>
                                <span class="font-medium text-sm">Safety</span>
                            </div>
                            <div class="flex justify-between border-t pt-3">
                                <span class="text-gray-600 font-semibold">Price:</span>
                                <span class="font-bold text-blue-600 text-lg">Rp17,000,000</span>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <a href="{{ route('procurement.detailnote') }}" 
                               class="w-full inline-flex justify-center items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 text-sm rounded-lg font-semibold shadow transition-all duration-150">
                               View Details
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Paint Materials Card -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-bold text-gray-800">Paint Materials</h3>
                            <span class="inline-block px-3 py-1 text-xs font-bold bg-yellow-100 text-yellow-700 rounded-full">Medium</span>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Item:</span>
                                <span class="font-medium">Paint Materials</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Quantity:</span>
                                <span class="font-medium">200</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Unit:</span>
                                <span class="font-medium">Liters</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">ETA:</span>
                                <span class="font-medium text-sm">05 Jul 2024</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Specification:</span>
                                <span class="font-medium text-sm">Acrylic Emulsion</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Remarks:</span>
                                <span class="font-medium text-sm">Finishing</span>
                            </div>
                            <div class="flex justify-between border-t pt-3">
                                <span class="text-gray-600 font-semibold">Price:</span>
                                <span class="font-bold text-blue-600 text-lg">Rp15,000,000</span>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <a href="{{ route('procurement.detailnote') }}" 
                               class="w-full inline-flex justify-center items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 text-sm rounded-lg font-semibold shadow transition-all duration-150">
                               View Details
                            </a>
                        </div>
                    </div>
                </div>

                <!-- First Aid Kit Card -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-bold text-gray-800">First Aid Kit</h3>
                            <span class="inline-block px-3 py-1 text-xs font-bold bg-yellow-100 text-yellow-700 rounded-full">Medium</span>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Item:</span>
                                <span class="font-medium">First Aid Kit</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Quantity:</span>
                                <span class="font-medium">50</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Unit:</span>
                                <span class="font-medium">Sets</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">ETA:</span>
                                <span class="font-medium text-sm">17 Jun 2024</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Specification:</span>
                                <span class="font-medium text-sm">Complete Medical Kit</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Remarks:</span>
                                <span class="font-medium text-sm">Safety</span>
                            </div>
                            <div class="flex justify-between border-t pt-3">
                                <span class="text-gray-600 font-semibold">Price:</span>
                                <span class="font-bold text-blue-600 text-lg">Rp25,500,000</span>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <a href="{{ route('procurement.detailnote') }}" 
                               class="w-full inline-flex justify-center items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 text-sm rounded-lg font-semibold shadow transition-all duration-150">
                               View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grand Total Summary -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <div class="text-center">
                <h3 class="text-lg font-semibold text-gray-600 uppercase mb-4">Total Project Budget</h3>
                <p class="text-4xl font-bold text-gray-800">Rp1,183,750,000</p>
                <div class="mt-4 flex justify-center space-x-8">
                    <div class="text-center">
                        <p class="text-sm text-gray-500">Project 1</p>
                        <p class="text-lg font-semibold text-red-600">Rp1,095,000,000</p>
                    </div>
                    <div class="text-center">
                        <p class="text-sm text-gray-500">Project 2</p>
                        <p class="text-lg font-semibold text-blue-600">Rp88,750,000</p>
                    </div>
                </div>
            </div>
        </div>
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
            this.urgencyFilter = 'all';
        }

        generateSampleData() {
            const project1Items = [
                {
                    id: 1,
                    name: "Excavator 5 unit",
                    supplier: "PT Heavy Equipment",
                    category: "Equipment",
                    eta: new Date('2024-06-30'),
                    ata: new Date('2024-06-28'),
                    delayDays: -2,
                    status: 'completed',
                    urgency: 'top-urgent',
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
                    ata: new Date('2024-06-25'),
                    delayDays: 0,
                    status: 'completed',
                    urgency: 'top-urgent',
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
                    ata: new Date('2024-06-24'),
                    delayDays: 2,
                    status: 'completed',
                    urgency: 'top-urgent',
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
                    ata: null,
                    delayDays: null,
                    status: 'pending',
                    urgency: 'top-urgent',
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
                    ata: new Date('2024-07-07'),
                    delayDays: 2,
                    status: 'completed',
                    urgency: 'urgent',
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
                    ata: null,
                    delayDays: null,
                    status: 'pending',
                    urgency: 'urgent',
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
                    ata: new Date('2024-06-18'),
                    delayDays: -2,
                    status: 'completed',
                    urgency: 'urgent',
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
                    ata: new Date('2024-06-28'),
                    delayDays: 0,
                    status: 'completed',
                    urgency: 'average',
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
                    ata: new Date('2024-06-22'),
                    delayDays: 1,
                    status: 'completed',
                    urgency: 'urgent',
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
                    ata: null,
                    delayDays: null,
                    status: 'pending',
                    urgency: 'top-urgent',
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
                    ata: new Date('2024-07-04'),
                    delayDays: -1,
                    status: 'completed',
                    urgency: 'urgent',
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
                    ata: new Date('2024-06-17'),
                    delayDays: 0,
                    status: 'completed',
                    urgency: 'urgent',
                    budget: 25500000,
                    unit: "Sets",
                    project: "project2"
                }
            ];

            // Additional dummy data for more realistic charts
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
            const urgencyLevels = ["top-urgent", "urgent", "average"];
            const projects = ["project1", "project2"];

            const additionalData = [];
            for (let i = 13; i <= 50; i++) {
                const etaDate = new Date();
                etaDate.setDate(etaDate.getDate() + Math.floor(Math.random() * 42) + 14);
                const urgencyRandom = Math.random();
                let urgency = urgencyRandom < 0.2 ? "top-urgent" : urgencyRandom < 0.5 ? "urgent" : "average";
                let ataDate, delayDays, status;
                const random = Math.random();

                if (random < 0.3) {
                    ataDate = new Date(etaDate);
                    delayDays = 0;
                    status = 'completed';
                } else if (random < 0.45) {
                    const earlyDays = Math.floor(Math.random() * 7) + 1;
                    ataDate = new Date(etaDate.getTime() - earlyDays * 24 * 60 * 60 * 1000);
                    delayDays = -earlyDays;
                    status = 'completed';
                } else if (random < 0.75) {
                    const lateDays = Math.floor(Math.random() * 14) + 1;
                    ataDate = new Date(etaDate.getTime() + lateDays * 24 * 60 * 60 * 1000);
                    delayDays = lateDays;
                    status = 'completed';
                } else if (random < 0.9) {
                    const veryLateDays = Math.floor(Math.random() * 16) + 15;
                    ataDate = new Date(etaDate.getTime() + veryLateDays * 24 * 60 * 60 * 1000);
                    delayDays = veryLateDays;
                    status = 'delayed';
                } else {
                    ataDate = null;
                    delayDays = null;
                    status = Math.random() < 0.5 ? 'pending' : 'in-progress';
                }

                additionalData.push({
                    id: i,
                    name: `${materials[Math.floor(Math.random() * materials.length)]} ${Math.floor(Math.random() * 100) + 10} unit`,
                    supplier: suppliers[Math.floor(Math.random() * suppliers.length)],
                    category: categories[Math.floor(Math.random() * categories.length)],
                    eta: etaDate,
                    ata: ataDate,
                    delayDays: delayDays,
                    status: status,
                    urgency: urgency,
                    budget: Math.floor(Math.random() * 50000000) + 5000000,
                    unit: ['unit', 'sak', 'm³', 'lembar', 'batang'][Math.floor(Math.random() * 5)],
                    project: projects[Math.floor(Math.random() * projects.length)]
                });
            }

            return [...project1Items, ...project2Items, ...additionalData];
        }

        applyFilters() {
            this.filteredData = this.allData.filter(item => {
                const matchesProject = this.projectFilter === '' || item.project === this.projectFilter;
                const matchesUrgency = this.urgencyFilter === 'all' || item.urgency === this.urgencyFilter;
                return matchesProject && matchesUrgency;
            });
        }
    }

    // Chart Manager for both ETA vs ATA and Monthly Spending
    class ChartManager {
        constructor() {
            this.dataManager = new ProcurementDataManager();
            this.urgencyFilter = 'all';
            this.projectFilter = '';
            this.etaAtaChart = null;
            this.monthlySpendChart = null;
            this.initCharts();
            this.initFilters();
        }

        initFilters() {
            // Urgency filter buttons
            document.getElementById('filterAll').addEventListener('click', () => this.setUrgencyFilter('all'));
            document.getElementById('filterTopUrgent').addEventListener('click', () => this.setUrgencyFilter('top-urgent'));
            document.getElementById('filterUrgent').addEventListener('click', () => this.setUrgencyFilter('urgent'));
            document.getElementById('filterAverage').addEventListener('click', () => this.setUrgencyFilter('average'));

            // Project selector
            document.getElementById('projectSelector').addEventListener('change', (e) => {
                this.projectFilter = e.target.value;
                this.applyFiltersAndUpdate();
            });

            this.updateFilterButtons();
        }

        setUrgencyFilter(urgency) {
            this.urgencyFilter = urgency;
            this.updateFilterButtons();
            this.applyFiltersAndUpdate();
        }

        updateFilterButtons() {
            const buttons = ['filterAll', 'filterTopUrgent', 'filterUrgent', 'filterAverage'];
            buttons.forEach(id => {
                const btn = document.getElementById(id);
                btn.classList.remove('border-blue-500', 'bg-blue-100');
            });

            let activeButton;
            switch(this.urgencyFilter) {
                case 'all': activeButton = 'filterAll'; break;
                case 'top-urgent': activeButton = 'filterTopUrgent'; break;
                case 'urgent': activeButton = 'filterUrgent'; break;
                case 'average': activeButton = 'filterAverage'; break;
            }

            if (activeButton) {
                const btn = document.getElementById(activeButton);
                btn.classList.add('border-blue-500', 'bg-blue-100');
            }
        }

        applyFiltersAndUpdate() {
            this.dataManager.projectFilter = this.projectFilter;
            this.dataManager.urgencyFilter = this.urgencyFilter;
            this.dataManager.applyFilters();
            this.updateETAATAChart();
            this.updateMonthlySpendChart();
            this.updateSummaryStats();
        }

        getUrgencyPointStyle(urgency) {
            switch(urgency) {
                case 'top-urgent':
                    return {
                        pointStyle: 'triangle',
                        pointRadius: 8,
                        pointHoverRadius: 10,
                        borderWidth: 3
                    };
                case 'urgent':
                    return {
                        pointStyle: 'rect',
                        pointRadius: 7,
                        pointHoverRadius: 9,
                        borderWidth: 2
                    };
                case 'average':
                    return {
                        pointStyle: 'circle',
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        borderWidth: 2
                    };
                default:
                    return {
                        pointStyle: 'circle',
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        borderWidth: 2
                    };
            }
        }

        initCharts() {
            // ETA vs ATA Chart
            const etaAtaCtx = document.getElementById('etaAtaChart').getContext('2d');
            this.etaAtaChart = new Chart(etaAtaCtx, {
                type: 'scatter',
                data: {
                    datasets: [
                        {
                            label: 'On Time',
                            data: [],
                            backgroundColor: 'rgba(34, 197, 94, 0.6)',
                            borderColor: 'rgba(34, 197, 94, 1)',
                            borderWidth: 2,
                            pointRadius: 6,
                            pointHoverRadius: 8
                        },
                        {
                            label: 'Early',
                            data: [],
                            backgroundColor: 'rgba(234, 179, 8, 0.6)',
                            borderColor: 'rgba(234, 179, 8, 1)',
                            borderWidth: 2,
                            pointRadius: 6,
                            pointHoverRadius: 8
                        },
                        {
                            label: 'Late',
                            data: [],
                            backgroundColor: 'rgba(239, 68, 68, 0.6)',
                            borderColor: 'rgba(239, 68, 68, 1)',
                            borderWidth: 2,
                            pointRadius: 6,
                            pointHoverRadius: 8
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'ETA vs ATA Scatter Plot',
                            font: { size: 16, weight: 'bold' }
                        },
                        legend: { display: true, position: 'top' },
                        tooltip: {
                            callbacks: {
                                title: function(context) {
                                    return context[0].raw.item.name;
                                },
                                label: function(context) {
                                    const point = context.raw;
                                    const eta = new Date(point.x).toLocaleDateString('id-ID');
                                    const ata = new Date(point.y).toLocaleDateString('id-ID');
                                    const delay = point.item.delayDays;
                                    const urgency = point.item.urgency;
                                    let urgencyEmoji = '';
                                    switch(urgency) {
                                        case 'top-urgent': urgencyEmoji = '🔴'; break;
                                        case 'urgent': urgencyEmoji = '🟠'; break;
                                        case 'average': urgencyEmoji = '🟢'; break;
                                    }
                                    return [
                                        `${urgencyEmoji} ${urgency.toUpperCase().replace('-', ' ')}`,
                                        `ETA: ${eta}`,
                                        `ATA: ${ata}`,
                                        `Delay: ${delay} days`,
                                        `Supplier: ${point.item.supplier}`
                                    ];
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            type: 'linear',
                            position: 'bottom',
                            title: { display: true, text: 'ETA (Estimated Arrival)' },
                            ticks: {
                                callback: function(value) {
                                    return new Date(value).toLocaleDateString('id-ID', { month: 'short', day: 'numeric' });
                                }
                            }
                        },
                        y: {
                            type: 'linear',
                            title: { display: true, text: 'ATA (Actual Arrival)' },
                            ticks: {
                                callback: function(value) {
                                    return new Date(value).toLocaleDateString('id-ID', { month: 'short', day: 'numeric' });
                                }
                            }
                        }
                    }
                }
            });

            // Add reference line for ETA vs ATA
            const referenceLinePlugin = {
                id: 'referenceLine',
                afterDraw: function(chart) {
                    const ctx = chart.ctx;
                    const xScale = chart.scales.x;
                    const yScale = chart.scales.y;
                    if (!xScale || !yScale) return;
                    ctx.save();
                    ctx.setLineDash([5, 5]);
                    ctx.strokeStyle = 'rgba(107, 114, 128, 0.5)';
                    ctx.lineWidth = 2;
                    ctx.beginPath();
                    const minTime = Math.max(xScale.min, yScale.min);
                    const maxTime = Math.min(xScale.max, yScale.max);
                    ctx.moveTo(xScale.getPixelForValue(minTime), yScale.getPixelForValue(minTime));
                    ctx.lineTo(xScale.getPixelForValue(maxTime), yScale.getPixelForValue(maxTime));
                    ctx.stroke();
                    ctx.restore();
                }
            };
            Chart.register(referenceLinePlugin);

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
                                label: function(context) {
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
                                callback: function(value) {
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

        updateETAATAChart() {
            const data = this.dataManager.filteredData.filter(item => item.ata !== null);
            const onTime = [];
            const early = [];
            const late = [];

            data.forEach(item => {
                const urgencyStyle = this.getUrgencyPointStyle(item.urgency);
                const point = {
                    x: item.eta.getTime(),
                    y: item.ata.getTime(),
                    item: item,
                    ...urgencyStyle
                };
                if (item.delayDays === 0) {
                    onTime.push(point);
                } else if (item.delayDays < 0) {
                    early.push(point);
                } else {
                    late.push(point);
                }
            });

            this.etaAtaChart.data.datasets[0].data = onTime;
            this.etaAtaChart.data.datasets[1].data = early;
            this.etaAtaChart.data.datasets[2].data = late;
            this.etaAtaChart.update();
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

        updateSummaryStats() {
            const data = this.dataManager.filteredData.filter(item => item.ata !== null);
            const total = data.length;

            if (total === 0) {
                document.getElementById('onTimeCount').textContent = '0';
                document.getElementById('onTimePercentage').textContent = '0%';
                document.getElementById('earlyCount').textContent = '0';
                document.getElementById('earlyPercentage').textContent = '0%';
                document.getElementById('lateCount').textContent = '0';
                document.getElementById('latePercentage').textContent = '0%';
                document.getElementById('avgDelay').textContent = '0';
                document.getElementById('topUrgentCount').textContent = '0';
                document.getElementById('topUrgentPercentage').textContent = '0%';
                document.getElementById('urgentCount').textContent = '0';
                document.getElementById('urgentPercentage').textContent = '0%';
                document.getElementById('averageCount').textContent = '0';
                document.getElementById('averagePercentage').textContent = '0%';
                return;
            }

            const onTime = data.filter(item => item.delayDays === 0).length;
            const early = data.filter(item => item.delayDays < 0).length;
            const late = data.filter(item => item.delayDays > 0).length;
            const avgDelay = data.reduce((sum, item) => sum + (item.delayDays || 0), 0) / total;

            document.getElementById('onTimeCount').textContent = onTime;
            document.getElementById('onTimePercentage').textContent = `${Math.round((onTime / total) * 100)}%`;
            document.getElementById('earlyCount').textContent = early;
            document.getElementById('earlyPercentage').textContent = `${Math.round((early / total) * 100)}%`;
            document.getElementById('lateCount').textContent = late;
            document.getElementById('latePercentage').textContent = `${Math.round((late / total) * 100)}%`;
            document.getElementById('avgDelay').textContent = Math.round(avgDelay * 10) / 10;

            const allFilteredData = this.dataManager.filteredData;
            const totalAll = allFilteredData.length;
            const topUrgent = allFilteredData.filter(item => item.urgency === 'top-urgent').length;
            const urgent = allFilteredData.filter(item => item.urgency === 'urgent').length;
            const average = allFilteredData.filter(item => item.urgency === 'average').length;

            document.getElementById('topUrgentCount').textContent = topUrgent;
            document.getElementById('topUrgentPercentage').textContent = totalAll > 0 ? `${Math.round((topUrgent / totalAll) * 100)}%` : '0%';
            document.getElementById('urgentCount').textContent = urgent;
            document.getElementById('urgentPercentage').textContent = totalAll > 0 ? `${Math.round((urgent / totalAll) * 100)}%` : '0%';
            document.getElementById('averageCount').textContent = average;
            document.getElementById('averagePercentage').textContent = totalAll > 0 ? `${Math.round((average / totalAll) * 100)}%` : '0%';
        }
    }

    // Initialize charts
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, initializing charts...');
        setTimeout(() => {
            try {
                window.chartManager = new ChartManager();
                console.log('Charts initialized successfully');
                window.chartManager.applyFiltersAndUpdate();
                console.log('Charts updated with data');
            } catch (error) {
                console.error('Error initializing charts:', error);
            }
        }, 500);
    });
</script>

@endsection