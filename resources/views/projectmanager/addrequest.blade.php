@extends('layouts.app')

@section('content')
    @include('components.navpm')

    <div class="flex min-h-screen">
          @include('components.sidepm')
          <div class="bg-gray-100 min-h-screen p-6 flex-1">
             <div class="bg-red-500 text-white px-6 py-4 rounded-md shadow">
                <h2 class="text-xl font-bold">Procurement Request </h2>
                <p class="text-sm">Manage your team's procurement needs</p>
            </div>

      <div class="max-w-7xl mx-auto mt-6">

        <!-- Header -->
       <div class="flex justify-end items-center mb-6">
          <a href="{{ route('projectmanager.formadd') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors ml-auto">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
              </svg>  
              Add Request
          </a>
      </div>


        <!-- Genset Cards Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Card 1 -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="mb-4">
                    <div class="flex-1">
                      <h1 class="text-3xl font-bold text-gray-800">Genset</h1>
                        <div class="flex items-center gap-3 mb-4">
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium">High</span>
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">Pending</span>
                        </div>
                        
                        <div class="space-y-4">
                            <!-- Basic Info -->
                            <div class="space-y-3">
                                <div>
                                    <span class="text-gray-600 text-sm font-medium">Category:</span>
                                    <p class="font-semibold text-gray-800">EQUIPMENT</p>
                                </div>
                                
                                <div>
                                    <span class="text-gray-600 text-sm font-medium">Budget:</span>
                                    <p class="font-semibold text-gray-800">Rp. 840.000.000</p>
                                </div>
                                
                                <div>
                                    <span class="text-gray-600 text-sm font-medium">Date Of Request:</span>
                                    <p class="font-semibold text-gray-800">12/06/2025</p>
                                </div>
                            </div>
                            
                            <!-- Detail Items -->
                            <div class="space-y-3">
                                <div>
                                    <span class="text-gray-600 text-sm font-medium">Detail Items:</span>
                                </div>
                                
                                <div class="space-y-3 bg-gray-50 p-3 rounded-lg">
                                    <div class="flex flex-col space-y-2">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <p class="text-sm text-gray-600">Model: HG 250 CDG</p>
                                                <p class="text-sm text-gray-600">Engine: CUMMINS 6LTAA8.9-G2</p>
                                                <p class="text-sm text-gray-600">Generator: DAIGENKO DGK274K</p>
                                            </div>
                                            <span class="text-red-600 font-semibold text-sm">Rp. 400.000.000</span>
                                        </div>
                                        
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <p class="text-sm text-gray-600">Model: HG 250 CD [6LT]</p>
                                                <p class="text-sm text-gray-600">Engine: CUMMINS 6LTAA8.9-G2</p>
                                                <p class="text-sm text-gray-600">Generator: STAMFORD UC0274K14</p>
                                            </div>
                                            <span class="text-red-600 font-semibold text-sm">Rp. 480.000.000</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex gap-3 mt-6 justify-end">
                            <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium transition-colors text-sm">
                                Delete
                            </button>
                            <button type="button" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium transition-colors text-sm inline-block">
                                Edit
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="mb-4">
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-gray-800">Excavator</h1>
                        <div class="flex items-center gap-3 mb-4">
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">Medium</span>
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">In Process</span>
                        </div>
                        
                        <div class="space-y-4">
                            <!-- Basic Info -->
                            <div class="space-y-3">
                                <div>
                                    <span class="text-gray-600 text-sm font-medium">Category:</span>
                                    <p class="font-semibold text-gray-800">EQUIPMENT</p>
                                </div>
                                
                                <div>
                                    <span class="text-gray-600 text-sm font-medium">Budget:</span>
                                    <p class="font-semibold text-gray-800">Rp. 840.000.000</p>
                                </div>
                                
                                <div>
                                    <span class="text-gray-600 text-sm font-medium">Date Of Request:</span>
                                    <p class="font-semibold text-gray-800">12/06/2025</p>
                                </div>
                            </div>
                            
                            <!-- Detail Items -->
                            <div class="space-y-3">
                                <div>
                                    <span class="text-gray-600 text-sm font-medium">Detail Items:</span>
                                </div>
                                
                                <div class="space-y-3 bg-gray-50 p-3 rounded-lg">
                                    <div class="flex flex-col space-y-2">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <p class="text-sm text-gray-600">Model: HG 250 CDG</p>
                                                <p class="text-sm text-gray-600">Engine: CUMMINS 6LTAA8.9-G2</p>
                                                <p class="text-sm text-gray-600">Generator: DAIGENKO DGK274K</p>
                                            </div>
                                            <span class="text-red-600 font-semibold text-sm">Rp. 400.000.000</span>
                                        </div>
                                        
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <p class="text-sm text-gray-600">Model: HG 250 CD [6LT]</p>
                                                <p class="text-sm text-gray-600">Engine: CUMMINS 6LTAA8.9-G2</p>
                                                <p class="text-sm text-gray-600">Generator: STAMFORD UC0274K14</p>
                                            </div>
                                            <span class="text-red-600 font-semibold text-sm">Rp. 480.000.000</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex gap-3 mt-6 justify-end">
                            <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium transition-colors text-sm">
                                Delete
                            </button>
                            <button type="button" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium transition-colors text-sm inline-block">
                                Edit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Optional: Add any JavaScript functionality here
    document.addEventListener('DOMContentLoaded', function() {
        // Add event listeners for buttons
        const deleteButtons = document.querySelectorAll('button:contains("Delete")');
        const editButtons = document.querySelectorAll('button:contains("Edit")');
        
        // You can add confirmation dialogs or other functionality here
    });
</script>
@endpush