@extends('layout.sidebarmenu')

@section('pages-content')
    <!-- Stats Section -->
    <div class="grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2 gap-5 mb-8">
        <!-- Total Products Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Total Products</h2>
            <div class="flex items-end justify-between">
                <div>
                    <h3 class="text-2xl font-semibold text-gray-900">50</h3>
                    <div class="mt-1 space-y-0.5">
                        <div class="flex items-center text-xs text-green-600">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            80% Active
                        </div>
                        <div class="flex items-center text-xs text-gray-600">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            20% Inactive
                        </div>
                    </div>
                </div>
                <p class="text-xs text-gray-500">Real Time Total</p>
            </div>
        </div>

        <!-- No. Category Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">No. Category</h2>
            <h3 class="text-2xl font-semibold text-gray-900">8</h3>
            <div class="flex items-center text-green-500 mt-1">
                <span class="text-sm font-medium">↑ +1 Last Week</span>
            </div>
            <p class="text-sm text-gray-500 mt-1">Categories</p>
        </div>

        <!-- Active Products Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Active Products</h2>
            <h3 class="text-2xl font-semibold text-gray-900">40</h3>
            <div class="flex items-center text-green-500 mt-1">
                <span class="text-sm font-medium">↑ 80% Active</span>
            </div>
            <p class="text-sm text-gray-500 mt-1">Products are available</p>
        </div>

        <!-- Low Stock Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Low Stock</h2>
            <h3 class="text-2xl font-semibold text-gray-900">5</h3>
            <div class="flex items-center text-red-500 mt-1">
                <span class="text-sm font-medium">↓ Need Restock</span>
            </div>
            <p class="text-sm text-gray-500 mt-1">Products are in Low Stock</p>
        </div>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
        <!-- Products List Header -->
        <div class="bg-white shadow-sm p-5 mb-2">
            <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-3">
                <h2 class="text-lg font-semibold text-gray-800">Products</h2>

                <div class="flex flex-col xl:flex-row gap-3 w-full xl:w-auto">
                    <!-- Search Input -->
                    <div class="relative flex-1 xl:w-72">
                        <input type="text" placeholder="Search Supplier Order ..."
                            class="w-full pl-9 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:text-gray-400">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Buttons and Filters -->
                    <button
                        class="px-5 py-2.5 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                        Search
                    </button>

                    <select
                        class="px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <option>All Status</option>
                        <option>Active</option>
                        <option>Inactive</option>
                    </select>

                    <select
                        class="px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <option>All Category</option>
                        <option>Peripherals</option>
                        <option>Accessories</option>
                        <option>CCTV</option>
                    </select>

                    <select
                        class="px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <option>All Stocks</option>
                        <option>High</option>
                        <option>Low</option>
                        <option>Out of Stock</option>
                    </select>

                    <a href="{{ route('products.create') }}"
                        class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium flex items-center justify-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Product
                    </a>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Product</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Brand</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Category</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Stock</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Stock Status</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Price</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Warranty</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Status</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-3 text-gray-800 font-medium">Intel Core i9 12th</td>
                        <td class="px-6 py-3 text-gray-600">Intel</td>
                        <td class="px-6 py-3 text-gray-600">Peripherals</td>
                        <td class="px-6 py-3 text-gray-600">0</td>
                        <td class="px-6 py-3">
                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-red-100 text-red-800">Out of
                                Stock</span>
                        </td>
                        <td class="px-6 py-3 text-gray-600">₺36,000.00</td>
                        <td class="px-6 py-3 text-gray-600">6 Months</td>
                        <td class="px-6 py-3">
                            <span
                                class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-800">Active</span>
                        </td>
                        <td class="px-6 py-3">
                            <div class="flex space-x-2">
                                <button class="text-green-600 hover:text-green-900">✅</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-3 text-gray-800 font-medium">NVIDIA RTX 4060</td>
                        <td class="px-6 py-3 text-gray-600">NVIDIA</td>
                        <td class="px-6 py-3 text-gray-600">Peripherals</td>
                        <td class="px-6 py-3 text-gray-600">10</td>
                        <td class="px-6 py-3">
                            <span
                                class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-800">High</span>
                        </td>
                        <td class="px-6 py-3 text-gray-600">₺20,800.00</td>
                        <td class="px-6 py-3 text-gray-600">10 Months</td>
                        <td class="px-6 py-3">
                            <span
                                class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-800">Active</span>
                        </td>
                        <td class="px-6 py-3">
                            <div class="flex space-x-2">
                                <button class="text-green-600 hover:text-green-900">✅</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-3 text-gray-800 font-medium">AMD Ryzen 75700</td>
                        <td class="px-6 py-3 text-gray-600">AMD</td>
                        <td class="px-6 py-3 text-gray-600">Peripherals</td>
                        <td class="px-6 py-3 text-gray-600">5</td>
                        <td class="px-6 py-3">
                            <span
                                class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-800">High</span>
                        </td>
                        <td class="px-6 py-3 text-gray-600">₺6,395.00</td>
                        <td class="px-6 py-3 text-gray-600">10 Months</td>
                        <td class="px-6 py-3">
                            <span
                                class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-800">Active</span>
                        </td>
                        <td class="px-6 py-3">
                            <div class="flex space-x-2">
                                <button class="text-green-600 hover:text-green-900">✅</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-3 text-gray-800 font-medium">Royal Kludge RK61</td>
                        <td class="px-6 py-3 text-gray-600">Royal Kludge</td>
                        <td class="px-6 py-3 text-gray-600">Accessories</td>
                        <td class="px-6 py-3 text-gray-600">2</td>
                        <td class="px-6 py-3">
                            <span
                                class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Low</span>
                        </td>
                        <td class="px-6 py-3 text-gray-600">₺1,745.00</td>
                        <td class="px-6 py-3 text-gray-600">3 Months</td>
                        <td class="px-6 py-3">
                            <span
                                class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-800">Active</span>
                        </td>
                        <td class="px-6 py-3">
                            <div class="flex space-x-2">
                                <button class="text-green-600 hover:text-green-900">✅</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-3 text-gray-800 font-medium">Hikvision DS-2CE...</td>
                        <td class="px-6 py-3 text-gray-600">Hikvision</td>
                        <td class="px-6 py-3 text-gray-600">CCTV</td>
                        <td class="px-6 py-3 text-gray-600">15</td>
                        <td class="px-6 py-3">
                            <span
                                class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-800">High</span>
                        </td>
                        <td class="px-6 py-3 text-gray-600">₺700.00</td>
                        <td class="px-6 py-3 text-gray-600">12 Months</td>
                        <td class="px-6 py-3">
                            <span
                                class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-800">Active</span>
                        </td>
                        <td class="px-6 py-3">
                            <div class="flex space-x-2">
                                <button class="text-green-600 hover:text-green-900">✅</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white px-6 py-4 border-t border-gray-200">
            <p class="text-sm text-gray-600">Showing 1 to 5 out of 50</p>
        </div>
    </div>

    <!-- Modal removed: Add Product now navigates to a dedicated page (route: products.add) -->
@endsection