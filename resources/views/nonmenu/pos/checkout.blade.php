@extends('layout.sidebarmenu')

@section('title', 'Purchase Summary')

@section('pages-content')
<div class="flex flex-col lg:flex-row gap-6 min-h-screen p-4">
    <!-- Left: Product Summary -->
    <div class="flex-[8] flex flex-col min-h-0 bg-white rounded-xl shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="p-6 border-b">
            <h1 class="text-2xl font-bold text-gray-800">Purchase Summary</h1>
            <p class="text-gray-500 mt-1">Review your order details before completing your purchase.</p>
        </div>
        
        <!-- Current Transaction -->
        <div class="px-6 pt-4">
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-600 font-medium">Current Transactions</div>
                <div class="text-xs text-gray-500">{{ now()->format('l, m/d/Y') }}</div>
            </div>
        </div>

        <!-- Product List -->
        <div class="p-6 border-b space-y-4">
            @forelse($cartProducts as $product)
                <div class="border border-dashed border-gray-300 rounded-lg p-4 relative flex gap-4 items-center">
                    <!-- Remove button -->
                    <button 
                        class="absolute top-2 right-2 text-gray-400 hover:text-red-500 transition-colors"
                        title="Remove item"
                    >
                        ✕
                    </button>

                    <!-- Product Image -->
                    <div class="w-20 h-20 rounded-lg overflow-hidden bg-gray-100 flex items-center justify-center">
                        @if($product['image'])
                            <img src="{{ asset('storage/' . $product['image']) }}" alt="{{ $product['name'] }}" class="object-cover w-full h-full">
                        @else
                            <span class="text-gray-400 text-sm">No Image</span>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div class="flex-1">
                        <div class="font-semibold text-lg text-gray-800">{{ $product['name'] }}</div>
                        <div class="text-sm text-gray-600 mt-1">Qty: {{ $product['quantity'] }}</div>
                        <div class="text-blue-600 font-bold text-md mt-1 product-price"
                            data-price="{{ $product['price'] }}"
                            data-quantity="{{ $product['quantity'] }}">
                            ₱{{ $product['track_serial'] ? '0.00' : number_format($product['price'] * $product['quantity'], 2) }}
                        </div>

                        <!-- Input Serial Button -->
                        @if($product['track_serial'])
                            <button type="button"
                                class="mt-2 text-sm px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition serial-btn"
                                data-product-id="{{ $product['product_id'] }}"
                                data-quantity="{{ $product['quantity'] }}">
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
        <div class="p-6 flex-1">
            <!-- Customer Details -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Customer Details</h3>
                <div class="flex gap-3 relative"> 
                    <div class="flex-1 relative">
                        <input type="text" id="customerSearch" placeholder="Search customer..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                            autocomplete="off">
                        <input type="hidden" id="customerId" name="customer_id">

                        <!-- Dropdown -->
                        <div id="customerResults"
                            class="absolute bg-white border border-gray-300 rounded-lg mt-1 w-full hidden max-h-48 overflow-y-auto shadow-lg z-50">
                        </div>
                    </div>

                    <button id="addCustomerBtn" type="button"
                        class="flex-[1] bg-blue-600 text-white rounded-lg px-6 py-3 text-sm font-medium hover:bg-blue-700 transition-colors">
                        Add Customer
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
            
            <!-- Payment Method -->
            <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Payment Method</h3>
            <div class="grid grid-cols-3 gap-3">
                <!-- Cash -->
                <label class="relative flex cursor-pointer">
                    <input type="radio" name="payment_method" value="cash" class="sr-only peer" checked />
                    <div class="w-full border-2 border-gray-300 rounded-lg px-3 py-3 text-sm hover:border-blue-400 transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:shadow-sm text-center">
                        <div class="flex flex-col items-center gap-1">
                            <svg class="w-5 h-5 text-gray-600 peer-checked:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span class="text-gray-700 peer-checked:text-blue-700 font-medium">Cash</span>
                        </div>
                    </div>
                </label>

                <!-- PCash -->
                <label class="relative flex cursor-pointer">
                    <input type="radio" name="payment_method" value="pcash" class="sr-only peer" />
                    <div class="w-full border-2 border-gray-300 rounded-lg px-3 py-3 text-sm hover:border-blue-400 transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:shadow-sm text-center">
                        <div class="flex flex-col items-center gap-1">
                            <svg class="w-5 h-5 text-gray-600 peer-checked:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                            <span class="text-gray-700 peer-checked:text-blue-700 font-medium">PCash</span>
                        </div>
                    </div>
                </label>

                <!-- PayMaya -->
                <label class="relative flex cursor-pointer">
                    <input type="radio" name="payment_method" value="paymaya" class="sr-only peer" />
                    <div class="w-full border-2 border-gray-300 rounded-lg px-3 py-3 text-sm hover:border-blue-400 transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:shadow-sm text-center">
                        <div class="flex flex-col items-center gap-1">
                            <svg class="w-5 h-5 text-gray-600 peer-checked:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            <span class="text-gray-700 peer-checked:text-blue-700 font-medium">PayMaya</span>
                        </div>
                    </div>
                </label>

                <!-- PayPal -->
                <label class="relative flex cursor-pointer">
                    <input type="radio" name="payment_method" value="paypal" class="sr-only peer" />
                    <div class="w-full border-2 border-gray-300 rounded-lg px-3 py-3 text-sm hover:border-blue-400 transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:shadow-sm text-center">
                        <div class="flex flex-col items-center gap-1">
                            <svg class="w-5 h-5 text-gray-600 peer-checked:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span class="text-gray-700 peer-checked:text-blue-700 font-medium">PayPal</span>
                        </div>
                    </div>
                </label>

                <!-- VISA -->
                <label class="relative flex cursor-pointer">
                    <input type="radio" name="payment_method" value="visa" class="sr-only peer" />
                    <div class="w-full border-2 border-gray-300 rounded-lg px-3 py-3 text-sm hover:border-blue-400 transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:shadow-sm text-center">
                        <div class="flex flex-col items-center gap-1">
                            <div class="w-5 h-5 bg-blue-600 rounded-sm flex items-center justify-center">
                                <span class="text-white text-xs font-bold">V</span>
                            </div>
                            <span class="text-gray-700 peer-checked:text-blue-700 font-medium">VISA</span>
                        </div>
                    </div>
                </label>

                <!-- Master Card -->
                <label class="relative flex cursor-pointer">
                    <input type="radio" name="payment_method" value="mastercard" class="sr-only peer" />
                    <div class="w-full border-2 border-gray-300 rounded-lg px-3 py-3 text-sm hover:border-blue-400 transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:shadow-sm text-center">
                        <div class="flex flex-col items-center gap-1">
                            <div class="w-5 h-5 bg-red-600 rounded-sm flex items-center justify-center">
                                <span class="text-white text-xs font-bold">MC</span>
                            </div>
                            <span class="text-gray-700 peer-checked:text-blue-700 font-medium">Master Card</span>
                        </div>
                    </div>
                </label>

                <!-- Bank Transfer -->
                <label class="relative flex cursor-pointer col-span-3">
                    <input type="radio" name="payment_method" value="bank_transfer" class="sr-only peer" />
                    <div class="w-full border-2 border-gray-300 rounded-lg px-3 py-3 text-sm hover:border-blue-400 transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:shadow-sm text-center">
                        <div class="flex flex-col items-center gap-1">
                            <svg class="w-5 h-5 text-gray-600 peer-checked:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                            </svg>
                            <span class="text-gray-700 peer-checked:text-blue-700 font-medium">Bank Transfer</span>
                        </div>
                    </div>
                </label>
            </div>
        </div>
            
            <!-- Promotion Code -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Promotion Code</h3>
                <div class="flex gap-3">
                    <input type="text" placeholder="Enter promo code" class="flex-1 border border-gray-300 rounded-lg px-4 py-3 text-sm" />
                    <button class="bg-blue-600 text-white rounded-lg px-6 py-3 text-sm font-medium hover:bg-blue-700 transition-colors">Apply</button>
                </div>
            </div>
            
            <!-- Amount Paid -->
            <div class="mb-8">
                <div class="flex justify-between mb-3">
                    <span class="text-gray-700 font-medium">Amount Paid</span>
                    <span class="text-gray-700 font-medium">Change</span>
                </div>
                <div class="flex gap-3">
                    <input type="text" placeholder="Enter amount" class="flex-1 border border-gray-300 rounded-lg px-4 py-3 text-sm" />
                    <div class="flex-1 border border-gray-300 rounded-lg px-4 py-3 text-sm bg-gray-50 flex items-center justify-center font-medium">0.00</div>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="border-t pt-6">
                <div class="flex justify-between text-md mb-2">
                    <span class="text-gray-700">Subtotal:</span>
                    <span class="text-gray-800">₱20,800.00</span>
                </div>
                <div class="flex justify-between text-md mb-4">
                    <span class="text-gray-700">Discount:</span>
                    <span class="text-gray-800">₱0.00</span>
                </div>
                <div class="flex justify-between text-md font-bold pt-4 border-t">
                    <span class="text-gray-800">Total Amount:</span>
                    <span class="text-blue-600">₱20,800.00</span>
                </div>
            </div>
            
            <!-- Checkout Button -->
            <button class="w-full mt-8 py-4 bg-green-600 text-white rounded-lg font-semibold text-lg flex items-center justify-center gap-3 hover:bg-green-700 transition-colors shadow-md">
                <span>Checkout Now</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </div>
    </div>
