@extends('layout.sidebarmenu')

@section('title', 'Purchase Summary')

@section('pages-content')

    <div class="flex flex-col lg:flex-row gap-3 min-h-screen">
        <!-- Left: Product Summary -->
        <div class="flex-[8] flex flex-col min-h-0 bg-white rounded-xl shadow-sm overflow-hidden">
            <!-- Header -->
            <div class="p-6 py-4 border-b">
                <h1 class="text-xl font-bold text-primary">Purchase Summary</h1>
                <p class="text-gray-500 mt-1 text-sm">Review your order details before completing your purchase.</p>
            </div>

            <!-- Current Transaction -->
            <div class="px-6 pt-4">
                <div class="text-md font-medium">All Selected Products</div>
                <!-- <div class="text-xs text-gray-500">{{ now()->format('l, m/d/Y') }}</div> -->
            </div>

            <!-- Product List -->
            <div class="p-6 space-y-4">
                @forelse($cartProducts as $product)
                    <div class="border border-dashed border-2 border-gray-300 rounded-lg p-4 relative flex gap-4 items-center mx-4"
                        data-product-id="{{ $product['product_id'] }}">
                        <!-- Remove button -->
                        <button class="absolute top-2 right-2 text-gray-400 hover:text-red-500 transition-colors"
                            title="Remove item">
                            ✕
                        </button>

                        <!-- Product Image -->
                        <div class="w-20 h-20 rounded-lg overflow-hidden bg-gray-100 flex items-center justify-center">
                            @if($product['image'])
                                <img src="{{ asset('storage/' . $product['image']) }}" alt="{{ $product['name'] }}"
                                    class="object-cover w-full h-full">
                            @else
                                <span class="text-gray-400 text-sm">No Image</span>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="flex-1">
                            <div class="font-semibold text-lg text-gray-800">{{ $product['name'] }}</div>
                            <div class="text-sm text-gray-600 mt-1">Qty: {{ $product['quantity'] }}</div>
                            <div class="text-primary font-bold text-md mt-1 product-price" data-price="{{ $product['price'] }}"
                                data-quantity="{{ $product['quantity'] }}"
                                data-track-serial="{{ $product['track_serial'] ? '1' : '0' }}">
                                ₱{{ $product['track_serial'] ? '0.00' : number_format($product['price'] * $product['quantity'], 2) }}
                            </div>

                            <!-- Input Serial Button -->
                            @if($product['track_serial'])
                                <button type="button"
                                    class="mt-2 text-sm px-3 py-1 bg-primary text-white rounded hover:bg-emerald-600 transition serial-btn"
                                    data-product-id="{{ $product['product_id'] }}" data-quantity="{{ $product['quantity'] }}">
                                    Input Serial
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-gray-500 italic">No items in cart.</div>
                @endforelse
            </div>
        </div>

        <!-- Right: Checkout Details -->
        <div class="flex-[4] flex flex-col bg-white rounded-xl shadow-sm overflow-hidden">
            <!-- Checkout Header -->
            <div class="p-6 border-b">
                <h2 class="text-xl font-bold text-gray-800">Checkout</h2>
            </div>

            <!-- Checkout Content -->
            <div class="p-6 flex-1 space-y-6 global-focus">
                <!-- Customer Details -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-3">Customer Details</h3>
                    <div class="flex gap-3 relative">
                        <div class="flex-1 relative">
                            <input type="text" id="customerSearch" placeholder="Search customer..."
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm" autocomplete="off">
                            <input type="hidden" id="customerId" name="customer_id">

                            <!-- Dropdown -->
                            <div id="customerResults"
                                class="absolute bg-white border border-gray-300 rounded-lg mt-1 w-full hidden max-h-48 overflow-y-auto shadow-lg z-50">
                            </div>
                        </div>

                        <button id="addCustomerBtn" type="button"
                            class="bg-primary text-white rounded-lg px-6 py-3 text-sm font-medium hover:bg-emerald-600 transition-colors">
                            Add
                        </button>
                    </div>

                    <!-- Selected Customer -->
                    <div id="selectedCustomer" class="mt-4 hidden">
                        <div class="bg-gray-50 border rounded-lg p-3">
                            <div class="font-semibold text-gray-800" id="cust-name"></div>
                            <div class="text-sm text-gray-600" id="cust-email"></div>
                            <div class="text-sm text-gray-600" id="cust-phone"></div>
                        </div>
                    </div>
                </div>  

                <!-- Payment Method (compact display + modal) -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-3">Payment Method</h3>
                        <div class="flex items-center gap-3">
                            <div class="flex-1">
                                <label for="paymentSelect" class="block text-sm text-gray-600 mb-1">Select Payment Method</label>
                                <select id="paymentSelect" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm bg-white">
                                    <option value="cash" selected>Cash</option>
                                    <option value="pcash">PCash</option>
                                    <option value="paymaya">PayMaya</option>
                                    <option value="paypal">PayPal</option>
                                    <option value="visa">VISA</option>
                                    <option value="mastercard">Master Card</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                </select>
                            </div>
                        </div>

                        <input type="hidden" id="selectedPaymentMethod" name="payment_method" value="cash">
                </div>

                <!-- Promotion Code -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-3">Promotion Code</h3>
                    <div class="flex gap-3">
                        <input type="text" placeholder="Enter promo code"
                            class="flex-1 border border-gray-300 rounded-lg px-4 py-3 text-sm" />
                        <button
                            class="bg-primary text-white rounded-lg px-6 py-3 text-sm font-medium hover:bg-emerald-600 transition-colors">Apply</button>
                    </div>
                </div>

                <!-- Amount Paid -->
                <div class="mb-8">
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <span class="text-gray-700 font-medium">Amount Paid</span>
                        </div>
                        <div>
                            <span class="text-gray-700 font-medium">Change</span>
                        </div>
                    </div>

                    <!-- make inputs same width using a 2-column grid -->
                    <div class="grid grid-cols-2 gap-3">
                        <input type="text" id="amountPaid" placeholder="Enter amount"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm text-left" />
                        <div id="changeDisplay"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm bg-gray-50 flex items-center justify-start font-medium">
                            ₱0.00</div>
                    </div>
                </div>

                <!-- Reference -->
                <div id="referenceContainer" class="mb-8 hidden">
                    <div class="flex justify-between mb-3">
                        <span class="text-gray-700 font-medium">Reference Number</span>
                    </div>
                    <div class="flex gap-3">
                        <input type="text" id="paymentReference" placeholder="Enter reference number"
                            class="flex-1 border border-gray-300 rounded-lg px-4 py-3 text-sm" />
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="border-t pt-6" id="orderSummary">
                    <div class="flex justify-between text-md mb-2">
                        <span class="text-gray-700">Subtotal:</span>
                        <span id="subtotal" class="text-gray-800">₱0.00</span>
                    </div>
                    <div class="flex justify-between text-md mb-4">
                        <span class="text-gray-700">Discount:</span>
                        <span id="discount" class="text-gray-800">₱0.00</span>
                    </div>
                    <div class="flex justify-between text-md font-bold pt-4 border-t">
                        <span class="text-gray-800">Total Amount:</span>
                        <span id="totalAmount" class="text-primary">₱0.00</span>
                    </div>
                </div>

                <!-- Checkout Button -->
                <button
                    class="w-full mt-8 py-3 bg-primary text-white rounded-lg font-medium text-md flex items-center justify-center gap-3 hover:bg-emerald-600 transition-colors shadow-md">
                    <span>Checkout Now</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Add Customer Modal -->
    <div id="customerModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 global-focus">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Add Customer</h2>
                <button id="closeCustomerModal" class="text-gray-500 hover:text-gray-700">&times;</button>
            </div>

            <div class="space-y-3">
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Name</label>
                    <input type="text" id="customerName" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Email</label>
                    <input type="email" id="customerEmail" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Phone</label>
                    <input type="text" id="customerPhone" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Address</label>
                    <textarea id="customerAddress" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></textarea>
                </div>
            </div>

            <div class="mt-5 flex justify-end gap-2">
                <button id="closeCustomerModalBtn" type="button"
                    class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Cancel</button>
                <button id="saveCustomerBtn" type="button"
                    class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-emerald-700">Save</button>
            </div>
        </div>
    </div>

    <!-- Serial Modal -->
    <div id="serialModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 global-focus">
            <h2 class="text-lg font-semibold mb-4">Enter Serial Numbers</h2>
            <input type="hidden" id="serialProductId">

            <div id="serialInputsContainer" class="space-y-2 mb-4"></div>

            <div class="flex justify-end gap-2">
                <button type="button" id="serialCancelBtn"
                    class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</button>
                <button type="button" id="serialSaveBtn"
                    class="px-4 py-2 bg-primary text-white rounded hover:bg-emerald-600">Save</button>
            </div>
        </div>
    </div>


    

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {

                recalculateTotals();

                let currentProductQty = 0;

                const serialModal = document.getElementById('serialModal');
                const serialContainer = document.getElementById('serialInputsContainer');
                const serialProductId = document.getElementById('serialProductId');
                const serialCancelBtn = document.getElementById('serialCancelBtn');
                const serialSaveBtn = document.getElementById('serialSaveBtn');

                function recalculateTotals() {
                    let subtotal = 0;

                    // Sum all product prices in the cart/grid
                    document.querySelectorAll('.product-price').forEach(node => {
                        const text = node.textContent.replace(/[₱,]/g, '').trim();
                        const val = parseFloat(text) || 0;
                        subtotal += val;
                    });

                    const discount = 0; // apply promo logic later if needed
                    const total = subtotal - discount;

                    document.getElementById('subtotal').textContent = '₱' + subtotal.toFixed(2);
                    document.getElementById('discount').textContent = '₱' + discount.toFixed(2);
                    document.getElementById('totalAmount').textContent = '₱' + total.toFixed(2);
                }

                // Open serial modal dynamically
                function openSerialModal(btn) {
                    const productId = btn.dataset.productId;
                    const productQty = parseInt(btn.dataset.quantity) || 1; // from data-attribute
                    currentProductQty = productQty;

                    serialProductId.value = productId;
                    serialContainer.innerHTML = '';

                    const existingSerials = btn.dataset.serials ? JSON.parse(btn.dataset.serials) : [];

                    for (let i = 0; i < productQty; i++) {
                        const input = document.createElement('input');
                        input.type = 'text';
                        input.placeholder = `Serial #${i + 1}`;
                        input.className = 'w-full px-3 py-2 border border-gray-300 rounded-lg';
                        if (existingSerials[i]) input.value = existingSerials[i];
                        serialContainer.appendChild(input);
                    }

                    serialModal.classList.remove('hidden');
                }

                function closeSerialModal() {
                    serialModal.classList.add('hidden');
                }

                function saveSerialNumbers() {
                    const productIdVal = serialProductId.value;
                    const serialInputs = Array.from(serialContainer.querySelectorAll('input'));
                    const serials = serialInputs.map(input => input.value.trim()).filter(s => s);

                    if (serials.length !== currentProductQty) {
                        return showToast(`Please enter ${currentProductQty} serial numbers`, 'error');
                    }

                    // Save serials on the product button for reopening
                    // preserve existing approach: find element that has data-product-id
                    const productBtn = document.querySelector(`[data-product-id="${productIdVal}"]`);
                    if (productBtn) productBtn.dataset.serials = JSON.stringify(serials);

                    axios.post('/pos/validate-serials', { product_id: productIdVal, serials })
                        .then(res => {
                            const data = res.data || {};
                            if (data.success) {
                                showToast('Serials validated and prices updated!', 'success');

                                // mark validated and persist serials where checkout will read them
                                if (productBtn) {
                                    // productBtn might be the product container - prefer the serial-btn element
                                    const serialBtn = document.querySelector(`.serial-btn[data-product-id="${productIdVal}"]`);
                                    if (serialBtn) {
                                        serialBtn.dataset.serials = JSON.stringify(serials);
                                        serialBtn.dataset.serialsValid = '1';
                                    }
                                    // also set on product container for redundancy
                                    productBtn.dataset.serials = JSON.stringify(serials);
                                    productBtn.dataset.serialsValid = '1';
                                }

                                closeSerialModal();

                                // Update frontend price: server returns total of unit prices; convert to per-unit
                                const priceNode = productBtn ? productBtn.closest('div').querySelector('.product-price') : null;
                                if (priceNode && data.updatedPrice !== undefined) {
                                    const qty = parseInt(priceNode.dataset.quantity) || 1;
                                    // interpret updatedPrice as total price for the serials (sum of unit prices)
                                    // compute unit price = total / qty
                                    const totalPrice = parseFloat(data.updatedPrice) || 0;
                                    const unit = qty > 0 ? (totalPrice / qty) : 0;

                                    if (!Number.isNaN(unit)) {
                                        // set dataset.price so checkout reads it
                                        priceNode.dataset.price = unit.toFixed(2);
                                        priceNode.textContent = '₱' + (unit * qty).toFixed(2);
                                    }
                                }

                                recalculateTotals();
                            } else {
                                showToast(data.message || 'Some serials are invalid', 'error');
                            }
                        })
                        .catch(err => {
                            showToast('Error validating serials', 'error');
                        });
                }

                // Attach event listeners
                document.querySelectorAll('.serial-btn').forEach(btn => {
                    btn.addEventListener('click', () => openSerialModal(btn));
                });

                serialCancelBtn.addEventListener('click', closeSerialModal);
                serialSaveBtn.addEventListener('click', saveSerialNumbers);

                // ensure axios present
                if (window.axios) {
                    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
                    if (tokenMeta) {
                        axios.defaults.headers.common['X-CSRF-TOKEN'] = tokenMeta.getAttribute('content');
                    }
                    axios.defaults.headers.common['Accept'] = 'application/json';
                }

                // fallback toast if your showToast isn't defined elsewhere
                window.showToast = window.showToast || function (msg, type = 'success') {
                    console.log(type.toUpperCase(), msg);
                    // you already have a nice toast; this fallback keeps things working.
                };

                (function initCustomerSearch() {
                    const searchInput = document.getElementById('customerSearch');
                    const resultsBox = document.getElementById('customerResults');
                    const customerIdInput = document.getElementById('customerId');
                    const addCustomerBtn = document.getElementById('addCustomerBtn');

                    // modal controls
                    const modal = document.getElementById('customerModal');
                    const closeCustomerModal = document.getElementById('closeCustomerModal');
                    const closeCustomerModalBtn = document.getElementById('closeCustomerModalBtn');
                    const saveCustomerBtn = document.getElementById('saveCustomerBtn');
                    const nameInput = document.getElementById('customerName');
                    const emailInput = document.getElementById('customerEmail');
                    const phoneInput = document.getElementById('customerPhone');
                    const addressInput = document.getElementById('customerAddress');

                    // selected customer display
                    const selectedCustomerBox = document.getElementById('selectedCustomer');
                    const custNameNode = document.getElementById('cust-name');
                    const custEmailNode = document.getElementById('cust-email');
                    const custPhoneNode = document.getElementById('cust-phone');

                    if (!searchInput || !resultsBox) return;

                    // prevent Enter from submitting parent forms (causes 405 previously)
                    searchInput.addEventListener('keydown', (e) => { if (e.key === 'Enter') e.preventDefault(); });

                    let timer = null;
                    searchInput.addEventListener('input', function () {
                        const q = this.value.trim();
                        if (timer) clearTimeout(timer);

                        if (q.length < 2) {
                            resultsBox.classList.add('hidden');
                            resultsBox.innerHTML = '';
                            return;
                        }

                        timer = setTimeout(() => {
                            axios.get('/customers/search', { params: { q } })
                                .then(res => {
                                    const data = res.data || [];
                                    resultsBox.innerHTML = '';

                                    if (!Array.isArray(data) || data.length === 0) {
                                        resultsBox.innerHTML = `<div class="px-3 py-2 text-gray-500 text-sm">No customers found</div>`;
                                    } else {
                                        data.forEach(customer => {
                                            const item = document.createElement('div');
                                            item.className = 'px-3 py-2 hover:bg-gray-100 cursor-pointer';
                                            item.textContent = `${customer.name || '(no name)'} ${customer.phone ? '(' + customer.phone + ')' : ''}`;
                                            item.addEventListener('click', () => {
                                                searchInput.value = customer.name || '';
                                                customerIdInput.value = customer.id ?? customer['id'] ?? '';
                                                // show selected customer info
                                                if (selectedCustomerBox) selectedCustomerBox.classList.remove('hidden');
                                                if (custNameNode) custNameNode.textContent = customer.name || '';
                                                if (custEmailNode) custEmailNode.textContent = customer.email || '';
                                                if (custPhoneNode) custPhoneNode.textContent = customer.phone || '';
                                                resultsBox.classList.add('hidden');
                                            });
                                            resultsBox.appendChild(item);
                                        });
                                    }
                                    resultsBox.classList.remove('hidden');
                                })
                                .catch(err => {
                                    console.error('Customer search error:', err);
                                    resultsBox.innerHTML = `<div class="px-3 py-2 text-red-500 text-sm">Error fetching customers</div>`;
                                    resultsBox.classList.remove('hidden');
                                });
                        }, 220);
                    });

                    // hide dropdown if click outside
                    document.addEventListener('click', (e) => {
                        if (!resultsBox.contains(e.target) && e.target !== searchInput) {
                            resultsBox.classList.add('hidden');
                        }
                    });

                    // modal open/close safe checks
                    if (addCustomerBtn && modal) {
                        addCustomerBtn.addEventListener('click', () => modal.classList.remove('hidden'));
                    }
                    [closeCustomerModal, closeCustomerModalBtn].forEach(btn => {
                        if (btn) btn.addEventListener('click', () => modal.classList.add('hidden'));
                    });

                    // Save new customer (AJAX)
                    if (saveCustomerBtn) {
                        saveCustomerBtn.addEventListener('click', () => {
                            const name = (nameInput?.value || '').trim();
                            if (!name) { showToast('Customer name is required', 'error'); return; }

                            saveCustomerBtn.disabled = true;

                            axios.post('/customers/store/ajax', {
                                name: name,
                                email: (emailInput?.value || '').trim(),
                                phone: (phoneInput?.value || '').trim(),
                                address: (addressInput?.value || '').trim(),
                            })
                                .then(resp => {
                                    const data = resp.data || {};
                                    if (data.success) {
                                        const c = data.customer;
                                        // set selection
                                        if (c) {
                                            searchInput.value = c.name || '';
                                            if (customerIdInput) customerIdInput.value = c.id ?? c['id'] ?? '';
                                            if (selectedCustomerBox) selectedCustomerBox.classList.remove('hidden');
                                            if (custNameNode) custNameNode.textContent = c.name || '';
                                            if (custEmailNode) custEmailNode.textContent = c.email || '';
                                            if (custPhoneNode) custPhoneNode.textContent = c.phone || '';
                                        }
                                        // clear and close
                                        if (nameInput) nameInput.value = '';
                                        if (emailInput) emailInput.value = '';
                                        if (phoneInput) phoneInput.value = '';
                                        if (addressInput) addressInput.value = '';
                                        if (modal) modal.classList.add('hidden');

                                        showToast('Customer added successfully!', 'success');
                                    } else {
                                        const msg = data.message || 'Failed to add customer.';
                                        showToast(msg, 'error');
                                    }
                                })
                                .catch(err => {
                                    if (err.response && err.response.status === 422 && err.response.data) {
                                        const errs = err.response.data.errors || {};
                                        Object.values(errs).flat().forEach(m => showToast(m, 'error'));
                                    } else {
                                        showToast('Something went wrong. Please try again.', 'error');
                                    }
                                })
                                .finally(() => { saveCustomerBtn.disabled = false; });
                        });
                    }
                })();

                document.querySelectorAll('.product-price').forEach(priceNode => {
                    const container = priceNode.closest('div');
                    const btn = container.querySelector('.serial-btn');
                    const price = parseFloat(priceNode.dataset.price) || 0;
                    const qty = parseInt(priceNode.dataset.quantity) || 1;

                    const trackSerial = priceNode.dataset.trackSerial === '1';
                    if (trackSerial) {
                        priceNode.textContent = '₱0.00';
                    } else {
                        priceNode.textContent = '₱' + (price * qty).toFixed(2);
                    }
                });

                // --------- PAYMENT METHOD dropdown binding ----------

                const paymentSelect = document.getElementById('paymentSelect');
                const selectedPaymentMethodInput = document.getElementById('selectedPaymentMethod');
                const referenceContainer = document.getElementById('referenceContainer');
                const paymentReferenceInput = document.getElementById('paymentReference');

                function updatePaymentSelection(val) {
                    const method = String(val || 'cash');
                    if (selectedPaymentMethodInput) selectedPaymentMethodInput.value = method;
                    // show reference only for non-cash
                    if (referenceContainer) {
                        if (method.toLowerCase() === 'cash') {
                            referenceContainer.classList.add('hidden');
                            if (paymentReferenceInput) paymentReferenceInput.value = '';
                        } else {
                            referenceContainer.classList.remove('hidden');
                        }
                    }
                }

                if (paymentSelect) {
                    paymentSelect.addEventListener('change', (e) => updatePaymentSelection(e.target.value));
                    // initialize
                    updatePaymentSelection(paymentSelect.value);
                } else {
                    // fallback: ensure hidden input default behavior
                    updatePaymentSelection(selectedPaymentMethodInput ? selectedPaymentMethodInput.value : 'cash');
                }

                // --------- CHECKOUT / LOGGING ----------
                // Find your Checkout Now button by text (keeps markup untouched)
                const checkoutButton = Array.from(document.querySelectorAll('button')).find(b => b.innerText && b.innerText.trim().startsWith('Checkout Now'));
                if (checkoutButton) {
                    checkoutButton.addEventListener('click', async (ev) => {
                        ev.preventDefault();

                        // Build items payload from DOM
                        const items = [];

                        // For each product-price entry, try to locate product id from closest [data-product-id] or from serial-btn if present
                        document.querySelectorAll('.product-price').forEach(priceNode => {
                            const qty = parseInt(priceNode.dataset.quantity) || 1;
                            const unitFromDataset = parseFloat(priceNode.dataset.price) || 0;

                            // locate the nearest ancestor with data-product-id
                            let container = priceNode.closest('[data-product-id]');
                            let productId = container ? container.dataset.productId : null;

                            // fallback: look for serial-btn in same visual product row and use its data-product-id
                            if (!productId) {
                                const serialBtn = priceNode.closest('div').querySelector('.serial-btn');
                                if (serialBtn && serialBtn.dataset.productId) productId = serialBtn.dataset.productId;
                            }

                            // determine unit price: if dataset.price present use it; else derive from displayed text / qty
                            let displayedText = (priceNode.textContent || '').replace(/[₱,]/g, '').trim();
                            let displayedVal = parseFloat(displayedText) || 0;
                            let unitPrice = unitFromDataset || (qty > 0 ? displayedVal / qty : 0);

                            // try to get serials array
                            let serials = [];
                            const btnForSerials = (container && container.querySelector('.serial-btn')) || document.querySelector(`.serial-btn[data-product-id="${productId}"]`);
                            if (btnForSerials && btnForSerials.dataset.serials) {
                                try { serials = JSON.parse(btnForSerials.dataset.serials); } catch (e) { serials = []; }
                            }

                            if (productId) {
                                items.push({
                                    product_id: productId,
                                    quantity: qty,
                                    unit_price: parseFloat(unitPrice.toFixed(2)),
                                    serial_numbers: serials
                                });
                            } else {
                                // productId missing - still push with null id so you can see in logs and correct in DOM if necessary
                                items.push({
                                    product_id: null,
                                    quantity: qty,
                                    unit_price: parseFloat(unitPrice.toFixed(2)),
                                    serial_numbers: []
                                });
                            }
                        });

                        if (items.length === 0) {
                            showToast('No items to checkout', 'error');
                            return;
                        }

                        // Ensure totals are current (in case something changed)
                        if (typeof recalculateTotals === 'function') recalculateTotals();

                        const totalEl = document.getElementById('totalAmount');
                        let total = 0;
                        if (totalEl) {
                            const t = (totalEl.textContent || totalEl.innerText || '₱0.00').replace(/[₱,]/g, '').trim();
                            total = parseFloat(t) || 0;
                        }

                        // parse amountPaid robustly (strip commas/currency if any)
                        const amountPaidInput = document.getElementById('amountPaid');
                        let amountPaid = 0;
                        if (amountPaidInput) {
                            const raw = String(amountPaidInput.value || '').replace(/[₱,]/g, '').trim();
                            amountPaid = parseFloat(raw) || 0;
                        }

                        // compute change here (client-side only for UX). Server must still compute and persist
                        const change = Math.max(0, +(amountPaid - total).toFixed(2));

                        // Optional: update change UI if present
                        const changeDisplay = document.getElementById('changeDisplay');
                        if (changeDisplay) {
                            changeDisplay.textContent = '₱' + change.toFixed(2);
                        }

                        // Basic validation
                        if (amountPaid <= 0) {
                            showToast('Please enter an amount paid', 'error');
                            amountPaidInput?.focus();
                            return;
                        }

                        // read selected payment method and reference from UI
                        const selectedMethod = document.getElementById('selectedPaymentMethod') ? (document.getElementById('selectedPaymentMethod').value || 'cash') : 'cash';
                        const paymentRef = (selectedMethod && String(selectedMethod).toLowerCase() !== 'cash') ? (document.getElementById('paymentReference') ? (document.getElementById('paymentReference').value.trim() || null) : null) : null;

                        const payload = {
                            branch_id: document.querySelector('meta[name="branch-id"]') ? document.querySelector('meta[name="branch-id"]').getAttribute('content') : null,
                            employee_id: document.querySelector('meta[name="employee-id"]') ? document.querySelector('meta[name="employee-id"]').getAttribute('content') : null,
                            customer_id: document.getElementById('customerId') ? (document.getElementById('customerId').value || null) : null,
                            payment_method: selectedMethod || 'cash',
                            payment_reference: paymentRef,
                            amount_paid: parseFloat(amountPaid.toFixed(2)), // send amount_paid
                            change: parseFloat(change.toFixed(2)),           // send change
                            status: 'completed',
                            items: items
                        };

                        // send ajax to server
                        try {
                            const resp = await axios.post('/pos/sales', payload);
                            const data = resp.data || {};
                            if (data.success) {
                                showToast(data.message || 'Sale recorded', 'success');
                                setTimeout(() => {
                                    window.location.href = '/pos/sales';
                                }, 800);
                            } else {
                                showToast(data.message || 'Sale failed', 'error');
                                console.error('POS sale response', data);
                            }
                        } catch (err) {
                            if (err.response && err.response.data && err.response.data.errors) {
                                const errs = err.response.data.errors;
                                Object.values(errs).flat().forEach(msg => showToast(msg, 'error'));
                            } else if (err.response && err.response.data && err.response.data.message) {
                                showToast(err.response.data.message, 'error');
                            } else {
                                showToast('Failed to create sale', 'error');
                            }
                        }
                    });
                }
                // --------- END CHECKOUT ----------

                // ----------------- small patch: live change display -----------------
                function parseNumber(s) {
                    if (!s && s !== 0) return 0;
                    // accept strings like "₱1,234.56" or "1234.56"
                    const cleaned = String(s).replace(/[^0-9\.\-]/g, '');
                    return parseFloat(cleaned) || 0;
                }

                function formatPHP(value) {
                    return new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format(Number(value || 0));
                }

                function updateChangeDisplay() {
                    const totalEl = document.getElementById('totalAmount');
                    const changeEl = document.getElementById('changeDisplay');
                    const amountPaidInput = document.getElementById('amountPaid');

                    if (!changeEl) return; // nothing to update

                    const total = totalEl ? parseNumber(totalEl.textContent || totalEl.innerText) : 0;
                    const amountPaid = amountPaidInput ? parseNumber(amountPaidInput.value) : 0;

                    // show change only when amountPaid > total (otherwise 0.00)
                    const change = Math.max(0, +(amountPaid - total).toFixed(2));
                    changeEl.textContent = formatPHP(change);
                }

                // attach listener to amountPaid input (live update)
                const amountPaidInput = document.getElementById('amountPaid');
                if (amountPaidInput) {
                    amountPaidInput.addEventListener('input', updateChangeDisplay);

                    // Optional: format input nicely on blur (won't interrupt typing)
                    amountPaidInput.addEventListener('blur', () => {
                        const v = parseNumber(amountPaidInput.value);
                        amountPaidInput.value = v ? v.toFixed(2) : '';
                    });

                    // If user presses Enter on amountPaid, trigger checkout helper (prevent accidental form submit)
                    amountPaidInput.addEventListener('keydown', (e) => {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            // find the checkout button and focus/click it (non-invasive)
                            const checkoutBtn = Array.from(document.querySelectorAll('button'))
                                .find(b => b.innerText && b.innerText.trim().startsWith('Checkout Now'));
                            if (checkoutBtn) checkoutBtn.focus();
                        }
                    });
                }

                // ensure change shows correct initial value after totals are computed
                if (typeof recalculateTotals === 'function') {
                    // you already call recalculateTotals() earlier; call updateChangeDisplay after it
                    updateChangeDisplay();
                }


            });
        </script>
    @endpush


    <style>
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
@endsection