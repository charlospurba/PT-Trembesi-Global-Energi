@extends('layouts.app')

@section('content')
  <div class="max-w-4xl mx-auto py-10 px-6">
    @php
    $status = auth()->user()->status;
  @endphp

    <div class="bg-white rounded-xl shadow p-6 text-gray-800">
    <h2 class="text-xl font-bold mb-4">
      Registration Status :
      @if ($status === 'pending') <span class="text-yellow-500">Waiting for Verification</span>
    @elseif ($status === 'rejected') <span class="text-red-500">Rejected</span>
    @elseif ($status === 'approved') <span class="text-green-600">Approved</span>
    @endif
    </h2>

    <!-- Step bar -->
    <div class="flex items-center justify-between mb-6">
      @php
    $steps = ['Form Filling', 'Verification Process', 'Approved'];
    $currentStep = $status === 'pending' ? 2 : ($status === 'rejected' ? 2 : 3);
    @endphp

      @foreach ($steps as $index => $step)
      <div class="flex flex-col items-center">
      <div class="w-10 h-10 flex items-center justify-center rounded-full 
      @if ($index + 1 < $currentStep) bg-blue-500 text-white
    @elseif ($index + 1 == $currentStep)
      @if ($status === 'rejected') bg-red-500 text-white
    @else bg-blue-600 text-white @endif
    @else bg-gray-200 text-gray-400 @endif
      ">
      {{ $index + 1 }}
      </div>
      <span class="text-sm mt-2">{{ $step }}</span>
      </div>
      @if ($index < count($steps) - 1)
      <div class="flex-1 h-1 bg-gray-300 mx-2 
      @if ($index + 1 < $currentStep) bg-blue-500 @endif
      "></div>
    @endif
    @endforeach
    </div>

    <!-- Message -->
    <div>
      @if ($status === 'pending')
      <div class="bg-blue-100 text-blue-700 p-4 rounded">
      <strong>Your data is being verified</strong><br>
      Thank you for filling out the form. Please wait 2 × 24 hours for the verification process.
      </div>
    @elseif ($status === 'rejected')
      <div class="bg-yellow-100 text-yellow-800 p-4 rounded">
      <strong>Data has not been verified successfully</strong><br>
      Registration cannot be processed because your data does not meet the applicable requirements. Please check and
      adjust again.
      </div>
    @elseif ($status === 'approved')
      <div class="bg-green-100 text-green-800 p-4 rounded">
      <strong>Data Successfully Verified</strong><br>
      Your registration has been approved. However, your account is not yet active.<br>
      Please wait 1 × 24 hours for the administrator to activate your account before you can log in.
      </div>
    @endif
    </div>
    </div>
  </div>
@endsection