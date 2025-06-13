<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Produk Saya | Trembesi Shop</title>
  <script src="https://cdn.tailwindcss.com"></script>
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
        <a href="{{ route('vendor.dashboardvendor') }}" class="block text-gray-700 hover:text-red-500">📦 Dashboard</a>
        <a href="#" class="block text-red-700 font-semibold">🛍️ My Products</a>
        <a href="{{ route('vendor.add_product') }}" class="block text-gray-700 hover:text-red-500">➕ Add Products</a>
        <a href="#" class="block text-gray-700 hover:text-red-500">📋 Orders</a>
        <a href="#" class="block text-gray-700 hover:text-red-500">💬 Review</a>
      </nav>
    </aside>

    <!-- Main Content: Produk Saya -->
    <main class="flex-1 p-6 space-y-6">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-red-600">My Products</h2>
        <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm font-medium">
          ➕ Add Product
        </button>
      </div>

      <!-- Grid Produk -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <!-- Kartu Produk -->
        <div class="bg-white rounded shadow hover:shadow-lg transition p-4 flex flex-col">
          <img src="https://via.placeholder.com/300x200" alt="Kaos Katun" class="rounded mb-4">
          <h3 class="text-lg font-semibold text-gray-800 mb-1">Kaos Katun Premium</h3>
          <p class="text-red-500 font-bold mb-1">Rp 120.000</p>
          <p class="text-sm text-gray-500 mb-4">Stok: 35</p>
          <div class="mt-auto flex justify-between gap-2">
            <button class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1 rounded">Edit</button>
            <button class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1 rounded">Delete</button>
          </div>
        </div>

        <div class="bg-white rounded shadow hover:shadow-lg transition p-4 flex flex-col">
          <img src="https://via.placeholder.com/300x200" alt="Tas Kulit" class="rounded mb-4">
          <h3 class="text-lg font-semibold text-gray-800 mb-1">Tas Kulit Asli</h3>
          <p class="text-red-500 font-bold mb-1">Rp 250.000</p>
          <p class="text-sm text-gray-500 mb-4">Stok: 12</p>
          <div class="mt-auto flex justify-between gap-2">
            <button class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1 rounded">Edit</button>
            <button class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1 rounded">Delete</button>
          </div>
        </div>

        <div class="bg-white rounded shadow hover:shadow-lg transition p-4 flex flex-col">
          <img src="https://via.placeholder.com/300x200" alt="Topi Merah" class="rounded mb-4">
          <h3 class="text-lg font-semibold text-gray-800 mb-1">Topi Merah Sport</h3>
          <p class="text-red-500 font-bold mb-1">Rp 90.000</p>
          <p class="text-sm text-gray-500 mb-4">Stok: 20</p>
          <div class="mt-auto flex justify-between gap-2">
            <button class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1 rounded">Edit</button>
            <button class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1 rounded">Delete</button>
          </div>
        </div>

        <!-- Tambah produk lainnya sesuai kebutuhan -->
      </div>
    </main>
  </div>

  <!-- Footer -->
  <footer class="bg-white text-center p-4 text-sm text-gray-500">
    © 2025 Trembesi Shop
  </footer>
</body>

</html>