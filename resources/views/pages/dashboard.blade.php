@extends('layout.app_with_nav')

@section('title', 'Dashboard')

@section('content')
  <h1 class="text-3xl font-semibold text-primary mb-6">Hello John Rex 👋</h1>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-white p-6 rounded-2xl shadow text-center">
      <h3 class="text-gray-500">Profits</h3>
      <p class="text-2xl font-bold text-primary">₱530,330</p>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow text-center">
      <h3 class="text-gray-500">Sales</h3>
      <p class="text-2xl font-bold text-primary">₱2,830,330</p>
    </div>
  </div>
@endsection