</div>
<!-- Add Customer Modal -->
<div id="customerModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
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
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
        <h2 class="text-lg font-semibold mb-4">Enter Serial Numbers</h2>
        <input type="hidden" id="serialProductId">

        <div id="serialInputsContainer" class="space-y-2 mb-4"></div>

        <div class="flex justify-end gap-2">
            <button type="button" id="serialCancelBtn" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</button>
            <button type="button" id="serialSaveBtn" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Save</button>
        </div>
    </div>
</div>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    let currentProductQty = 0;

    const serialModal = document.getElementById('serialModal');
    const serialContainer = document.getElementById('serialInputsContainer');
    const serialProductId = document.getElementById('serialProductId');
    const serialCancelBtn = document.getElementById('serialCancelBtn');
    const serialSaveBtn = document.getElementById('serialSaveBtn');

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
            return showToast(`Please enter ${currentProductQty} serial numbers`,'error');
        }

        // Save serials on the product button for reopening
        const productBtn = document.querySelector(`[data-product-id="${productIdVal}"]`);
        if (productBtn) productBtn.dataset.serials = JSON.stringify(serials);

        axios.post('/pos/validate-serials', { product_id: productIdVal, serials })
        .then(res => {
            const data = res.data;
            if (data.success) {
                showToast('Serials validated and prices updated!', 'success');
                closeSerialModal();

                // Optional: update frontend price
                if (data.updatedPrice !== undefined && productBtn) {
                    const priceNode = productBtn.closest('div').querySelector('.product-price');
                    if (priceNode) priceNode.textContent = '₱' + parseFloat(data.updatedPrice).toFixed(2);
                }
            } else {
                showToast(data.message || 'Some serials are invalid', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            showToast('Error validating serials', 'error');
        });
    }

    // Attach event listeners
    document.querySelectorAll('.serial-btn').forEach(btn => {
        btn.addEventListener('click', () => openSerialModal(btn));
    });

    serialCancelBtn.addEventListener('click', closeSerialModal);
    serialSaveBtn.addEventListener('click', saveSerialNumbers);


    // ------------------------------
    // Toast Notification
    // ------------------------------
    window.showToast = function (message, type = 'success') {
        let container = document.getElementById("toast-container");
        if (!container) {
            container = document.createElement("div");
            container.id = "toast-container";
            container.className = "fixed top-4 right-4 z-50 flex flex-col gap-2";
            document.body.appendChild(container);
        }

        const toast = document.createElement("div");
        toast.className = `px-4 py-3 rounded-xl shadow-lg text-white flex items-center justify-between transform transition-all duration-300 ease-in-out relative overflow-hidden ${type === 'success'
            ? 'bg-green-500 border-l-4 border-green-600'
            : 'bg-red-500 border-l-4 border-red-600'
            }`;

        const icon = type === 'success'
            ? `<svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>`
            : `<svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>`;

        toast.innerHTML = `
    <div class="flex items-center">
        ${icon}
        <span class="font-medium">${message}</span>
    </div>
    <button class="ml-4 opacity-70 hover:opacity-100 transition-opacity" onclick="this.parentElement.remove()">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
    <div class="absolute bottom-0 left-0 right-0 h-1 bg-black/10">
        <div class="h-full ${type === 'success' ? 'bg-green-600' : 'bg-red-600'} progress-bar"></div>
    </div>
`;

        // Add slide-in animation
        toast.style.transform = 'translateX(100%)';
        toast.style.opacity = '0';

        container.appendChild(toast);

        // Trigger animation
        requestAnimationFrame(() => {
            toast.style.transform = 'translateX(0)';
            toast.style.opacity = '1';
        });

        // Progress bar animation
        const progressBar = toast.querySelector('.progress-bar');
        progressBar.style.width = '100%';
        progressBar.style.transition = 'width 3s linear';

        setTimeout(() => {
            progressBar.style.width = '0%';
        }, 10);

        // Auto remove after delay
        setTimeout(() => {
            toast.style.transform = 'translateX(100%)';
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    };
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
          console.error('Add customer error:', err);
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

        // If no serial tracking, calculate subtotal immediately
        if (!btn) {
            const price = parseFloat(priceNode.dataset.price) || 0;
            const qty = parseInt(priceNode.dataset.quantity) || 1;
            priceNode.textContent = '₱' + (price * qty).toFixed(2);
        }
    });

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