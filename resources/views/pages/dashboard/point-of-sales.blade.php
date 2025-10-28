@extends('layout.sidebarmenu')

@section('title', 'Point of Sales')

@section('pages-content')
  <div class="flex overflow-hidden flex-col gap-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 h-auto lg:h-[calc(100vh-8rem)]">
      <div class="lg:col-span-2 flex flex-col min-h-0">

        <!-- Product Catalog -->
        <!-- Header -->
        <div class="flex items-center justify-between mb-2 bg-white rounded-lg shadow-sm px-6 py-3">
          <div>
            <h1 class="text-xl font-semibold text-primary">Point of Sales</h1>
            <p class="text-sm text-gray-500">Product Catalog</p>
          </div>

          <div class="flex items-center gap-2">
            <div class="relative">
              <input id="searchInput" type="text" placeholder="Search Product..."
                class="border rounded-lg px-3 py-2 text-sm w-48" />
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
            <button data-category="" class="tab-btn px-4 py-2 rounded-lg bg-primary text-white text-sm">All
              Products</button>

            @foreach($categories as $category)
              <div class="relative group">
                <button data-category="{{ $category->id }}"
                  class="tab-btn px-4 py-2 rounded-lg bg-gray-100 text-gray-700 text-sm">
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
      <aside class="flex flex-col min-h-0 bg-white rounded-lg shadow-sm border border-gray-200">
        <!-- Header -->
        <div class="px-4 pt-4">
          <div class="bg-gradient-to-r from-emerald-600 to-emerald-500 rounded-lg shadow-sm p-4 text-white">
            <div class="flex items-start justify-between">
              <div>
                <div class="text-sm text-white font-medium">Sales Order</div>
                <div class="text-xs" id="current-date">{{ now()->format('l, m/d/Y') }}</div>
              </div>
              @php
                $branch = auth()->guard('employee')->user()?->branch;
              @endphp

              <div class="text-sm font-medium text-white">
                {{ $branch?->name ?? 'Unknown Branch' }}
              </div>
            </div>
          </div>
        </div>

        <!-- Cart content -->
        <div class="p-4 flex-1 min-h-0 flex flex-col">
          <div class="flex items-center justify-between mb-3">
            <h3 class="font-semibold text-md">Selected Products</h3>
            <button id="clearCartBtn"
              class="flex items-center gap-2 text-sm bg-red-50 text-red-600 px-4 py-2 rounded-md hover:bg-red-100 transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22" />
              </svg>
              Clear All
            </button>
          </div>

          <div id="cartItems" class="space-y-4 overflow-y-auto h-[260px] md:h-[320px] lg:h-[420px] pr-2">
            <div class="text-center py-8 text-gray-500">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                class="size-12 text-gray-300 mx-auto mb-2" style="width:48px; height:48px;">
                <path
                  d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" />
                <path
                  d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
              </svg>
              <p class="font-medium">No products in cart.</p>
              <p class="text-xs">Add products from the catalog</p>
            </div>
          </div>
        </div>

        <!-- Action Button -->
        <div class="p-4 border-t bg-white">
          <button id="processPaymentBtn" type="button"
            class="w-full py-3 bg-primary hover:bg-emerald-600 text-white rounded-lg font-medium flex items-center justify-center gap-2">
            <span>Process Payment</span>
          </button>
        </div>
      </aside>
    </div>
  </div>

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

        // ---------- Render Cart ----------
        function renderCart() {
          if (!cartItemsEl) return;
          if (cart.size === 0) {
            cartItemsEl.innerHTML = `
                              <div class="text-center py-8 text-gray-500">

                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-12 text-gray-300 mx-auto mb-2" style="width:48px; height:48px;">
                                  <path d="M2.25 2.25a.75.75 0 0 0 0 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 0 0-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 0 0 0-1.5H5.378A2.25 2.25 0 0 1 7.5 15h11.218a.75.75 0 0 0 .674-.421 60.358 60.358 0 0 0 2.96-7.228.75.75 0 0 0-.525-.965A60.864 60.864 0 0 0 5.68 4.509l-.232-.867A1.875 1.875 0 0 0 3.636 2.25H2.25ZM3.75 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM16.5 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z" />
                                </svg>

                                <p class="font-medium">No products in cart.</p>
                                <p class="text-xs">Add products from the catalog</p>
                              </div>`;
            return;
          }

          let html = '';
          for (const [pid, item] of cart.entries()) {
            html += `
                              <div class="po-item border rounded-lg p-3 px-5 flex flex-col gap-2 bg-white">
                                <div class="flex justify-between items-center">
                                  <span class="font-medium text-md">${escapeHtml(item.name)}</span>
                                  <button data-remove="${pid}" aria-label="Remove item" class="text-black hover:text-red-600 text-xl leading-none">
                                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                                             class="w-5 h-5 text-black hover:text-red-600 transition-colors duration-150">
                                                          <path fill-rule="evenodd"
                                                                d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                    </button>
                                </div>

                                <div class="flex items-start gap-6 mt-2 global-focus">
                                  <div class="flex-shrink-0">
                                    <img src="${item.image || '{{ asset('assets/img/default-product.png') }}'}" alt="${escapeHtml(item.name)}" class="size-24 object-cover rounded-lg border">
                                  </div>

                                  <div class="flex flex-col flex-1 justify-between gap-1">
                                    <div class="flex items-center gap-3">
                                      <label class="text-gray-500">Qty: </label>
                                      <div class="flex items-center gap-2">
                                        <button data-decrement="${pid}" class="w-6 h-6 flex items-center justify-center rounded border text-gray-600">-</button>
                                        <div class="px-3">${item.qty}</div>
                                        <button data-increment="${pid}" class="w-6 h-6 flex items-center justify-center rounded border text-gray-600">+</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>`;
          }

          // set once after building markup
          cartItemsEl.innerHTML = html;
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