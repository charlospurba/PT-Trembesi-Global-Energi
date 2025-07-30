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

<!-- Timeline Chart Section -->
<section class="bg-white py-8 px-6 md:px-12 shadow-sm">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Project Timeline </h2>
            
            <!-- Project Selector Dropdown -->
            <div class="relative">
                <select id="projectSelector" class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 text-sm font-medium text-gray-700 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
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
        
       <div class="mt-6">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
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
                <!-- New Urgency Cards -->
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
                                <span class="text-gray-600">Category:</span>
                                <span class="font-medium">Equipment</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Budget/Unit:</span>
                                <span class="font-medium">Rp168,000,000</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Quantity:</span>
                                <span class="font-medium">5 Units</span>
                            </div>
                            <div class="flex justify-between border-t pt-3">
                                <span class="text-gray-600 font-semibold">Total:</span>
                                <span class="font-bold text-red-600 text-lg">Rp840,000,000</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Timeline:</span>
                                <span class="font-medium text-sm">12 Jun - 30 Jun</span>
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
                                <span class="text-gray-600">Category:</span>
                                <span class="font-medium">Material</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Budget/Unit:</span>
                                <span class="font-medium">Rp20,000</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Quantity:</span>
                                <span class="font-medium">500 Bags</span>
                            </div>
                            <div class="flex justify-between border-t pt-3">
                                <span class="text-gray-600 font-semibold">Total:</span>
                                <span class="font-bold text-red-600 text-lg">Rp10,000,000</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Timeline:</span>
                                <span class="font-medium text-sm">20 Jun - 25 Jun</span>
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
                                <span class="text-gray-600">Category:</span>
                                <span class="font-medium">Equipment</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Budget/Unit:</span>
                                <span class="font-medium">Rp15,000,000</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Quantity:</span>
                                <span class="font-medium">2 Units</span>
                            </div>
                            <div class="flex justify-between border-t pt-3">
                                <span class="text-gray-600 font-semibold">Total:</span>
                                <span class="font-bold text-red-600 text-lg">Rp30,000,000</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Timeline:</span>
                                <span class="font-medium text-sm">14 Jun - 22 Jun</span>
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
                                <span class="text-gray-600">Category:</span>
                                <span class="font-medium">Equipment</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Budget/Unit:</span>
                                <span class="font-medium">Rp150,000,000</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Quantity:</span>
                                <span class="font-medium">1 Unit</span>
                            </div>
                            <div class="flex justify-between border-t pt-3">
                                <span class="text-gray-600 font-semibold">Total:</span>
                                <span class="font-bold text-red-600 text-lg">Rp150,000,000</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Timeline:</span>
                                <span class="font-medium text-sm">15 Jun - 10 Jul</span>
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
                                <span class="text-gray-600">Category:</span>
                                <span class="font-medium">Material</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Budget/Unit:</span>
                                <span class="font-medium">Rp8,500</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Quantity:</span>
                                <span class="font-medium">3000 kg</span>
                            </div>
                            <div class="flex justify-between border-t pt-3">
                                <span class="text-gray-600 font-semibold">Total:</span>
                                <span class="font-bold text-red-600 text-lg">Rp25,500,000</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Timeline:</span>
                                <span class="font-medium text-sm">22 Jun - 05 Jul</span>
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
                                <span class="text-gray-600">Category:</span>
                                <span class="font-medium">Equipment</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Budget/Unit:</span>
                                <span class="font-medium">Rp390,000</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Quantity:</span>
                                <span class="font-medium">100 Sets</span>
                            </div>
                            <div class="flex justify-between border-t pt-3">
                                <span class="text-gray-600 font-semibold">Total:</span>
                                <span class="font-bold text-red-600 text-lg">Rp39,000,000</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Timeline:</span>
                                <span class="font-medium text-sm">18 Jun - 15 Jul</span>
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
                                <span class="text-gray-600">Category:</span>
                                <span class="font-medium">PPE</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Budget/Unit:</span>
                                <span class="font-medium">Rp25,000</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Quantity:</span>
                                <span class="font-medium">100 Pcs</span>
                            </div>
                            <div class="flex justify-between border-t pt-3">
                                <span class="text-gray-600 font-semibold">Total:</span>
                                <span class="font-bold text-blue-600 text-lg">Rp2,500,000</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Timeline:</span>
                                <span class="font-medium text-sm">15 Jun - 20 Jun</span>
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
                                <span class="text-gray-600">Category:</span>
                                <span class="font-medium">Material</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Budget/Unit:</span>
                                <span class="font-medium">Rp125,000</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Quantity:</span>
                                <span class="font-medium">200 Units</span>
                            </div>
                            <div class="flex justify-between border-t pt-3">
                                <span class="text-gray-600 font-semibold">Total:</span>
                                <span class="font-bold text-blue-600 text-lg">Rp25,000,000</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Timeline:</span>
                                <span class="font-medium text-sm">18 Jun - 28 Jun</span>
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
                                <span class="text-gray-600">Category:</span>
                                <span class="font-medium">PPE</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Budget/Unit:</span>
                                <span class="font-medium">Rp75,000</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Quantity:</span>
                                <span class="font-medium">50 Pcs</span>
                            </div>
                            <div class="flex justify-between border-t pt-3">
                                <span class="text-gray-600 font-semibold">Total:</span>
                                <span class="font-bold text-blue-600 text-lg">Rp3,750,000</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Timeline:</span>
                                <span class="font-medium text-sm">16 Jun - 21 Jun</span>
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
                                <span class="text-gray-600">Category:</span>
                                <span class="font-medium">Safety</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Budget/Unit:</span>
                                <span class="font-medium">Rp850,000</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Quantity:</span>
                                <span class="font-medium">20 Units</span>
                            </div>
                            <div class="flex justify-between border-t pt-3">
                                <span class="text-gray-600 font-semibold">Total:</span>
                                <span class="font-bold text-blue-600 text-lg">Rp17,000,000</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Timeline:</span>
                                <span class="font-medium text-sm">14 Jun - 18 Jun</span>
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
                                <span class="text-gray-600">Category:</span>
                                <span class="font-medium">Finishing</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Budget/Unit:</span>
                                <span class="font-medium">Rp75,000</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Quantity:</span>
                                <span class="font-medium">200 Liters</span>
                            </div>
                            <div class="flex justify-between border-t pt-3">
                                <span class="text-gray-600 font-semibold">Total:</span>
                                <span class="font-bold text-blue-600 text-lg">Rp15,000,000</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Timeline:</span>
                                <span class="font-medium text-sm">25 Jun - 05 Jul</span>
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
                                <span class="text-gray-600">Category:</span>
                                <span class="font-medium">Safety</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Budget/Unit:</span>
                                <span class="font-medium">Rp500,000</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Quantity:</span>
                                <span class="font-medium">50 Sets</span>
                            </div>
                            <div class="flex justify-between border-t pt-3">
                                <span class="text-gray-600 font-semibold">Total:</span>
                                <span class="font-bold text-blue-600 text-lg">Rp25,500,000</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Timeline:</span>
                                <span class="font-medium text-sm">12 Jun - 17 Jun</span>
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
 // Dummy data untuk ETA vs ATA chart
    function generateETAATADummyData() {
        const dummyData = [];
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
        
        const categories = ["Material", "Equipment", "Electrical Tools", "Consumables"];
        const urgencyLevels = ["top-urgent", "urgent", "average"];
        
        for (let i = 1; i <= 50; i++) {
            // Generate ETA (2-8 weeks from now)
            const etaDate = new Date();
            etaDate.setDate(etaDate.getDate() + Math.floor(Math.random() * 42) + 14);
            
            // Generate urgency level
            const urgencyRandom = Math.random();
            let urgency;
            if (urgencyRandom < 0.2) {
                urgency = "top-urgent"; // 20%
            } else if (urgencyRandom < 0.5) {
                urgency = "urgent"; // 30%
            } else {
                urgency = "average"; // 50%
            }
            
            // Generate ATA with realistic patterns
            let ataDate, delayDays, status;
            const random = Math.random();
            
            if (random < 0.3) {
                // 30% On time (0 days delay)
                ataDate = new Date(etaDate);
                delayDays = 0;
                status = 'completed';
            } else if (random < 0.45) {
                // 15% Early (-1 to -7 days)
                const earlyDays = Math.floor(Math.random() * 7) + 1;
                ataDate = new Date(etaDate.getTime() - earlyDays * 24 * 60 * 60 * 1000);
                delayDays = -earlyDays;
                status = 'completed';
            } else if (random < 0.75) {
                // 30% Late (1-14 days)
                const lateDays = Math.floor(Math.random() * 14) + 1;
                ataDate = new Date(etaDate.getTime() + lateDays * 24 * 60 * 60 * 1000);
                delayDays = lateDays;
                status = 'completed';
            } else if (random < 0.9) {
                // 15% Very late (15-30 days)
                const veryLateDays = Math.floor(Math.random() * 16) + 15;
                ataDate = new Date(etaDate.getTime() + veryLateDays * 24 * 60 * 60 * 1000);
                delayDays = veryLateDays;
                status = 'delayed';
            } else {
                // 10% Still pending/in-progress (no ATA yet)
                ataDate = null;
                delayDays = null;
                status = Math.random() < 0.5 ? 'pending' : 'in-progress';
            }
            
            dummyData.push({
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
                unit: ['unit', 'sak', 'm³', 'lembar', 'batang'][Math.floor(Math.random() * 5)]
            });
        }
        
        return dummyData;
    }

    // ETA vs ATA Chart Manager
    class ETAATAChartManager {
        constructor() {
            this.dummyData = generateETAATADummyData();
            this.filteredData = [...this.dummyData];
            this.urgencyFilter = 'all';
            this.chart = null;
            this.initChart();
            this.initFilters();
        }
        
        initFilters() {
            // Setup urgency filter buttons
            document.getElementById('filterAll').addEventListener('click', () => this.setUrgencyFilter('all'));
            document.getElementById('filterTopUrgent').addEventListener('click', () => this.setUrgencyFilter('top-urgent'));
            document.getElementById('filterUrgent').addEventListener('click', () => this.setUrgencyFilter('urgent'));
            document.getElementById('filterAverage').addEventListener('click', () => this.setUrgencyFilter('average'));
            
            // Set initial active state
            this.updateFilterButtons();
        }
        
        setUrgencyFilter(urgency) {
            this.urgencyFilter = urgency;
            this.applyFilters();
            this.updateChart();
            this.updateFilterButtons();
        }
        
        applyFilters() {
            if (this.urgencyFilter === 'all') {
                this.filteredData = [...this.dummyData];
            } else {
                this.filteredData = this.dummyData.filter(item => item.urgency === this.urgencyFilter);
            }
        }
        
        updateFilterButtons() {
            // Reset all buttons
            const buttons = ['filterAll', 'filterTopUrgent', 'filterUrgent', 'filterAverage'];
            buttons.forEach(id => {
                const btn = document.getElementById(id);
                btn.classList.remove('border-blue-500', 'bg-blue-100');
            });
            
            // Highlight active button
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
        
        initChart() {
            const ctx = document.getElementById('etaAtaChart').getContext('2d');
            
            this.chart = new Chart(ctx, {
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
                            font: {
                                size: 16,
                                weight: 'bold'
                            }
                        },
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                title: function(context) {
                                    const point = context[0];
                                    const item = point.raw.item;
                                    return item.name;
                                },
                                label: function(context) {
                                    const point = context.raw;
                                    const eta = new Date(point.x).toLocaleDateString('id-ID');
                                    const ata = new Date(point.y).toLocaleDateString('id-ID');
                                    const delay = point.item.delayDays;
                                    const urgency = point.item.urgency;
                                    
                                    // Urgency emoji
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
                            title: {
                                display: true,
                                text: 'ETA (Estimated Arrival)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return new Date(value).toLocaleDateString('id-ID', { 
                                        month: 'short', 
                                        day: 'numeric' 
                                    });
                                }
                            }
                        },
                        y: {
                            type: 'linear',
                            title: {
                                display: true,
                                text: 'ATA (Actual Arrival)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return new Date(value).toLocaleDateString('id-ID', { 
                                        month: 'short', 
                                        day: 'numeric' 
                                    });
                                }
                            }
                        }
                    }
                }
            });
            
            // Tambahkan garis diagonal untuk referensi "on time"
            this.addReferenceLine();
        }
        
        addReferenceLine() {
            // Tambahkan reference line setelah chart update
            const chart = this.chart;
            
            // Plugin untuk menggambar garis diagonal
            const referenceLinePlugin = {
                id: 'referenceLine',
                afterDraw: function(chart) {
                    const ctx = chart.ctx;
                    const xScale = chart.scales.x;
                    const yScale = chart.scales.y;
                    
                    if (!xScale || !yScale) return;
                    
                    // Gambar garis diagonal (ETA = ATA)
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
        }
        
        updateChart() {
            const data = this.filteredData.filter(item => item.ata !== null);
            
            // Kategorikan data
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
            
            // Update chart data
            this.chart.data.datasets[0].data = onTime;
            this.chart.data.datasets[1].data = early;
            this.chart.data.datasets[2].data = late;
            
            this.chart.update();
            
            // Update summary statistics
            this.updateSummaryStats(data);
        }
        
        updateSummaryStats(data) {
            const total = data.length;
            
            if (total === 0) {
                document.getElementById('onTimeCount').textContent = '0';
                document.getElementById('onTimePercentage').textContent = '0%';
                document.getElementById('earlyCount').textContent = '0';
                document.getElementById('earlyPercentage').textContent = '0%';
                document.getElementById('lateCount').textContent = '0';
                document.getElementById('latePercentage').textContent = '0%';
                document.getElementById('avgDelay').textContent = '0';
                
                // Urgency stats
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
            
            // Performance stats
            document.getElementById('onTimeCount').textContent = onTime;
            document.getElementById('onTimePercentage').textContent = `${Math.round((onTime / total) * 100)}%`;
            
            document.getElementById('earlyCount').textContent = early;
            document.getElementById('earlyPercentage').textContent = `${Math.round((early / total) * 100)}%`;
            
            document.getElementById('lateCount').textContent = late;
            document.getElementById('latePercentage').textContent = `${Math.round((late / total) * 100)}%`;
            
            document.getElementById('avgDelay').textContent = Math.round(avgDelay * 10) / 10;
            
            // Urgency stats (from all filtered data, not just completed)
            const allFilteredData = this.filteredData;
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

    // Inisialisasi chart setelah DOM loaded
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, initializing ETA ATA chart...');
        
        // Tunggu sebentar untuk memastikan semua library loaded
        setTimeout(() => {
            try {
                window.etaAtaChart = new ETAATAChartManager();
                console.log('Chart initialized successfully');
                
                // Initial update
                window.etaAtaChart.updateChart();
                console.log('Chart updated with data');
                
            } catch (error) {
                console.error('Error initializing chart:', error);
            }
        }, 500);
    });
</script>

@endsection