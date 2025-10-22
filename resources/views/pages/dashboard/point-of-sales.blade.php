@extends('layout.sidebarmenu')

@section('title', 'Point of Sales')

@section('pages-content')
  <div class="flex flex-col lg:flex-row gap-6 h-auto lg:h-[600px]">
    <!-- Left: Product Catalog -->
  <div class="flex-1 flex flex-col min-h-0">
      <!-- Header -->
      <div class="flex items-center justify-between mb-2 bg-white rounded-lg shadow-sm px-6 py-3">
        <div>
          <h1 class="text-xl font-semibold text-primary">Point of Sales</h1>
          <p class="text-sm text-gray-500">Product Catalog</p>
        </div>
        <div class="flex items-center gap-2">
          <div class="relative">
            <input type="text" placeholder="Search Product..." class="border rounded-lg px-3 py-2 text-sm w-48" />
            <button class="absolute right-1 top-1 bg-primary text-white px-3 py-1 rounded-lg text-sm">Search</button>
          </div>
          <select class="border rounded-lg px-3 py-2 text-sm">
            <option>All Brands</option>
          </select>
          <label class="flex items-center gap-1 text-sm">
            <input type="checkbox" class="accent-primary" />
            Discounted
          </label>
        </div>
      </div>
      <!-- Tabs -->
  <div class="bg-white rounded-lg shadow-sm p-6 flex-1 flex flex-col min-h-0">
        <div class="gap-4 mb-4">
          <button class="px-4 py-2 rounded-lg bg-primary text-white text-sm font-medium">All Products</button>
          <button class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 text-sm font-medium">Peripherals</button>
          <button class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 text-sm font-medium">Accessories</button>
          <button class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 text-sm font-medium">PC Furniture</button>
          <button class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 text-sm font-medium">CCTV</button>
          <button class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 text-sm font-medium">Solar</button>
        </div>
        <!-- Product Grid (scrollable) -->
        <div>
          <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 overflow-y-auto h-[410px] pr-2">
            <!-- Example Product Card -->
            @for($i = 0; $i < 15; $i++)
              <div class="border rounded-xl p-3 flex flex-col">
                <img src="https://via.placeholder.com/120x80?text=Product" alt="Product"
                  class="mb-2 rounded-lg object-cover h-20 w-full" />
                <div class="font-semibold text-gray-800 text-sm mb-1">Product Name</div>
                <div class="text-primary font-bold text-base mb-1">₱1,000.00</div>
                <div class="text-xs text-gray-500 mb-2">Stock: 10</div>
                <button
                  class="mt-auto px-3 py-2 bg-gray-100 rounded-lg text-sm flex items-center justify-center gap-2 hover:bg-primary hover:text-white transition">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 3h2l.4 2M7 13h10l4-8H5.4" stroke-linecap="round" stroke-linejoin="round" />
                    <circle cx="9" cy="21" r="1" />
                    <circle cx="20" cy="21" r="1" />
                  </svg>
                  Add to Cart
                </button>
              </div>
            @endfor
          </div>
        </div>
      </div>
    </div>
    <!-- Right: Cart Panel -->
    <aside class="w-full lg:w-[350px] flex flex-col min-h-0 bg-transparent lg:bg-white rounded-lg lg:shadow-sm overflow-hidden">
      <!-- Header (card-like) -->
      <div class="px-4 pt-4">
        <div class="bg-white rounded-lg shadow-sm p-3 flex items-start justify-between">
          <div>
            <div class="text-sm text-gray-600">Current Transactions</div>
            <div class="text-xs text-gray-400">Monday, 09/11/2025</div>
          </div>
          <div class="text-emerald-600 text-sm font-semibold">BZ Davao Branch</div>
        </div>
      </div>

      <!-- Cart content (scrollable list) -->
      <div class="p-4 flex-1 min-h-0 flex flex-col">
        <div class="flex items-center justify-between mb-3">
          <h3 class="font-semibold text-md">All Added Products</h3>
          <button class="flex items-center gap-2 text-sm bg-gray-100 p-3 rounded-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22" />
            </svg>
            Remove All
          </button>
        </div>

        <!-- Scrollable items container with responsive fixed height -->
        <div class="space-y-4 overflow-y-auto h-[260px] md:h-[320px] lg:h-[420px] pr-2">
          @for($i = 0; $i < 8; $i++)
            <div class="border rounded-lg p-3 flex gap-4 items-start bg-white">
              <img src="https://via.placeholder.com/80x80?text=IMG" alt="Product" class="w-20 h-20 object-cover rounded-md shadow-sm -ml-1" />
              <div class="flex-1">
                <div class="flex items-start justify-between">
                  <div class="font-semibold text-sm">NVIDIA RTX 4060</div>
                  <button class="text-red-400 text-sm">×</button>
                </div>
                <div class="text-primary font-bold text-sm mt-1">₱20,800.00</div>

                <div class="mt-3 text-sm">
                  <div class="mb-1">Qty:</div>
                  <div class="flex items-center gap-2">
                    <button class="w-6 h-6 flex items-center justify-center rounded border text-gray-600">-</button>
                    <div class="px-3">1</div>
                    <button class="w-6 h-6 flex items-center justify-center rounded border text-gray-600">+</button>
                  </div>
                </div>
              </div>
            </div>
          @endfor
        </div>
      </div>

      <!-- Totals + Action (fixed at bottom of the panel) -->
      <div class="p-4 border-t bg-white">
        <div class="flex items-center justify-between text-sm mb-3">
          <div class="text-gray-600">Total Items: <span class="font-semibold">1</span></div>
          <div class="text-gray-800 font-semibold">Total Amount: ₱20,800.00</div>
        </div>

        <button class="w-full py-3 bg-emerald-600 text-white rounded-lg font-semibold flex items-center justify-center gap-2">
          <span>Process Payment</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
          </svg>
        </button>
      </div>
    </aside>
  </div>
@endsection