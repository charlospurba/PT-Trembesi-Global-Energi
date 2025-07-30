@extends('layouts.app')

@section('content')
@include('components.navpm')

<div class="flex min-h-screen bg-gradient-to-r from-slate-100 via-white to-slate-100">
    @include('components.sidepm')

    <div class="flex-1 p-6">
        <div class="max-w-7xl mx-auto space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 px-6 py-4 rounded-lg shadow-md animate-fade-in">
                    <h2 class="text-xl font-semibold mb-1">✅ Request Berhasil Ditambahkan</h2>
                    <p class="text-sm">Berikut adalah daftar permintaan Anda:</p>
                </div>
            @endif

            @if(isset($requests) && $requests->count())
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach($requests as $pmRequest)
                        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-5 hover:shadow-lg transition duration-300 ease-in-out">
                            <!-- Header with Title and Status -->
                            <div class="flex justify-between items-start mb-4">
                                <h1 class="text-lg font-bold text-blue-800 flex-1 pr-3">{{ $pmRequest->description ?? '-' }}</h1>
                                    <div class="flex-shrink-0">
                                        @if(isset($pmRequest->status) && $pmRequest->status === 'completed')
                                            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Completed
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                On Progress
                                            </span>
                                        @endif
                                    </div>
                            </div>

                            <!-- Main Info Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                 {{-- Item --}}
                                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg border-l-4 border-red-400 shadow-sm">
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 uppercase">Item</p>
                                        <p class="text-sm text-gray-800 font-bold">{{ $pmRequest->item ?? '-' }}</p>
                                    </div>
                                </div>

                                {{-- Qty --}}
                                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg border-l-4 border-red-400 shadow-sm">
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 uppercase">Qty</p>
                                        <p class="text-sm text-gray-800 font-bold">{{ $pmRequest->qty ?? '-' }}</p>
                                    </div>
                                </div>

                                {{-- Unit --}}
                                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg border-l-4 border-red-400 shadow-sm">
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 uppercase">Unit</p>
                                        <p class="text-sm text-gray-800 font-bold">{{ $pmRequest->unit ?? '-' }}</p>
                                    </div>
                                </div>

                                {{-- ETA --}}
                                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg border-l-4 border-red-400 shadow-sm">
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 uppercase">Estimated time of arrival</p>
                                        <p class="text-sm text-gray-800 font-bold">{{ $pmRequest->eta ? \Carbon\Carbon::parse($pmRequest->eta)->format('Y-m-d') : '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Specification -->
                            <div class="mb-3 p-4 bg-gray-50 rounded-lg shadow-sm border-l-4 border-red-400">
                                <p class="text-xs font-semibold text-gray-500 uppercase">Specification</p>
                                <p class="text-sm text-gray-800 line-clamp-2">{{ $pmRequest->specification ?? '-' }}</p>
                            </div>

                            <!-- Remarks -->
                            <div class="mb-3 p-4 bg-gray-50 rounded-lg shadow-sm border-l-4 border-red-400">
                                <p class="text-xs font-semibold text-gray-500 uppercase">Remarks</p>
                                <p class="text-sm text-gray-800 line-clamp-2">{{ $pmRequest->remark ?? '-' }}</p>
                            </div>

                            <!-- Price -->
                            <div class="mb-3 p-4 bg-gray-50 rounded-lg shadow-sm border-l-4 border-red-400">
                                <p class="text-xs font-semibold text-gray-500 uppercase">Price</p>
                                <p class="text-sm text-gray-800">Rp {{ number_format($pmRequest->price ?? 0, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-right pt-6">
                    <a href="{{ route('projectmanager.formadd') }}"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-lg shadow-md transition duration-200 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Request Lain
                    </a>
                </div>

            @else
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-6 py-6 rounded-lg text-center mt-10 shadow-md animate-fade-in">
                    <p class="mb-2 text-lg font-semibold">⚠️ Belum ada data request.</p>
                    <p class="mb-4 text-sm">Silakan tambahkan request terlebih dahulu.</p>
                    <a href="{{ route('projectmanager.formadd') }}"
                       class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-medium shadow transition">
                        Tambah Request
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection