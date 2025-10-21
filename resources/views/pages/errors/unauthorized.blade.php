@extends('layout.sidebarmenu')

@section('title', 'Error - Pages')

@section('pages-content')
<!-- Error -->
<div class="flex flex-col items-center justify-center min-h-screen py-10 bg-gray-50 text-center">
  <h1 class="text-[6rem] leading-[6rem] font-bold text-gray-800 mb-2">404</h1>
  <h4 class="text-2xl font-semibold text-gray-700 mb-2">Access Restricted</h4>
  <p class="max-w-xl text-gray-600 mb-6">
    You don't have permission to view this page. If you believe this is a mistake, please contact your administrator.
  </p>
  <button 
    onclick="history.back()" 
    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-green-600 font-medium rounded-lg shadow transition duration-200"
  >
    Go Back
  </button>
  <div class="mt-8">
    <img 
      src="{{ asset('assets/img/illustrations/page-misc-error-light.png') }}" 
      alt="page-misc-error-light" 
      class="max-w-[500px] w-full h-auto"
    >
  </div>
</div>
<!-- /Error -->
@endsection
