@extends('layouts.app')

@section('content')
    @include('components.navpm')
    
    <div class="flex min-h-screen">
        @include('components.sidepm')
        
        <div class="bg-gray-100 min-h-screen p-6 flex-1">
            <!-- Header -->
            <div class="bg-red-500 text-white px-6 py-4 rounded-md shadow mb-6">
                <h2 class="text-xl font-bold">Construction Materials Procurement</h2>
                <p class="text-sm">Track construction material deliveries and manage project supply chain</p>
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
           <!-- Controls -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <div class="grid grid-cols-4 gap-4 mb-4">
            <div class="flex flex-col space-y-1">
                <label class="text-xs font-medium text-gray-700 uppercase tracking-wide">Search</label>
                <input type="text" id="searchInput" placeholder="Search materials, suppliers..." 
                    class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
            </div>
            <div class="flex flex-col space-y-1">
                <label class="text-xs font-medium text-gray-700 uppercase tracking-wide">Status</label>
                <select id="statusFilter" class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    <option value="all">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="in-progress">In Progress</option>
                    <option value="completed">Completed</option>
                    <option value="delayed">Delayed</option>
                </select>
            </div>
            <div class="flex flex-col space-y-1">
                <label class="text-xs font-medium text-gray-700 uppercase tracking-wide">Category</label>
                <select id="categoryFilter" class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    <option value="all">All Categories</option>
                </select>
            </div>
            <div class="flex flex-col space-y-1">
                <label class="text-xs font-medium text-gray-700 uppercase tracking-wide">Items per page</label>
                <select id="itemsPerPage" class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    <option value="10">10</option>
                    <option value="25" selected>25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>

    <!-- Pagination Info -->
    <div class="flex items-center justify-between">
        <div class="text-sm text-gray-600">
            Showing <span id="showingStart">1</span>-<span id="showingEnd">25</span> of <span id="totalItems">0</span> items
        </div>
        <div class="flex items-center space-x-2">
            <button id="prevPage" onclick="changePage(-1)" class="px-3 py-1 text-sm border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                Previous
            </button>
            <span id="pageInfo" class="text-sm text-gray-600">Page 1 of 1</span>
            <button id="nextPage" onclick="changePage(1)" class="px-3 py-1 text-sm border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                Next
            </button>
        </div>
    </div>
