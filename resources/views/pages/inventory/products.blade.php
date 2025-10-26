@extends('layout.sidebarmenu')

@section('pages-content')
    @php
        $activeProductPercentage = $totalProducts > 0 ? round(($activeProducts / $totalProducts) * 100) : 0;
        $inactiveProductPercentage = $totalProducts > 0 ? round(($inactiveProducts / $totalProducts) * 100) : 0;
    @endphp
    <!-- Stats Section -->
    <div class="grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2 gap-3 mb-3">
        <!-- Total Products Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center">
                    <div class="w-8 h-8 bg-gradient-to-r from-emerald-600 to-emerald-500 flex items-center justify-center"
                        style="clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%)">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-4 text-white">
                            <path fill-rule="evenodd"
                                d="M1.5 9.832v1.793c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875V9.832a3 3 0 0 0-.722-1.952l-3.285-3.832A3 3 0 0 0 16.215 3h-8.43a3 3 0 0 0-2.278 1.048L2.222 7.88A3 3 0 0 0 1.5 9.832ZM7.785 4.5a1.5 1.5 0 0 0-1.139.524L3.881 8.25h3.165a3 3 0 0 1 2.496 1.336l.164.246a1.5 1.5 0 0 0 1.248.668h2.092a1.5 1.5 0 0 0 1.248-.668l.164-.246a3 3 0 0 1 2.496-1.336h3.165l-2.765-3.226a1.5 1.5 0 0 0-1.139-.524h-8.43Z"
                                clip-rule="evenodd" />
                            <path
                                d="M2.813 15c-.725 0-1.313.588-1.313 1.313V18a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3v-1.688c0-.724-.588-1.312-1.313-1.312h-4.233a3 3 0 0 0-2.496 1.336l-.164.246a1.5 1.5 0 0 1-1.248.668h-2.092a1.5 1.5 0 0 1-1.248-.668l-.164-.246A3 3 0 0 0 7.046 15H2.812Z" />
                        </svg>
                    </div>
                </div>
                <h2 class="text-base font-medium text-gray-700">Total Products</h2>
            </div>
            <div class="ps-14">
                <h3 class="text-2xl font-semibold text-gray-900">{{ $totalProducts }}</h3>
                <p class="text-xs text-gray-500 mt-1">Real Time Total</p>
                <div class="flex items-center gap-2 mt-2">
                    @php
                        $activeProductPercentage = $totalProducts > 0 ? round(($activeProducts / $totalProducts) * 100) : 0;
                    @endphp
                    <div class="flex items-center text-green-600 text-xs">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>{{ $activeProductPercentage }}% Active</span>
                    </div>
                    <div class="flex items-center text-red-600 text-xs">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>{{ 100 - $activeProductPercentage }}% Inactive</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Products Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center">
                    <div class="w-8 h-8 bg-gradient-to-r from-emerald-600 to-emerald-500 flex items-center justify-center"
                        style="clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-bag-check-fill size-4 text-white" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0m-.646 5.354a.5.5 0 0 0-.708-.708L7.5 10.793 6.354 9.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0z" />
                        </svg>
                    </div>
                </div>
                <h2 class="text-base font-medium text-gray-700">Active Products</h2>
            </div>
            <div class="ps-14">
                <h3 class="text-2xl font-semibold text-gray-900">{{ $activeProducts }}</h3>
                <p class="text-xs text-gray-500 mt-1">Currently Active</p>
                <div class="flex items-center gap-2 mt-2">
                    <div class="flex items-center text-green-600 text-xs">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>{{ $activeProductPercentage }}% of Total</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inactive Products Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center">
                    <div class="w-8 h-8 bg-gradient-to-r from-emerald-600 to-emerald-500 flex items-center justify-center"
                        style="clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%)">
                        <svg width="16" height="16" fill="currentColor" class="bi bi-bag-x-fill size-4 text-white"
                            viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0M6.854 8.146a.5.5 0 1 0-.708.708L7.293 10l-1.147 1.146a.5.5 0 0 0 .708.708L8 10.707l1.146 1.147a.5.5 0 0 0 .708-.708L8.707 10l1.147-1.146a.5.5 0 0 0-.708-.708L8 9.293z" />
                        </svg>
                    </div>
                </div>
                <h2 class="text-base font-medium text-gray-700">Inactive Products</h2>
            </div>
            <div class="ps-14">
                <h3 class="text-2xl font-semibold text-gray-900">{{ $inactiveProducts }}</h3>
                <p class="text-xs text-gray-500 mt-1">Currently Inactive</p>
                <div class="flex items-center gap-2 mt-2">
                    <div class="flex items-center text-red-600 text-xs">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>{{ $inactiveProductPercentage }}% of Total</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Stock Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center">
                    <div class="w-8 h-8 bg-gradient-to-r from-emerald-600 to-emerald-500 flex items-center justify-center"
                        style="clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%)">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-4 text-white">
                            <path fill-rule="evenodd"
                                d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <h2 class="text-base font-medium text-gray-700">Low/Out of Stock</h2>
            </div>
            <div class="ps-14">
                <h3 class="text-2xl font-semibold text-gray-900">{{ $lowStock }}</h3>
                <p class="text-xs text-gray-500 mt-1">Need Restock</p>
                <div class="flex items-center gap-2 mt-2">
                    <div class="relative group">
                        <div
                            class="flex items-center {{ $lowStock > 0 ? 'text-orange-600' : 'text-green-600' }} text-xs cursor-default">
                            <svg class="size-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                @if($lowStock > 0)
                                    <!-- Warning icon for low stock -->
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.721-1.36 3.486 0l6.518 11.593c.75 1.335-.213 2.983-1.743 2.983H3.482c-1.53 0-2.493-1.648-1.743-2.983L8.257 3.1zM10 6.5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 6.5zm0 7.75a.75.75 0 100 1.5.75.75 0 000-1.5z"
                                        clip-rule="evenodd" />
                                @else
                                    <!-- Checkmark icon for all in stock -->
                                    <path
                                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                @endif
                            </svg>
                            <span>{{ $lowStock > 0 ? 'Attention Needed' : 'All Products in Stock' }}</span>
                        </div>

                        @if($lowStock > 0)
                            @php
                                // Determine source for tooltip items:
                                // Prefer explicit $lowStockProducts passed from controller.
                                // Fallback to current $products collection (handles paginator).
                                $tooltipProducts = collect();
                                if (!empty($lowStockProducts) && count($lowStockProducts) > 0) {
                                    $tooltipProducts = collect($lowStockProducts);
                                } else {
                                    $src = $products ?? collect();
                                    if (is_object($src) && method_exists($src, 'getCollection')) {
                                        $src = $src->getCollection();
                                    }
                                    $src = collect($src);
                                    $tooltipProducts = $src->filter(function ($p) {
                                        $stock = $p->stock_count ?? $p->stock ?? $p->quantity ?? 0;
                                        $low = $p->low_threshold ?? 10;
                                        return $stock <= $low; // include zero (out) and low
                                    })->values();
                                }

                                // Sort by stock ascending so the least-stocked items appear first (0,1,2...)
                                $tooltipProducts = $tooltipProducts->sortBy(function ($p) {
                                    return (int) ($p->stock_count ?? $p->stock ?? $p->quantity ?? 0);
                                })->values();

                                // Small card list: take the first 3 lowest-stock products for quick view
                                $cardLowProducts = $tooltipProducts->slice(0, 3)->values();
                            @endphp

                            <!-- Tooltip: list of products that need restock (positioned below icon) -->
                            <div
                                class="absolute z-20 top-full mt-2 left-1/2 transform -translate-x-1/2 hidden group-hover:block group-focus:block w-64 bg-white border border-gray-200 rounded shadow-sm text-sm text-gray-700 p-3">
                                <div class="font-medium mb-1 text-red-600">Products needing restock</div>
                                <ul class="list-disc ml-4 max-h-44 overflow-auto">
                                    @forelse($tooltipProducts as $p)
                                        @php
                                            $name = $p->product_name ?? $p->name ?? $p->title ?? 'Unnamed Product';
                                            $stock = $p->stock_count ?? $p->stock ?? $p->quantity ?? 0;
                                        @endphp
                                        @if($stock == 0)
                                            <li class="truncate">{{ $name }} — Out of Stock</li>
                                        @else
                                            <li class="truncate">{{ $name }} — {{ $stock }} left</li>
                                        @endif
                                    @empty
                                        <li>No product details available.</li>
                                    @endforelse
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Products Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
        <!-- Products List Header -->
        <div class="bg-white shadow-sm p-5 mb-2">
            <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
                <!-- Title -->
                <h2 class="text-xl font-semibold text-primary mb-4 xl:mb-0">Products</h2>

                <!-- Filters and Actions Container -->
                <div class="flex flex-col xl:flex-row gap-4 w-full xl:w-auto">
                    <!-- Search and Filters -->
                    <form method="GET" class="flex flex-col md:flex-row gap-3 flex-1 global-focus">
                        <!-- Search Input -->
                        <div class="relative flex-1 md:max-w-60">
                            <input type="text" name="search" value="{{ $search }}" placeholder="Search Product..."
                                class="w-full px-3 py-2 pl-10 border border-gray-300 rounded-lg text-sm" />
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Filter Dropdowns -->
                        <div class="flex flex-wrap gap-3">
                            <select name="status"
                                class="px-3 py-2 border border-gray-300 rounded-lg text-sm flex-1 min-w-32">
                                <option value="">All Status</option>
                                <option value="Active" {{ $status === 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ $status === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>

                            <select id="mainCategorySelect" name="category"
                                class="px-3 py-2 border border-gray-300 rounded-lg text-sm flex-2 min-w-32">
                                <option value="">All Categories</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $category == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- <select id="subCategorySelect" name="sub_category"
                                    class="px-3 py-2 border border-gray-300 rounded-lg text-sm flex-1 min-w-32" {{ $subCategories ? '' : 'disabled' }}>
                                    <option value="">All Subcategories</option>
                                    @if($subCategories)
                                        @foreach($subCategories as $sub)
                                            <option value="{{ $sub->id }}" {{ $subCategory == $sub->id ? 'selected' : '' }}>
                                                {{ $sub->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select> -->

                            <select name="stock"
                                class="px-3 py-2 border border-gray-300 rounded-lg text-sm flex-1 min-w-32">
                                <option value="">All Stocks</option>
                                <option value="High" {{ $stockLevel === 'High' ? 'selected' : '' }}>High</option>
                                <option value="Low" {{ $stockLevel === 'Low' ? 'selected' : '' }}>Low</option>
                                <option value="Out" {{ $stockLevel === 'Out' ? 'selected' : '' }}>Out of Stock</option>
                            </select>
                            <!-- Action Buttons (submit inside the form) -->
                            <div class="flex gap-3">
                                <button type="submit"
                                    class="px-5 py-2 bg-primary text-white rounded-lg hover:bg-emerald-700 text-sm font-medium">
                                    Filter
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Add Product Button (separate link) -->
                    <div class="flex gap-3">
                        <a href="{{ route('products.create') }}"
                            class="px-5 py-2.5 bg-primary text-white rounded-lg hover:bg-emerald-700 transition-colors text-sm font-medium flex items-center justify-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            Add Product
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sms">
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
                    @forelse ($products as $product)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-3 text-gray-800 font-medium">{{ $product->product_name }}</td>
                            <td class="px-6 py-3 text-gray-600">{{ $product->brand->name ?? '—' }}</td>
                            <td class="px-6 py-3 text-gray-600">{{ $product->category->name ?? '—' }}</td>
                            <td class="px-6 py-3 text-gray-600">
                                {{ $product->stock_count }}
                            </td>
                            <td class="px-6 py-3">
                                @php
                                    $stock = $product->stock_count ?? 0;
                                    $low = $product->low_threshold ?? 10;

                                    $stockBadge = $stock == 0
                                        ? ['Out of Stock', 'bg-red-100 text-red-800']
                                        : ($stock <= $low
                                            ? ['Low', 'bg-yellow-100 text-yellow-800']
                                            : ['High', 'bg-green-100 text-green-800']);
                                @endphp
                                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $stockBadge[1] }}">
                                    {{ $stockBadge[0] }}
                                </span>
                            </td>

                            <td class="px-6 py-3 text-gray-600">
                                ₱{{ number_format($product->currentPrice(auth()->guard('employee')->user()?->branch_id), 2) }}
                            </td>
                            <td class="px-6 py-3 text-gray-600">{{ $product->warranty_period ?? '—' }} Months</td>

                            <td class="px-6 py-3">
                                @php
                                    $isActive = $product->active_status; // boolean
                                    $statusText = $isActive ? 'Active' : 'Inactive';
                                    $statusClass = $isActive ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-600';
                                @endphp

                                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $statusClass }}">
                                    {{ $statusText }}
                                </span>
                            </td>

                            <td class="px-6 py-3">
                                <div class="flex space-x-2">
                                    <!-- View Button -->
                                    <div class="relative group">
                                        <button
                                            class="text-gray-600 hover:text-primary/90 transition-colors duration-200 p-1 rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd"
                                                    d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <div
                                            class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-primary rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap pointer-events-none z-10">
                                            View Product
                                            <div
                                                class="absolute top-full left-1/2 transform -translate-x-1/2 border-4 border-transparent border-t-primary">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Edit Button -->
                                    <div class="relative group">
                                        <button
                                            class="text-gray-600 hover:text-primary/90 transition-colors duration-200 p-1 rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </button>
                                        <div
                                            class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-primary rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap pointer-events-none z-10">
                                            Edit Product
                                            <div
                                                class="absolute top-full left-1/2 transform -translate-x-1/2 border-4 border-transparent border-t-primary">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-3 text-center text-gray-500">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white px-6 py-4 border-t border-gray-200">
            {{ $products->links() }}
        </div>
    </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const mainCategorySelect = document.getElementById('mainCategorySelect');
                const subCategorySelect = document.getElementById('subCategorySelect');

                mainCategorySelect.addEventListener('change', function () {
                    const mainCategoryId = this.value;

                    // Reset subcategory dropdown
                    subCategorySelect.innerHTML = '<option value="">All Subcategories</option>';

                    if (!mainCategoryId) {
                        subCategorySelect.disabled = true;
                        return;
                    }

                    axios.get(`/categories/${mainCategoryId}/subcategories`)
                        .then(response => {
                            const subcategories = response.data;

                            if (subcategories.length > 0) {
                                subcategories.forEach(sub => {
                                    const option = new Option(sub.name, sub.id);
                                    subCategorySelect.add(option);
                                });
                                subCategorySelect.disabled = false;
                            } else {
                                subCategorySelect.disabled = true;
                                // optional: showToast('No subcategories found', 'error');
                            }
                        })
                        .catch(() => {
                            subCategorySelect.disabled = true;
                            // optional: showToast('Error loading subcategories', 'error');
                        });
                });
            });
        </script>

    @endpush
@endsection