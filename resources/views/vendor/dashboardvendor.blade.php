<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Dashboard Vendor | Trembesi Shop</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>
    <body class="bg-red-50 font-sans">
        <!-- Navbar -->
        <header class="bg-gradient-to-r from-red-600 to-red-400 shadow-md p-4 flex justify-between items-center text-white">
            <div class="flex items-center gap-2">
               <img src="{{ asset('assets/images/logo_trembesi.png') }}" alt="Logo Trembesi" class="w-10 h-auto" />
                <h1 class="text-xl font-bold text-white-700">Trembesi Shop</h1>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-gray-700">Halo, Vendor</span>
                <img src="https://via.placeholder.com/40" class="rounded-full w-10 h-10" />
            </div>
        </header>

        <div class="flex min-h-screen">
            <!-- Sidebar -->
            <aside class="w-64 bg-white p-6 shadow hidden md:block">
                <nav class="space-y-4 font-medium">
                    <a href="" class="block text-red-700 hover:font-semibold">📦 Dashboard</a>
                    <a href="/myproducts" class="block text-gray-700 hover:text-red-500">🛍️ My Products</a>
                    <a href="#" class="block text-gray-700 hover:text-red-500">➕ Add Products</a>
                    <a href="#" class="block text-gray-700 hover:text-red-500">📋 Orders</a>
                    <a href="#" class="block text-gray-700 hover:text-red-500">💬 Review</a>
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 p-6 space-y-6">
                <!-- Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white p-4 rounded shadow text-center border-t-4 border-red-500">
                        <p class="text-gray-500">Number of Products</p>
                        <p class="text-2xl font-bold">125</p>
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
                    <h2 class="text-lg font-semibold mb-2 text-red-600">
                        Sales Graph (7 Days)
                    </h2>
                    <canvas id="salesChart" height="100"></canvas>
                </div>
            </main>
        </div>

        <!-- Footer -->
        <footer class="bg-white text-center p-4 text-sm text-gray-500">
            © 2025 Trembesi Shop
        </footer>

        <!-- Chart.js Script -->
        <script>
            const ctx = document.getElementById("salesChart").getContext("2d");
            new Chart(ctx, {
                type: "line",
                data: {
                    labels: ["Sen", "Sel", "Rab", "Kam", "Jum", "Sab", "Min"],
                    datasets: [
                        {
                            label: "Penjualan",
                            data: [5, 7, 3, 6, 9, 4, 8],
                            borderColor: "rgb(34,197,94)", // Merah
                            backgroundColor: "rgba(34,197,94,0.1)",
                            tension: 0.4,
                            fill: true,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                    },
                },
            });
        </script>
    </body>
</html>