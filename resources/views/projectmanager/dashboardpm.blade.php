@extends('layouts.app')

@section('content')
    @include('components.navpm')

    <div class="flex min-h-screen">
          @include('components.sidepm')
          <div class="bg-gray-100 min-h-screen p-6 flex-1">
            <div class="bg-red-500 text-white px-6 py-4 rounded-md shadow">
                <h2 class="text-xl font-bold">Procurement Request </h2>
                <p class="text-sm">Manage your team's procurement needs</p>
            </div>
        </div>
    </div>



 