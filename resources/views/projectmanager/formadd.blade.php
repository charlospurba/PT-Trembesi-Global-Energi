@extends('layouts.app')

@section('content')
    @include('components.navpm')

    <div class="flex min-h-screen bg-gradient-to-r from-slate-100 via-white to-slate-100">
        @include('components.sidepm')
        <div class="flex-1 p-6">
            <div class="max-w-4xl mx-auto mt-10 bg-white p-8 rounded-xl shadow-md">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah PM Request</h1>

                {{-- Error Alert --}}
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <ul class="list-disc pl-5 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Form --}}
                <form action="{{ route('pm-requests.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="qty" class="block font-semibold text-sm text-gray-700">Qty</label>
                        <input type="number" name="qty" id="qty" value="{{ old('qty') }}"
                            class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>

                    <div>
                        <label for="unit" class="block font-semibold text-sm text-gray-700">Unit</label>
                        <input type="text" name="unit" id="unit" value="{{ old('unit') }}"
                            class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>

                    <div>
                        <label for="commcode" class="block font-semibold text-sm text-gray-700">Commcode</label>
                        <input type="text" name="commcode" id="commcode" value="{{ old('commcode') }}"
                            class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="description" class="block font-semibold text-sm text-gray-700">Description of
                            Material</label>
                        <textarea name="description" id="description" rows="3"
                            class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label for="specification" class="block font-semibold text-sm text-gray-700">Specification</label>
                        <textarea name="specification" id="specification" rows="3"
                            class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('specification') }}</textarea>
                    </div>

                    <div>
                        <label for="required_delivery_date" class="block font-semibold text-sm text-gray-700">Required
                            Delivery Date</label>
                        <input type="date" name="required_delivery_date" id="required_delivery_date"
                            value="{{ old('required_delivery_date') }}"
                            class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="remarks" class="block font-semibold text-sm text-gray-700">Remarks</label>
                        <textarea name="remarks" id="remarks" rows="2"
                            class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('remarks') }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition">
                            Submit
                        </button>
                    </div>
                </form>

                <div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow-md mt-10">
                    <h2 class="text-xl font-semibold mb-4 text-gray-700">Import Request Barang</h2>

                    {{-- Form Upload Excel --}}
                    <form action="{{ route('pmrequest.import') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-4">
                        @csrf
                        <div>
                            <label for="file" class="block text-sm font-medium text-gray-600 mb-1">Pilih File Excel</label>
                            <input type="file" name="file" id="file" accept=".xlsx, .xls" required
                                class="block w-full text-sm text-gray-700 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-300 p-2">
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md shadow">
                                Upload
                            </button>

                            <a href="{{ route('pmrequest.downloadTemplate') }}"
                                class="text-sm text-blue-600 hover:underline font-medium">
                                📥 Download Template
                            </a>
                        </div>
                    </form>
                </div>


            </div>
        </div>
@endsection