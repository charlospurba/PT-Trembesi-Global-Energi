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
                    <p class="text-2xl font-bold">{{ $stats['orders_in'] ?? 0 }}</p>
                    <p class="text-xs text-gray-400 mt-1">Awaiting Shipment</p>
                </div>
                <div class="bg-white p-4 rounded shadow text-center border-t-4 border-yellow-400">
                    <p class="text-gray-500">Orders Processed</p>
                    <p class="text-2xl font-bold">{{ $stats['orders_processed'] ?? 0 }}</p>
                    <p class="text-xs text-gray-400 mt-1">Shipped + Completed</p>
                </div>
                <div class="bg-white p-4 rounded shadow text-center border-t-4 border-red-500">
                    <p class="text-gray-500">Total Sales</p>
                    <p class="text-2xl font-bold">Rp {{ number_format($stats['total_sales'] ?? 0, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-400 mt-1">From completed orders</p>
                </div>
            </div>

            <!-- Sales Graph -->
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
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        // Initialize Chart.js
        const ctx = document.getElementById("salesChart").getContext("2d");
        const salesChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: @json($stats['sales_labels']),
                datasets: [{
                    label: "Penjualan",
                    data: @json($stats['sales_data']),
                    borderColor: "rgb(34,197,94)",
                    backgroundColor: "rgba(34,197,94,0.1)",
                    tension: 0.4,
                    fill: true,
                }],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    }
                }
            },
        });

        // Initialize Pusher for WebSocket
        Pusher.logToConsole = true; // For debugging
        const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            encrypted: true
        });

        const channel = pusher.subscribe('vendor.{{ Auth::id() }}');
        channel.bind('App\\Events\\OrderStatusUpdated', function(data) {
            if (data.status === 'Completed') {
                const updatedAt = new Date(data.updated_at);
                const today = new Date();
                const diffDays = Math.floor((today - updatedAt) / (1000 * 60 * 60 * 24));

                if (diffDays >= 0 && diffDays < 7) {
                    const index = 6 - diffDays; // Adjust index based on days ago
                    salesChart.data.datasets[0].data[index] = parseFloat(salesChart.data.datasets[0].data[index]) +
                        parseFloat(data.total_price);
                    salesChart.update(); // Update the chart
                }
            }
        });
    </script>
@endpush
