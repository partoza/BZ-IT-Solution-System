<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
  @forelse($products as $product)
    @include('pages.dashboard.partials.product-cards-grid', ['product' => $product])
  @empty
    <div class="col-span-full flex justify-center items-center text-gray-400" style="min-height: 200px;">
      No products found.
    </div>
  @endforelse
</div>
