{{-- resources/views/partials/product-grid.blade.php --}}
<div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 overflow-y-auto h-[600px] pr-2">
    @forelse($products as $product)
        <div
            class="border rounded-xl p-3 flex flex-col bg-white hover:shadow-md transition product-card h-[390px]"
            data-product-id="{{ $product['product_id'] }}"
        >
            <img 
                src="{{ $product['image'] ? asset('storage/'.$product['image']) : asset('assets/img/default-product.png') }}" 
                alt="{{ $product['name'] }}"
                class="mb-2 rounded-lg object-cover h-20 w-full h-[190px]"
            />

            {{-- Name --}}
            <div class="product-name font-semibold text-gray-800 text-lg mb-1">
                {{ $product['name'] }}
            </div>

            {{-- Price with raw value in data-price --}}
            <div class="product-price text-primary font-bold text-base mb-1" data-price="{{ $product['price'] }}">
                ₱{{ number_format($product['price'], 2) }}
            </div>

            {{-- Stock --}}
            <div class="product-stock text-xs text-gray-500 mb-2" data-stock="{{ $product['stock_count'] }}">
                Stock: {{ $product['stock_count'] }}
            </div>

            {{-- Optional small meta --}}
            @if(!empty($product['brand']))
                <div class="text-xs text-gray-400 mb-2">{{ $product['brand'] }}</div>
            @endif

            {{-- Add to Cart: include complete dataset so JS can read immediately --}}
            <button
                class="mt-auto px-3 py-2 bg-gray-100 rounded-lg text-sm flex items-center justify-center gap-2 hover:bg-primary hover:text-white transition add-to-cart"
                data-product-id="{{ $product['product_id'] }}"
                data-product-name="{{ e($product['name']) }}"
                data-product-price="{{ $product['price'] }}"
                data-product-stock="{{ $product['stock_count'] }}"
                data-product-image="{{ $product['image'] ? asset('storage/'.$product['image']) : '' }}"
                type="button"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 3h2l.4 2M7 13h10l4-8H5.4" stroke-linecap="round" stroke-linejoin="round" />
                    <circle cx="9" cy="21" r="1" />
                    <circle cx="20" cy="21" r="1" />
                </svg>
                Add to Cart
            </button>
        </div>
    @empty
        <div class="col-span-full text-center text-gray-500 py-10">
            No products found for this selection.
        </div>
    @endforelse
</div>
