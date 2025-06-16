@extends('layouts.app')

@section('content')
@include('components.navbar')

<div class="min-h-screen bg-[#F6F3F2] py-10">
    <div class="w-full max-w-[1000px] mx-auto px-4">

        {{-- Breadcrumb --}}
        <h5 class="text-lg font-bold mb-6">
            <a href="{{ route('procurement.dashboardproc') }}" class="text-black hover:underline">Dashboard</a>
            <span class="text-gray-500"> > </span>
            <a href="/cart" class="text-black hover:underline">Cart</a>
            <span class="text-red-500 font-bold"> > Check Out</span>
        </h5>

        <div class="flex flex-col md:flex-row gap-6">

            {{-- LEFT: Form --}}
            <div class="w-full md:w-1/2 bg-white p-6 rounded-xl shadow text-sm">
                <h2 class="text-lg font-bold mb-4">CONTACT INFORMATION <span class="text-xs font-normal float-right">*Required</span></h2>
                <form>
                    <div class="mb-4">
                        <label class="block mb-1 font-semibold">Email *</label>
                        <input type="email" value="gracesiaromauli10@gmail.com" disabled class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2" />
                    </div>

                    <h2 class="text-lg font-bold mb-4 mt-6">SHIPPING ADDRESS</h2>

                    <div class="mb-4">
                        <label class="block mb-1 font-semibold">Full Name *</label>
                        <input type="text" class="w-full border border-gray-300 rounded px-3 py-2" />
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 font-semibold">Country *</label>
                        <input type="text" class="w-full border border-gray-300 rounded px-3 py-2" />
                    </div>

                    <div class="mb-4 grid grid-cols-3 gap-3">
                        <div>
                            <label class="block mb-1 font-semibold">State/Province</label>
                            <input type="text" class="w-full border border-gray-300 rounded px-3 py-2" />
                        </div>
                        <div class="col-span-2">
                            <label class="block mb-1 font-semibold">Postal code*</label>
                            <input type="text" class="w-full border border-gray-300 rounded px-3 py-2" />
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 font-semibold">Street Address *</label>
                        <textarea rows="2" class="w-full border border-gray-300 rounded px-3 py-2"></textarea>
                    </div>

                    <div class="flex gap-4 mt-6">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-semibold">Save</button>
                        <button type="reset" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded font-semibold">Reset</button>
                    </div>
                </form>
            </div>

            {{-- RIGHT: Ringkasan Produk --}}
            <div class="w-full md:w-1/2 bg-white p-6 rounded-xl shadow border border-red-400 text-sm">
                <h2 class="text-lg font-bold mb-4 text-center">CHECK OUT</h2>

                <div class="space-y-3 mb-4">
                    <div class="flex items-center justify-between border-b pb-2">
                        <div class="flex items-center gap-2">
                            <img src="https://via.placeholder.com/50" class="w-12 h-12 object-cover rounded border border-red-400">
                            <div>
                                <div class="font-semibold text-sm">Pipa Besi Anti Karat</div>
                                <div class="text-gray-500 text-xs">Variasi : 20mm</div>
                            </div>
                        </div>
                        <div class="font-semibold text-right text-sm">RP. 810,000</div>
                    </div>

                    <div class="flex items-center justify-between border-b pb-2">
                        <div class="flex items-center gap-2">
                            <img src="https://via.placeholder.com/50" class="w-12 h-12 object-cover rounded border border-red-400">
                            <div>
                                <div class="font-semibold text-sm">Pipa PVC</div>
                                <div class="text-gray-500 text-xs">Variasi : 2m</div>
                            </div>
                        </div>
                        <div class="font-semibold text-right text-sm">RP. 110,000</div>
                    </div>

                    <div class="flex items-center justify-between border-b pb-2">
                        <div class="flex items-center gap-2">
                            <img src="https://via.placeholder.com/50" class="w-12 h-12 object-cover rounded border border-red-400">
                            <div>
                                <div class="font-semibold text-sm">Pipa Besi Anti Karat</div>
                                <div class="text-gray-500 text-xs">Variasi : 30mm</div>
                            </div>
                        </div>
                        <div class="font-semibold text-right text-sm">RP. 620,000</div>
                    </div>
                </div>

                <div class="text-sm text-gray-600 mb-1 flex justify-between">
                    <span>Subtotal</span>
                    <span>RP. 1,540,000</span>
                </div>
                <div class="text-base font-bold text-black flex justify-between border-t pt-2 mb-4">
                    <span>Total</span>
                    <span>RP. 1,540,000</span>
                </div>

                <div class="flex flex-col gap-2">
                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1.5 rounded text-sm">Print E-Billing</button>
                    <button class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-1.5 rounded text-sm">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection