{{-- resources/views/partials/po-product-grid.blade.php --}}
@php use Illuminate\Support\Str; @endphp

<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 overflow-y-auto h-[410px] pr-2">
    @forelse($products as $product)
        @php
            // Normalize image URL:
            $img = $product['image_url'] ?? null;
            if ($img) {
                // if it's already an absolute URL or starts with a slash, use it as-is,
                // otherwise assume it's a storage path and prefix with asset('storage/...')
                $imgSrc = Str::startsWith($img, ['http://', 'https://', '/'])
                    ? $img
                    : asset('storage/'.$img);
            } else {
                $imgSrc = asset('assets/img/default-product.png');
            }

            $cost = $product['cost_price'] ?? 0;
            $base = $product['base_price'] ?? $cost;
            $stock = $product['stock_count'] ?? 0;
        @endphp

        <div
            class="border rounded-xl p-3 flex flex-col bg-white hover:shadow-md transition product-card"
            data-product-id="{{ $product['product_id'] }}"
        >
            <img
                src="{{ $imgSrc }}"
                alt="{{ $product['product_name'] ?? 'Product' }}"
                class="mb-2 rounded-lg object-cover h-20 w-full"
            />

            {{-- Product Name --}}
            <div class="product-name font-semibold text-gray-800 text-sm mb-1">
                {{ $product['product_name'] ?? 'Unnamed product' }}
            </div>

            {{-- Stock --}}
            <div class="product-stock text-xs text-gray-500 mb-2" data-stock="{{ $stock }}">
                Stock: {{ $stock }}
            </div>

            {{-- Add to PO Button (full dataset) --}}
            <button
                class="mt-auto px-3 py-2 bg-primary text-white rounded-lg text-sm flex items-center justify-center gap-2 hover:bg-primary-dark transition add-to-po-btn"
                data-product-id="{{ $product['product_id'] }}"
                data-product-name="{{ e($product['product_name'] ?? '') }}"
                data-product-cost="{{ $cost }}"
                data-product-base="{{ $base }}"
                data-product-stock="{{ $stock }}"
                data-product-image="{{ $imgSrc }}"
                data-product-sku="{{ $product['sku'] ?? '' }}"
                type="button"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Add to PO
            </button>
        </div>
    @empty
        <div class="col-span-full text-center text-gray-500 py-10">
            No products found for this selection.
        </div>
    @endforelse
</div>
