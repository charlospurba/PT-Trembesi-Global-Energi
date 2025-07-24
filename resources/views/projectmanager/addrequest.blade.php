@extends('layouts.app')

@section('content')
@include('components.navpm')

<div class="flex min-h-screen bg-gradient-to-r from-slate-100 via-white to-slate-100">
    @include('components.sidepm')

    <div class="flex-1 p-6">
        <div class="max-w-5xl mx-auto space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 px-6 py-4 rounded-lg shadow-md animate-fade-in">
                    <h2 class="text-xl font-semibold mb-1">✅ Request Berhasil Ditambahkan</h2>
                    <p class="text-sm">Berikut adalah daftar permintaan Anda:</p>
                </div>
            @endif

            @if(isset($requests) && $requests->count())
                @foreach($requests as $pmRequest)
                    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 hover:shadow-lg transition duration-300 ease-in-out">
                        <h1 class="text-2xl font-bold text-blue-800 mb-4">{{ $pmRequest->description ?? '-' }}</h1>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                            <div>
                                <p class="text-xs uppercase tracking-wide text-gray-500">Qty</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $pmRequest->qty ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-wide text-gray-500">Unit</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $pmRequest->unit ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-wide text-gray-500">Commcode</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $pmRequest->commcode ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-wide text-gray-500">Required Delivery Date</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $pmRequest->required_delivery_date ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <p class="text-xs uppercase tracking-wide text-gray-500">Specification</p>
                            <p class="text-gray-800">{{ $pmRequest->specification ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs uppercase tracking-wide text-gray-500">Remarks</p>
                            <p class="text-gray-800">{{ $pmRequest->remarks ?? '-' }}</p>
                        </div>
                    </div>
                @endforeach

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
