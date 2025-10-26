@extends('layout.sidebarmenu')

@section('title', 'Create Purchase Order')

@section('pages-content')
    <form id="poForm" method="POST" action="{{ route('purchase-orders.store') }}">
        @csrf
        <!-- Hidden fields passed from blade/server -->
        <input type="hidden" name="branch_id" id="branch_id"
            value="{{ auth()->guard('employee')->user()?->branch_id ?? 1 }}">
        <input type="hidden" name="status" id="po_status" value="pending">
        <!-- items and shipping will be set by JS before submit -->
        <input type="hidden" name="items_json" id="items_json" value="">

        <div class="flex overflow-hidden flex-col gap-6">
            <!-- toast container is provided globally in layout -->

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 h-auto lg:h-[calc(100vh-8rem)]">
                <!-- 🟩 LEFT COLUMN: Supplier Info + Product Catalog -->
                <div class="lg:col-span-2 flex flex-col min-h-0">
                    <!-- Supplier Information -->
                    <div class="bg-white rounded-xl shadow-sm p-6 py-4 mb-3 border border-gray-100">
                        <div class="flex items-center justify-between mb-4 border-b pb-3">
                            <h2 class="text-lg font-semibold">Supplier Information</h2>
                        </div>

                        <!-- Supplier Form Grid -->
                        <!-- supplier select will be full-width on its own row; info boxes below in responsive grid -->
                        <div class="grid grid-cols-1 gap-5">
                            <!-- Supplier Selection (row 1) -->
                            <div class="global-focus">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Select Supplier
                                </label>
                                <select id="supplier-select" name="supplier_id"
                                    class="supplier-select w-full border border-gray-300 rounded-lg px-3 py-2 text-sm transition">
                                    <option value="" diasbled selected>Select Supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->company_name }} -
                                            {{ $supplier->category ?? 'N/A' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Info Boxes (row 2) -->
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <div class="supplier-info">
                                    <label class="block text-xs text-gray-500 mb-1">Company</label>
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm min-h-[42px] flex items-center"
                                        data-field="company_name">
                                        <span class="text-gray-500">Select a supplier</span>
                                    </div>
                                </div>
                                <div class="supplier-info">
                                    <label class="block text-xs text-gray-500 mb-1">Contact Person</label>
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm min-h-[42px] flex items-center"
                                        data-field="contact_person">
                                        <span class="text-gray-500">Select a supplier</span>
                                    </div>
                                </div>
                                <div class="supplier-info">
                                    <label class="block text-xs text-gray-500 mb-1">Email</label>
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm min-h-[42px] flex items-center"
                                        data-field="email">
                                        <span class="text-gray-500">Select a supplier</span>
                                    </div>
                                </div>
                                <div class="supplier-info">
                                    <label class="block text-xs text-gray-500 mb-1">Phone</label>
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm min-h-[42px] flex items-center"
                                        data-field="phone_number">
                                        <span class="text-gray-500">Select a supplier</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Catalog -->
                    <div class="flex flex-col bg-white rounded-lg shadow-sm p-6 flex-1 min-h-0">
                        <!-- Header + Filters -->
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-4">
                            <div>
                                <h1 class="text-xl font-semibold text-primary">Purchase Order Items</h1>
                                <p class="text-sm text-gray-500">Add products to your purchase order</p>
                            </div>
                            <div class="flex items-center gap-2 global-focus">
                                <div class="relative">
                                    <input id="searchInput" type="text" placeholder="Search Product..."
                                        class="border rounded-lg px-3 py-2 text-sm w-48" />
                                </div>

                                <select id="brandFilter" class="border rounded-lg px-3 py-2 text-sm">
                                    <option value="">All Brands</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id ?? $brand->brand_id }}">
                                            {{ $brand->name ?? $brand->brand_name }}
                                        </option>
                                    @endforeach
                                </select>

                                <label class="flex items-center gap-1 text-sm">
                                    <input id="discountFilter" type="checkbox" class="accent-primary" />
                                    Discounted
                                </label>
                            </div>
                        </div>

                        <!-- Product Tabs -->
                        <div class="flex flex-wrap gap-2 mb-4">
                            <button type="button"
                                class="category-tab px-4 py-2 rounded-lg bg-primary text-white text-sm font-medium border border-gray-200 hover:bg-gray-100"
                                data-category="">
                                All Products
                            </button>

                            @foreach($categories as $category)
                                <button type="button"
                                    class="category-tab px-4 py-2 rounded-lg text-sm font-medium border border-gray-200 hover:bg-gray-100"
                                    data-category="{{ $category->id }}">
                                    {{ $category->name }}
                                </button>
                            @endforeach
                        </div>

                        <!-- Product Grid -->
                        <div id="productGridWrapper">
                            @include('partials.po-product-grid', ['products' => $products])
                        </div>
                    </div>
                </div>

                <!-- 🟦 RIGHT COLUMN: Purchase Order Cart -->
                <aside class="flex flex-col min-h-0 bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-4 pt-4">
                        <div class="bg-gradient-to-r from-emerald-600 to-emerald-500 rounded-lg shadow-sm p-4 text-white">
                            <div class="flex items-start justify-between">
                                <div>
                                    <div class="text-sm text-white font-medium">Purchase Order</div>
                                    <div class="text-xs" id="current-date">{{ now()->format('l, m/d/Y') }}</div>
                                </div>
                                @php
                                    $branch = auth()->guard('employee')->user()?->branch;
                                @endphp

                                <div class="text-sm font-medium">
                                    {{ $branch?->name ?? 'Unknown Branch' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 flex-1 min-h-0 flex flex-col">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-semibold text-md text-gray-800">Order Items</h3>
                            <button id="clear-po" type="button"
                                class="flex items-center gap-2 text-sm bg-red-50 text-red-600 px-4 py-2 rounded-md hover:bg-red-100 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22" />
                                </svg>
                                Clear All
                            </button>
                        </div>

                        <div id="po-items" class="space-y-3 pr-2 overflow-y-auto" style="max-height:45vh;">
                            <!-- PO items will be dynamically inserted here -->
                            <div class="text-center py-8 text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-2"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <p>Purchase Order is Empty</p>
                                <p class="text-sm">Add products from the catalog</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 border-t border-dashed bg-white">
                        <div class="space-y-3 mb-4">
                            <div class="flex items-center justify-between text-sm">
                                <div class="text-gray-600">Subtotal:</div>
                                <div class="text-gray-800 font-medium" id="subtotal-amount">₱0.00</div>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <div class="text-gray-600">Shipping:</div>
                                <div class="text-gray-800 font-medium">
                                    <input type="number" id="shipping-cost" name="shipping" value="0" min="0" step="0.01"
                                        class="w-24 text-right py-1">
                                </div>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <div class="text-gray-600">Tax (12%):</div>
                                <div class="text-gray-800 font-medium" id="tax-amount">₱0.00</div>
                            </div>
                            <div class="flex items-center justify-between text-base border-t pt-2">
                                <div class="text-gray-800 font-semibold">Total Amount:</div>
                                <div class="text-green-600 font-bold text-lg" id="total-amount">₱0.00</div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between text-sm mb-3">
                            <div class="text-gray-600">Total Items: <span class="font-semibold" id="total-items">0</span>
                            </div>
                            <div class="text-gray-600">Unique Items: <span class="font-semibold" id="unique-items">0</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-3">
                            <button id="create-po" type="submit"
                                class="py-3 bg-primary hover:bg-emerald-700 text-white rounded-lg font-medium flex items-center justify-center gap-2 hover:from-green-700 hover:to-green-800 transition disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled>
                                Purchase Order
                            </button>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </form>


    <!-- Modal -->
    <div id="product-modal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 backdrop-blur-sm">
        <div class="bg-white p-5 rounded-2xl shadow-2xl w-full max-w-md mx-2 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800" id="modal-product-name">Product Name</h2>
                <button id="modal-close" class="text-gray-400 hover:text-red-600 transition-colors" type="button">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <hr class="mb-2">


            <div class="space-y-4 mt-4">
                <div class="global-focus">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                    <input type="number" id="modal-quantity" value="1" min="1"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50"
                        placeholder="Enter Quantity">
                </div>

                <div class="global-focus">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cost Price</label>
                    <input type="number" id="modal-cost-price" value="0" min="0" step="0.01"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50"
                        placeholder="Enter Cost">
                </div>

                <div class="flex gap-3 pt-2">
                    <button id="modal-cancel" type="button"
                        class="flex-1 px-3 py-2 border border-gray-300 text-gray-700 hover:bg-gray-300 hover:text-black rounded-xl font-medium transition-colors duration-200">
                        Cancel
                    </button>
                    <button id="modal-add" type="button"
                        class="flex-1 px-3 py-2 bg-primary hover:bg-emerald-700 text-white rounded-xl font-medium shadow-sm hover:shadow-md transition-all duration-200">
                        Add to Order
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Create PO Confirmation Modal -->
    <div id="create-confirm-modal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 backdrop-blur-sm">
        <div class="bg-white p-5 rounded-2xl shadow-2xl w-full max-w-md mx-4 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Create Purchase Order</h3>
                <button id="confirm-close" class="text-gray-400 hover:text-red-600 transition-colors"
                    type="button">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <hr class="mb-2">

            <p class="text-md mt-4 mb-5 font-medium">Are you sure you want to create this purchase order? <br> <span class="text-xs font-regular">This will submit the
                current items to the selected supplier. </span></p>

            <div class="flex gap-3 pt-2">
                <button id="confirm-cancel" type="button"
                    class="flex-1 px-3 py-2 border border-gray-300 text-gray-700 hover:bg-gray-300 hover:text-black rounded-xl font-medium transition-colors duration-200">
                    Cancel
                </button>
                <button id="confirm-create" type="button"
                    class="flex-1 px-3 py-2 bg-primary hover:bg-emerald-700 text-white rounded-xl font-medium shadow-sm hover:shadow-md transition-all duration-200">
                    Confirm
                </button>
            </div>
        </div>
    </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {

                async function fetchProducts() {
                    const params = new URLSearchParams({
                        category_id: currentCategory || '',
                        brand_id: brandFilter?.value || '',
                        search: searchInput?.value || '',
                        discounted: discountFilter?.checked ? 1 : 0
                    });

                    try {
                        const res = await fetch(`{{ route('stock-in.index') }}?${params.toString()}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        const html = await res.text();
                        const wrapper = document.getElementById('productGridWrapper');
                        wrapper.innerHTML = html;
                    } catch (err) {
                        console.error('Error fetching products:', err);
                    }
                }

                // Filter state variables
                let currentCategory = '';

                // Filter DOM elements
                const brandFilter = document.getElementById('brandFilter');
                const searchInput = document.getElementById('searchInput');
                const discountFilter = document.getElementById('discountFilter');
                const categoryTabs = document.querySelectorAll('.category-tab');

                // Attach listeners
                brandFilter?.addEventListener('change', fetchProducts);
                discountFilter?.addEventListener('change', fetchProducts);
                searchInput?.addEventListener('input', debounce(fetchProducts, 300)); // debounce for search
                categoryTabs?.forEach(btn => {
                    btn.addEventListener('click', () => {
                        currentCategory = btn.dataset.category;
                        // visually highlight active tab
                        categoryTabs.forEach(b => b.classList.remove('bg-primary', 'text-white'));
                        btn.classList.add('bg-primary', 'text-white');
                        currentCategory = btn.dataset.category || '';
                        fetchProducts();
                    });
                });

                // Debounce helper
                function debounce(fn, delay) {
                    let timer;
                    return (...args) => {
                        clearTimeout(timer);
                        timer = setTimeout(() => fn(...args), delay);
                    };
                }

                // configure axios csrf header
                if (window.axios) {
                    axios.defaults.headers.common['X-CSRF-TOKEN'] = '{{ csrf_token() }}';
                }

                // ---------------------------
                // PO state
                // ---------------------------
                let poItems = [];
                const poItemsContainer = document.getElementById('po-items');
                const totalItemsElement = document.getElementById('total-items');
                const uniqueItemsElement = document.getElementById('unique-items');
                const subtotalElement = document.getElementById('subtotal-amount');
                const taxElement = document.getElementById('tax-amount');
                const totalAmountElement = document.getElementById('total-amount');
                const shippingCostInput = document.getElementById('shipping-cost');
                const createPOButton = document.getElementById('create-po');
                const clearPOButton = document.getElementById('clear-po');
                const itemsJsonInput = document.getElementById('items_json');
                const poForm = document.getElementById('poForm');

                // Modal elements (product add modal)
                const modal = document.getElementById('product-modal');
                const modalProductName = document.getElementById('modal-product-name');
                const modalQuantity = document.getElementById('modal-quantity');
                const modalCostPrice = document.getElementById('modal-cost-price');
                const modalCancel = document.getElementById('modal-cancel');
                const modalClose = document.getElementById('modal-close');
                const modalAdd = document.getElementById('modal-add');

                // Confirmation modal elements (created above)
                const confirmModal = document.getElementById('create-confirm-modal');
                const confirmGlobalMarkupInput = document.getElementById('confirm-global-markup');
                const confirmCreateNoMarkupBtn = document.getElementById('confirm-create-no-markup');
                const confirmCreateWithMarkupBtn = document.getElementById('confirm-create-with-markup');

                let currentProduct = null; // product currently selected

                // ---------------------------
                // Helpers
                // ---------------------------
                // Global showToast is provided by resources/js/utils/toast.js and attached to window.

                function fmt(v) { return '₱' + Number(v || 0).toFixed(2); }

                // Reset PO
                clearPOButton.addEventListener('click', () => {
                    poItems = [];
                    updatePODisplay();
                    showToast('Cleared PO items', 'info');
                });

                // Supplier AJAX for info boxes
                const supplierSelect = document.getElementById('supplier-select');
                const supplierInfoBoxes = document.querySelectorAll('.supplier-info [data-field]');
                supplierSelect.addEventListener('change', function () {
                    const supplierId = this.value;
                    if (!supplierId) {
                        supplierInfoBoxes.forEach(box => { box.innerHTML = '<span class="text-gray-500">Select a supplier</span>'; });
                        return;
                    }
                    supplierInfoBoxes.forEach(box => { box.innerHTML = '<span class="text-gray-500">Loading...</span>'; });
                    fetch(`/supplier/${supplierId}/details`)
                        .then(response => { if (!response.ok) throw new Error('Supplier not found'); return response.json(); })
                        .then(data => {
                            supplierInfoBoxes.forEach(box => {
                                const field = box.getAttribute('data-field');
                                box.textContent = data[field] || 'N/A';
                                box.classList.remove('text-gray-500');
                            });
                            showToast(`Supplier ${data.company_name} selected`, 'success');
                        })
                        .catch(() => {
                            supplierInfoBoxes.forEach(box => { box.innerHTML = '<span class="text-red-500">Error loading</span>'; });
                            showToast('Error loading supplier details', 'error');
                        });
                });

                // ---------------------------
                // Render PO items (NO markup inputs anywhere)
                // ---------------------------
                function updatePODisplay() {
                    poItemsContainer.innerHTML = '';

                    if (poItems.length === 0) {
                        poItemsContainer.innerHTML = `
                                                                                <div class="text-center py-8 text-gray-500">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-12 text-gray-300 mx-auto mb-2" style="width:48px; height:48px;">
                                                                  <path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" />
                                                                  <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                                                                </svg>

                                                                                    <p class="font-medium">Purchase Order is Empty</p>
                                                                                    <p class="text-xs">Add products from the catalog</p>
                                                                                </div>
                                                                            `;
                        updatePOTotals();
                        return;
                    }

                    poItems.forEach((item, itemIndex) => {
                        const div = document.createElement('div');
                        div.className = 'po-item border rounded-lg p-3 px-5 flex flex-col gap-2 bg-white global-focus';

                        // Bulk (non-serial) row: qty + cost editable (no markup)
                        if (!item.serials) {
                            div.innerHTML = `
                                                           <div class="flex justify-between items-center">
                          <span class="font-medium text-md">${escapeHtml(item.name)}</span>
                          <button class="remove-item" data-index="${itemIndex}" aria-label="Remove item">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                 class="w-5 h-5 text-black hover:text-red-600 transition-colors duration-150">
                              <path fill-rule="evenodd"
                                    d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z"
                                    clip-rule="evenodd" />
                            </svg>
                          </button>
                        </div>

                        <!-- Image + Inputs Column -->
                        <div class="flex items-start gap-6">
                          <!-- Product Image -->
                          <div class="flex-shrink-0">
                            <img src="${item.image || '/placeholder-image.jpg'}"
                                 alt="${escapeHtml(item.name)}"
                                 class="w-[110px] h-[110px] object-cover rounded-lg border">
                          </div>

                          <!-- Quantity and Cost stacked vertically -->
                          <div class="flex flex-col flex-1 justify-between gap-1">
                            <!-- Quantity -->
                            <div class="flex flex-col">
                              <label class="text-xs text-gray-500">Quantity</label>
                              <input type="number"
                                     class="po-qty w-full border rounded px-2 py-1 text-sm h-9"
                                     min="1"s
                                     placeholder="Enter Quantity"
                                     value="${item.quantity}">
                            </div>

                            <!-- Cost -->
                            <div class="flex flex-col">
                              <label class="text-xs text-gray-500">Cost</label>
                              <input type="number"
                                     class="po-cost w-full border rounded px-2 py-1 text-sm h-9"
                                     min="0"
                                     step="0.01"
                                     placeholder="Enter Cost"
                                     value="${item.costPrice}">
                            </div>
                          </div>
                        </div>

                        <!-- Total Cost -->
                        <div class="mt-3 pt-3 border-t text-sm">
                          Cost Total: ₱<span class="line-total">${(item.costPrice * item.quantity).toFixed(2)}</span>
                        </div>

                                                        `;

                            const qtyInput = div.querySelector('.po-qty');
                            const costInput = div.querySelector('.po-cost');
                            const removeBtn = div.querySelector('.remove-item');
                            const lineTotalEl = div.querySelector('.line-total');

                            qtyInput.addEventListener('input', () => {
                                item.quantity = parseInt(qtyInput.value) || 1;
                                lineTotalEl.textContent = (item.costPrice * item.quantity).toFixed(2);
                                updatePOTotals();
                            });

                            costInput.addEventListener('input', () => {
                                item.costPrice = parseFloat(costInput.value) || 0;
                                lineTotalEl.textContent = (item.costPrice * item.quantity).toFixed(2);
                                updatePOTotals();
                            });

                            removeBtn.addEventListener('click', () => {
                                poItems.splice(itemIndex, 1);
                                updatePODisplay();
                            });

                        } else {
                            // Serial-tracked: each row shows serial input + unit cost. No per-serial markup input.
                            div.innerHTML = `<div class="flex justify-between items-center">
                                                                                        <span class="font-semibold">${escapeHtml(item.name)}</span>
                                                                                        <button class="remove-item text-black font-bold hover:text-red-600" data-index="${itemIndex}" aria-label="Remove item">&times;</button>
                                                                                    </div>`;

                            const serialContainer = document.createElement('div');
                            serialContainer.className = 'flex flex-col gap-2 mt-2';

                            item.serials.forEach((serialObj, sIndex) => {
                                const row = document.createElement('div');
                                row.className = 'flex gap-2 items-center text-sm';

                                // Serial input
                                const serialInput = document.createElement('input');
                                serialInput.type = 'text';
                                serialInput.placeholder = 'Serial number';
                                serialInput.value = serialObj.serial || '';
                                serialInput.required = true; // <-- add this
                                serialInput.className = 'border rounded px-2 py-1 w-32';
                                serialInput.addEventListener('input', (e) => {
                                    item.serials[sIndex].serial = e.target.value;
                                });

                                // Unit cost input
                                const costInput = document.createElement('input');
                                costInput.type = 'number';
                                costInput.min = 0;
                                costInput.step = '0.01';
                                costInput.value = (serialObj.unit_price != null ? serialObj.unit_price : item.costPrice || 0);
                                costInput.className = 'border rounded px-2 py-1 w-28';
                                costInput.addEventListener('input', (e) => {
                                    item.serials[sIndex].unit_price = parseFloat(e.target.value) || 0;
                                    updatePOTotals();
                                });

                                // selling price display removed from UI per your request (we keep only cost)
                                const removeSerialBtn = document.createElement('button');
                                removeSerialBtn.type = 'button';
                                removeSerialBtn.className = 'remove-serial-btn text-black hover:text-red-600 ml-2';
                                removeSerialBtn.innerHTML = '&times;';
                                removeSerialBtn.addEventListener('click', () => {
                                    item.serials.splice(sIndex, 1);
                                    if ((item.serials || []).length === 0) {
                                        poItems.splice(itemIndex, 1);
                                    }
                                    updatePODisplay();
                                });

                                row.appendChild(serialInput);
                                const costLabel = document.createElement('span'); costLabel.className = 'text-xs text-gray-500'; costLabel.textContent = ' Cost:';
                                row.appendChild(costLabel);
                                row.appendChild(costInput);
                                row.appendChild(removeSerialBtn);

                                serialContainer.appendChild(row);
                            });

                            // Cost total for serials
                            const serialsCostTotal = document.createElement('div');
                            serialsCostTotal.className = 'text-green-600 font-bold mt-2';
                            serialsCostTotal.innerHTML = `Cost Total: ₱<span class="serials-line-total">${item.serials.reduce((s, it) => s + (parseFloat(it.unit_price || item.costPrice || 0)), 0).toFixed(2)}</span>`;

                            div.appendChild(serialContainer);
                            div.appendChild(serialsCostTotal);

                            const removeBtn = div.querySelector('.remove-item');
                            removeBtn.addEventListener('click', () => {
                                poItems.splice(itemIndex, 1);
                                updatePODisplay();
                            });
                        }

                        poItemsContainer.appendChild(div);
                    });

                    updatePOTotals();
                }

                // ---------------------------
                // Totals (SUBTOTAL uses COST only, markup excluded)
                // ---------------------------
                function updatePOTotals() {
                    const totalItems = poItems.reduce((sum, item) => {
                        if (item.serials) return sum + (item.serials.length || 0);
                        return sum + (item.quantity || 0);
                    }, 0);

                    const uniqueItems = poItems.length;

                    const subtotal = poItems.reduce((sum, item) => {
                        if (item.serials) {
                            return sum + item.serials.reduce((ss, s) => {
                                const p = parseFloat(s.unit_price != null ? s.unit_price : (item.costPrice || 0));
                                return ss + p;
                            }, 0);
                        } else {
                            const price = parseFloat(item.costPrice || 0);
                            return sum + price * (item.quantity || 0);
                        }
                    }, 0);

                    const shipping = parseFloat(shippingCostInput.value) || 0;
                    const tax = 0;
                    const total = subtotal + tax + shipping;

                    totalItemsElement.textContent = totalItems;
                    uniqueItemsElement.textContent = uniqueItems;
                    subtotalElement.textContent = fmt(subtotal);
                    taxElement.textContent = fmt(tax);
                    totalAmountElement.textContent = fmt(total);

                    createPOButton.disabled = poItems.length === 0;
                }

                // ---------------------------
                // Simple HTML escape helper
                // ---------------------------
                function escapeHtml(unsafe) {
                    return String(unsafe)
                        .replace(/&/g, "&amp;")
                        .replace(/</g, "&lt;")
                        .replace(/>/g, "&gt;")
                        .replace(/"/g, "&quot;")
                        .replace(/'/g, "&#039;");
                }

                // Delegate clicks to dynamically loaded "Add to PO" buttons
                document.addEventListener('click', function (e) {
                    const btn = e.target.closest('.add-to-po-btn');
                    if (!btn) return;

                    // Extract product data
                    currentProduct = {
                        id: btn.dataset.productId,
                        name: btn.dataset.productName,
                        costPrice: parseFloat(btn.dataset.productCost) || 0,
                        basePrice: parseFloat(btn.dataset.productBase) || 0,
                        stock: parseInt(btn.dataset.productStock) || 0,
                        image: btn.dataset.productImage || '',
                        sku: btn.dataset.productSku || ''
                    };

                    // Populate modal
                    modalProductName.textContent = currentProduct.name || 'Unnamed Product';
                    modalQuantity.value = 1;
                    modalCostPrice.value = currentProduct.costPrice;

                    // Show modal
                    modal.classList.remove('hidden');
                });

                modalCancel.addEventListener('click', () => modal.classList.add('hidden'));
                modalClose.addEventListener('click', () => modal.classList.add('hidden'));


                // ---------------------------
                // Add to PO from modal (no markup handling here)
                // ---------------------------
                modalAdd.addEventListener('click', () => {
                    const qty = parseInt(modalQuantity.value) || 1;
                    const costPrice = parseFloat(modalCostPrice.value) || currentProduct.costPrice || 0;

                    const existing = poItems.find(i => i.id === currentProduct.id);
                    if (existing) {
                        existing.quantity = (existing.quantity || 0) + qty;
                        existing.costPrice = costPrice;
                        existing.branch_id = currentProduct.branch_id;
                        // ensure image is present/updated
                        existing.image = currentProduct.image || existing.image || '';
                    } else {
                        poItems.push({
                            id: currentProduct.id,
                            name: currentProduct.name,
                            quantity: qty,
                            costPrice: costPrice,
                            branch_id: currentProduct.branch_id,
                            image: currentProduct.image || ''
                        });
                    }

                    modal.classList.add('hidden');
                    updatePODisplay();
                    showToast(`${currentProduct.name} added to order`, 'success');
                });

                shippingCostInput.addEventListener('input', updatePOTotals);

                // ---------------------------
                // Create PO: open confirmation modal instead of sending immediately
                // ---------------------------
                createPOButton.addEventListener('click', function (ev) {
                    ev.preventDefault();
                    if (poItems.length === 0) {
                        showToast('Add items to purchase order first', 'error');
                        return;
                    }
                    // show confirmation modal
                    confirmModal.classList.remove('hidden');
                });

                // Close modal on Esc (optional)
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        confirmModal && confirmModal.classList.add('hidden');
                        modal && modal.classList.add('hidden');
                    }
                });

                // ---------------------------
                // sendCreatePO function used by both confirm buttons
                // ---------------------------
                function sendCreatePO(applyMarkup = false, globalMarkup = 0) {
                    // Basic validation: supplier present
                    const supplierId = document.getElementById('supplier-select').value;
                    if (!supplierId) {
                        showToast('Please select a supplier', 'error');
                        confirmModal.classList.add('hidden');
                        return;
                    }

                    const branchId = document.getElementById('branch_id').value;
                    const shipping = parseFloat(shippingCostInput.value) || 0;

                    // Build items payload: unit_price from cost, and optionally set selling_price & markup
                    const itemsPayload = poItems.map(item => {
                        if (item.serials) {
                            // Check serials are filled
                            const serials = item.serials.map((s, idx) => {
                                if (!(s.serial || '').trim()) {
                                    throw new Error(`Serial number required for ${item.name}, line ${idx + 1}`);
                                }
                                return {
                                    serial: s.serial.trim(),
                                    unit_price: parseFloat(s.unit_price || item.costPrice || 0)
                                };
                            });

                            return {
                                product_id: item.id,
                                branch_id: branchId,
                                quantity: serials.length, // Laravel expects "quantity"
                                unit_price: parseFloat(item.costPrice || 0),
                                serials: serials
                            };
                        } else {
                            return {
                                product_id: item.id,
                                branch_id: branchId,
                                quantity: parseInt(item.quantity || 0), // Laravel expects "quantity"
                                unit_price: parseFloat(item.costPrice || 0)
                            };
                        }
                    });

                    // put JSON in hidden input if you still want form-submitted version
                    itemsJsonInput.value = JSON.stringify(itemsPayload);

                    const payload = {
                        supplier_id: supplierId,
                        branch_id: branchId,
                        shipping: shipping,
                        status: document.getElementById('po_status').value || 'pending',
                        apply_markup: applyMarkup ? 1 : 0,
                        global_markup: applyMarkup ? parseFloat(globalMarkup || 0) : 0,
                        products: itemsPayload // <-- change from items to products
                    };

                    confirmModal.classList.add('hidden');

                    axios.post("{{ route('purchase-orders.store') }}", payload)
                        .then(response => {
                            const data = response.data || {};
                            if (data.success || (response.status >= 200 && response.status < 300)) {
                                showToast(data.message || 'Purchase Order created successfully!', 'success');
                                // clear local cart and optionally redirect
                                poItems = [];
                                updatePODisplay();
                                setTimeout(() => {
                                    if (data.redirect) window.location.href = data.redirect;
                                    else window.location.reload();
                                }, 900);
                            } else {
                                showToast(data.message || 'Failed to create order', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Create PO error', error);
                            if (error.response && error.response.data && error.response.data.errors) {
                                const errs = error.response.data.errors;
                                Object.values(errs).forEach(arr => arr.forEach(msg => showToast(msg, 'error')));
                            } else if (error.response && error.response.data && error.response.data.message) {
                                showToast(error.response.data.message, 'error');
                            } else {
                                showToast('Something went wrong creating order', 'error');
                            }
                        });
                }

                const confirmCreateBtn = document.getElementById('confirm-create');
                const confirmCancelBtn = document.getElementById('confirm-cancel');
                const confirmCloseConfirmation = document.getElementById('confirm-close');
                // Wire confirm modal buttons
                confirmCreateBtn.addEventListener('click', () => {
                    sendCreatePO(false, 0); // always false since no markup
                });

                confirmCancelBtn.addEventListener('click', () => {
                    confirmModal.classList.add('hidden');
                });

                confirmCloseConfirmation.addEventListener('click', () => {
                    confirmModal.classList.add('hidden');
                });

                // Initialize UI
                updatePODisplay();
            });
        </script>
    @endpush



    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .aspect-w-16 {
            position: relative;
        }

        .aspect-w-16::before {
            content: '';
            display: block;
            padding-top: 75%;
            /* 4:3 aspect ratio */
        }

        .aspect-w-16>* {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>
@endsection