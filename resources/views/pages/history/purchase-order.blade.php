@extends('layout.sidebarmenu')

@section('pages-content')
    <!-- Stats Section -->
    <div class="grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2 gap-5 mb-8">
        <!-- Total Orders Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Total Orders</h2>
            <div class="flex items-end justify-between">
                <div>
                    <h3 class="text-2xl font-semibold text-gray-900">156</h3>
                    <div class="mt-1 space-y-0.5">
                        <div class="flex items-center text-xs text-green-600">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            72% Completed
                        </div>
                        <div class="flex items-center text-xs text-yellow-600">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            28% Pending
                        </div>
                    </div>
                </div>
                <p class="text-xs text-gray-500">This Month</p>
            </div>
        </div>

        <!-- Total Suppliers Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Total Suppliers</h2>
            <h3 class="text-2xl font-semibold text-gray-900">24</h3>
            <p class="text-sm text-gray-500 mt-1">Active Suppliers</p>
        </div>

        <!-- Pending Orders Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Pending Orders</h2>
            <h3 class="text-2xl font-semibold text-gray-900">12</h3>
            <p class="text-sm text-gray-500 mt-1">Awaiting Delivery</p>
        </div>

        <!-- Total Products Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Total Products</h2>
            <h3 class="text-2xl font-semibold text-gray-900">1,247</h3>
            <p class="text-sm text-gray-500 mt-1">In Inventory</p>
        </div>
    </div>

    <!-- Stock Orders Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
        <!-- Stock Orders Header -->
        <div class="bg-white shadow-sm p-5 mb-2">
            <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-3">
                <h2 class="text-lg font-semibold text-gray-800">Stock Orders History</h2>
                
                <div class="flex flex-col xl:flex-row gap-3 w-full xl:w-auto">
                    <!-- Search Input -->
                    <div class="relative flex-1 xl:w-72">
                        <input 
                            type="text" 
                            placeholder="Search Product or Supplier ..." 
                            class="w-full pl-9 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:text-gray-400"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Buttons and Filters -->
                    <button class="px-5 py-2.5 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                        Search
                    </button>

                    <select class="px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <option>All Suppliers</option>
                        <option>ABC Suppliers</option>
                        <option>XYZ Distributors</option>
                        <option>Global Imports</option>
                    </select>

                    <select class="px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <option>All Status</option>
                        <option>Completed</option>
                        <option>Pending</option>
                        <option>Cancelled</option>
                    </select>

                    <!-- Add New Order -->
                    <button class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium flex items-center justify-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        New Order
                    </button>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Order ID</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Product Name</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Supplier</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Quantity</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Unit Price</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Total Cost</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Order Date</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Delivery Date</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Status</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    <!-- Sample Data Row -->
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-3 text-gray-800 font-medium">#ORD-001</td>
                        <td class="px-6 py-3 text-gray-600">Samsung Galaxy S23</td>
                        <td class="px-6 py-3 text-gray-600">ABC Suppliers</td>
                        <td class="px-6 py-3 text-gray-600">50 units</td>
                        <td class="px-6 py-3 text-gray-600">₱25,000.00</td>
                        <td class="px-6 py-3 text-gray-600 font-semibold">₱1,250,000.00</td>
                        <td class="px-6 py-3 text-gray-600">Jan 15, 2024</td>
                        <td class="px-6 py-3 text-gray-600">Jan 20, 2024</td>
                        <td class="px-6 py-3">
                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-800">Completed</span>
                        </td>
                        <td class="px-6 py-3">
                            <div class="flex space-x-2">
                                <button class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">View</button>
                                <button class="text-red-600 hover:text-red-900 text-sm font-medium">Cancel</button>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Additional sample rows would go here -->
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-3 text-gray-800 font-medium">#ORD-002</td>
                        <td class="px-6 py-3 text-gray-600">iPhone 15 Pro</td>
                        <td class="px-6 py-3 text-gray-600">XYZ Distributors</td>
                        <td class="px-6 py-3 text-gray-600">30 units</td>
                        <td class="px-6 py-3 text-gray-600">₱35,000.00</td>
                        <td class="px-6 py-3 text-gray-600 font-semibold">₱1,050,000.00</td>
                        <td class="px-6 py-3 text-gray-600">Jan 18, 2024</td>
                        <td class="px-6 py-3 text-gray-600">Jan 25, 2024</td>
                        <td class="px-6 py-3">
                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                        </td>
                        <td class="px-6 py-3">
                            <div class="flex space-x-2">
                                <button class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">View</button>
                                <button class="text-red-600 hover:text-red-900 text-sm font-medium">Cancel</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Showing 1 to 10 of 156 results
                </div>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 text-sm border border-gray-300 rounded-lg hover:bg-gray-50">Previous</button>
                    <button class="px-3 py-1 text-sm bg-blue-600 text-white rounded-lg">1</button>
                    <button class="px-3 py-1 text-sm border border-gray-300 rounded-lg hover:bg-gray-50">2</button>
                    <button class="px-3 py-1 text-sm border border-gray-300 rounded-lg hover:bg-gray-50">3</button>
                    <button class="px-3 py-1 text-sm border border-gray-300 rounded-lg hover:bg-gray-50">Next</button>
                </div>
            </div>
        </div>
    </div>
@endsection