</div>
            <!-- Timeline Container -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Construction Materials Timeline</h3>
                        <div class="flex items-center space-x-4 text-sm">
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-blue-500 rounded"></div>
                                <span>Pending</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-yellow-500 rounded"></div>
                                <span>In Progress</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-green-500 rounded"></div>
                                <span>Completed</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-red-500 rounded"></div>
                                <span>Delayed</span>
                            </div>
                        </div>
                    </div>

                    <!-- Loading indicator -->
                    <div id="loadingIndicator" class="text-center py-8 hidden">
                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
                        <p class="text-sm text-gray-600 mt-2">Loading...</p>
                    </div>

                    <!-- Timeline Header -->
                    <div id="timelineHeader" class="border-b border-gray-200 pb-4 mb-4"></div>

                    <!-- Timeline Content -->
                    <div id="timelineContent" class="space-y-2 min-h-[400px]"></div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-md flex items-center justify-center">
                                <div class="w-4 h-4 bg-blue-500 rounded"></div>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Materials</p>
                            <p id="statTotal" class="text-2xl font-semibold text-gray-900">0</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-100 rounded-md flex items-center justify-center">
                                <div class="w-4 h-4 bg-yellow-500 rounded"></div>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">In Progress</p>
                            <p id="statInProgress" class="text-2xl font-semibold text-gray-900">0</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-md flex items-center justify-center">
                                <div class="w-4 h-4 bg-green-500 rounded"></div>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Completed</p>
                            <p id="statCompleted" class="text-2xl font-semibold text-gray-900">0</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-red-100 rounded-md flex items-center justify-center">
                                <div class="w-4 h-4 bg-red-500 rounded"></div>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Delayed</p>
                            <p id="statDelayed" class="text-2xl font-semibold text-gray-900">0</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Adding New Item -->
    <div id="addItemModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Add New Construction Material</h3>
                    <form id="addItemForm">
                        <div class="space-y-4">
                            <!-- Quantity -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Quantity <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="qty" name="qty" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter quantity" required min="1">
                                <div class="text-red-500 text-sm mt-1 hidden" id="qty-error">Quantity is required and must be a valid number</div>
                            </div>

                            <!-- Unit -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Unit <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="unit" name="unit" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g., sak, m³, kg, pcs" required>
                                <div class="text-red-500 text-sm mt-1 hidden" id="unit-error">Unit is required</div>
                            </div>

                            <!-- Category -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Category <span class="text-red-500">*</span>
                                </label>
                                <select id="category" name="category" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="">Select Category</option>
                                    <option value="Material">Material</option>
                                    <option value="Equipment">Equipment</option>
                                    <option value="Electrical Tools">Electrical Tools</option>
                                    <option value="Consumables">Consumables</option>
                                    <option value="Personal Protective Equipment">Personal Protective Equipment</option>
                                </select>
                                <div class="text-red-500 text-sm mt-1 hidden" id="category-error">Category is required</div>
                            </div>

                            <!-- Supplier -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Supplier <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="supplier" name="supplier" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter supplier name" required>
                                <div class="text-red-500 text-sm mt-1 hidden" id="supplier-error">Supplier is required</div>
                            </div>

                            <!-- Budget -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Budget (IDR) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="budget" name="budget" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter budget amount" required min="0">
                                <div class="text-red-500 text-sm mt-1 hidden" id="budget-error">Budget is required</div>
                            </div>

                            <!-- Commodity Code -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Commodity Code
                                </label>
                                <input type="text" id="commcode" name="commcode" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter commodity code (optional)">
                            </div>

                            <!-- Description -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Description <span class="text-red-500">*</span>
                                </label>
                                <textarea id="description" name="description" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter material description" required></textarea>
                                <div class="text-red-500 text-sm mt-1 hidden" id="description-error">Description is required</div>
                            </div>

                            <!-- Specification -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Specification
                                </label>
                                <textarea id="specification" name="specification" rows="2" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter material specification (optional)"></textarea>
                            </div>

                            <!-- Start Date -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Start Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="startDate" name="startDate" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <div class="text-red-500 text-sm mt-1 hidden" id="startDate-error">Start date is required</div>
                            </div>

                            <!-- End Date -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    End Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="endDate" name="endDate" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <div class="text-red-500 text-sm mt-1 hidden" id="endDate-error">End date is required and must be after start date</div>
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select id="status" name="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="">Select Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="in-progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                    <option value="delayed">Delayed</option>
                                </select>
                                <div class="text-red-500 text-sm mt-1 hidden" id="status-error">Status is required</div>
                            </div>

                            <!-- Remarks -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Remarks
                                </label>
                                <textarea id="remarks" name="remarks" rows="2" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Additional remarks (optional)"></textarea>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="button" onclick="closeModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        // Optimized data management class
        class ProcurementDataManager {
            constructor() {
                this.allData = this.generateSampleData();
                this.filteredData = [...this.allData];
                this.currentPage = 1;
                this.itemsPerPage = 25;
                this.searchQuery = '';
                this.statusFilter = 'all';
                this.categoryFilter = 'all';
                this.categories = new Set();
                
                // Cache for computed values
                this.cache = new Map();
                
                this.updateCategories();
            }

            generateSampleData() {
                const data = [];
                const categories = ["Material", "Equipment", "Electrical Tools", "Consumables", "Personal Protective Equipment"];
                const statuses = ["pending", "in-progress", "completed", "delayed"];
                const suppliers = [
                    "PT Krakatau Steel", "PT Semen Indonesia", "CV Sumber Alam Jaya", "PT Roman Ceramics",
                    "PT Propan Raya", "UD Bata Mandiri", "PT Rucika Indonesia", "PT Genteng Nusantara",
                    "CV Kayu Jati Mas", "PT Wire Industries", "PT Holcim Indonesia", "PT Indocement",
                    "CV Baja Ringan", "PT Keramika Indonesia", "UD Pasir Bangunan", "PT Pipa Prima"
                ];
                
                const materialsByCategory = {
                    "Material": [
                        "Besi Beton SNI", "Semen Portland", "Pasir Beton", "Keramik Lantai", 
                        "Bata Merah Press", "Pipa PVC", "Genteng Beton", "Kayu Balok", 
                        "Baja Ringan", "Kaca Jendela", "Pintu Panel", "Atap Spandek"
                    ],
                    "Equipment": [
                        "Excavator", "Concrete Mixer", "Tower Crane", "Bulldozer",
                        "Compactor", "Generator Set", "Welding Machine", "Air Compressor",
                        "Concrete Pump", "Scaffolding System", "Formwork Panel", "Hoist"
                    ],
                    "Electrical Tools": [
                        "Power Drill", "Angle Grinder", "Circular Saw", "Impact Driver",
                        "Multimeter", "Cable Tester", "Electrical Pliers", "Wire Stripper",
                        "Voltage Tester", "Soldering Iron", "Heat Gun", "Electric Hammer"
                    ],
                    "Consumables": [
                        "Welding Rod", "Cutting Disc", "Drill Bits", "Screws & Bolts",
                        "Sandpaper", "Adhesive Tape", "Cable Ties", "Fuses",
                        "Electrical Wire", "Conduit Pipe", "Junction Box", "Cable Clamps"
                    ],
                    "Personal Protective Equipment": [
                        "Safety Helmet", "Safety Boots", "Work Gloves", "Safety Goggles",
                        "Reflective Vest", "Ear Plugs", "Face Mask", "Safety Harness",
                        "Hard Hat", "Steel Toe Boots", "Cut Resistant Gloves", "Safety Glasses"
                    ]
                };

                // Generate 100 sample items
                for (let i = 1; i <= 100; i++) {
                    const startDate = new Date(2025, 6, Math.floor(Math.random() * 60) + 1);
                    const endDate = new Date(startDate.getTime() + (Math.random() * 60 + 7) * 24 * 60 * 60 * 1000);
                    const status = statuses[Math.floor(Math.random() * statuses.length)];
                    const category = categories[Math.floor(Math.random() * categories.length)];
                    const categoryMaterials = materialsByCategory[category];
                    const material = categoryMaterials[Math.floor(Math.random() * categoryMaterials.length)];
                    
                    // Define units based on category
                    let unit;
                    switch(category) {
                        case "Material":
                            unit = ['m³', 'sak', 'batang', 'lembar', 'unit'][Math.floor(Math.random() * 5)];
                            break;
                        case "Equipment":
                            unit = ['unit', 'set'][Math.floor(Math.random() * 2)];
                            break;
                        case "Electrical Tools":
                            unit = ['unit', 'pcs'][Math.floor(Math.random() * 2)];
                            break;
                        case "Consumables":
                            unit = ['pcs', 'kg', 'meter', 'roll', 'box'][Math.floor(Math.random() * 5)];
                            break;
                        case "Personal Protective Equipment":
                            unit = ['pcs', 'pair', 'unit'][Math.floor(Math.random() * 3)];
                            break;
                        default:
                            unit = 'unit';
                    }
                    
                    data.push({
                        id: i,
                        name: `${material} ${Math.floor(Math.random() * 100) + 10} ${unit}`,
                        supplier: suppliers[Math.floor(Math.random() * suppliers.length)],
                        startDate,
                        endDate,
                        status,
                        budget: Math.floor(Math.random() * 90000000) + 10000000,
                        progress: status === 'completed' ? 100 : 
                                 status === 'in-progress' ? Math.floor(Math.random() * 80) + 20 :
                                 status === 'delayed' ? Math.floor(Math.random() * 30) + 10 : 0,
                        category,
                        unit
                    });
                }
                
                return data;
            }

            updateCategories() {
                this.categories.clear();
                this.allData.forEach(item => this.categories.add(item.category));
                this.populateCategoryFilter();
            }

            populateCategoryFilter() {
                const categorySelect = document.getElementById('categoryFilter');
                categorySelect.innerHTML = '<option value="all">All Categories</option>';
                [...this.categories].sort().forEach(category => {
                    categorySelect.innerHTML += `<option value="${category}">${category}</option>`;
                });
            }

            applyFilters() {
                this.cache.clear();
                
                this.filteredData = this.allData.filter(item => {
                    const matchesSearch = this.searchQuery === '' || 
                        item.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                        item.supplier.toLowerCase().includes(this.searchQuery.toLowerCase());
                    
                    const matchesStatus = this.statusFilter === 'all' || item.status === this.statusFilter;
                    const matchesCategory = this.categoryFilter === 'all' || item.category === this.categoryFilter;
                    
                    return matchesSearch && matchesStatus && matchesCategory;
                });
                
                this.currentPage = 1;
            }

            getPaginatedData() {
                const start = (this.currentPage - 1) * this.itemsPerPage;
                const end = start + this.itemsPerPage;
                return this.filteredData.slice(start, end);
            }

            getTotalPages() {
                return Math.ceil(this.filteredData.length / this.itemsPerPage);
            }

            getStatistics() {
                const cacheKey = `stats_${this.statusFilter}_${this.categoryFilter}_${this.searchQuery}`;
                if (this.cache.has(cacheKey)) {
                    return this.cache.get(cacheKey);
                }

                const stats = {
                    total: this.filteredData.length,
                    pending: this.filteredData.filter(item => item.status === 'pending').length,
                    inProgress: this.filteredData.filter(item => item.status === 'in-progress').length,
                    completed: this.filteredData.filter(item => item.status === 'completed').length,
                    delayed: this.filteredData.filter(item => item.status === 'delayed').length
                };

                this.cache.set(cacheKey, stats);
                return stats;
            }

            addItem(item) {
                item.id = this.allData.length + 1;
                this.allData.push(item);
                this.updateCategories();
                this.applyFilters();
            }
        }

        // Initialize data manager
        const dataManager = new ProcurementDataManager();

        // Status colors
        const statusColors = {
            'pending': 'bg-blue-500',
            'in-progress': 'bg-yellow-500',  
            'completed': 'bg-green-500',
            'delayed': 'bg-red-500'
        };

        // Debounce function for search
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Generate timeline header
        function generateTimelineHeader() {
            const header = document.getElementById('timelineHeader');
            const today = new Date();
            const months = [];
            
            for (let i = -2; i <= 3; i++) {
                const date = new Date(today.getFullYear(), today.getMonth() + i, 1);
                months.push({
                    name: date.toLocaleDateString('id-ID', { month: 'short', year: 'numeric' }),
                    date: date
                });
            }

            header.innerHTML = `
                <div class="flex">
                    <div class="w-72 flex-shrink-0"></div>
                    <div class="flex-1 grid grid-cols-6 gap-1">
                        ${months.map(month => `
                            <div class="text-center text-sm font-medium text-gray-600 py-2">
                                ${month.name}
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;
        }

        // Modal functions
        function openModal() {
            document.getElementById('addItemModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('addItemModal').classList.add('hidden');
            document.getElementById('addItemForm').reset();
            document.querySelectorAll('[id$="-error"]').forEach(error => {
                error.classList.add('hidden');
            });
        }

        // Form validation
        function validateForm() {
            let isValid = true;
            
            // Validate all required fields
            const requiredFields = ['qty', 'unit', 'category', 'supplier', 'budget', 'description', 'startDate', 'endDate', 'status'];
            
            requiredFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                const errorElement = document.getElementById(`${fieldId}-error`);
                
                if (!field.value.trim()) {
                    errorElement.classList.remove('hidden');
                    isValid = false;
                } else {
                    errorElement.classList.add('hidden');
                }
            });

            // Validate date order
            const startDate = new Date(document.getElementById('startDate').value);
            const endDate = new Date(document.getElementById('endDate').value);
            const endDateError = document.getElementById('endDate-error');
            
            if (startDate && endDate && endDate <= startDate) {
                endDateError.textContent = 'End date must be after start date';
                endDateError.classList.remove('hidden');
                isValid = false;
            } else if (document.getElementById('endDate').value) {
                endDateError.classList.add('hidden');
            }

            // Validate quantity
            const qty = document.getElementById('qty');
            const qtyError = document.getElementById('qty-error');
            if (!qty.value || parseInt(qty.value) < 1) {
                qtyError.classList.remove('hidden');
                isValid = false;
            } else {
                qtyError.classList.add('hidden');
            }

            // Validate budget
            const budget = document.getElementById('budget');
            const budgetError = document.getElementById('budget-error');
            if (!budget.value || parseInt(budget.value) < 0) {
                budgetError.classList.remove('hidden');
                isValid = false;
            } else {
                budgetError.classList.add('hidden');
            }

            return isValid;
        }

        // Calculate position and width for timeline bars
        function calculateTimelinePosition(startDate, endDate) {
            const today = new Date();
            const timelineStart = new Date(today.getFullYear(), today.getMonth() - 2, 1);
            const timelineEnd = new Date(today.getFullYear(), today.getMonth() + 4, 0);
            
            const totalDays = (timelineEnd - timelineStart) / (1000 * 60 * 60 * 24);
            const startOffset = Math.max(0, (startDate - timelineStart) / (1000 * 60 * 60 * 24));
            const duration = (endDate - startDate) / (1000 * 60 * 60 * 24);
            
            const leftPercent = (startOffset / totalDays) * 100;
            const widthPercent = Math.min((duration / totalDays) * 100, 100 - leftPercent);
            
            return { left: leftPercent, width: Math.max(widthPercent, 2) };
        }

        // Generate timeline content with pagination
        function generateTimelineContent() {
            const content = document.getElementById('timelineContent');
            const data = dataManager.getPaginatedData();
            
            if (data.length === 0) {
                content.innerHTML = `
                    <div class="text-center py-12">
                        <div class="text-gray-400 mb-4">
                            <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No materials found</h3>
                        <p class="text-gray-500">Try adjusting your search or filter criteria.</p>
                    </div>
                `;
                return;
            }

            const formatCurrency = (amount) => {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(amount);
            };

            const fragment = document.createDocumentFragment();
            
            data.forEach(item => {
                const position = calculateTimelinePosition(item.startDate, item.endDate);
                
                const row = document.createElement('div');
                row.className = 'flex items-center py-3 border-b border-gray-100 hover:bg-gray-50 transition-colors duration-200';
                
                row.innerHTML = `
                    <div class="w-72 flex-shrink-0 pr-4">
                        <h4 class="font-medium text-gray-900 text-sm truncate" title="${item.name}">${item.name}</h4>
                        <p class="text-xs text-gray-500 truncate" title="${item.supplier}">${item.supplier}</p>
                        <div class="flex items-center justify-between mt-1">
                            <p class="text-xs text-gray-400">${formatCurrency(item.budget)}</p>
                            <span class="text-xs bg-gray-100 text-gray-700 px-2 py-0.5 rounded">${item.category}</span>
                        </div>
                    </div>
                    <div class="flex-1 relative h-6 bg-gray-100 rounded mx-2">
                        <div class="absolute top-0 h-6 ${statusColors[item.status]} rounded opacity-80 hover:opacity-100 transition-opacity duration-200 cursor-pointer group"
                             style="left: ${position.left}%; width: ${position.width}%;"
                             title="${item.name} - ${item.status} (${item.progress}%)">
                            <div class="h-full flex items-center justify-center text-white text-xs font-medium">
                                ${item.progress}%
                            </div>
                            <!-- Tooltip -->
                            <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 bg-gray-900 text-white text-xs rounded shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-10 pointer-events-none">
                                <div class="font-medium">${item.name}</div>
                                <div>Start: ${item.startDate.toLocaleDateString('id-ID')}</div>
                                <div>End: ${item.endDate.toLocaleDateString('id-ID')}</div>
                                <div>Status: ${item.status}</div>
                                <div>Category: ${item.category}</div>
                                <div>Budget: ${formatCurrency(item.budget)}</div>
                                <div class="absolute top-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-gray-900"></div>
                            </div>
                        </div>
                    </div>
                    <div class="w-20 flex-shrink-0 text-right">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize
                            ${item.status === 'completed' ? 'bg-green-100 text-green-800' : 
                              item.status === 'in-progress' ? 'bg-yellow-100 text-yellow-800' : 
                              item.status === 'delayed' ? 'bg-red-100 text-red-800' : 
                              'bg-blue-100 text-blue-800'}">
                            ${item.status.replace('-', ' ')}
                        </span>
                    </div>
                `;
                
                fragment.appendChild(row);
            });

            content.innerHTML = '';
            content.appendChild(fragment);
        }

        // Update pagination info
        function updatePaginationInfo() {
            const totalPages = dataManager.getTotalPages();
            const start = (dataManager.currentPage - 1) * dataManager.itemsPerPage + 1;
            const end = Math.min(dataManager.currentPage * dataManager.itemsPerPage, dataManager.filteredData.length);
            
            document.getElementById('showingStart').textContent = dataManager.filteredData.length > 0 ? start : 0;
            document.getElementById('showingEnd').textContent = end;
            document.getElementById('totalItems').textContent = dataManager.filteredData.length;
            document.getElementById('pageInfo').textContent = `Page ${dataManager.currentPage} of ${totalPages}`;
            
            document.getElementById('prevPage').disabled = dataManager.currentPage === 1;
            document.getElementById('nextPage').disabled = dataManager.currentPage === totalPages;
        }

        // Update statistics
        function updateStatistics() {
            const stats = dataManager.getStatistics();
            
            document.getElementById('statTotal').textContent = stats.total;
            document.getElementById('statInProgress').textContent = stats.inProgress;
            document.getElementById('statCompleted').textContent = stats.completed;
            document.getElementById('statDelayed').textContent = stats.delayed;
        }

        // Change page
        function changePage(direction) {
            const totalPages = dataManager.getTotalPages();
            const newPage = dataManager.currentPage + direction;
            
            if (newPage >= 1 && newPage <= totalPages) {
                dataManager.currentPage = newPage;
                generateTimelineContent();
                updatePaginationInfo();
            }
        }

        // Apply filters and update display
        function applyFiltersAndUpdate() {
            dataManager.searchQuery = document.getElementById('searchInput').value;
            dataManager.statusFilter = document.getElementById('statusFilter').value;
            dataManager.categoryFilter = document.getElementById('categoryFilter').value;
            dataManager.itemsPerPage = parseInt(document.getElementById('itemsPerPage').value);
            
            dataManager.applyFilters();
            generateTimelineContent();
            updatePaginationInfo();
            updateStatistics();
        }

        // Show success toast
        function showSuccessToast(message) {
            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300';
            toast.textContent = message;
            document.body.appendChild(toast);
            
            // Animate in
            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 100);
            
            // Animate out and remove
            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 300);
            }, 3000);
        }

        // Initialize dashboard
        function initializeDashboard() {
            generateTimelineHeader();
            generateTimelineContent();
            updatePaginationInfo();
            updateStatistics();
        }

        // Event listeners setup
        document.addEventListener('DOMContentLoaded', function() {
            initializeDashboard();

            // Search with debounce
            const debouncedSearch = debounce(applyFiltersAndUpdate, 300);
            document.getElementById('searchInput').addEventListener('input', debouncedSearch);
            
            // Filter listeners
            document.getElementById('statusFilter').addEventListener('change', applyFiltersAndUpdate);
            document.getElementById('categoryFilter').addEventListener('change', applyFiltersAndUpdate);
            document.getElementById('itemsPerPage').addEventListener('change', applyFiltersAndUpdate);
            
            // Form submission
            document.getElementById('addItemForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (!validateForm()) {
                    return;
                }
                
                const formData = new FormData(e.target);
                const newItem = {
                    name: `${formData.get('description')} ${formData.get('qty')} ${formData.get('unit')}`,
                    supplier: formData.get('supplier'),
                    startDate: new Date(formData.get('startDate')),
                    endDate: new Date(formData.get('endDate')),
                    status: formData.get('status'),
                    budget: parseInt(formData.get('budget')) || 0,
                    progress: formData.get('status') === 'completed' ? 100 : 
                             formData.get('status') === 'in-progress' ? 50 : 
                             formData.get('status') === 'delayed' ? 25 : 0,
                    category: formData.get('category'),
                    unit: formData.get('unit')
                };
                
                dataManager.addItem(newItem);
                applyFiltersAndUpdate();
                closeModal();
                showSuccessToast('Material added successfully!');
            });

            // Close modal when clicking outside
            document.getElementById('addItemModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey || e.metaKey) {
                    switch(e.key) {
                        case 'ArrowLeft':
                            e.preventDefault();
                            changePage(-1);
                            break;
                        case 'ArrowRight':
                            e.preventDefault();
                            changePage(1);
                            break;
                        case 'k':
                            e.preventDefault();
                            document.getElementById('searchInput').focus();
                            break;
                    }
                }
                
                // ESC to close modal
                if (e.key === 'Escape') {
                    closeModal();
                }
            });

            // Add tooltips for keyboard shortcuts
            const searchInput = document.getElementById('searchInput');
            searchInput.setAttribute('title', 'Search materials and suppliers (Ctrl+K)');
            
            const prevButton = document.getElementById('prevPage');
            const nextButton = document.getElementById('nextPage');
            prevButton.setAttribute('title', 'Previous page (Ctrl+←)');
            nextButton.setAttribute('title', 'Next page (Ctrl+→)');

            // Real-time validation for form fields
            const formFields = document.querySelectorAll('#addItemForm input, #addItemForm select, #addItemForm textarea');
            formFields.forEach(field => {
                field.addEventListener('blur', function() {
                    const errorElement = document.getElementById(`${this.id}-error`);
                    if (this.hasAttribute('required') && !this.value.trim()) {
                        errorElement?.classList.remove('hidden');
                    } else {
                        errorElement?.classList.add('hidden');
                    }
                });
            });

            // Date validation
            document.getElementById('endDate').addEventListener('change', function() {
                const startDate = new Date(document.getElementById('startDate').value);
                const endDate = new Date(this.value);
                const errorElement = document.getElementById('endDate-error');
                
                if (startDate && endDate && endDate <= startDate) {
                    errorElement.textContent = 'End date must be after start date';
                    errorElement.classList.remove('hidden');
                } else {
                    errorElement.classList.add('hidden');
                }
            });
        });
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