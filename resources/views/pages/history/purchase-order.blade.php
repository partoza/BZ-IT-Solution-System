@extends('layout.sidebarmenu')

@section('pages-content')
    <!-- Stats Section -->
    <div class="grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2 gap-5 mb-8">
        <!-- Total Orders Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Total Orders</h2>
            <div class="flex items-end justify-between">
                <div>
                    <h3 class="text-2xl font-semibold text-gray-900">{{ $totalPOs }}</h3>
                    <div class="mt-1 space-y-0.5">
                        <div class="flex items-center text-xs text-green-600">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            {{ $receivedPOs }} Received
                        </div>
                        <div class="flex items-center text-xs text-yellow-600">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            {{ $pendingPOs }} Pending
                        </div>
                    </div>
                </div>
                <p class="text-xs text-gray-500">This Month</p>
            </div>
        </div>

        <!-- Total Suppliers Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Total Suppliers</h2>
            <h3 class="text-2xl font-semibold text-gray-900">{{ $suppliers->count() }}</h3>
            <p class="text-sm text-gray-500 mt-1">Active Suppliers</p>
        </div>

        <!-- Pending Orders Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Pending Orders</h2>
            <h3 class="text-2xl font-semibold text-gray-900">{{ $pendingPOs }}</h3>
            <p class="text-sm text-gray-500 mt-1">Awaiting Delivery</p>
        </div>

        <!-- Total Products Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Total Products</h2>
            <h3 class="text-2xl font-semibold text-gray-900">{{ $totalPOsValue }}</h3>
            <p class="text-sm text-gray-500 mt-1">Value in Orders</p>
        </div>
    </div>

    <!-- Stock Orders Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
        <!-- Stock Orders Header -->
        <div class="bg-white shadow-sm p-5 mb-2">
            <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-3">
                <h2 class="text-lg font-semibold text-gray-800">Stock Orders History</h2>
                
                <div class="flex flex-col xl:flex-row gap-3 w-full xl:w-auto">
                    <!-- Search Form -->
                    <form method="GET" class="flex flex-wrap gap-3">
                        <div class="relative flex-1 xl:w-72">
                            <input 
                                type="text" 
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search Product or Supplier ..." 
                                class="w-full pl-9 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:text-gray-400"
                            >
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <select name="supplier" class="px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="">All Suppliers</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ request('supplier') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->company_name }}
                                </option>
                            @endforeach
                        </select>

                        <select name="status" class="px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="received" {{ request('status') == 'received' ? 'selected' : '' }}>Received</option>
                            <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>Partial</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>

                        <button type="submit" class="px-5 py-2.5 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                            Search
                        </button>

                        <a href="{{ route('stock-in.index') }}" class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium flex items-center justify-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            New Order
                        </a>
                    </form>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">PO Number</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Supplier</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Order Date</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Received Date</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Created By</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Status</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($purchase_orders as $po)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-3 font-medium">{{ $po->po_number }}</td>
                            <td class="px-6 py-3">{{ $po->supplier->company_name ?? '—' }}</td>
                            <td class="px-6 py-3">{{ $po->order_date->format('M d, Y') }}</td>
                            <td class="px-6 py-3">
                                @if ($po->received_date)
                                    {{ $po->received_date->format('M d, Y') }}
                                @else   
                                    Not yet received
                                @endif
                            </td>
                            <td class="px-6 py-3">{{ $po->creator?->full_name ?? '—' }}</td>
                            <td class="px-6 py-3">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'received' => 'bg-green-100 text-green-800',
                                        'partial' => 'bg-blue-100 text-blue-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                    ];
                                @endphp
                                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $statusClasses[$po->status] ?? 'bg-gray-100 text-gray-600' }}">
                                    {{ ucfirst($po->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-3">
                                <div class="relative inline-block text-left">
                                    <button id="options-menu-{{ $po->id }}" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-2 py-1 bg-white text-sm font-medium hover:bg-gray-50">
                                        Actions
                                        <svg class="-mr-1 ml-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414L10 13.414 5.293 8.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>

                                    <div id="dropdown-{{ $po->id }}" class="hidden origin-top-right absolute right-0 mt-2 w-36 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                                        @if($po->status === 'pending')
                                            <button class="block w-full text-left px-3 py-1 text-sm hover:bg-gray-100 receive-btn" data-po-id="{{ $po->id }}">Receive</button>
                                            <button class="block w-full text-left px-3 py-1 text-sm hover:bg-gray-100 cancel-btn" data-po-id="{{ $po->id }}">Cancel</button>
                                        @elseif($po->status === 'received')
                                            <button class="block w-full text-left px-3 py-1 text-sm hover:bg-gray-100 void-btn" data-po-id="{{ $po->id }}">Void</button>
                                        @endif

                                        <button class="block w-full text-left px-3 py-1 text-sm hover:bg-gray-100 view-btn" data-po-id="{{ $po->id }}">View Items</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-3 text-center text-gray-500">No purchase orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white px-6 py-4 border-t border-gray-200">
            {{ $purchase_orders->links() }}
        </div>
    </div>

<!-- Receive Modal -->
<div id="receive-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg w-3/4 max-w-3xl p-6 overflow-y-auto max-h-[80vh]">
        <h2 class="text-lg font-semibold mb-4">Receive Purchase Order</h2>
        <form id="receive-form">
            <div id="receive-products-container" class="space-y-4">
                <!-- Dynamically filled with products & serial inputs & markup -->
            </div>
            <div class="flex justify-end mt-6">
                <button type="button" class="px-5 py-2.5 bg-gray-200 rounded-lg mr-2" id="receive-cancel">Cancel</button>
                <button type="submit" class="px-5 py-2.5 bg-green-600 text-white rounded-lg">Confirm Receive</button>
            </div>
        </form>
    </div>
</div>

<!-- View Items Modal -->
<div id="view-items-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg w-3/4 max-w-3xl p-6 overflow-y-auto max-h-[80vh]">
        <h2 class="text-lg font-semibold mb-4">PO Items & Serials</h2>
        <div id="view-items-container" class="space-y-3">
            <!-- Dynamically filled -->
        </div>
        <div class="flex justify-end mt-6">
            <button type="button" class="px-5 py-2.5 bg-gray-200 rounded-lg" id="view-close">Close</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    // Use the global `showToast(message, type)` provided by resources/js/utils/toast.js

    document.querySelectorAll('[id^="options-menu-"]').forEach(btn => {
        btn.addEventListener('click', e => {
            const poId = btn.id.split('-')[2];
            const dropdown = document.getElementById('dropdown-' + poId);
            dropdown.classList.toggle('hidden');
        });
    });

    const receiveModal = document.getElementById('receive-modal');
    const receiveProductsContainer = document.getElementById('receive-products-container');
    let currentPoId = null;

    // Open receive modal
    document.querySelectorAll('.receive-btn').forEach(btn => {
        btn.addEventListener('click', e => {
            currentPoId = btn.dataset.poId;

            axios.get(`/purchase-orders/${currentPoId}/items`)
                .then(res => {
                    const items = res.data.items;
                    receiveProductsContainer.innerHTML = '';

                    items.forEach(item => {
                        const div = document.createElement('div');
                        div.className = 'border rounded p-3';
                        div.dataset.productId = item.product_id;
                        div.dataset.poItemId = item.id;

                        // Base markup input
                        div.innerHTML = `
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-semibold">${item.product_name}</span>
                                <span>${item.quantity_ordered} units</span>
                            </div>
                            <div class="mb-2">
                                <label class="block mb-1 font-medium">Markup %:</label>
                                <input type="number" min="0" value="20" class="border rounded px-2 py-1 w-24 markup-input">
                            </div>
                        `;

                        // Serial inputs container
                        const serialInputsContainer = document.createElement('div');
                        serialInputsContainer.className = 'serial-inputs mt-2';

                        // Automatically render serial inputs if track_serials is true
                        if (item.track_serials) {
                            for (let i = 0; i < item.quantity_ordered; i++) {
                                const input = document.createElement('input');
                                input.type = 'text';
                                input.placeholder = 'Serial #' + (i + 1);
                                input.className = 'border rounded px-2 py-1 w-48 mb-1 block';
                                serialInputsContainer.appendChild(input);
                            }
                        } else {
                            serialInputsContainer.classList.add('hidden');
                        }

                        div.appendChild(serialInputsContainer);
                        receiveProductsContainer.appendChild(div);
                    });

                    receiveModal.classList.remove('hidden');
                })
                .catch(err => {
                    console.error(err);
                    showToast('Failed to fetch PO items', 'error');
                });
        });
    });

    // Cancel button
    document.getElementById('receive-cancel').addEventListener('click', () => receiveModal.classList.add('hidden'));

    // Submit receive form
    document.getElementById('receive-form').addEventListener('submit', e => {
        e.preventDefault();
        if(!currentPoId) return;

        const itemsPayload = [];

        receiveProductsContainer.querySelectorAll('div.border').forEach(div => {
            const productId = div.dataset.productId;
            const poItemId = div.dataset.poItemId;
            const qty = parseInt(div.querySelector('span:last-child').textContent.split(' ')[0]);
            const markup = parseFloat(div.querySelector('.markup-input').value) || 20;

            // Collect serials if inputs exist
            const serials = [];
            div.querySelectorAll('.serial-inputs input').forEach(inp => {
                if(inp.value.trim()) serials.push(inp.value.trim());
            });

            itemsPayload.push({
                po_item_id: poItemId,
                product_id: productId,
                quantity: qty,
                serials: serials,
                markup: markup
            });
        });

        axios.post(`/purchase-orders/${currentPoId}/receive`, { items: itemsPayload })
            .then(res => {
                showToast(res.data.message || 'PO received successfully', 'success');
                receiveModal.classList.add('hidden');
                window.location.reload();
            })
            .catch(err => {
                console.error(err);
                showToast(err.response?.data?.message || 'Failed to receive PO', 'error');
            });
    });

    const viewModal = document.getElementById('view-items-modal');
    const viewContainer = document.getElementById('view-items-container');

    document.querySelectorAll('.view-btn').forEach(btn => {
        btn.addEventListener('click', e => {
            const poId = btn.dataset.poId;

            // Request getItems with inventory items
            const url = `/purchase-orders/${poId}/items?inventory=1`;

            axios.get(url)
                .then(res => {
                    console.log('PO Items response:', res.data);
                    const items = res.data.items;
                    viewContainer.innerHTML = '';

                    items.forEach(item => {
                        const div = document.createElement('div');
                        div.className = 'border rounded p-3';

                        const inventoryItems = Array.isArray(item.inventory_items) ? item.inventory_items : [];
                        let serialList = '';

                        if(inventoryItems.length > 0){
                            serialList = '<ul class="list-disc list-inside">';
                            inventoryItems.forEach(inv => {
                                serialList += `<li>ID: ${inv.id} | Serial: ${inv.serial_number || 'N/A'}</li>`;
                            });
                            serialList += '</ul>';
                        } else {
                            serialList = '<span class="text-gray-500">No serials / inventory items</span>';
                        }

                        div.innerHTML = `
                            <div class="font-semibold mb-1">${item.product_name} - ${item.quantity_ordered} units</div>
                            <div>${serialList}</div>
                        `;

                        viewContainer.appendChild(div);
                    });

                    viewModal.classList.remove('hidden');
                })
                .catch(err => {
                    console.error(err);
                    showToast('Failed to fetch items', 'error');
                });
        });
    });

    // Close modal
    document.getElementById('view-close').addEventListener('click', () => {
        viewModal.classList.add('hidden');
    });
});
</script>
@endpush

@endsection