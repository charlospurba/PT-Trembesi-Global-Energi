@extends('layouts.app')

@section('content')
    @include('components.navpm')

    <div class="flex min-h-screen bg-gradient-to-br from-red-50 via-rose-50 to-pink-50">
        @include('components.sidepm')
        <div class="flex-1 p-6">
            <div class="max-w-5xl mx-auto mt-8">

                {{-- Main Form Card --}}
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    {{-- Header --}}
                    <div class="bg-gradient-to-r from-red-600 to-rose-600 px-8 py-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-white">Tambah PM Request</h1>
                                <p class="text-red-100 text-sm">Lengkapi formulir untuk membuat permintaan material baru</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-8">
                        {{-- Error Alert --}}
                        @if ($errors->any())
                            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-lg">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan pada form:</h3>
                                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Form --}}
                        <form action="{{ route('pm-requests.store') }}" method="POST" class="space-y-6">
                            @csrf

                            {{-- Grid Layout --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Project Name --}}
                                <div class="group">
                                    <label for="project_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <span class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 6h16M4 12h16M4 18h16"></path>
                                            </svg>
                                            <span>Project Name</span>
                                            <span class="text-red-500">*</span>
                                        </span>
                                    </label>
                                    <input type="text" name="project_name" id="project_name" value="{{ $projectName }}"
                                        class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-gray-100 cursor-not-allowed text-gray-700"
                                        readonly>
                                </div>

                                {{-- Item --}}
                                <div class="group">
                                    <label for="item" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <span class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                            </svg>
                                            <span>Item</span>
                                            <span class="text-red-500">*</span>
                                        </span>
                                    </label>
                                    <input type="string" name="item" id="qty" value="{{ old('item') }}"
                                        class="w-full border border-gray-300 rounded-xl px-4 py-3 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent hover:border-gray-400 group-hover:shadow-sm"
                                        placeholder="Masukkan item" required>
                                </div>

                                {{-- Spesification --}}
                                <div class="group">
                                    <label for="specification" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <span class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 6h16M4 12h16M4 18h7"></path>
                                            </svg>
                                            <span>Specification</span>
                                        </span>
                                    </label>
                                    <textarea name="specification" id="specification" rows="4"
                                        class="w-full border border-gray-300 rounded-xl px-4 py-3 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent hover:border-gray-400 group-hover:shadow-sm resize-none"
                                        placeholder="Spesifikasi material yang dibutuhkan secara detail...">{{ old('specification') }}</textarea>
                                </div>

                                {{-- Unit --}}
                                <div class="group">
                                    <label for="unit" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <span class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <span>Unit</span>
                                            <span class="text-red-500">*</span>
                                        </span>
                                    </label>
                                    <input type="text" name="unit" id="unit" value="{{ old('unit') }}"
                                        class="w-full border border-gray-300 rounded-xl px-4 py-3 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent hover:border-gray-400 group-hover:shadow-sm"
                                        placeholder="e.g., kg, pcs, m³" required>
                                </div>

                                {{-- Qty --}}
                                <div class="group">
                                    <label for="qty" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <span class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                            </svg>
                                            <span>Quantity</span>
                                            <span class="text-red-500">*</span>
                                        </span>
                                    </label>
                                    <input type="number" name="qty" id="qty" value="{{ old('qty') }}"
                                        class="w-full border border-gray-300 rounded-xl px-4 py-3 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent hover:border-gray-400 group-hover:shadow-sm"
                                        placeholder="Masukkan jumlah" required>
                                </div>
                            </div>

                            {{-- Grid Layout for Date and Remarks --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Required Delivery Date --}}
                                <div class="group">
                                    <label for="required_delivery_date"
                                        class="block text-sm font-semibold text-gray-700 mb-2">
                                        <span class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <span>ETA</span>
                                        </span>
                                    </label>
                                    <input type="date" name="eta" id="eta"
                                        value="{{ old('eta') }}"
                                        class="w-full border border-gray-300 rounded-xl px-4 py-3 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent hover:border-gray-400 group-hover:shadow-sm">
                                </div>

                                {{-- Remark --}}
                                <div class="group">
                                    <label for="remarks" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <span class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                                                </path>
                                            </svg>
                                            <span>Remark</span>
                                        </span>
                                    </label>
                                    <textarea name="remark" id="remark" rows="3"
                                        class="w-full border border-gray-300 rounded-xl px-4 py-3 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent hover:border-gray-400 group-hover:shadow-sm resize-none"
                                        placeholder="Catatan tambahan (opsional)...">{{ old('remark') }}</textarea>
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div class="flex justify-end pt-6 border-t border-gray-100">
                                <button type="submit"
                                    class="group relative bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-semibold px-8 py-3 rounded-xl transition-all duration-200 transform hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                    <span class="flex items-center space-x-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg>
                                        <span>Submit Request</span>
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Import Section --}}
                <div class="mt-8 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    {{-- Header --}}
                    <div class="bg-gradient-to-r from-red-700 to-rose-700 px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-white">Import Request Barang</h2>
                                <p class="text-red-100 text-sm">Upload file Excel untuk import data dalam jumlah besar</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        {{-- Form Upload Excel --}}
                        <form action="{{ route('pmrequest.import') }}" method="POST" enctype="multipart/form-data"
                            class="space-y-6">
                            @csrf

                            {{-- File Upload --}}
                            <div class="group">
                                <label for="file" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <span class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        <span>Pilih File Excel</span>
                                        <span class="text-red-500">*</span>
                                    </span>
                                </label>
                                <div class="relative">
                                    <input type="file" name="file" id="file" accept=".xlsx, .xls" required
                                        class="block w-full text-sm text-gray-700 border border-gray-300 rounded-xl p-3 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent hover:border-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                                </div>
                                <p class="mt-2 text-xs text-gray-500">Format yang didukung: .xlsx, .xls (maksimal 10MB)</p>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <a href="{{ route('pmrequest.downloadTemplate') }}"
                                    class="group flex items-center space-x-2 text-sm text-red-600 hover:text-red-700 font-semibold transition-colors duration-200">
                                    <svg class="w-4 h-4 group-hover:scale-110 transition-transform duration-200" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2z">
                                        </path>
                                    </svg>
                                    <span>📥 Download Template</span>
                                </a>

                                <button type="submit"
                                    class="group relative bg-gradient-to-r from-red-700 to-rose-700 hover:from-red-800 hover:to-rose-800 text-white font-semibold px-6 py-2.5 rounded-xl transition-all duration-200 transform hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                    <span class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                            </path>
                                        </svg>
                                        <span>Upload File</span>
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection