<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up - Trembesi Global Energi</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-200 font-sans min-h-screen flex items-center justify-center">
  <div class="flex flex-col md:flex-row w-full max-w-6xl bg-white rounded-xl shadow-2xl overflow-hidden">
    <!-- Left Section -->
    <div class="flex-1 p-12 flex flex-col justify-between bg-white">
      <div class="flex flex-col gap-8">
        <!-- Logo Header -->
        <div class="flex items-center">
          <h2 class="text-3xl font-bold text-gray-800">Sign Up</h2>
          <img src="{{ asset('assets/images/logo_merah.png') }}" alt="Trembesi Logo" class="w-16 h-auto ml-auto">
        </div>

        <br/>
        <!-- Vendor Box Centered -->
        <a href="{{ route('auth.register_form') }}"
          class="inline-flex items-center bg-gray-100 hover:bg-gray-200 rounded-lg p-5 shadow-md transition-colors duration-200 cursor-pointer no-underline mx-auto">
          <img src="{{ asset('assets/images/vendor_17641134.png') }}" alt="Vendor Icon" class="w-14 h-14 mr-4">
          <div class="text-gray-700">
            <b class="block text-lg mb-1">Vendor</b>
            <p class="text-sm">Become a trusted partner in supplying goods and services for our projects.</p>
          </div>
        </a>
      </div>

      <!-- Sign In Text -->
      <div class="mt-10 border-t pt-4 text-center text-sm text-gray-600">
        Already have an account?
        <a href="/signin" class="text-blue-600 hover:underline">Sign in</a>
      </div>
    </div>

    <!-- Right Section -->
    <div
      class="flex-1 bg-gradient-to-b from-red-500 to-red-700 text-white flex flex-col justify-center items-center text-center p-12">
      <img src="{{ asset('assets/images/register-as.cf421d13.svg') }}" alt="Document Icon" class="w-5/6 max-w-lg">
      <!-- Gambar diperbesar -->
      <h4 class="text-2xl font-semibold mb-3">With Trembesi Global Energi</h4>
      <p class="text-base leading-relaxed max-w-sm">
        Smart Solutions. Seamless Execution.<br />
        Strategic Impact.
      </p>
    </div>
  </div>
</body>
</html>