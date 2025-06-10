<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Trembesi Shop Sign Up</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-red-600 text-white-800 font-[Roboto]">
  <div class="max-w-7xl mx-auto mt-12 px-4 flex flex-col md:flex-row gap-10 items-start">
    <!-- Left Section: Steps -->
    <section aria-label="Steps to start selling on Trembesi Shop" class="md:w-3/5 text-white">
      <h2 class="text-3xl font-bold mb-10 leading-snug text-white">4 Easy Steps to Start Selling on Trembesi Shop:</h2>

      <div class="space-y-8">
        <!-- Step 1 -->
        <div class="flex items-start gap-4">
          <img src="{{ asset('assets/images/data.png') }}" alt="Step 1" class="w-14 h-14 object-contain" />
          <div class="text-base leading-relaxed">
            <strong class="font-bold text-white">1. Create an Account</strong><br />
            Fill in your personal information on this page
          </div>
        </div>

        <!-- Step 2 -->
        <div class="flex items-start gap-4">
          <img src="{{ asset('assets/images/email.png') }}" alt="Step 2" class="w-14 h-14 object-contain" />
          <div class="text-base leading-relaxed">
            <strong class="font-bold text-white">2. Confirm Your Email</strong><br />
            Check your email inbox, confirm your registration.
          </div>
        </div>

        <!-- Step 3 -->
        <div class="flex items-start gap-4">
          <img src="{{ asset('assets/images/account.png') }}" alt="Step 3" class="w-14 h-14 object-contain" />
          <div class="text-base leading-relaxed">
            <strong class="font-bold text-white">3. Complete Business Information</strong><br />
            Prepare and upload the following documents:
            <ul class="list-disc ml-5 mt-1">
              <li>Owner’s ID (KTP)</li>
              <li>Store or Company Address</li>
            </ul>
          </div>
        </div>

        <!-- Step 4 -->
        <div class="flex items-start gap-4">
          <img src="{{ asset('assets/images/product.png') }}" alt="Step 4" class="w-14 h-14 object-contain" />
          <div class="text-base leading-relaxed">
            <strong class="font-bold text-white">4. Upload Your Products</strong><br />
            Add product photos and provide detailed product descriptions.
          </div>
        </div>
      </div>
    </section>


    <!-- Right Section: Form -->
    <section aria-label="Sign up form" class="md:w-2/5 bg-white rounded-xl p-8 shadow-xl text-gray-800 relative">
      <div class="flex items-center justify-between mb-6 relative">
        <!-- Teks Sign Up di tengah -->
        <h3 class="text-2xl font-bold text-gray-800 absolute left-1/2 transform -translate-x-1/2">
          Sign Up
        </h3>
        <!-- Logo di pojok kanan -->
        <div class="w-14 h-14 ml-auto">
          <img src="{{ asset('assets/images/logo_merah.png') }}" alt="Trembesi Shop logo"
            class="w-full h-full object-contain" />
        </div>
      </div>

      <form class="flex flex-col gap-4">
        <div>
          <label for="storeName" class="text-sm font-medium text-gray-700">Store Name</label>
          <input type="text" id="storeName" name="storeName" autocomplete="organization"
            class="w-full mt-1 px-4 py-2 border border-gray-300 bg-white text-gray-900 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500" />
        </div>
        <div>
          <label for="email" class="text-sm font-medium text-gray-700">Email Address</label>
          <input type="email" id="email" name="email" autocomplete="email"
            class="w-full mt-1 px-4 py-2 border border-gray-300 bg-white text-gray-900 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500" />
        </div>
        <div>
          <label for="phone" class="text-sm font-medium text-gray-700">Phone Number</label>
          <input type="tel" id="phone" name="phone" autocomplete="tel"
            class="w-full mt-1 px-4 py-2 border border-gray-300 bg-white text-gray-900 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500" />
        </div>
        <div>
          <label for="npwp" class="text-sm font-medium text-gray-700">Nomor NPWP</label>
          <input type="text" id="npwp" name="npwp"
            class="w-full mt-1 px-4 py-2 border border-gray-300 bg-white text-gray-900 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500" />
        </div>
        <div>
          <label for="username" class="text-sm font-medium text-gray-700">Username</label>
          <input type="text" id="username" name="username" autocomplete="username"
            class="w-full mt-1 px-4 py-2 border border-gray-300 bg-white text-gray-900 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500" />
        </div>
        <div>
          <label for="password" class="text-sm font-medium text-gray-700">Password</label>
          <input type="password" id="password" name="password" autocomplete="new-password"
            class="w-full mt-1 px-4 py-2 border border-gray-300 bg-white text-gray-900 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500" />
        </div>
        <button type="submit"
          class="mt-4 bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-lg transition duration-300">
          Sign Up
        </button>
      </form>
    </section>
  </div>
</body>

</html>