{{-- resources/views/partials/po-product-grid.blade.php --}}
@php use Illuminate\Support\Str; @endphp

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-4 gap-4 overflow-y-auto h-[340px] pr-2">
    @forelse($products as $product)
        @php
            // Normalize image URL:
            $img = $product['image_url'] ?? null;
            if ($img) {
                // if it's already an absolute URL or starts with a slash, use it as-is,
                // otherwise assume it's a storage path and prefix with asset('storage/...')
                $imgSrc = Str::startsWith($img, ['http://', 'https://', '/'])
                    ? $img
                    : asset('storage/' . $img);
            } else {
                $imgSrc = asset('assets/img/default-product.png');
            }

            $cost = $product['cost_price'] ?? 0;
            $base = $product['base_price'] ?? $cost;
            $stock = $product['stock_count'] ?? 0;
        @endphp

        <div class="border rounded-xl p-2 flex flex-col justify-between bg-white hover:shadow-md transition product-card h-[220px]"
            data-product-id="{{ $product['product_id'] }}">
            <div class="mb-2 rounded-lg bg-white h-24 w-full flex items-center justify-center">
                <img src="{{ $imgSrc }}" alt="{{ $product['product_name'] ?? 'Product' }}"
                    class="max-h-full max-w-full object-contain" />
            </div>

            {{-- Product Name --}}
            <div class="product-name font-semibold text-gray-800 text-sm truncate w-full">
                {{ $product['product_name'] ?? 'Unnamed product' }}
            </div>

            {{-- Stock --}}
            <div class="product-stock text-xs text-gray-500" data-stock="{{ $stock }}">
                Stock:
                @if ($stock == 0)
                    <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-red-100 text-red-800">Out of Stock</span>
                @elseif ($stock <= 5)
                    <span>{{ $stock }} Left</span>
                    <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Low</span>
                @else
                    <span class="py-0.5">{{ $stock }} Left</span>
                @endif
            </div>

            {{-- Add to PO Button (full dataset) --}}
            <button
                class="px-3 py-2 mt-2 border border-2 hover:border-none hover:bg-primary hover:text-white rounded-lg text-sm flex items-center justify-center gap-2 hover:bg-primary-dark transition add-to-po-btn"
                data-product-id="{{ $product['product_id'] }}" data-product-name="{{ e($product['product_name'] ?? '') }}"
                data-product-cost="{{ $cost }}" data-product-base="{{ $base }}" data-product-stock="{{ $stock }}"
                data-product-image="{{ $imgSrc }}" data-product-sku="{{ $product['sku'] ?? '' }}" type="button">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                Add to Order
            </button>
        </div>
    @empty
        <div class="col-span-full text-center text-gray-500 py-10">
            No products found for this selection.
        </div>
    @endforelse
</div>