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
    <!-- Header (card-like) -->
    <div class="px-4 pt-4">
      <div class="bg-white rounded-lg shadow-sm p-3 flex items-start justify-between">
        <div>
          <div class="text-sm text-gray-600">Current Transactions</div>
          <div id="currentDate" class="text-xs text-gray-400"></div>
        </div>
        <div class="text-emerald-600 text-sm font-semibold">BZ Davao Branch</div>
      </div>
    </div>

    <!-- Cart content (scrollable list) -->
    <div class="p-4 flex-1 min-h-0 flex flex-col">
      <div class="flex items-center justify-between mb-3">
        <h3 class="font-semibold text-md">All Added Products</h3>
        <button id="clearCartBtn" class="flex items-center gap-2 text-sm bg-gray-100 p-3 rounded-md">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22" />
          </svg>
          Remove All
        </button>
      </div>

      <!-- Scrollable cart items -->
      <div id="cartItems" class="space-y-4 overflow-y-auto h-[260px] md:h-[320px] lg:h-[420px] pr-2">
        <!-- Items injected by JS -->
        <div class="text-center text-gray-400">No products in cart.</div>
      </div>
    </div>

    <!-- Totals + Action (fixed at bottom of the panel) -->
    <div class="p-4 border-t bg-white">
      <div class="flex items-center justify-between text-sm mb-3">
        <div class="text-gray-800 font-semibold">Total Amount: <span id="cartTotal">₱0.00</span></div>
      </div>

      <button id="processPaymentBtn" class="w-full py-3 bg-emerald-600 text-white rounded-lg font-semibold flex items-center justify-center gap-2">
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
  console.debug('POS script: init');

  // ---------- DOM refs ----------
  const productGridWrapper = document.getElementById('productGridWrapper');
  const categoryTabs = document.getElementById('categoryTabs');
  const brandFilter = document.getElementById('brandFilter');
  const searchInput = document.getElementById('searchInput');
  const discountFilter = document.getElementById('discountFilter');
  const searchBtn = document.getElementById('searchBtn');
  const clearCartBtn = document.getElementById('clearCartBtn');
  const cartItemsEl = document.getElementById('cartItems');
  const cartTotalEl = document.getElementById('cartTotal');

  // route for AJAX product reload
  const productGridUrl = '{{ route("pos.index") }}';

  // Client-side cart store: Map<productId, { id, name, price, qty, stock_count, image }>
  const cart = new Map();

  // filter state
  let currentCategory = '';
  let debounceTimer = null;

  // ------------------------------
  // Toast Notification
  // ------------------------------
  window.showToast = function (message, type = 'success') {
    let container = document.getElementById("toast-container");
    if (!container) {
      container = document.createElement("div");
      container.id = "toast-container";
      container.className = "fixed top-20 left-1/2 transform -translate-x-1/2 z-50";
      document.body.appendChild(container);
    }

    const toast = document.createElement("div");
    toast.className = `mb-2 px-4 py-3 rounded shadow-lg text-white flex items-center justify-between ${
      type === 'success' ? 'bg-green-500' : 'bg-red-500'
    }`;
    toast.innerHTML = `<span>${message}</span><button class="ml-4 font-bold" onclick="this.parentElement.remove()">×</button>`;

    container.appendChild(toast);
    setTimeout(() => toast.remove(), 1500);
  };

  // ---------- Helpers ----------
  function formatMoney(num) {
    return '₱' + Number(num || 0).toFixed(2);
  }

  function escapeHtml(text) {
    if (!text) return '';
    return String(text).replace(/[&<>"'`=\/]/g, s => ({
      '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;',
      "'": '&#39;', '/': '&#x2F;', '`': '&#x60;', '=': '&#x3D;'
    }[s]));
  }

  // Renders the cart panel from `cart` map
  function renderCart() {
    if (!cartItemsEl) return;
    if (cart.size === 0) {
      cartItemsEl.innerHTML = '<div class="text-center text-gray-400">No products in cart.</div>';
      if (cartTotalEl) cartTotalEl.textContent = formatMoney(0);
      return;
    }

    let html = '';
    let total = 0;

    for (const [pid, item] of cart.entries()) {
      const subtotal = item.price * item.qty;
      total += subtotal;

      html += `
        <div class="border rounded-lg p-3 flex gap-4 items-start bg-white">
          <img src="${item.image ? item.image : '{{ asset('assets/img/default-product.png') }}'}" alt="${escapeHtml(item.name)}" class="w-20 h-20 object-cover rounded-md shadow-sm -ml-1" />
          <div class="flex-1">
            <div class="flex items-start justify-between">
              <div class="font-semibold text-sm">${escapeHtml(item.name)}</div>
              <button data-remove="${pid}" class="text-red-400 text-sm">×</button>
            </div>
            <div class="text-primary font-bold text-sm mt-1">${formatMoney(item.price)}</div>
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
    if (cartTotalEl) cartTotalEl.textContent = formatMoney(total);
  }

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

  // Add product to cart from a button element (reads dataset)
  function addToCartFromButton(btn) {
    if (!btn) return;
    const pid = btn.dataset.productId;
    if (!pid) return;

    const name = btn.dataset.productName ?? 'Unknown';
    const price = parseFloat(btn.dataset.productPrice ?? 0);
    const stock = parseInt(btn.dataset.productStock ?? 0);
    const image = btn.dataset.productImage ?? '{{ asset('assets/img/default-product.png') }}';

    const existing = cart.get(pid);
    if (existing) {
      if (existing.qty + 1 > stock) {
        showToast('Cannot add more than available stock', 'error');
        return;
      }
      existing.qty += 1;
      cart.set(pid, existing);
      showToast('Increased quantity', 'success');
    } else {
      if (stock === 0) { showToast('Item out of stock', 'error'); return; }
      cart.set(pid, { id: pid, name, price, qty: 1, stock_count: stock, image });
      showToast('Item added to cart', 'success');
    }
    renderCart();
  }

  // Annotate product cards (after AJAX inject)
  function annotateProductCardsForCart() {
    if (!productGridWrapper) return;
    productGridWrapper.querySelectorAll('[data-product-id]').forEach(card => {
      const pid = card.dataset.productId;
      const btn = card.querySelector('.add-to-cart');
      if (!btn) return;

      if (!btn.dataset.productId) btn.dataset.productId = pid;

      const nameNode = card.querySelector('.product-name');
      if (!btn.dataset.productName && nameNode) btn.dataset.productName = nameNode.textContent.trim();

      const priceNode = card.querySelector('.product-price');
      if (!btn.dataset.productPrice && priceNode) {
        btn.dataset.productPrice = (priceNode.dataset.price ?? parseFloat(priceNode.textContent.replace(/[^\d.-]/g, ''))) || 0;
      }

      const stockNode = card.querySelector('.product-stock');
      if (!btn.dataset.productStock && stockNode) {
        btn.dataset.productStock = (stockNode.dataset.stock ?? parseInt(stockNode.textContent.replace(/\D/g, ''))) || 0;
      }

      const img = card.querySelector('img');
      if (!btn.dataset.productImage && img) btn.dataset.productImage = img.src || '';
    });
  }

  // ---------- AJAX product reload ----------
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
      if (!res.ok) throw new Error('Network response not ok: ' + res.status);
      const html = await res.text();
      if (productGridWrapper) {
        productGridWrapper.innerHTML = html;
        annotateProductCardsForCart();
      }
    } catch (err) {
      console.error('fetchProducts error:', err);
      showToast('Failed to load products', 'error');
    }
  }

  // ---------- Event delegation ----------
  document.addEventListener('click', (e) => {
    const addBtn = e.target.closest('.add-to-cart');
    if (addBtn) { addToCartFromButton(addBtn); return; }

    const inc = e.target.closest('[data-increment]');
    if (inc) { changeQty(inc.getAttribute('data-increment'), 1); return; }

    const dec = e.target.closest('[data-decrement]');
    if (dec) { changeQty(dec.getAttribute('data-decrement'), -1); return; }

    const rem = e.target.closest('[data-remove]');
    if (rem) {
      cart.delete(rem.getAttribute('data-remove'));
      showToast('Item removed from cart', 'success');
      renderCart();
      return;
    }

    const tab = e.target.closest('.tab-btn, .sub-tab-btn');
    if (tab && categoryTabs && categoryTabs.contains(tab)) {
      categoryTabs.querySelectorAll('.tab-btn').forEach(t => {
        t.classList.remove('bg-primary', 'text-white');
        t.classList.add('bg-gray-100', 'text-gray-700');
      });
      if (tab.classList.contains('tab-btn')) {
        tab.classList.remove('bg-gray-100', 'text-gray-700');
        tab.classList.add('bg-primary', 'text-white');
      } else {
        const parent = tab.closest('.group')?.querySelector('.tab-btn');
        if (parent) {
          parent.classList.remove('bg-gray-100', 'text-gray-700');
          parent.classList.add('bg-primary', 'text-white');
        }
      }
      currentCategory = tab.dataset.category ?? '';
      fetchProducts();
      return;
    }
  });

  // Brand & discount change
  brandFilter?.addEventListener('change', fetchProducts);
  discountFilter?.addEventListener('change', fetchProducts);

  // Search
  searchInput?.addEventListener('input', () => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(fetchProducts, 300);
  });
  searchBtn?.addEventListener('click', fetchProducts);

  // Clear cart
  clearCartBtn?.addEventListener('click', () => {
    cart.clear();
    renderCart();
    showToast('Cart cleared', 'success');
  });

  annotateProductCardsForCart();
  renderCart();

  console.debug('POS: script fully initialized.');
});
</script>
@endpush

@endsection
