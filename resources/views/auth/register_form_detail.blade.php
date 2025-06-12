<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up - Trembesi (Detail)</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-red-600 text-white font-[Roboto] min-h-screen">
  <div class="max-w-7xl mx-auto mt-12 px-4 flex flex-col md:flex-row gap-10 items-start">
    <!-- Left: Langkah-langkah -->
    <section aria-label="Steps" class="md:w-3/5 text-white">
      <h2 class="text-3xl font-bold mb-10 leading-snug">4 Easy Steps to Start Selling on Trembesi Shop:</h2>

      <div class="space-y-8">
        <div class="flex items-start gap-4">
          <img src="{{ asset('assets/images/data.png') }}" alt="Step 1" class="w-12 h-12" />
          <div>
            <p class="font-bold">1. Create an Account</p>
            <p>Fill in your personal information on this page.</p>
          </div>
        </div>
        <div class="flex items-start gap-4">
          <img src="{{ asset('assets/images/email.png') }}" alt="Step 2" class="w-12 h-12" />
          <div>
            <p class="font-bold">2. Confirm Your Email</p>
            <p>Check your email inbox and confirm your registration.</p>
          </div>
        </div>
        <div class="flex items-start gap-4">
          <img src="{{ asset('assets/images/account.png') }}" alt="Step 3" class="w-12 h-12" />
          <div>
            <p class="font-bold">3. Complete Business Information</p>
            <p>Prepare and upload the following documents:<br />
              • Owner’s ID (KTP)<br />
              • Store or Company Address
            </p>
          </div>
        </div>
        <div class="flex items-start gap-4">
          <img src="{{ asset('assets/images/product.png') }}" alt="Step 4" class="w-12 h-12" />
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

      <form method="POST" action="{{ route('auth.register_detail_submit') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <!-- NIB -->
        <div>
          <label for="nib" class="text-sm font-medium text-gray-700">NIB</label>
          <input type="text" id="nib" name="nib"
            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500" />
        </div>

        <!-- Upload Fields -->
        @php
          $uploadFields = [
            ['id' => 'company_profile', 'label' => 'Company Profile'],
            ['id' => 'business_license', 'label' => 'Izin Perusahaan'],
            ['id' => 'tax_document', 'label' => 'Surat Pengukuhan Pengusaha Kena Pajak'],
            ['id' => 'organization_structure', 'label' => 'Struktur Organisasi / Perusahaan'],
            ['id' => 'company_experience', 'label' => 'Daftar Pengalaman Perusahaan'],
          ];
        @endphp

        @foreach ($uploadFields as $field)
          <div>
            <label for="{{ $field['id'] }}" class="text-sm font-medium text-gray-700">{{ $field['label'] }}</label>
            <div class="relative mt-1 flex rounded-lg border border-gray-300 overflow-hidden">
              <!-- Hidden File Input -->
              <input type="file" id="{{ $field['id'] }}" name="{{ $field['id'] }}"
                class="hidden" onchange="document.getElementById('{{ $field['id'] }}_label').textContent = this.files[0]?.name || 'Pilih file...';" />

              <!-- File Name Display -->
              <div id="{{ $field['id'] }}_label"
                class="flex-1 px-4 py-2 text-sm text-gray-500 bg-white border-none select-none truncate">
                Pilih file...
              </div>

              <!-- Upload Button -->
              <label for="{{ $field['id'] }}"
                class="cursor-pointer bg-gray-200 px-4 py-2 text-sm font-medium text-gray-600 flex items-center gap-1 hover:bg-gray-300 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M4 12l1.293-1.293a1 1 0 011.414 0L10 14l2-2 4 4m-6-6h.01" />
                </svg>
                Upload
              </label>
            </div>
          </div>
        @endforeach

        <!-- Submit Button -->
        <div class="pt-2">
          <button type="submit"
            class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
            Sign Up
          </button>
        </div>
      </form>
    </section>
  </div>
</body>

</html>
