@extends('layouts.app')

@section('content')
    @include('components.navvendor')

    <div class="flex min-h-screen">
        @include('components.sidevendor')

        <main class="flex-1 p-6 space-y-6">
            <!-- Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                 <div class="bg-white p-4 rounded shadow text-center border-t-4 border-red-500">
                    <p class="text-gray-500">Number of Products</p>
                    <p class="text-2xl font-bold">{{ $productCount }}</p>
                </div>
                <div class="bg-white p-4 rounded shadow text-center border-t-4 border-green-500">
                    <p class="text-gray-500">Orders In</p>
                    <p class="text-2xl font-bold">18</p>
                </div>
                <div class="bg-white p-4 rounded shadow text-center border-t-4 border-yellow-400">
                    <p class="text-gray-500">Orders Processed</p>
                    <p class="text-2xl font-bold">20</p>
                </div>
                <div class="bg-white p-4 rounded shadow text-center border-t-4 border-red-500">
                    <p class="text-gray-500">Total Sales</p>
                    <p class="text-2xl font-bold">50</p>
                </div>
            </div>

            <!-- Grafik Penjualan -->
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-lg font-semibold mb-2 text-red-600">Sales Graph (7 Days)</h2>
                <canvas id="salesChart" height="100"></canvas>
            </div>
        </main>
    </div>

    <footer class="bg-white text-center p-4 text-sm text-gray-500">
        © 2025 Trembesi Shop
    </footer>
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById("salesChart").getContext("2d");
    new Chart(ctx, {
        type: "line",
        data: {
            labels: ["Sen", "Sel", "Rab", "Kam", "Jum", "Sab", "Min"],
            datasets: [{
                label: "Penjualan",
                data: [5, 7, 3, 6, 9, 4, 8],
                borderColor: "rgb(34,197,94)",
                backgroundColor: "rgba(34,197,94,0.1)",
                tension: 0.4,
                fill: true,
            }],
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
            },
        },
    });
</script>
@endpush
