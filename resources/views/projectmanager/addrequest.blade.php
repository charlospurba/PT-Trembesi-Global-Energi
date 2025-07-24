@extends('layouts.app')

@section('content')
@include('components.navpm')

<div class="flex min-h-screen">
    @include('components.sidepm')

    <div class="bg-gray-50 min-h-screen p-6 flex-1">
        <div class="max-w-5xl mx-auto">

            @if(session('success'))
                <div class="bg-green-500 text-white px-6 py-4 rounded-md shadow mb-6">
                    <h2 class="text-xl font-bold">Request Berhasil Ditambahkan</h2>
                    <p class="text-sm">Berikut adalah daftar permintaan Anda:</p>
                </div>
            @endif

            @if(isset($requests) && $requests->count())
                @foreach($requests as $pmRequest)
                    <div class="bg-white rounded-lg shadow border border-gray-200 p-6 mb-6">
                        <h1 class="text-2xl font-bold text-gray-800 mb-4">{{ $pmRequest->description ?? '-' }}</h1>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-sm text-gray-500">Qty</p>
                                <p class="font-semibold text-gray-800">{{ $pmRequest->qty ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Unit</p>
                                <p class="font-semibold text-gray-800">{{ $pmRequest->unit ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Commcode</p>
                                <p class="font-semibold text-gray-800">{{ $pmRequest->commcode ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Required Delivery Date</p>
                                <p class="font-semibold text-gray-800">{{ $pmRequest->required_delivery_date ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <p class="text-sm text-gray-500">Specification</p>
                            <p class="text-gray-800">{{ $pmRequest->specification ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Remarks</p>
                            <p class="text-gray-800">{{ $pmRequest->remarks ?? '-' }}</p>
                        </div>
                    </div>
                @endforeach

                <div class="text-right">
                    <a href="{{ route('projectmanager.formadd') }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-all">
                        Tambah Request Lain
                    </a>
                </div>
            @else
                <div class="bg-yellow-100 text-yellow-800 px-6 py-4 rounded-md text-center mt-10 shadow">
                    <p class="mb-2 font-semibold">Belum ada data request.</p>
                    <p class="mb-4">Silakan tambahkan request terlebih dahulu.</p>
                    <a href="{{ route('projectmanager.formadd') }}"
                       class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        Tambah Request
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
