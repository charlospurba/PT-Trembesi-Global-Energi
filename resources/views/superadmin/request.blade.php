@extends('layouts.app')

@section('content')
    @include('components.navadmin')

    <div class="flex h-screen overflow-hidden bg-white">
        @include('components.sideadmin')

        {{-- SweetAlert --}}
        @if (session('success'))
            <script>
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                Swal.fire({
                    title: 'Ditolak!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

        <div class="flex-1 bg-[#f2f2f2] p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Vendor's Request</h2>

            <div class="bg-white rounded-xl shadow-md p-6">
                <form method="GET" action="{{ route('superadmin.request') }}" class="mb-4">
                    <select name="status" onchange="this.form.submit()" class="border px-3 py-1 rounded">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </form>

                <table class="w-full text-sm text-left border border-gray-300">
                    <thead class="bg-red-600 text-white uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-4 py-2">Store Name</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Register</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800">
                        @foreach ($vendors as $vendor)
                            <tr class="border-t border-gray-200">
                                <td class="px-4 py-2">{{ $vendor->name }}</td>
                                <td class="px-4 py-2">{{ $vendor->email }}</td>
                                <td class="px-4 py-2">
                                    @php
                                        $statusColor = match ($vendor->status) {
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'approved' => 'bg-green-100 text-green-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        };
                                    @endphp

                                    <span class="{{ $statusColor }} text-xs px-3 py-0.5 rounded-full font-medium">
                                        {{ ucfirst($vendor->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">{{ $vendor->created_at->format('M d, Y') }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('superadmin.vendor.detail', $vendor->id) }}" class="btn-view" style="background-color:#2563eb; color:white; padding:4px 12px; border-radius:6px; font-size:12px; font-weight:500; display:inline-block;">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection