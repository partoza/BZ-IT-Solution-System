@extends('layout.sidebarmenu')

@section('title', 'Point of Sales')

@section('pages-content')
<div class="flex flex-col">
    <!-- Enhanced Supplier Selection Row -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Supplier Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Supplier *</label>
                <select class="w-full border rounded-lg px-3 py-2 text-sm">
                    <option value="">-- Select Supplier --</option>
                    <option value="supplier1">Supplier A - Electronics</option>
                    <option value="supplier2">Supplier B - Computer Parts</option>
                    <option value="supplier3">Supplier C - Accessories</option>
                    <option value="supplier4">Supplier D - Office Equipment</option>
                </select>
            </div>
            
            <!-- Company Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                <div class="text-gray-600 text-sm p-2 bg-gray-50 rounded-lg min-h-[42px] flex items-center">
                    Select a supplier to view company name
                </div>
            </div>
            
            <!-- Contact Person -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Contact Person</label>
                <div class="text-gray-600 text-sm p-2 bg-gray-50 rounded-lg min-h-[42px] flex items-center">
                    Select a supplier to view contact person
                </div>
            </div>
            
            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <div class="text-gray-600 text-sm p-2 bg-gray-50 rounded-lg min-h-[42px] flex items-center">
                    Select a supplier to view email
                </div>
            </div>
            
            <!-- Phone Number -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                <div class="text-gray-600 text-sm p-2 bg-gray-50 rounded-lg min-h-[42px] flex items-center">
                    Select a supplier to view phone number
                </div>
            </div>
            
            <!-- Address -->
            <div class="lg:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                <div class="text-gray-600 text-sm p-2 bg-gray-50 rounded-lg min-h-[42px] flex items-center">
                    Select a supplier to view address
                </div>
            </div>
        </div>
    </div>

    <!-- POS Content -->
    <div class="flex flex-col lg:flex-row gap-6 h-auto lg:h-[600px]">
        <!-- Left: Product Catalog -->
        <div class="flex-1 flex flex-col min-h-0">
            <!-- Fixed Header -->
            <div class="flex flex-col md:flex-row md:items-center gap-4 mb-2 bg-white rounded-lg shadow-sm px-6 py-4">
                <!-- Title -->
                <div class="flex-shrink-0">
                    <h1 class="text-xl font-semibold text-primary">Point of Sales</h1>
                    <p class="text-sm text-gray-500">Product Catalog</p>
                </div>

                <!-- Search and Filters container -->
                <div class="flex flex-wrap justify-items-end gap-3 flex-1 min-w-0">
                    <!-- Search -->
                    <!-- <div class="relative flex-grow min-w-[180px] max-w-md">
                    <input
                        type="text"
                        placeholder="Search Product..."
                        class="border rounded-lg px-3 py-2 pr-20 text-sm w-full focus:outline-none focus:ring-2 focus:ring-primary"
                    />
                    <button
                        class="absolute top-1/2 right-2 -translate-y-1/2 bg-primary text-white px-4 py-1.5 rounded-lg text-sm hover:bg-primary-dark transition-colors"
                    >
                        Search
                    </button>
                    </div> -->

                    <!-- Filters -->
                    <select
                        class="border rounded-lg px-3 py-2 text-sm w-36 min-w-[9rem] focus:outline-none focus:ring-2 focus:ring-primary"
                    >
                        <option>All Categories</option>
                        <option>Peripherals</option>
                        <option>Accessories</option>
                        <option>PC Furniture</option>
                    </select>

                    <select
                        class="border rounded-lg px-3 py-2 text-sm w-32 min-w-[8rem] focus:outline-none focus:ring-2 focus:ring-primary"
                    >
                        <option>All Brands</option>
                        <option>NVIDIA</option>
                        <option>AMD</option>
                        <option>Intel</option>
                    </select>

                    <!-- More Filters button -->
                    <button
                        class="border rounded-lg px-3 py-2 text-sm flex items-center gap-1 hover:bg-gray-50 transition-colors whitespace-nowrap"
                    >
                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"
                            />
                        </svg>
                        More Filters
                    </button>

                    <!-- Discounted checkbox -->
                    <label
                        class="flex items-center gap-2 text-sm cursor-pointer whitespace-nowrap"
                    >
                        <input type="checkbox" class="accent-primary w-4 h-4" />
                        Discounted
                    </label>
                </div>
            </div>

            <!-- Tabs -->
            <div class="bg-white rounded-lg shadow-sm p-6 flex-1 flex flex-col min-h-0">
                <div class="flex flex-wrap gap-2 mb-4">
                    <button class="px-4 py-2 rounded-lg bg-primary text-white text-sm font-medium">All Products</button>
                    <button class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 text-sm font-medium hover:bg-gray-200 transition-colors">Peripherals</button>
                    <button class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 text-sm font-medium hover:bg-gray-200 transition-colors">Accessories</button>
                    <button class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 text-sm font-medium hover:bg-gray-200 transition-colors">PC Furniture</button>
                    <button class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 text-sm font-medium hover:bg-gray-200 transition-colors">CCTV</button>
                    <button class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 text-sm font-medium hover:bg-gray-200 transition-colors">Solar</button>
                </div>
                
                <!-- Product Grid (scrollable) -->
                <div>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 overflow-y-auto h-[410px] pr-2">
                        <!-- Example Product Card -->
                        @for($i = 0; $i < 15; $i++)
                        <div class="border rounded-xl p-3 flex flex-col hover:shadow-md transition-shadow">
                            <img src="https://via.placeholder.com/120x80?text=Product" alt="Product"
                                class="mb-2 rounded-lg object-cover h-20 w-full" />
                            <div class="font-semibold text-gray-800 text-sm mb-1">Product Name {{ $i + 1 }}</div>
                            <div class="text-primary font-bold text-base mb-1">₱1,000.00</div>
                            <div class="text-xs text-gray-500 mb-2">Stock: 10</div>
                            <button
                                class="mt-auto px-3 py-2 bg-gray-100 rounded-lg text-sm flex items-center justify-center gap-2 hover:bg-primary hover:text-white transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M3 3h2l.4 2M7 13h10l4-8H5.4" stroke-linecap="round" stroke-linejoin="round" />
                                    <circle cx="9" cy="21" r="1" />
                                    <circle cx="20" cy="21" r="1" />
                                </svg>
                                Add to Cart
                            </button>
                        </div>
                        @endfor
                    </div>
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
                        <div class="text-xs text-gray-400">Monday, 09/11/2025</div>
                    </div>
                    <div class="text-emerald-600 text-sm font-semibold">BZ Davao Branch</div>
                </div>
            </div>

            <!-- Cart content (scrollable list) -->
            <div class="p-4 flex-1 min-h-0 flex flex-col">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-semibold text-md">All Added Products</h3>
                    <button class="flex items-center gap-2 text-sm bg-gray-100 p-3 rounded-md hover:bg-gray-200 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22" />
                        </svg>
                        Remove All
                    </button>
                </div>

                <!-- Scrollable items container with responsive fixed height -->
                <div class="space-y-4 overflow-y-auto h-[260px] md:h-[320px] lg:h-[420px] pr-2">
                    @for($i = 0; $i < 8; $i++)
                    <div class="border rounded-lg p-3 flex gap-4 items-start bg-white hover:shadow-sm transition-shadow">
                        <img src="https://via.placeholder.com/80x80?text=IMG" alt="Product" class="w-20 h-20 object-cover rounded-md shadow-sm -ml-1" />
                        <div class="flex-1">
                            <div class="flex items-start justify-between">
                                <div class="font-semibold text-sm">NVIDIA RTX 4060</div>
                                <button class="text-red-400 text-sm hover:text-red-600 transition-colors">×</button>
                            </div>
                            <div class="text-primary font-bold text-sm mt-1">₱20,800.00</div>

                            <div class="mt-3 text-sm">
                                <div class="mb-1">Qty:</div>
                                <div class="flex items-center gap-2">
                                    <button class="w-6 h-6 flex items-center justify-center rounded border text-gray-600 hover:bg-gray-100 transition-colors">-</button>
                                    <div class="px-3">1</div>
                                    <button class="w-6 h-6 flex items-center justify-center rounded border text-gray-600 hover:bg-gray-100 transition-colors">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>

            <!-- Totals + Action (fixed at bottom of the panel) -->
            <div class="p-4 border-t bg-white">
                <div class="flex items-center justify-between text-sm mb-3">
                    <div class="text-gray-600">Total Items: <span class="font-semibold">1</span></div>
                    <div class="text-gray-800 font-semibold">Total Amount: ₱20,800.00</div>
                </div>

                <button class="w-full py-3 bg-emerald-600 text-white rounded-lg font-semibold flex items-center justify-center gap-2 hover:bg-emerald-700 transition-colors">
                    <span>Process Payment</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
        </aside>
    </div>
