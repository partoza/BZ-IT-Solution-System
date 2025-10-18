@extends('layout.sidebarmenu')

@section('title', 'Dashboard')

@section('pages-content')
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
                    <p class="text-gray-600">Welcome back, {{ Auth::guard('employee')->user()->first_name }}!</p>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">{{ Auth::guard('employee')->user()->full_name }}</span>
                    <span class="px-3 py-1 bg-primary/10 text-primary rounded-full text-sm">
                        {{ Auth::guard('employee')->user()->role }}
                    </span>
                    
                    <!-- Logout Form -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 transition-colors">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="border-4 border-dashed border-gray-200 rounded-lg h-96 p-8 text-center">
                    <h2 class="text-2xl font-semibold text-gray-600 mb-4">Welcome to BZ IT Solutions Dashboard</h2>
                    
                    <!-- Quick Stats -->
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold text-gray-700">Branch</h3>
                            <p class="text-2xl font-bold text-primary">{{ Auth::guard('employee')->user()->branch->name ?? 'N/A' }}</p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold text-gray-700">Role</h3>
                            <p class="text-2xl font-bold text-primary capitalize">{{ Auth::guard('employee')->user()->role }}</p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold text-gray-700">Last Login</h3>
                            <p class="text-sm text-gray-600">
                                {{ Auth::guard('employee')->user()->last_login ? Auth::guard('employee')->user()->last_login->format('M j, Y g:i A') : 'First login' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
