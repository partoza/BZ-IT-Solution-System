@extends('layout.sidebarmenu')

@section('pages-content')
    <!-- Stats Section (styled like products) -->
    @php
        $totalTx = $totalSales ?? 0;
        $completedPct = $totalTx > 0 ? round(($completedSales / $totalTx) * 100) : 0;
        $cancelledPct = $totalTx > 0 ? round(($cancelledSales / $totalTx) * 100) : 0;
        $reservedPct = $totalTx > 0 ? round(($reservedSales / $totalTx) * 100) : 0;
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2 gap-3 mb-3">
        <!-- Total Transactions Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <div class="flex items-center gap-3 mb-1">
                <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center">
                    <div class="w-8 h-8 bg-gradient-to-r from-emerald-600 to-emerald-500 flex items-center justify-center"
                        style="clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%)">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 text-white">
                            <path d="M3 3h18v2H3z" />
                            <path d="M5 7h14v11a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V7z" />
                        </svg>
                    </div>
                </div>
                <h2 class="text-base font-medium text-gray-700">Total Sales</h2>
            </div>
            <div class="ps-14">
                <h3 class="text-2xl font-semibold text-gray-900">{{ number_format($totalTx) }}</h3>
                <p class="text-xs text-gray-500 mt-1">Overall recorded sales</p>
                <div class="flex items-center gap-2 mt-2">
                    <div class="flex items-center text-green-600 text-xs">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 10a1 1 0 012 0v4a1 1 0 11-2 0v-4z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ $completedPct }}% Completed</span>
                    </div>
                    <div class="flex items-center text-red-600 text-xs">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 9l2 2 4-4" />
                        </svg>
                        <span>{{ $cancelledPct }}% Cancelled</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Sales Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <div class="flex items-center gap-3 mb-1">
                <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center">
                    <div class="w-8 h-8 bg-gradient-to-r from-emerald-600 to-emerald-500 flex items-center justify-center"
                        style="clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle size-4 text-white" viewBox="0 0 16 16">
                            <path d="M2.5 8a5.5 5.5 0 1111 0 5.5 5.5 0 01-11 0z" />
                            <path d="M10.97 5.97a.235.235 0 00-.02-.022L7.477 9.417 6.354 8.293a.75.75 0 10-1.06 1.06l1.732 1.732a.75.75 0 001.06 0l3.386-3.388a.75.75 0 00-.002-1.01z" />
                        </svg>
                    </div>
                </div>
                <h2 class="text-base font-medium text-gray-700">Completed Sales</h2>
            </div>
            <div class="ps-14">
                <h3 class="text-2xl font-semibold text-green-700">{{ number_format($completedSales) }}</h3>
                <p class="text-xs text-gray-500 mt-1">₱{{ number_format($salesThisMonth ?? 0, 2) }} this month</p>
                <div class="flex items-center gap-2 mt-2">
                    <div class="flex items-center text-green-600 text-xs">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 10a8 8 0 1116 0A8 8 0 012 10z" />
                        </svg>
                        <span>{{ $completedPct }}% of Total</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cancelled Sales Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <div class="flex items-center gap-3 mb-1">
                <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center">
                    <div class="w-8 h-8 bg-gradient-to-r from-rose-600 to-rose-500 flex items-center justify-center"
                        style="clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%)">
                        <svg width="16" height="16" fill="currentColor" class="bi bi-x-circle size-4 text-white" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 108 1a7 7 0 000 14z" />
                            <path d="M4.646 4.646a.5.5 0 01.708 0L8 7.293l2.646-2.647a.5.5 0 11.708.708L8.707 8l2.647 2.646a.5.5 0 01-.708.708L8 8.707l-2.646 2.647a.5.5 0 01-.708-.708L7.293 8 4.646 5.354a.5.5 0 010-.708z" />
                        </svg>
                    </div>
                </div>
                <h2 class="text-base font-medium text-gray-700">Cancelled Sales</h2>
            </div>
            <div class="ps-14">
                <h3 class="text-2xl font-semibold text-red-600">{{ number_format($cancelledSales) }}</h3>
                <p class="text-xs text-gray-500 mt-1">₱{{ number_format($cancelledValue ?? 0, 2) }} total cancelled</p>
                <div class="flex items-center gap-2 mt-2">
                    <div class="flex items-center text-red-600 text-xs">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a8 8 0 100 16 8 8 0 000-16z" />
                        </svg>
                        <span>{{ $cancelledPct }}% of Total</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reserved Sales Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <div class="flex items-center gap-3 mb-1">
                <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center">
                    <div class="w-8 h-8 bg-gradient-to-r from-amber-600 to-amber-500 flex items-center justify-center"
                        style="clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%)">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 text-white">
                            <path d="M12 2l3 7h7l-5.5 4 2 7L12 16l-6.5 4 2-7L2 9h7z" />
                        </svg>
                    </div>
                </div>
                <h2 class="text-base font-medium text-gray-700">Reserved Sales</h2>
            </div>
            <div class="ps-14">
                <h3 class="text-2xl font-semibold text-amber-600">{{ number_format($reservedSales) }}</h3>
                <p class="text-xs text-gray-500 mt-1">₱{{ number_format($reservedValue ?? 0, 2) }} reserved value</p>
                <div class="flex items-center gap-2 mt-2">
                    <div class="flex items-center text-amber-600 text-xs">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a8 8 0 100 16 8 8 0 000-16z" />
                        </svg>
                        <span>{{ $reservedPct }}% of Total</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
        <!-- Transaction List Header -->
        <div class="bg-white shadow-sm p-5 mb-2">
            <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-3">
                <h2 class="text-lg font-semibold text-gray-800">Sales History</h2>
                
                <div class="flex flex-col xl:flex-row gap-3 w-full xl:w-auto">
                    <form id="transactionSearchForm" method="GET" class="flex flex-wrap gap-3 global-focus">
                        <!-- keep per_page sync with UI defaults -->
                        <input type="hidden" name="per_page" value="5" />
                        <!-- Search -->
                        <div class="relative flex-1 xl:w-72">
                            <input 
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="ID, Serial, Product, or Customer..."
                                class="w-full pl-9 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:text-gray-400"
                            >
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Status -->
                        <select name="status"
                            class="px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="">All Status</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>Reserved</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>

                        <!-- Payment Method -->
                        <select name="payment_method"
                            class="px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="">All Payment Methods</option>
                            <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="gcash" {{ request('payment_method') == 'gcash' ? 'selected' : '' }}>GCash</option>
                        </select>

                        <!-- Buttons -->
                        <button type="submit"
                            class="px-5 py-2.5 text-sm bg-primary hover:bg-emerald-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                            Filter
                        </button>

                        <button id="resetFilters" type="button"
                            class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium flex items-center justify-center">
                            Clear
                        </button>

                        <button type="button"
                            class="px-5 py-2.5 bg-primary hover:bg-primary-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium flex items-center justify-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Export Report
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Transaction #</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Date</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Customer</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Created By</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Payment</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Amount</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Status</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($sales as $sale)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-3 font-medium text-gray-900">#{{ $sale->sales_number }}</td>
                            <td class="px-6 py-3 text-gray-600">
                                {{ $sale->sold_at ? $sale->sold_at->format('M d, Y h:i A') : '—' }}
                            </td>
                            <td class="px-6 py-3 text-gray-700">
                                {{ $sale->customer?->name ?? 'Walk-in' }}
                            </td>
                            <td class="px-6 py-3 text-gray-700">
                                {{ $sale->employee?->full_name ?? '—' }}
                            </td>
                            <td class="px-6 py-3 text-gray-600 capitalize">
                                {{ $sale->payment_method ?? '—' }}
                            </td>
                            <td class="px-6 py-3 text-gray-800 font-medium">
                                ₱{{ number_format($sale->grand_total ?? 0, 2) }}
                            </td>
                            <td class="px-6 py-3">
                                @php
                                    $statusColor = match($sale->status) {
                                        'completed' => 'bg-green-100 text-green-700',
                                        'reserved' => 'bg-amber-100 text-amber-700',
                                        'cancelled' => 'bg-red-100 text-red-700',
                                        default => 'bg-gray-100 text-gray-700',
                                    };
                                @endphp
                                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $statusColor }}">
                                    {{ ucfirst($sale->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-3">
                                <div class="flex items-center space-x-2">
                                    <!-- View button (opens transaction details modal) -->
                                    <button
                                        type="button"
                                        class="openViewBtn text-gray-600 hover:text-primary/90 transition-colors duration-200 p-1 rounded"
                                        data-sale-id="{{ $sale->id }}"
                                        aria-label="View Transaction"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                    </button>

                                    <!-- Receipt button (existing behavior) -->
                                    <button
                                        type="button"
                                        class="openReceiptBtn text-green-600 hover:text-green-900 transition-colors duration-200 p-1 rounded"
                                        data-sale-id="{{ $sale->id }}"
                                        aria-label="Open Receipt"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14M12 3v4" />
                                        </svg>
                                    </button>

                                    <!-- Void button -->
                                    @if($sale->status !== 'cancelled')
                                        <button type="button" class="text-red-600 hover:text-red-900 transition-colors duration-200 p-1 rounded voidBtn" data-sale-id="{{ $sale->id }}" aria-label="Void Transaction">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-6 text-gray-500">
                                No transactions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-end">
                @if (view()->exists('vendor.pagination.circular'))
                    {!! $sales->appends(request()->except('page'))->links('vendor.pagination.circular') !!}
                @else
                    {!! $sales->appends(request()->except('page'))->links() !!}
                @endif
            </div>
        </div>
    </div>

    <!-- View Transaction Modal -->
    <div id="viewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-10 mx-auto p-4 border w-full max-w-4xl shadow-2xl rounded-lg bg-white">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-4 border-b">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Transaction Details</h2>
                    <p class="text-sm text-gray-600 mt-1">Complete information about the transaction</p>
                </div>
                <button type="button" class="closeViewModalBtn text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="mt-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left Column - Transaction Info -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Transaction Overview -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Transaction Overview</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">Transaction ID</p>
                                    <p class="font-medium" id="viewTransactionId">#TRX-2023-00125</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Date & Time</p>
                                    <p class="font-medium" id="viewDateTime">Nov 15, 2023 10:30 AM</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Status</p>
                                    <span id="viewStatus" class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-800">Completed</span>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Payment Method</p>
                                    <p class="font-medium" id="viewPaymentMethod">GCash</p>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Information -->
                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Customer Information</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">Customer Name</p>
                                    <p class="font-medium" id="viewCustomerName">Maria Santos</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Contact Number</p>
                                    <p class="font-medium" id="viewCustomerPhone">+63 912 345 6789</p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-sm text-gray-600">Email Address</p>
                                    <p class="font-medium" id="viewCustomerEmail">maria.santos@email.com</p>
                                </div>
                            </div>
                        </div>

                        <!-- Items List -->
                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Items Purchased</h3>
                            <div class="space-y-3" id="viewItemsList">
                                <!-- Items will be dynamically inserted here -->
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Summary & Actions -->
                    <div class="space-y-6">
                        <!-- Payment Summary -->
                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Payment Summary</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Subtotal:</span>
                                    <span id="viewSubtotal">₱2,200.00</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">VAT (12%):</span>
                                    <span id="viewVat">₱264.00</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Discount:</span>
                                    <span id="viewDiscount">-₱14.00</span>
                                </div>
                                <div class="flex justify-between text-base font-bold border-t border-gray-300 pt-2">
                                    <span>TOTAL:</span>
                                    <span id="viewTotal">₱2,450.00</span>
                                </div>
                                <div class="flex justify-between text-sm pt-2">
                                    <span class="text-gray-600">Amount Paid:</span>
                                    <span class="font-medium" id="viewAmountPaid">₱2,500.00</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Change:</span>
                                    <span class="font-medium" id="viewChange">₱50.00</span>
                                </div>
                            </div>
                        </div>

                        <!-- Transaction Notes -->
                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Transaction Notes</h3>
                            <p class="text-sm text-gray-600" id="viewNotes">Customer requested electronic receipt via email. Items were properly packaged and handed over.</p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Actions</h3>
                            <div class="space-y-3">
                                <button class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Download Receipt
                                </button>
                                <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                    </svg>
                                    Send to Customer
                                </button>
                                <button id="voidTransactionBtn" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Void Transaction
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end gap-3 pt-6 mt-6 border-t">
                <button type="button" class="closeViewModalBtn px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                    Close
                </button>
                <button type="button" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-medium flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    View Full Receipt
                </button>
            </div>
        </div>
    </div>

    <!-- Void Transaction Confirmation Modal -->
    <div id="voidModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-8 border w-full max-w-md shadow-lg rounded-2xl bg-white">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-4 border-b">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Void Transaction</h2>
                    <p class="text-sm text-gray-600 mt-1">This action cannot be undone</p>
                </div>
                <button type="button" class="closeVoidModalBtn text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="mt-6">
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <span class="text-red-800 font-medium">Warning: This action is irreversible</span>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-700 mb-2">You are about to void transaction:</p>
                        <p class="font-medium text-lg text-gray-800" id="voidTransactionId">#TRX-2023-00125</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Voiding</label>
                        <select id="voidReason" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white">
                            <option value="">Select a reason</option>
                            <option value="incorrect_amount">Incorrect Amount Charged</option>
                            <option value="wrong_items">Wrong Items Scanned</option>
                            <option value="duplicate_transaction">Duplicate Transaction</option>
                            <option value="system_error">System Error</option>
                            <option value="customer_request">Customer Request</option>
                            <option value="other">Other Reason</option>
                        </select>
                    </div>

                    <div id="otherReasonContainer" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Please specify reason</label>
                        <textarea id="otherReason" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500" rows="3" placeholder="Enter specific reason for voiding..."></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Additional Notes (Optional)</label>
                        <textarea id="voidNotes" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500" rows="2" placeholder="Any additional information..."></textarea>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="confirmVoid" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                        <label for="confirmVoid" class="ml-2 block text-sm text-gray-700">
                            I understand this action cannot be undone and I have verified this is the correct transaction to void
                        </label>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end gap-3 pt-6 mt-6 border-t">
                <button type="button" class="closeVoidModalBtn px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                    Cancel
                </button>
                <button type="button" id="confirmVoidBtn" disabled
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium flex items-center disabled:bg-red-300 disabled:cursor-not-allowed">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Confirm Void
                </button>
            </div>
        </div>
    </div>

        <!-- Export Report Modal -->
    <div id="exportReportModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-8 border w-full max-w-md shadow-lg rounded-2xl bg-white">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-4 border-b">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Export Transaction Report</h2>
                    <p class="text-sm text-gray-600 mt-1">Select the date range and format for your report.</p>
                </div>
                <button type="button" class="closeExportModalBtn text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal Content -->
            <form id="exportForm" class="mt-6">
                <div class="space-y-5">
                    <!-- Date Range -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date Range</label>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Report Format -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Report Format</label>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="radio" name="format" id="pdf" value="pdf" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300" checked>
                                <label for="pdf" class="ml-2 block text-sm text-gray-700">PDF Document</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" name="format" id="excel" value="excel" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                <label for="excel" class="ml-2 block text-sm text-gray-700">Excel Spreadsheet</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" name="format" id="csv" value="csv" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                <label for="csv" class="ml-2 block text-sm text-gray-700">CSV File</label>
                            </div>
                        </div>
                    </div>

                    <!-- Include Details -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Include Details</label>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="checkbox" id="customerInfo" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded" checked>
                                <label for="customerInfo" class="ml-2 block text-sm text-gray-700">Customer Information</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="itemDetails" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded" checked>
                                <label for="itemDetails" class="ml-2 block text-sm text-gray-700">Item Details</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="paymentInfo" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                                <label for="paymentInfo" class="ml-2 block text-sm text-gray-700">Payment Information</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-end gap-3 pt-6 mt-6 border-t">
                    <button type="button" class="closeExportModalBtn px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export Report
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Receipt Modal -->
    <div id="receiptModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-10 mx-auto p-4 border w-full max-w-4xl shadow-2xl rounded-lg bg-white">
            <!-- Receipt Content -->
            <div class="bg-white p-8 rounded-lg">
                <!-- Receipt Header -->
                <div class="text-center border-b border-gray-300 pb-6 mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">BZ It Solutions</h2>
                    <p class="text-sm text-gray-600">123 Business Street, City, Philippines 1000</p>
                    <p class="text-sm text-gray-600">Phone: (02) 8123-4567 | Email: bzitsolutions@gmail.com</p>
                    <p class="text-xs text-gray-500 mt-2">VAT Reg TIN: 123-456-789-000</p>
                </div>

                <!-- Transaction Details -->
                <div class="grid grid-cols-2 gap-8 mb-6">
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600 font-medium">Receipt No:</span>
                            <span class="font-bold" id="receiptTransactionId">#TRX-2023-00125</span>
                        </div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600 font-medium">Date:</span>
                            <span class="font-medium" id="receiptDate">Nov 15, 2023 10:30 AM</span>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600 font-medium">Cashier:</span>
                            <span class="font-medium" id="receiptCashier">Maria Santos</span>
                        </div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600 font-medium">Customer:</span>
                            <span class="font-medium" id="receiptCustomer">Maria Santos</span>
                        </div>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="mb-6">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b-2 border-gray-300">
                                <th class="text-left pb-3 font-semibold text-gray-700">Serial No.</th>
                                <th class="text-left pb-3 font-semibold text-gray-700">Item Description</th>
                                <th class="text-right pb-3 font-semibold text-gray-700">Qty</th>
                                <th class="text-right pb-3 font-semibold text-gray-700">Unit Price</th>
                                <th class="text-right pb-3 font-semibold text-gray-700">Total</th>
                            </tr>
                        </thead>
                        <tbody id="receiptItems">
                            <!-- Items will be dynamically inserted here -->
                        </tbody>
                    </table>
                </div>

                <!-- Totals Section -->
                <div class="grid grid-cols-2 gap-8">
                    <div>
                        <!-- Payment Details -->
                        <div class="border-t border-gray-300 pt-4">
                            <h4 class="font-semibold text-gray-800 mb-3">Payment Details</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Payment Method:</span>
                                    <span class="font-medium" id="receiptPaymentMethod">GCash</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Amount Paid:</span>
                                    <span class="font-medium" id="receiptAmountPaid">₱2,500.00</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Change:</span>
                                    <span class="font-medium" id="receiptChange">₱50.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <!-- Summary -->
                        <div class="border-t border-gray-300 pt-4">
                            <h4 class="font-semibold text-gray-800 mb-3">Summary</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Subtotal:</span>
                                    <span id="receiptSubtotal">₱2,200.00</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">VAT (12%):</span>
                                    <span id="receiptVat">₱264.00</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Discount:</span>
                                    <span id="receiptDiscount">-₱14.00</span>
                                </div>
                                <div class="flex justify-between text-base font-bold border-t border-gray-300 pt-2 mt-2">
                                    <span class="text-gray-800">TOTAL:</span>
                                    <span id="receiptTotal" class="text-green-600">₱2,450.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center border-t border-gray-300 pt-6 mt-6">
                    <p class="text-sm text-gray-600 mb-2">Thank you for your purchase!</p>
                    <p class="text-xs text-gray-500">Items can be exchanged within 7 days with original receipt</p>
                    <p class="text-xs text-gray-500 mt-2">*** THIS IS NOT AN OFFICIAL RECEIPT ***</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-center gap-4 mt-8 pt-6 border-t border-gray-200">
                <button type="button" class="closeReceiptModalBtn px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                    Close
                </button>
                <button type="button" id="printReceiptBtn" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print Receipt
                </button>
                <button type="button" id="downloadReceiptBtn" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Download PDF
                </button>
            </div>
        </div>
    </div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const openButtons = document.querySelectorAll('.openReceiptBtn');
    const modalWrap = document.getElementById('receiptModal');
    const closeBtns = document.querySelectorAll('.closeReceiptModalBtn');

    // modal elements
    const elTransactionId = document.getElementById('receiptTransactionId');
    const elDate = document.getElementById('receiptDate');
    const elCashier = document.getElementById('receiptCashier');
    const elCustomer = document.getElementById('receiptCustomer');
    const elItems = document.getElementById('receiptItems');
    const elPaymentMethod = document.getElementById('receiptPaymentMethod');
    const elAmountPaid = document.getElementById('receiptAmountPaid');
    const elChange = document.getElementById('receiptChange');
    const elSubtotal = document.getElementById('receiptSubtotal');
    const elVat = document.getElementById('receiptVat');
    const elDiscount = document.getElementById('receiptDiscount');
    const elTotal = document.getElementById('receiptTotal');

    function formatCurrency(value) {
        // Philippine peso formatting
        return new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format(value);
    }

    function formatDate(dateString) {
        if (!dateString) return '—';
        const d = new Date(dateString);
        // e.g., Nov 15, 2023 10:30 AM
        return d.toLocaleString('en-PH', {
            year: 'numeric', month: 'short', day: '2-digit',
            hour: 'numeric', minute: '2-digit', hour12: true
        });
    }

    async function fetchSaleJson(saleId) {
        try {
            const res = await fetch(`/sales/${saleId}/json`, {
                headers: { 'Accept': 'application/json' },
                credentials: 'same-origin'
            });
            if (!res.ok) {
                const txt = await res.text();
                throw new Error(txt || 'Failed to fetch sale');
            }
            return await res.json();
        } catch (err) {
            showToast('Unable to load receipt. See console for details.');
            return null;
        }
    }

    function openModal() {
        modalWrap.classList.remove('hidden');
    }
    function closeModal() {
        modalWrap.classList.add('hidden');
    }

    openButtons.forEach(btn => {
        btn.addEventListener('click', async (ev) => {
            ev.preventDefault();
            const saleId = btn.dataset.saleId;
            if (!saleId) return;

            const data = await fetchSaleJson(saleId);
            if (!data || !data.success) return;

            const sale = data.sale;

            // header
            elTransactionId.textContent = sale.sales_number ? `#${sale.sales_number}` : `#${sale.id}`;
            elDate.textContent = formatDate(sale.sold_at ?? new Date().toISOString());
            elCashier.textContent = sale.cashier ?? '—';
            elCustomer.textContent = sale.customer ?? 'Walk-in';

            // items
            elItems.innerHTML = '';
            (sale.items || []).forEach(item => {
                const tr = document.createElement('tr');
                tr.className = '';

                // Serial column: join serials with <br> if present
                const serialTd = document.createElement('td');
                serialTd.className = 'py-2';
                serialTd.innerHTML = (item.serials && item.serials.length) ? item.serials.join('<br>') : '—';

                const descTd = document.createElement('td');
                descTd.className = 'py-2';
                descTd.textContent = item.product_name;

                const qtyTd = document.createElement('td');
                qtyTd.className = 'py-2 text-right';
                qtyTd.textContent = item.qty;

                const unitTd = document.createElement('td');
                unitTd.className = 'py-2 text-right';
                unitTd.textContent = formatCurrency(item.unit_price);

                const totalTd = document.createElement('td');
                totalTd.className = 'py-2 text-right';
                totalTd.textContent = formatCurrency(item.line_total);

                tr.appendChild(serialTd);
                tr.appendChild(descTd);
                tr.appendChild(qtyTd);
                tr.appendChild(unitTd);
                tr.appendChild(totalTd);

                elItems.appendChild(tr);
            });

            // payment
            elPaymentMethod.textContent = (sale.payment_method || '—').toUpperCase();
            elAmountPaid.textContent = formatCurrency(sale.amount_paid || 0);
            elChange.textContent = formatCurrency(sale.change || 0);

            // summary
            elSubtotal.textContent = formatCurrency(sale.subtotal || 0);
            elVat.textContent = formatCurrency(sale.vat || 0);
            elDiscount.textContent = (sale.discount && sale.discount > 0) ? `-${formatCurrency(sale.discount)}` : formatCurrency(0);
            elTotal.textContent = formatCurrency(sale.grand_total || 0);

            openModal();
        });
    });

    closeBtns.forEach(b => b.addEventListener('click', (e) => {
        e.preventDefault();
        closeModal();
    }));

    // Close modal when clicking outside content area
    modalWrap.addEventListener('click', function (e) {
        if (e.target === modalWrap) closeModal();
    });

    // Print and Download
    document.getElementById('printReceiptBtn')?.addEventListener('click', function () {
        // Create a printable window with receipt content
        const receiptContent = document.querySelector('#receiptModal > div > .bg-white')?.outerHTML || document.querySelector('#receiptModal')?.outerHTML;
        const w = window.open('', '_blank', 'width=800,height=900');
        if (!w) { alert('Unable to open print window. Allow popups or use browser print shortcut.'); return; }

        w.document.write(`
            <html>
            <head>
                <title>Receipt</title>
                <meta name="viewport" content="width=device-width,initial-scale=1" />
                <style>
                    /* Basic styles for printing - adjust if you need your Tailwind compiled print styles */
                    body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial; padding: 20px; color: #111; }
                    table { width: 100%; border-collapse: collapse; }
                    td, th { padding: 6px; vertical-align: top; }
                    .text-right { text-align: right; }
                    .border-top { border-top: 1px solid #ddd; margin-top: 8px; padding-top: 8px; }
                </style>
            </head>
            <body>
                ${receiptContent}
            </body>
            </html>
        `);
        w.document.close();
        w.focus();

        // Wait a tick then print
        setTimeout(() => { w.print(); }, 250);
    });

    document.getElementById('downloadReceiptBtn')?.addEventListener('click', function () {
        // Use the same print dialog (user can save as PDF) - or implement html2pdf if you want
        document.getElementById('printReceiptBtn')?.click();
    });

    // --- Additional UI wiring: View modal, Reset button, Void modal handlers ---
    const viewModalEl = document.getElementById('viewModal');
    const openViewBtns = document.querySelectorAll('.openViewBtn');
    const closeViewBtns = document.querySelectorAll('.closeViewModalBtn');

    // View modal elements
    const vTransactionId = document.getElementById('viewTransactionId');
    const vDate = document.getElementById('viewDateTime');
    const vStatus = document.getElementById('viewStatus');
    const vPaymentMethod = document.getElementById('viewPaymentMethod');
    const vCustomerName = document.getElementById('viewCustomerName');
    const vCustomerPhone = document.getElementById('viewCustomerPhone');
    const vCustomerEmail = document.getElementById('viewCustomerEmail');
    const vItemsList = document.getElementById('viewItemsList');
    const vSubtotal = document.getElementById('viewSubtotal');
    const vVat = document.getElementById('viewVat');
    const vDiscount = document.getElementById('viewDiscount');
    const vTotal = document.getElementById('viewTotal');
    const vAmountPaid = document.getElementById('viewAmountPaid');
    const vChange = document.getElementById('viewChange');
    const vNotes = document.getElementById('viewNotes');

    function openViewModal() { viewModalEl.classList.remove('hidden'); }
    function closeViewModal() { viewModalEl.classList.add('hidden'); }

    openViewBtns.forEach(b => {
        b.addEventListener('click', async (ev) => {
            ev.preventDefault();
            const saleId = b.dataset.saleId;
            if (!saleId) return;
            const data = await fetchSaleJson(saleId);
            if (!data || !data.success) return;
            const sale = data.sale;

            vTransactionId.textContent = sale.sales_number ? `#${sale.sales_number}` : `#${sale.id}`;
            vDate.textContent = formatDate(sale.sold_at ?? new Date().toISOString());
            vStatus.textContent = (sale.status || '').toString().replace(/^(.)/, s => s.toUpperCase());
            vPaymentMethod.textContent = (sale.payment_method || '—').toUpperCase();
            vCustomerName.textContent = sale.customer ?? 'Walk-in';
            vCustomerPhone.textContent = sale.customer_phone ?? '—';
            vCustomerEmail.textContent = sale.customer_email ?? '—';

            // Items list (simple list with name and qty)
            vItemsList.innerHTML = '';
            (sale.items || []).forEach(it => {
                const el = document.createElement('div');
                el.className = 'flex items-center justify-between';
                el.innerHTML = `<div class="text-sm text-gray-700">${it.product_name}</div><div class="text-sm font-medium text-gray-800">${it.qty}×</div>`;
                vItemsList.appendChild(el);
            });

            vSubtotal.textContent = formatCurrency(sale.subtotal || 0);
            vVat.textContent = formatCurrency(sale.vat || 0);
            vDiscount.textContent = (sale.discount && sale.discount > 0) ? `-${formatCurrency(sale.discount)}` : formatCurrency(0);
            vTotal.textContent = formatCurrency(sale.grand_total || 0);
            vAmountPaid.textContent = formatCurrency(sale.amount_paid || 0);
            vChange.textContent = formatCurrency(sale.change || 0);
            vNotes.textContent = sale.notes ?? '';

            openViewModal();
        });
    });

    closeViewBtns.forEach(b => b.addEventListener('click', (e) => { e.preventDefault(); closeViewModal(); }));
    // close when clicking outside
    viewModalEl?.addEventListener('click', function (e) { if (e.target === viewModalEl) closeViewModal(); });

    // Reset button behavior: redirect to base path with per_page=5
    document.getElementById('resetFilters')?.addEventListener('click', function () {
        const base = window.location.pathname;
        const perPage = 5;
        window.location.href = `${base}?per_page=${perPage}`;
    });

    // Void modal wiring: open/close and confirm enable
    const voidModal = document.getElementById('voidModal');
    const voidButtons = document.querySelectorAll('.voidBtn');
    const closeVoidBtns = document.querySelectorAll('.closeVoidModalBtn');
    const voidTransactionIdEl = document.getElementById('voidTransactionId');
    const confirmVoidCheckbox = document.getElementById('confirmVoid');
    const confirmVoidBtn = document.getElementById('confirmVoidBtn');

    voidButtons.forEach(b => b.addEventListener('click', function () {
        const id = b.dataset.saleId;
        if (!id) return;
        voidTransactionIdEl.textContent = id;
        voidModal.classList.remove('hidden');
    }));

    closeVoidBtns.forEach(b => b.addEventListener('click', function (e) { e.preventDefault(); voidModal.classList.add('hidden'); }));

    if (confirmVoidCheckbox && confirmVoidBtn) {
        confirmVoidCheckbox.addEventListener('change', function () {
            confirmVoidBtn.disabled = !this.checked;
        });
    }
});
</script>
@endpush
@endsection