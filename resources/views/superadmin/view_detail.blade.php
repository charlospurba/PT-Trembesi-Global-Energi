@extends('layouts.app')

@section('content')
@include('components.navadmin')

<div class="flex h-screen overflow-hidden bg-white">
    @include('components.sideadmin')

    <div class="flex-1 bg-[#f2f2f2] p-6 overflow-y-auto">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Detail Acc Vendor</h2>

        <div class="bg-white rounded-xl shadow-md">
            <!-- Header -->
            <div class="bg-red-600 text-white px-6 py-3 rounded-t-xl font-semibold">
                Vendor's request
            </div>

            <!-- Konten dua kolom -->
            <div class="px-8 py-6 bg-white">
                <table class="w-full text-sm">
                    <tbody>
                        <tr>
                            <td class="text-red-600 font-semibold w-1/3">Store name</td>
                            <td class="text-gray-800">PT. Janji Maria Menteng Agung</td>
                        </tr>
                        <tr>
                            <td class="text-red-600 font-semibold">Email Address</td>
                            <td>mariajanji@maria.com</td>
                        </tr>
                        <tr>
                            <td class="text-red-600 font-semibold">Phone Number</td>
                            <td>0821 8098 7890</td>
                        </tr>
                        <tr>
                            <td class="text-red-600 font-semibold">Nomor NPWP</td>
                            <td>0821 8098 7890</td>
                        </tr>
                        <tr>
                            <td class="text-red-600 font-semibold">username</td>
                            <td>pt_janjimariamentengagung</td>
                        </tr>
                        <tr>
                            <td class="text-red-600 font-semibold">Password</td>
                            <td>Maria1234567890</td>
                        </tr>
                        <tr>
                            <td class="text-red-600 font-semibold">NIB</td>
                            <td>0821 8098 7890</td>
                        </tr>
                        <tr>
                            <td class="text-red-600 font-semibold">Company Profile</td>
                            <td><a href="#" class="text-blue-600 hover:underline">https://prkl/dacjaksajns/view?q=</a></td>
                        </tr>
                        <tr>
                            <td class="text-red-600 font-semibold">Izin Perusahaan</td>
                            <td><a href="#" class="text-blue-600 hover:underline">https://prkl/dacjaksajns/view?q=</a></td>
                        </tr>
                        <tr>
                            <td class="text-red-600 font-semibold">SPPKP</td>
                            <td><a href="#" class="text-blue-600 hover:underline">https://prkl/dacjaksajns/view?q=</a></td>
                        </tr>
                        <tr>
                            <td class="text-red-600 font-semibold">Struktur Organisasi / Perusahaan</td>
                            <td><a href="#" class="text-blue-600 hover:underline">https://prkl/dacjaksajns/view?q=</a></td>
                        </tr>
                        <tr>
                            <td class="text-red-600 font-semibold">Daftar Pengalaman Perusahaan</td>
                            <td><a href="#" class="text-blue-600 hover:underline">https://prkl/dacjaksajns/view?q=</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end gap-3 px-6 py-4 bg-[#f2f2f2] rounded-b-xl">
    <button class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold px-5 py-2 rounded shadow-md transition">
        Reject
    </button>
    <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-5 py-2 rounded shadow-md">
    Accept
    </button>
</div>

        </div>
    </div>
</div>
@endsection
