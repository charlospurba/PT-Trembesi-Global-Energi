@extends('layouts.app')

@section('content')
    @include('components.navadmin')

    <div class="flex h-screen overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100">
        @include('components.sideadmin')

        {{-- SweetAlert --}}
        @if (session('success'))
            <script>
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-lg transition-colors duration-200'
                    }
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                Swal.fire({
                    title: 'Ditolak!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-6 rounded-lg transition-colors duration-200'
                    }
                });
            </script>
        @endif

        <div class="flex-1 p-8 overflow-y-auto scrollbar-thin scrollbar-thumb-slate-400 scrollbar-track-transparent">
            {{-- Header --}}
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Vendor Requests</h1>
                        <p class="text-gray-600">Manage and review vendor registration requests</p>
                    </div>
                    <div class="flex items-center space-x-2 bg-white px-4 py-2 rounded-lg shadow-sm border">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span class="text-sm font-medium text-gray-700">{{ $vendors->count() }} Total Requests</span>
                    </div>
                </div>
            </div>

            {{-- Card Section --}}
            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                {{-- Filter --}}
                <div class="bg-gradient-to-r from-red-50 to-white border-b border-red-200 p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Filter Requests
                        </h3>

                        <form method="GET" action="{{ route('superadmin.request') }}" class="flex items-center space-x-3">
                            <label for="status" class="text-sm font-medium text-gray-700">Status:</label>
                            <select name="status" id="status" onchange="this.form.submit()"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 px-4 py-2.5 min-w-[140px] transition-all duration-200 hover:border-gray-400">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>🟡 Pending</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>🟢 Approved</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>🔴 Rejected</option>
                                <option value="active" {{ request('status') == 'Active' ? 'selected' : '' }}>🟢 Active</option>
                            </select>
                        </form>
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-red-600 to-red-700 text-white">
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Store Name</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Registered</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse ($vendors as $vendor)
                                <tr class="hover:bg-gray-50 transition-colors duration-200 group">
                                    <td class="px-6 py-4 whitespace-nowrap flex items-center space-x-3">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-r from-red-500 to-red-600 flex items-center justify-center text-white font-semibold text-sm">
                                            {{ substr($vendor->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $vendor->name }}</div>
                                            <div class="text-xs text-gray-500">Store</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 font-medium">{{ $vendor->email }}</div>
                                        <div class="text-xs text-gray-500">Contact Email</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusConfig = match ($vendor->status) {
                                                'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'ring' => 'ring-yellow-600/20', 'icon' => '⏳'],
                                                'approved' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'ring' => 'ring-green-600/20', 'icon' => '✅'],
                                                'rejected' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'ring' => 'ring-red-600/20', 'icon' => '❌'],
                                                'Active' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'ring' => 'ring-blue-600/20', 'icon' => '🟢'],
                                                default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'ring' => 'ring-gray-600/20', 'icon' => '⚪']
                                            };
                                        @endphp

                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} ring-1 {{ $statusConfig['ring'] }}">
                                            <span class="mr-1">{{ $statusConfig['icon'] }}</span>
                                            {{ ucfirst($vendor->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 font-medium">{{ $vendor->created_at->format('M d, Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $vendor->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('superadmin.vendor.detail', $vendor->id) }}"
                                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white text-sm font-semibold rounded-lg transition-all duration-200 transform hover:-translate-y-1 shadow-md hover:shadow-lg group-hover:shadow-xl">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center space-y-4">
                                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 009.586 13H7" />
                                            </svg>
                                            <div class="text-center">
                                                <h3 class="text-lg font-medium text-gray-900 mb-1">No vendor requests found</h3>
                                                <p class="text-gray-500">There are no vendor registration requests to display.</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if(method_exists($vendors, 'links'))
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                        {{ $vendors->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