</div>

<!-- JavaScript for dynamic supplier information -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const supplierSelect = document.querySelector('.bg-white.rounded-lg.shadow-sm select');
        const supplierInfoContainers = document.querySelectorAll('.bg-gray-50.rounded-lg');
        
        // Enhanced supplier data
        const supplierData = {
            supplier1: {
                company: "Tech Solutions Inc.",
                contactPerson: "John Doe",
                email: "john.doe@techsolutions.com",
                phone: "(555) 123-4567",
                address: "123 Tech Street, Makati City, Metro Manila",
            },
            supplier2: {
                company: "Computer Parts Depot",
                contactPerson: "Jane Smith",
                email: "jane.smith@computerparts.com",
                phone: "(555) 987-6543",
                address: "456 Computer Ave, Quezon City, Metro Manila",
            },
            supplier3: {
                company: "Accessories World",
                contactPerson: "Robert Johnson",
                email: "robert@accessoriesworld.com",
                phone: "(555) 456-7890",
                address: "789 Accessories Blvd, Taguig City, Metro Manila",
            },
            supplier4: {
                company: "Office Equipment Pro",
                contactPerson: "Maria Garcia",
                email: "maria.garcia@officepro.com",
                phone: "(555) 234-5678",
                address: "321 Office Park, Mandaluyong City, Metro Manila",
            }
        };
        
        supplierSelect.addEventListener('change', function() {
            const selectedSupplier = this.value;
            
            if (selectedSupplier && supplierData[selectedSupplier]) {
                const data = supplierData[selectedSupplier];
                supplierInfoContainers[0].textContent = data.company;
                supplierInfoContainers[1].textContent = data.contactPerson;
                supplierInfoContainers[2].textContent = data.email;
                supplierInfoContainers[3].textContent = data.phone;
                supplierInfoContainers[4].textContent = data.address;
                supplierInfoContainers[5].textContent = data.terms;
            } else {
                const defaultText = "Select a supplier to view information";
                supplierInfoContainers.forEach(container => {
                    container.textContent = defaultText;
                });
                supplierInfoContainers[0].textContent = "Select a supplier to view company name";
                supplierInfoContainers[1].textContent = "Select a supplier to view contact person";
                supplierInfoContainers[2].textContent = "Select a supplier to view email";
                supplierInfoContainers[3].textContent = "Select a supplier to view phone number";
                supplierInfoContainers[4].textContent = "Select a supplier to view address";
            }
        });
    });
</script>
@endsection