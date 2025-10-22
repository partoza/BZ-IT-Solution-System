@extends('layout.sidebarmenu')

@section('pages-content')
    <!-- Stats Section -->
    <div class="grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2 gap-5 mb-8">
        <!-- Total Products Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Total Products</h2>
            <h3 class="text-2xl font-semibold text-gray-900">{{ $totalProducts }}</h3>
            <p class="text-xs text-gray-500 mt-1">Real Time Total</p>
        </div>

        <!-- No. Category Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Active Products</h2>
            <h3 class="text-2xl font-semibold text-gray-900">{{ $activeProducts }}</h3>
            <p class="text-xs text-green-600 mt-1">↑ Active</p>
        </div>

        <!-- Active Products Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Inactive Products</h2>
            <h3 class="text-2xl font-semibold text-gray-900">{{ $inactiveProducts }}</h3>
            <p class="text-xs text-red-600 mt-1">↓ Inactive</p>
        </div>

        <!-- Low Stock Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Low Stock</h2>
            <h3 class="text-2xl font-semibold text-gray-900">{{ $lowStock }}</h3>
            <p class="text-xs text-yellow-600 mt-1">⚠️ Need Restock</p>
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
                <form method="GET" class="flex flex-wrap gap-3">
                    <div class="relative flex-1 xl:w-72">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Search Product..."
                        class="w-60 px-3 py-2 border border-gray-300 rounded-lg text-sm" />
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        <option value="">All Status</option>
                        <option value="Active" {{ $status === 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ $status === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>

                    <select id="mainCategorySelect" name="category" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        <option value="">All Categories</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $category == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>

                    <select id="subCategorySelect" name="sub_category" class="px-3 py-2 border border-gray-300 rounded-lg text-sm" {{ $subCategories ? '' : 'disabled' }}>
                        <option value="">All Subcategories</option>
                        @if($subCategories)
                            @foreach($subCategories as $sub)
                                <option value="{{ $sub->id }}" {{ $subCategory == $sub->id ? 'selected' : '' }}>
                                    {{ $sub->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    
                    <select name="stock" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        <option value="">All Stocks</option>
                        <option value="High" {{ $stockLevel === 'High' ? 'selected' : '' }}>High</option>
                        <option value="Low" {{ $stockLevel === 'Low' ? 'selected' : '' }}>Low</option>
                        <option value="Out" {{ $stockLevel === 'Out' ? 'selected' : '' }}>Out of Stock</option>
                    </select>

                    <button type="submit"
                        class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-medium">
                        Filter
                    </button>

                    <a href="{{ route('products.create') }}"
                        class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium flex items-center justify-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Product
                    </a>
                </form>
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
                    @forelse ($products as $product)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-3 text-gray-800 font-medium">{{ $product->product_name }}</td>
                            <td class="px-6 py-3 text-gray-600">{{ $product->brand->name ?? '—' }}</td>
                            <td class="px-6 py-3 text-gray-600">{{ $product->category->name ?? '—' }}</td>
                            <td class="px-6 py-3 text-gray-600">
                                {{ $product->branches->first()?->pivot->quantity_in_stock ?? 0 }}
                            </td>

                            <td class="px-6 py-3">
                                @php
                                    $branchId = auth()->guard('employee')->user()?->branch_id;
                                    $branchPivot = $product->branches->firstWhere('branch_id', $branchId)?->pivot;
                                    $branchStock = $branchPivot->quantity_in_stock ?? 0;
                                    $branchLow = $branchPivot->low_stock_threshold ?? 10;

                                    $stockBadge = $branchStock == 0
                                        ? ['Out of Stock', 'bg-red-100 text-red-800']
                                        : ($branchStock <= $branchLow
                                            ? ['Low', 'bg-yellow-100 text-yellow-800']
                                            : ['High', 'bg-green-100 text-green-800']);
                                @endphp
                                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $stockBadge[1] }}">
                                    {{ $stockBadge[0] }}
                                </span>
                            </td>

                            <td class="px-6 py-3 text-gray-600">₱{{ number_format($product->base_price, 2) }}</td>
                            <td class="px-6 py-3 text-gray-600">{{ $product->warranty_period ?? '—' }} Months</td>

                            <td class="px-6 py-3">
                                @php
                                    $isActive = $product->active_status; // boolean
                                    $statusText = $isActive ? 'Active' : 'Inactive';
                                    $statusClass = $isActive ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600';
                                @endphp

                                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $statusClass }}">
                                    {{ $statusText }}
                                </span>
                            </td>

                            <td class="px-6 py-3">
                                <div class="flex space-x-2">
                                    <a href="#" class="text-blue-600 hover:text-blue-900">✏️</a>
                                    <a href="#" class="text-red-600 hover:text-red-900">🗑️</a>
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