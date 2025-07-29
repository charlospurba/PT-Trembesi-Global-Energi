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
            <a href="{{ route('procurement.notes') }}" 
               class="inline-flex items-center bg-white text-red-600 px-4 py-2 text-sm rounded-full font-semibold shadow hover:bg-gray-100 transition-all duration-150">
               ← Back to Projects
            </a>
        </div>
    </div>
</section>

<!-- Timeline Chart Section -->
<section class="bg-white py-8 px-6 md:px-12 shadow-sm">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Project Timeline Overview</h2>
            
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
        
        <!-- Single Chart Container -->
        <div id="chartContainer" class="bg-gradient-to-br from-red-50 to-red-100 p-6 rounded-xl shadow-lg transition-all duration-300">
            <h3 id="chartTitle" class="text-lg font-bold text-red-800 mb-4 flex items-center">
                <span id="chartDot" class="w-4 h-4 bg-red-600 rounded-full mr-3"></span>
                <span id="chartTitleText">Project 1 - Heavy Equipment & Materials</span>
            </h3>
            <div class="bg-white rounded-lg p-4">
                <canvas id="projectTimeline" width="400" height="300"></canvas>
            </div>
            <div class="mt-4 text-center">
                <p id="chartDuration" class="text-sm text-red-700 font-medium">Duration: Jun 12 - Jul 15, 2024</p>
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
document.addEventListener('DOMContentLoaded', function() {
    let currentChart = null;
    
    // Project data
    const projectData = {
        project1: {
            title: 'Project 1 - Heavy Equipment & Materials',
            duration: 'Duration: Jun 12 - Jul 15, 2024',
            labels: ['Excavator', 'Cement', 'Concrete Mixer', 'Tower Crane', 'Rebar Steel', 'Scaffolding'],
            data: [19, 6, 9, 26, 14, 28], // Updated durations for all 6 items
            backgroundColor: [
                'rgba(220, 38, 38, 0.9)',
                'rgba(220, 38, 38, 0.8)',
                'rgba(220, 38, 38, 0.7)',
                'rgba(220, 38, 38, 0.6)',
                'rgba(220, 38, 38, 0.5)',
                'rgba(220, 38, 38, 0.4)'
            ],
            borderColor: 'rgba(220, 38, 38, 1)',
            dotColor: 'bg-red-600',
            titleColor: 'text-red-800',
            durationColor: 'text-red-700',
            containerBg: 'from-red-50 to-red-100'
        },
        project2: {
            title: 'Project 2 - Safety & Finishing Materials',
            duration: 'Duration: Jun 12 - Jul 05, 2024',
            labels: ['Safety Helmet', 'Steel Beams', 'Safety Vest', 'Fire Extinguisher', 'Paint Materials', 'First Aid Kit'],
            data: [6, 11, 6, 5, 11, 6], // Updated durations for all 6 items
            backgroundColor: [
                'rgba(37, 99, 235, 0.9)',
                'rgba(37, 99, 235, 0.8)',
                'rgba(37, 99, 235, 0.7)',
                'rgba(37, 99, 235, 0.6)',
                'rgba(37, 99, 235, 0.5)',
                'rgba(37, 99, 235, 0.4)'
            ],
            borderColor: 'rgba(37, 99, 235, 1)',
            dotColor: 'bg-blue-600',
            titleColor: 'text-blue-800',
            durationColor: 'text-blue-700',
            containerBg: 'from-blue-50 to-blue-100'
        }
    };

    // Function to update chart and UI
    function updateChart(projectKey) {
        const project = projectData[projectKey];
        const ctx = document.getElementById('projectTimeline').getContext('2d');
        
        // Destroy existing chart
        if (currentChart) {
            currentChart.destroy();
        }
        
        // Update UI elements
        document.getElementById('chartTitleText').textContent = project.title;
        document.getElementById('chartDuration').textContent = project.duration;
        
        // Update colors
        const chartTitle = document.getElementById('chartTitle');
        const chartDot = document.getElementById('chartDot');
        const chartDuration = document.getElementById('chartDuration');
        const chartContainer = document.getElementById('chartContainer');
        
        // Remove old classes
        chartTitle.className = chartTitle.className.replace(/text-\w+-800/g, '') + ' ' + project.titleColor;
        chartDot.className = chartDot.className.replace(/bg-\w+-600/g, '') + ' ' + project.dotColor;
        chartDuration.className = chartDuration.className.replace(/text-\w+-700/g, '') + ' ' + project.durationColor;
        chartContainer.className = chartContainer.className.replace(/from-\w+-50 to-\w+-100/g, '') + ' ' + project.containerBg;
        
        // Create new chart
        currentChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: project.labels,
                datasets: [{
                    label: 'Duration (Days)',
                    data: project.data,
                    backgroundColor: project.backgroundColor,
                    borderColor: Array(project.labels.length).fill(project.borderColor),
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
                            text: 'Days'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Item Duration Timeline'
                    }
                }
            }
        });
    }

    // Initialize with Project 1
    updateChart('project1');
    
    // Handle dropdown change
    document.getElementById('projectSelector').addEventListener('change', function() {
        updateChart(this.value);
    });
});
</script>

@endsection