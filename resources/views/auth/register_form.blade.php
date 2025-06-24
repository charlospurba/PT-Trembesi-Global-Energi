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
        @php
          $steps = [
            ['img' => 'data.png', 'title' => '1. Create an Account', 'desc' => 'Fill in your personal information on this page.'],
            ['img' => 'email.png', 'title' => '2. Confirm Your Email', 'desc' => 'Check your email inbox and confirm your registration.'],
            ['img' => 'account.png', 'title' => '3. Complete Business Information', 'desc' => 'Owner’s ID (KTP) and Store or Company Address.'],
            ['img' => 'product.png', 'title' => '4. Upload Your Products', 'desc' => 'Add product photos and provide detailed product descriptions.']
          ];
        @endphp

        @foreach ($steps as $step)
          <div class="flex items-start gap-4">
            <img src="{{ asset('assets/images/' . $step['img']) }}" class="w-14 h-14" />
            <div>
              <p class="font-bold">{{ $step['title'] }}</p>
              <p>{!! nl2br($step['desc']) !!}</p>
            </div>
          </div>
        @endforeach
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

      <!-- Step 1: Basic Info -->
      <form id="step1-form" class="flex flex-col gap-4">
        <div>
          <label class="text-sm font-medium text-gray-700">Store Name</label>
          <input type="text" class="w-full mt-1 px-4 py-2 border rounded-lg text-sm" />
        </div>
        <div>
          <label class="text-sm font-medium text-gray-700">Email Address</label>
          <input type="email" class="w-full mt-1 px-4 py-2 border rounded-lg text-sm" />
        </div>
        <div>
          <label class="text-sm font-medium text-gray-700">Phone Number</label>
          <input type="tel" class="w-full mt-1 px-4 py-2 border rounded-lg text-sm" />
        </div>
        <div>
          <label class="text-sm font-medium text-gray-700">Nomor NPWP</label>
          <input type="text" class="w-full mt-1 px-4 py-2 border rounded-lg text-sm" />
        </div>
        <div>
          <label class="text-sm font-medium text-gray-700">Username</label>
          <input type="text" class="w-full mt-1 px-4 py-2 border rounded-lg text-sm" />
        </div>
        <div>
          <label class="text-sm font-medium text-gray-700">Password</label>
          <input type="password" class="w-full mt-1 px-4 py-2 border rounded-lg text-sm" />
        </div>
        <button type="button" onclick="showStep2()"
          class="mt-4 bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-lg transition">
          Next
        </button>
      </form>

      <!-- Step 2: Business Details -->
      <form id="step2-form" method="POST" action="{{ route('auth.register_detail_submit') }}"
        enctype="multipart/form-data" class="hidden space-y-4 mt-6">
        @csrf

        <div>
          <label class="text-sm font-medium text-gray-700">NIB</label>
          <input type="text" name="nib" class="w-full mt-1 px-4 py-2 border rounded-lg text-sm" />
        </div>

        @php
          $fields = [
            ['id' => 'company_profile', 'label' => 'Company Profile'],
            ['id' => 'business_license', 'label' => 'Izin Perusahaan'],
            ['id' => 'tax_document', 'label' => 'Surat Pengukuhan PKP'],
            ['id' => 'organization_structure', 'label' => 'Struktur Organisasi'],
            ['id' => 'company_experience', 'label' => 'Daftar Pengalaman Perusahaan']
          ];
        @endphp

        @foreach ($fields as $field)
          <div>
            <label for="{{ $field['id'] }}" class="text-sm font-medium text-gray-700">{{ $field['label'] }}</label>
            <div class="relative mt-1 flex rounded-lg border border-gray-300 overflow-hidden">
              <input type="file" id="{{ $field['id'] }}" name="{{ $field['id'] }}"
                class="hidden" onchange="document.getElementById('{{ $field['id'] }}_label').textContent = this.files[0]?.name || 'Choose a file...';" />
              <div id="{{ $field['id'] }}_label"
                class="flex-1 px-4 py-2 text-sm text-gray-500 bg-white truncate">Choose a file...</div>
              <label for="{{ $field['id'] }}"
                class="cursor-pointer bg-gray-200 px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-300 transition">Upload</label>
            </div>
          </div>
        @endforeach

        <div class="pt-2">
          <button type="button"
  onclick="window.location.href='{{ route('vendor.dashboardvendor') }}'"
  class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
  Sign Up
</button>
        </div>
      </form>
    </section>
  </div>

  <script>
    function showStep2() {
      document.getElementById('step1-form').classList.add('hidden');
      document.getElementById('step2-form').classList.remove('hidden');
    }
  </script>
</body>
</html>
