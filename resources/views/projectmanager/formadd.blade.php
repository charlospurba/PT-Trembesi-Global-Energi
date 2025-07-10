@extends('layouts.app')

@section('content')
    @include('components.navpm')

    <div class="flex min-h-screen">
        @include('components.sidepm')
        <div class="bg-gray-100 min-h-screen p-6 flex-1">
            <div class="max-w-4xl mx-auto">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold text-gray-800">Add New Request</h1>
                      <a href="{{ route('dashboard.projectmanager') }}" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 shadow-md transition-colors duration-200">
                          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                          </svg>
                          Back to List
                      </a>
                </div>

                <!-- Form -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <form>
                        @csrf
                        
                        <!-- Basic Information -->
                        <div class="space-y-6">
                            <div class="border-b border-gray-200 pb-4">
                                <h2 class="text-xl font-semibold text-gray-800 mb-4">Basic Information</h2>
                            </div>

                            <!-- Request Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Request Title</label>
                                <input type="text" id="title" name="title" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="Enter request title (e.g., Genset, Excavator)">
                            </div>

                            <!-- Category and Priority -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                    <select id="category" name="category" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        <option value="">Select Category</option>
                                        <option value="EQUIPMENT">EQUIPMENT</option>
                                        <option value="MATERIALS">MATERIALS</option>
                                        <option value="SERVICES">SERVICES</option>
                                        <option value="MAINTENANCE">MAINTENANCE</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
                                    <select id="priority" name="priority" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                        <option value="">Select Priority</option>
                                        <option value="High">High</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Low">Low</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Budget and Date -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="budget" class="block text-sm font-medium text-gray-700 mb-2">Budget (Rp)</label>
                                    <input type="number" id="budget" name="budget" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                        placeholder="Enter budget amount">
                                </div>

                                <div>
                                    <label for="request_date" class="block text-sm font-medium text-gray-700 mb-2">Date of Request</label>
                                    <input type="date" id="request_date" name="request_date" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                        value="{{ date('Y-m-d') }}">
                                </div>
                            </div>

                            <!-- Detail Items Section -->
                            <div class="border-b border-gray-200 pb-4">
                                <h2 class="text-xl font-semibold text-gray-800 mb-4">Detail Items</h2>
                            </div>

                            <div id="items-container">
                                <!-- Item 1 -->
                                <div class="item-row bg-gray-50 p-4 rounded-lg mb-4">
                                    <div class="flex justify-between items-center mb-3">
                                        <h3 class="font-medium text-gray-800">Item #1</h3>
                                        <button type="button" class="remove-item bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition-colors" style="display: none;">
                                            Remove
                                        </button>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Model</label>
                                            <input type="text" name="items[0][model]" required
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                                placeholder="Enter model">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Price (Rp)</label>
                                            <input type="number" name="items[0][price]" required
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                                placeholder="Enter price">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Engine</label>
                                            <input type="text" name="items[0][engine]"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                                placeholder="Enter engine specification">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Generator</label>
                                            <input type="text" name="items[0][generator]"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                                placeholder="Enter generator specification">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Add Item Button -->
                            <div class="flex justify-start">
                                <button type="button" id="add-item" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add Another Item
                                </button>
                            </div>

                            <!-- Form Actions -->
                            <div class="relative mt-10">
                                <!-- Tombol Save & Cancel -->
                                <div class="absolute bottom-0 right-0 flex gap-3">
                                    <button type="button" onclick="window.location.href='{{ route('dashboard.projectmanager') }}'" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium transition-colors text-sm">
                                        Cancel
                                    </button>
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium transition-colors text-sm">
                                        Save Request
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                            <div class="border rounded-md mt-10 bg-white">
                        <div class="bg-gray-100 px-4 py-2 flex items-center gap-2 border-b">
                            <span class="text-red-600 text-xl">📂</span>
                            <h3 class="font-semibold text-lg">Upload Request Via Excel</h3>
                        </div>
                        <div class="p-4">
                            <div class="text-right mb-4">
                                <a 
                                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-semibold text-sm"
                                    download>
                                    Download Template Excel
                                </a>
                            </div>

                            <form  enctype="multipart/form-data"
                                class="space-y-4">
                                @csrf
                                <div>
                                    <label class="font-semibold block mb-1">Excel File</label>
                                    <input type="file" name="excel_file" accept=".xlsx,.xls" required
                                        class="w-full border px-4 py-2 rounded" />
                                    <p class="text-xs text-gray-500 italic mt-2">
                                        * Fill in all required columns in the Excel file and make sure the image file names match
                                        the names listed in the Zip file.
                                    </p>
                                </div>
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded font-semibold">
                                    Upload Products
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let itemCount = 1;
    const itemsContainer = document.getElementById('items-container');
    const addItemBtn = document.getElementById('add-item');

    // Add new item
    addItemBtn.addEventListener('click', function() {
        const newItem = createItemRow(itemCount);
        itemsContainer.appendChild(newItem);
        itemCount++;
        updateRemoveButtons();
    });

    // Remove item functionality
    itemsContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item')) {
            e.target.closest('.item-row').remove();
            updateRemoveButtons();
            reindexItems();
        }
    });

    function createItemRow(index) {
        const div = document.createElement('div');
        div.className = 'item-row bg-gray-50 p-4 rounded-lg mb-4';
        div.innerHTML = `
            <div class="flex justify-between items-center mb-3">
                <h3 class="font-medium text-gray-800">Item #${index + 1}</h3>
                <button type="button" class="remove-item bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition-colors">
                    Remove
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Model</label>
                    <input type="text" name="items[${index}][model]" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        placeholder="Enter model">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Price (Rp)</label>
                    <input type="number" name="items[${index}][price]" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        placeholder="Enter price">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Engine</label>
                    <input type="text" name="items[${index}][engine]"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        placeholder="Enter engine specification">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Generator</label>
                    <input type="text" name="items[${index}][generator]"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        placeholder="Enter generator specification">
                </div>
            </div>
        `;
        return div;
    }

    function updateRemoveButtons() {
        const items = itemsContainer.querySelectorAll('.item-row');
        items.forEach((item, index) => {
            const removeBtn = item.querySelector('.remove-item');
            if (items.length > 1) {
                removeBtn.style.display = 'block';
            } else {
                removeBtn.style.display = 'none';
            }
        });
    }

    function reindexItems() {
        const items = itemsContainer.querySelectorAll('.item-row');
        items.forEach((item, index) => {
            // Update item number display
            const itemTitle = item.querySelector('h3');
            itemTitle.textContent = `Item #${index + 1}`;
            
            // Update input names
            const inputs = item.querySelectorAll('input');
            inputs.forEach(input => {
                const name = input.getAttribute('name');
                if (name) {
                    const newName = name.replace(/\[\d+\]/, `[${index}]`);
                    input.setAttribute('name', newName);
                }
            });
        });
    }

    // Format budget input
    const budgetInput = document.getElementById('budget');
    budgetInput.addEventListener('input', function(e) {
        // Remove non-numeric characters except for dots
        let value = e.target.value.replace(/[^\d]/g, '');
        e.target.value = value;
    });
});
</script>
@endpush



