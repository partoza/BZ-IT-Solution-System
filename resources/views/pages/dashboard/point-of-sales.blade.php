@extends('layout.sidebarmenu')

@section('title', 'Point of Sales')

@section('pages-content')
<div class="flex flex-col lg:flex-row gap-6 h-auto lg:h-[800px]">
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
          <input id="searchInput" type="text" placeholder="Search Product..." class="border rounded-lg px-3 py-2 text-sm w-48" />
        </div>

        <select id="brandFilter" class="border rounded-lg px-3 py-2 text-sm">
          <option value="">All Brands</option>
          @foreach($brands as $brand)
            <option value="{{ $brand->id ?? $brand->brand_id }}">{{ $brand->name ?? $brand->brand_name }}</option>
          @endforeach
        </select>

        <label class="flex items-center gap-1 text-sm">
          <input id="discountFilter" type="checkbox" class="accent-primary" />
          Discounted
        </label>
      </div>
    </div>

    <!-- Tabs -->
    <div class="bg-white rounded-lg shadow-sm p-6 flex-1 flex flex-col min-h-0">
      <div id="categoryTabs" class="gap-2 mb-4 flex flex-wrap">
        <button data-category="" class="tab-btn px-4 py-2 rounded-lg bg-primary text-white text-sm">All Products</button>

        @foreach($categories as $category)
          <div class="relative group">
            <button data-category="{{ $category->id }}" class="tab-btn px-4 py-2 rounded-lg bg-gray-100 text-gray-700 text-sm">
              {{ $category->name }}
            </button>
          </div>
        @endforeach
      </div>

      <!-- Product Grid (AJAX replacement target) -->
      <div id="productGridWrapper">
        @include('partials.product-grid', ['products' => $products])
      </div>
    </div>
  </div>

  <!-- Right: Cart Panel -->
  <aside class="w-full lg:w-[350px] flex flex-col min-h-0 bg-transparent lg:bg-white rounded-lg lg:shadow-sm overflow-hidden">
    <!-- Header -->
    <div class="px-4 pt-4">
      <div class="bg-white rounded-lg shadow-sm p-3 flex items-start justify-between">
        <div>
          <div class="text-sm text-gray-600">Current Transactions</div>
          <div id="currentDate" class="text-xs text-gray-400"></div>
        </div>
        <div class="text-emerald-600 text-sm font-semibold">BZ Davao Branch</div>
      </div>
    </div>

    <!-- Cart content -->
    <div class="p-4 flex-1 min-h-0 flex flex-col">
      <div class="flex items-center justify-between mb-3">
        <h3 class="font-semibold text-md">Selected Products</h3>
        <button id="clearCartBtn" class="flex items-center gap-2 text-sm bg-gray-100 p-3 rounded-md">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22" />
          </svg>
          Remove All
        </button>
      </div>

      <div id="cartItems" class="space-y-4 overflow-y-auto h-[260px] md:h-[320px] lg:h-[420px] pr-2">
        <div class="text-center text-gray-400">No products in cart.</div>
      </div>
    </div>

    <!-- Action Button -->
    <div class="p-4 border-t bg-white">
      <button id="processPaymentBtn" type="button" class="w-full py-3 bg-emerald-600 text-white rounded-lg font-semibold flex items-center justify-center gap-2">
        <span>Process Payment</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
        </svg>
      </button>
    </div>
  </aside>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  console.debug('POS script: selection-only mode initialized.');

  const productGridWrapper = document.getElementById('productGridWrapper');
  const categoryTabs = document.getElementById('categoryTabs');
  const brandFilter = document.getElementById('brandFilter');
  const searchInput = document.getElementById('searchInput');
  const discountFilter = document.getElementById('discountFilter');
  const clearCartBtn = document.getElementById('clearCartBtn');
  const checkoutBtn = document.getElementById('processPaymentBtn'); 
  const cartItemsEl = document.getElementById('cartItems');

  const productGridUrl = '{{ route("pos.index") }}';
  const checkoutUrl = '{{ route("pos.checkout") }}';
  const csrfToken = '{{ csrf_token() }}';
  const cart = new Map();
  let currentCategory = '';
  let debounceTimer = null;

  // ---------- Utility ----------
  function escapeHtml(text) {
    if (!text) return '';
    return String(text).replace(/[&<>"'`=\/]/g, s => ({
      '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;',
      "'": '&#39;', '/': '&#x2F;', '`': '&#x60;', '=': '&#x3D;'
    }[s]));
  }

  // ---------- Render Cart ----------
  function renderCart() {
    if (!cartItemsEl) return;
    if (cart.size === 0) {
      cartItemsEl.innerHTML = '<div class="text-center text-gray-400">No products in cart.</div>';
      return;
    }

    let html = '';
    for (const [pid, item] of cart.entries()) {
      html += `
        <div class="border rounded-lg p-3 flex gap-4 items-start bg-white">
          <img src="${item.image || '{{ asset('assets/img/default-product.png') }}'}" alt="${escapeHtml(item.name)}" class="w-20 h-20 object-cover rounded-md shadow-sm -ml-1" />
          <div class="flex-1">
            <div class="flex items-start justify-between">
              <div class="font-semibold text-sm">${escapeHtml(item.name)}</div>
              <button data-remove="${pid}" class="text-red-400 text-sm">×</button>
            </div>
            <div class="mt-3 text-sm">
              <div class="mb-1">Qty:</div>
              <div class="flex items-center gap-2">
                <button data-decrement="${pid}" class="w-6 h-6 flex items-center justify-center rounded border text-gray-600">-</button>
                <div class="px-3">${item.qty}</div>
                <button data-increment="${pid}" class="w-6 h-6 flex items-center justify-center rounded border text-gray-600">+</button>
              </div>
            </div>
          </div>
        </div>`;
    }
    cartItemsEl.innerHTML = html;
  }

  // ---------- Quantity & Cart Control ----------
  function changeQty(productId, delta) {
    const item = cart.get(productId);
    if (!item) return;
    const newQty = item.qty + delta;
    if (newQty <= 0) {
      cart.delete(productId);
      showToast('Item removed from cart', 'success');
    } else if (newQty > item.stock_count) {
      showToast('Reached maximum stock available', 'error');
      return;
    } else {
      item.qty = newQty;
      cart.set(productId, item);
    }
    renderCart();
  }

  function addToCartFromButton(btn) {
    if (!btn) return;
    const pid = btn.dataset.productId;
    if (!pid) return;

    const name = btn.dataset.productName ?? 'Unknown';
    const stock = parseInt(btn.dataset.productStock ?? 0);
    const image = btn.dataset.productImage ?? '{{ asset('assets/img/default-product.png') }}';

    const existing = cart.get(pid);
    if (existing) {
      if (existing.qty + 1 > stock) {
        showToast('Reached maximum stock available', 'error');
        return;
      }
      existing.qty += 1;
      cart.set(pid, existing);
      showToast('Increased quantity', 'success');
    } else {
      if (stock === 0) { showToast('Item out of stock', 'error'); return; }
      cart.set(pid, { id: pid, name, qty: 1, stock_count: stock, image });
      showToast('Item added to cart', 'success');
    }
    renderCart();
  }

  // ---------- Product Card Preparation ----------
  function annotateProductCardsForCart() {
    if (!productGridWrapper) return;
    productGridWrapper.querySelectorAll('[data-product-id]').forEach(card => {
      const pid = card.dataset.productId;
      const btn = card.querySelector('.add-to-cart');
      if (!btn) return;
      if (!btn.dataset.productId) btn.dataset.productId = pid;

      const nameNode = card.querySelector('.product-name');
      if (!btn.dataset.productName && nameNode) btn.dataset.productName = nameNode.textContent.trim();

      const stockNode = card.querySelector('.product-stock');
      if (!btn.dataset.productStock && stockNode) {
        btn.dataset.productStock = (stockNode.dataset.stock ?? parseInt(stockNode.textContent.replace(/\D/g, ''))) || 0;
      }

      const img = card.querySelector('img');
      if (!btn.dataset.productImage && img) btn.dataset.productImage = img.src || '';
    });
  }

  // ---------- Fetch Products ----------
  async function fetchProducts() {
    const params = new URLSearchParams({
      category_id: currentCategory || '',
      brand_id: brandFilter?.value || '',
      search: searchInput?.value || '',
      discounted: discountFilter?.checked ? 1 : 0
    });

    try {
      const res = await fetch(productGridUrl + '?' + params.toString(), {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      });
      if (!res.ok) throw new Error('Network error ' + res.status);
      const html = await res.text();
      if (productGridWrapper) {
        productGridWrapper.innerHTML = html;
        annotateProductCardsForCart();
      }
    } catch (err) {
      console.error(err);
      showToast('Failed to load products', 'error');
    }
  }

  // ---------- Event Listeners ----------
  document.addEventListener('click', (e) => {
    const addBtn = e.target.closest('.add-to-cart');
    if (addBtn) return addToCartFromButton(addBtn);

    const inc = e.target.closest('[data-increment]');
    if (inc) return changeQty(inc.getAttribute('data-increment'), 1);

    const dec = e.target.closest('[data-decrement]');
    if (dec) return changeQty(dec.getAttribute('data-decrement'), -1);

    const rem = e.target.closest('[data-remove]');
    if (rem) {
      cart.delete(rem.getAttribute('data-remove'));
      showToast('Item removed from cart', 'success');
      return renderCart();
    }

    const tab = e.target.closest('.tab-btn, .sub-tab-btn');
    if (tab && categoryTabs.contains(tab)) {
      categoryTabs.querySelectorAll('.tab-btn').forEach(t => {
        t.classList.remove('bg-primary', 'text-white');
        t.classList.add('bg-gray-100', 'text-gray-700');
      });
      tab.classList.remove('bg-gray-100', 'text-gray-700');
      tab.classList.add('bg-primary', 'text-white');
      currentCategory = tab.dataset.category ?? '';
      fetchProducts();
    }
  });

  brandFilter?.addEventListener('change', fetchProducts);
  discountFilter?.addEventListener('change', fetchProducts);
  searchInput?.addEventListener('input', () => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(fetchProducts, 300);
  });

  clearCartBtn?.addEventListener('click', () => {
    cart.clear();
    renderCart();
    showToast('Cart cleared', 'success');
  });

  // ---------- ✅ Checkout Handler 
  checkoutBtn?.addEventListener('click', () => {
    if (cart.size === 0) {
      showToast('Cart is empty.', 'error');
      return;
    }

    const cartData = Array.from(cart.values());

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("pos.checkout") }}';

    const csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_token';
    csrf.value = '{{ csrf_token() }}';
    form.appendChild(csrf);

    const cartInput = document.createElement('input');
    cartInput.type = 'hidden';
    cartInput.name = 'cartData';
    cartInput.value = JSON.stringify(cartData);
    form.appendChild(cartInput);

    document.body.appendChild(form);
    form.submit();
  });

  // ---------- Initialize ----------
  annotateProductCardsForCart();
  renderCart();
});
</script>
@endpush

@endsection
