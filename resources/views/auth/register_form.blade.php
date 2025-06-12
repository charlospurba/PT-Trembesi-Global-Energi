<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up - Trembesi</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-red-600 text-white font-[Roboto] min-h-screen">
  <div class="max-w-7xl mx-auto mt-12 px-4 flex flex-col md:flex-row gap-10 items-start">
    <!-- Left: Langkah-langkah -->
    <section aria-label="Steps" class="md:w-3/5 text-white">
      <h2 class="text-3xl font-bold mb-10 leading-snug">4 Easy Steps to Start Selling on Trembesi:</h2>

      <div class="space-y-8">
        <div class="flex items-start gap-4">
          <img src="{{ asset('assets/images/data.png') }}" alt="Step 1" class="w-14 h-14" />
          <div>
            <p class="font-bold">1. Create an Account</p>
            <p>Fill in your personal information on this page.</p>
          </div>
        </div>
        <div class="flex items-start gap-4">
          <img src="{{ asset('assets/images/email.png') }}" alt="Step 2" class="w-14 h-14" />
          <div>
            <p class="font-bold">2. Confirm Your Email</p>
            <p>Check your email inbox and confirm your registration.</p>
          </div>
        </div>
        <div class="flex items-start gap-4">
          <img src="{{ asset('assets/images/account.png') }}" alt="Step 3" class="w-14 h-14" />
          <div>
            <p class="font-bold">3. Complete Business Information</p>
            <ul class="list-disc ml-5 mt-1">
              <li>Owner’s ID (KTP)</li>
              <li>Store or Company Address</li>
            </ul>
          </div>
        </div>
        <div class="flex items-start gap-4">
          <img src="{{ asset('assets/images/product.png') }}" alt="Step 4" class="w-14 h-14" />
          <div>
            <p class="font-bold">4. Upload Your Products</p>
            <p>Add product photos and provide detailed product descriptions.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Right: Form -->
    <section class="md:w-2/5 bg-white rounded-xl p-8 shadow-xl text-gray-800 relative">
      <div class="flex items-center justify-between mb-6 relative">
        <h3 class="text-2xl font-bold absolute left-1/2 transform -translate-x-1/2">Sign Up</h3>
        <div class="w-14 h-14 ml-auto">
          <img src="{{ asset('assets/images/logo_merah.png') }}" alt="Trembesi Logo" class="w-full h-full" />
        </div>
      </div>

      <form method="GET" action="{{ url('/register-detail') }}" class="flex flex-col gap-4">
        <div>
          <label for="storeName" class="text-sm font-medium text-gray-700">Store Name</label>
          <input type="text" id="storeName" name="storeName" autocomplete="organization"
            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500" />
        </div>
        <div>
          <label for="email" class="text-sm font-medium text-gray-700">Email Address</label>
          <input type="email" id="email" name="email" autocomplete="email"
            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500" />
        </div>
        <div>
          <label for="phone" class="text-sm font-medium text-gray-700">Phone Number</label>
          <input type="tel" id="phone" name="phone" autocomplete="tel"
            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500" />
        </div>
        <div>
          <label for="npwp" class="text-sm font-medium text-gray-700">Nomor NPWP</label>
          <input type="text" id="npwp" name="npwp"
            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500" />
        </div>
        <div>
          <label for="username" class="text-sm font-medium text-gray-700">Username</label>
          <input type="text" id="username" name="username" autocomplete="username"
            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500" />
        </div>
        <div>
          <label for="password" class="text-sm font-medium text-gray-700">Password</label>
          <input type="password" id="password" name="password" autocomplete="new-password"
            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500" />
        </div>

        <a href="{{ route('register.step2') }}"
   class="mt-4 block text-center bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-lg transition duration-300">
   Next
</a>
      </form>
    </section>
  </div>
</body>

</html>
