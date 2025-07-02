@extends('layouts.app')

@section('content')
    @include('components.navadmin')

    <div class="flex h-screen overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100">
        @include('components.sideadmin')

        <div class="flex-1 p-8 overflow-y-auto">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Vendor Detail</h1>
                        <p class="text-gray-600">Review and manage vendor registration request</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('superadmin.request') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Requests
                        </a>
                        @php
                            $statusConfig = match ($vendor->status) {
                                'pending' => [
                                    'bg' => 'bg-yellow-100',
                                    'text' => 'text-yellow-800',
                                    'ring' => 'ring-yellow-600/20',
                                    'icon' => '⏳'
                                ],
                                'approved' => [
                                    'bg' => 'bg-green-100',
                                    'text' => 'text-green-800',
                                    'ring' => 'ring-green-600/20',
                                    'icon' => '✅'
                                ],
                                'rejected' => [
                                    'bg' => 'bg-red-100',
                                    'text' => 'text-red-800',
                                    'ring' => 'ring-red-600/20',
                                    'icon' => '❌'
                                ],
                                'Active' => [
                                    'bg' => 'bg-emerald-100',
                                    'text' => 'text-emerald-800',
                                    'ring' => 'ring-emerald-600/20',
                                    'icon' => '🟢'
                                ],
                                default => [
                                    'bg' => 'bg-gray-100',
                                    'text' => 'text-gray-800',
                                    'ring' => 'ring-gray-600/20',
                                    'icon' => '⚪'
                                ]
                            };
                        @endphp
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} ring-1 {{ $statusConfig['ring'] }}">
                            <span class="mr-2">{{ $statusConfig['icon'] }}</span>
                            {{ ucfirst($vendor->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                <!-- Header Card -->
                <div class="bg-gradient-to-r from-red-600 to-red-700 text-white px-8 py-6">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="h-16 w-16 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                <span class="text-white font-bold text-2xl">{{ substr($vendor->store_name, 0, 1) }}</span>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">{{ $vendor->store_name }}</h2>
                            <p class="text-red-100 text-sm">Vendor Registration Request</p>
                            <p class="text-red-100 text-xs mt-1">Submitted {{ $vendor->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Content Sections -->
                <div class="p-8">
                    <!-- Basic Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Basic Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <label class="text-sm font-medium text-red-600 block mb-1">Store Name</label>
                                <p class="text-gray-900 font-semibold">{{ $vendor->store_name }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <label class="text-sm font-medium text-red-600 block mb-1">Email Address</label>
                                <p class="text-gray-900">{{ $vendor->email }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <label class="text-sm font-medium text-red-600 block mb-1">Phone Number</label>
                                <p class="text-gray-900">{{ $vendor->phone_number }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <label class="text-sm font-medium text-red-600 block mb-1">Username</label>
                                <p class="text-gray-900">{{ $vendor->username }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Business Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h6m-6 4h6m-6 4h6"/>
                            </svg>
                            Business Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <label class="text-sm font-medium text-red-600 block mb-1">NPWP Number</label>
                                <p class="text-gray-900 font-mono">{{ $vendor->npwp }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <label class="text-sm font-medium text-red-600 block mb-1">NIB Number</label>
                                <p class="text-gray-900 font-mono">{{ $vendor->nib }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Documents Section -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Required Documents
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @php
                                $documents = [
                                    'comp_profile' => 'Company Profile',
                                    'izin_perusahaan' => 'Business License',
                                    'sppkp' => 'SPPKP Document',
                                    'struktur_organisasi' => 'Organizational Structure',
                                    'daftar_pengalaman' => 'Company Experience List'
                                ];
                            @endphp

                            @foreach($documents as $field => $label)
                                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4 border border-blue-200">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-sm font-semibold text-gray-900">{{ $label }}</h4>
                                            <p class="text-xs text-gray-600 mt-1">PDF Document</p>
                                        </div>
                                        <a href="{{ asset('storage/' . $vendor->$field) }}" 
                                           target="_blank"
                                           class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            View
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                @if($vendor->status === 'pending')
                    <div class="bg-gray-50 px-8 py-6 border-t border-gray-200 rounded-b-2xl">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-600">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                This vendor request is pending your review
                            </div>
                            <div class="flex items-center space-x-3">
                                <form method="POST" action="{{ route('superadmin.vendor.reject', $vendor->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            onclick="return confirm('Are you sure you want to reject this vendor request?')"
                                            class="inline-flex items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Reject Request
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('superadmin.vendor.accept', $vendor->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            onclick="return confirm('Are you sure you want to approve this vendor request?')"
                                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white text-sm font-semibold rounded-lg transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Accept Request
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-gray-50 px-8 py-4 border-t border-gray-200 rounded-b-2xl">
                        <div class="text-center text-sm text-gray-600">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            This vendor request has been {{ $vendor->status }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Custom Styles -->
    <style>
        /* Smooth scrollbar */
        .overflow-y-auto::-webkit-scrollbar {
            width: 8px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Button hover effects */
        .transform:hover {
            transform: translateY(-1px);
        }
    </style>
@endsection