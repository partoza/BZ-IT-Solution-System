@extends('layout.sidebarmenu')

@section('pages-content')
    <!-- Stats Section -->
    <div class="grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2 gap-5 mb-8">
        <!-- Total Transactions Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Total Transactions</h2>
            <div class="flex items-end justify-between">
                <div>
                    <h3 class="text-2xl font-semibold text-gray-900">1,247</h3>
                    <div class="mt-1 space-y-0.5">
                        <div class="flex items-center text-xs text-green-600">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            78% Completed
                        </div>
                        <div class="flex items-center text-xs text-red-600">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            22% Cancelled
                        </div>
                    </div>
                </div>
                <p class="text-xs text-gray-500">Last 30 Days</p>
            </div>
        </div>

        <!-- Total Revenue Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Total Revenue</h2>
            <h3 class="text-2xl font-semibold text-gray-900">₱124,580</h3>
            <p class="text-sm text-gray-500 mt-1">Last 30 Days</p>
        </div>

        <!-- Average Transaction Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Average Transaction</h2>
            <h3 class="text-2xl font-semibold text-gray-900">₱1,250</h3>
            <p class="text-sm text-gray-500 mt-1">Per Transaction</p>
        </div>

        <!-- Pending Transactions Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Pending Transactions</h2>
            <h3 class="text-2xl font-semibold text-gray-900">18</h3>
            <p class="text-sm text-gray-500 mt-1">Awaiting Processing</p>
        </div>
    </div>

    <!-- Transaction Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
        <!-- Transaction List Header -->
        <div class="bg-white shadow-sm p-5 mb-2">
            <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-3">
                <h2 class="text-lg font-semibold text-gray-800">Transaction History</h2>
                
                <div class="flex flex-col xl:flex-row gap-3 w-full xl:w-auto">
                    <!-- Search Input -->
                    <div class="relative flex-1 xl:w-72">
                        <input 
                            type="text" 
                            placeholder="Search Transaction ID or Customer ..." 
                            class="w-full pl-9 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:text-gray-400"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Date Range Filter -->
                    <div class="flex items-center border border-gray-300 rounded-lg px-3">
                        <svg class="h-4 w-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <input type="text" placeholder="Date Range" class="py-2.5 text-sm bg-transparent focus:outline-none w-40">
                    </div>

                    <!-- Status Filter -->
                    <select class="px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <option>All Status</option>
                        <option>Completed</option>
                        <option>Pending</option>
                        <option>Cancelled</option>
                        <option>Voided</option>
                        <option>Refunded</option>
                    </select>

                    <!-- Payment Method Filter -->
                    <select class="px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <option>All Payment Methods</option>
                        <option>Cash</option>
                        <option>Credit Card</option>
                        <option>Debit Card</option>
                        <option>GCash</option>
                        <option>PayMaya</option>
                    </select>

                    <!-- Export Report Button -->
                    <button id="exportReportBtn" class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium flex items-center justify-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export Report
                    </button>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Transaction ID</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Date & Time</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Customer</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Items</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Payment Method</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Amount</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Status</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    <!-- Sample Transaction 1 -->
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-3 text-gray-800 font-medium">#TRX-2023-00125</td>
                        <td class="px-6 py-3 text-gray-600">Nov 15, 2023 10:30 AM</td>
                        <td class="px-6 py-3 text-gray-600">Maria Santos</td>
                        <td class="px-6 py-3 text-gray-600">3 items</td>
                        <td class="px-6 py-3 text-gray-600">GCash</td>
                        <td class="px-6 py-3 text-gray-600 font-medium">₱2,450</td>
                        <td class="px-6 py-3">
                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-800">Completed</span>
                        </td>
                        <td class="px-6 py-3">
                            <div class="flex space-x-2">
                                <button class="viewBtn text-indigo-600 hover:text-indigo-900 text-sm font-medium" data-transaction-id="TRX-2023-00125">View</button>
                                <button class="receiptBtn text-green-600 hover:text-green-900 text-sm font-medium" data-transaction-id="TRX-2023-00125">Receipt</button>
                                <button class="voidBtn text-red-600 hover:text-red-900 text-sm font-medium" data-transaction-id="TRX-2023-00125">Void</button>
                            </div>
                        </td>
                    </tr>

                    <!-- Sample Voided Transaction -->
                    <tr class="hover:bg-gray-50 transition-colors bg-red-50">
                        <td class="px-6 py-3 text-gray-800 font-medium">#TRX-2023-00124</td>
                        <td class="px-6 py-3 text-gray-600">Nov 15, 2023 09:15 AM</td>
                        <td class="px-6 py-3 text-gray-600">Carlos Rodriguez</td>
                        <td class="px-6 py-3 text-gray-600">1 item</td>
                        <td class="px-6 py-3 text-gray-600">Cash</td>
                        <td class="px-6 py-3 text-gray-600 font-medium line-through">₱890</td>
                        <td class="px-6 py-3">
                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-red-100 text-red-800">Voided</span>
                        </td>
                        <td class="px-6 py-3">
                            <div class="flex space-x-2">
                                <button class="viewBtn text-indigo-600 hover:text-indigo-900 text-sm font-medium" data-transaction-id="TRX-2023-00124">View</button>
                                <button class="receiptBtn text-green-600 hover:text-green-900 text-sm font-medium" data-transaction-id="TRX-2023-00124">Receipt</button>
                                <button class="text-gray-400 text-sm font-medium cursor-not-allowed" disabled>Voided</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Showing <span class="font-medium">1</span> to <span class="font-medium">4</span> of <span class="font-medium">1,247</span> results
                </div>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 text-sm border border-gray-300 rounded-lg hover:bg-gray-50">Previous</button>
                    <button class="px-3 py-1 text-sm bg-green-600 text-white rounded-lg">1</button>
                    <button class="px-3 py-1 text-sm border border-gray-300 rounded-lg hover:bg-gray-50">2</button>
                    <button class="px-3 py-1 text-sm border border-gray-300 rounded-lg hover:bg-gray-50">3</button>
                    <button class="px-3 py-1 text-sm border border-gray-300 rounded-lg hover:bg-gray-50">Next</button>
                </div>
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
        <div class="relative top-10 mx-auto p-4 border w-full max-w-md shadow-2xl rounded-lg bg-white">
            <!-- Receipt Content -->
            <div class="bg-white p-6 rounded-lg">
                <!-- Receipt Header -->
                <div class="text-center border-b border-gray-300 pb-4 mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Your Store Name</h2>
                    <p class="text-sm text-gray-600">123 Business Street, City</p>
                    <p class="text-sm text-gray-600">Phone: (02) 8123-4567</p>
                    <p class="text-xs text-gray-500 mt-1">VAT Reg TIN: 123-456-789-000</p>
                </div>

                <!-- Transaction Details -->
                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600">Receipt No:</span>
                        <span class="font-medium" id="receiptTransactionId">#TRX-2023-00125</span>
                    </div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600">Date:</span>
                        <span class="font-medium" id="receiptDate">Nov 15, 2023 10:30 AM</span>
                    </div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600">Cashier:</span>
                        <span class="font-medium" id="receiptCashier">Maria Santos</span>
                    </div>
                </div>

                <!-- Items List -->
                <div class="border-y border-gray-300 py-3 mb-4">
                    <div class="flex justify-between text-sm font-medium mb-2">
                        <span>Item</span>
                        <span>Amount</span>
                    </div>
                    
                    <div class="space-y-2" id="receiptItems">
                        <!-- Items will be dynamically inserted here -->
                    </div>
                </div>

                <!-- Totals -->
                <div class="mb-4 space-y-2">
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
                        <span>TOTAL:</span>
                        <span id="receiptTotal">₱2,450.00</span>
                    </div>
                </div>

                <!-- Payment Details -->
                <div class="border-t border-gray-300 pt-3 mb-4">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Payment Method:</span>
                        <span class="font-medium" id="receiptPaymentMethod">GCash</span>
                    </div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Amount Paid:</span>
                        <span class="font-medium" id="receiptAmountPaid">₱2,500.00</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Change:</span>
                        <span class="font-medium" id="receiptChange">₱50.00</span>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center border-t border-gray-300 pt-4">
                    <p class="text-xs text-gray-500 mb-2">Thank you for your purchase!</p>
                    <p class="text-xs text-gray-500">Items can be exchanged within 7 days with original receipt</p>
                    <p class="text-xs text-gray-500 mt-2">*** THIS IS NOT AN OFFICIAL RECEIPT ***</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-center gap-3 mt-6 pt-4 border-t border-gray-200">
                <button type="button" class="closeReceiptModalBtn px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium text-sm">
                    Close
                </button>
                <button type="button" id="printReceiptBtn" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium text-sm flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print Receipt
                </button>
            </div>
        </div>
    </div>
@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Export Modal Functionality
    const exportModal = document.getElementById('exportReportModal');
    const exportForm = document.getElementById('exportForm');
    const exportBtn = document.getElementById('exportReportBtn');
    const closeExportBtns = exportModal.querySelectorAll('.closeExportModalBtn');

    // View Modal Functionality
    const viewModal = document.getElementById('viewModal');
    const closeViewBtns = viewModal.querySelectorAll('.closeViewModalBtn');
    const viewBtns = document.querySelectorAll('.viewBtn');
    const voidTransactionBtn = document.getElementById('voidTransactionBtn');

    // Void Modal Functionality
    const voidModal = document.getElementById('voidModal');
    const closeVoidBtns = voidModal.querySelectorAll('.closeVoidModalBtn');
    const voidBtns = document.querySelectorAll('.voidBtn');
    const confirmVoidBtn = document.getElementById('confirmVoidBtn');
    const confirmVoidCheckbox = document.getElementById('confirmVoid');
    const voidReasonSelect = document.getElementById('voidReason');
    const otherReasonContainer = document.getElementById('otherReasonContainer');
    const otherReasonTextarea = document.getElementById('otherReason');

    // Receipt Modal Functionality
    const receiptModal = document.getElementById('receiptModal');
    const closeReceiptBtns = receiptModal.querySelectorAll('.closeReceiptModalBtn');
    const printReceiptBtn = document.getElementById('printReceiptBtn');
    const receiptBtns = document.querySelectorAll('.receiptBtn');

    // Sample transaction data
    const transactionData = {
        'TRX-2023-00125': {
            transactionId: 'TRX-2023-00125',
            date: 'Nov 15, 2023 10:30 AM',
            customerName: 'Maria Santos',
            customerPhone: '+63 912 345 6789',
            customerEmail: 'maria.santos@email.com',
            items: [
                { name: 'Wireless Bluetooth Headphones', price: 1200.00, quantity: 1 },
                { name: 'Phone Case - Premium', price: 850.00, quantity: 1 },
                { name: 'Screen Protector', price: 150.00, quantity: 1 }
            ],
            subtotal: 2200.00,
            vat: 264.00,
            discount: 14.00,
            total: 2450.00,
            paymentMethod: 'GCash',
            amountPaid: 2500.00,
            change: 50.00,
            status: 'Completed',
            notes: 'Customer requested electronic receipt via email. Items were properly packaged and handed over.'
        },
        'TRX-2023-00126': {
            transactionId: 'TRX-2023-00126',
            date: 'Nov 15, 2023 11:15 AM',
            customerName: 'Juan Dela Cruz',
            customerPhone: '+63 917 654 3210',
            customerEmail: 'juan.delacruz@email.com',
            items: [
                { name: 'Smartphone XYZ Model', price: 2500.00, quantity: 1 },
                { name: 'Wireless Charger', price: 980.00, quantity: 1 },
                { name: 'USB-C Cable', price: 300.00, quantity: 2 }
            ],
            subtotal: 3780.00,
            vat: 453.60,
            discount: 0.00,
            total: 3780.00,
            paymentMethod: 'Cash',
            amountPaid: 4000.00,
            change: 220.00,
            status: 'Pending',
            notes: 'Customer will pick up items tomorrow. Payment received in full.'
        },
        'TRX-2023-00127': {
            transactionId: 'TRX-2023-00127',
            date: 'Nov 14, 2023 02:45 PM',
            customerName: 'Ana Reyes',
            customerPhone: '+63 918 765 4321',
            customerEmail: 'ana.reyes@email.com',
            items: [
                { name: 'Laptop Sleeve', price: 750.00, quantity: 1 },
                { name: 'Mouse Pad - Large', price: 500.00, quantity: 1 }
            ],
            subtotal: 1250.00,
            vat: 150.00,
            discount: 0.00,
            total: 1250.00,
            paymentMethod: 'Credit Card',
            amountPaid: 1250.00,
            change: 0.00,
            status: 'Completed',
            notes: 'Regular customer. Items delivered to shipping address.'
        },
        'TRX-2023-00124': {
            transactionId: 'TRX-2023-00124',
            date: 'Nov 15, 2023 09:15 AM',
            customerName: 'Carlos Rodriguez',
            customerPhone: '+63 920 123 4567',
            customerEmail: 'carlos.rodriguez@email.com',
            items: [
                { name: 'Power Bank 10000mAh', price: 890.00, quantity: 1 }
            ],
            subtotal: 890.00,
            vat: 106.80,
            discount: 0.00,
            total: 890.00,
            paymentMethod: 'Cash',
            amountPaid: 1000.00,
            change: 110.00,
            status: 'Voided',
            notes: 'Transaction voided due to incorrect item scanning. Customer was charged for wrong product.',
            voidReason: 'incorrect_amount',
            voidNotes: 'Scanned wrong product barcode. Correct product should have been Power Bank 20000mAh.'
        }
    };

    let currentTransactionId = null;

    // Export Modal Functions
    function openExportModal() {
        exportModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeExportModal() {
        exportModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // View Modal Functions
    function openViewModal(transactionId) {
        const data = transactionData[transactionId];
        if (data) {
            currentTransactionId = transactionId;
            
            // Populate view modal data
            document.getElementById('viewTransactionId').textContent = `#${data.transactionId}`;
            document.getElementById('viewDateTime').textContent = data.date;
            document.getElementById('viewCustomerName').textContent = data.customerName;
            document.getElementById('viewCustomerPhone').textContent = data.customerPhone;
            document.getElementById('viewCustomerEmail').textContent = data.customerEmail;
            document.getElementById('viewPaymentMethod').textContent = data.paymentMethod;
            document.getElementById('viewSubtotal').textContent = `₱${data.subtotal.toFixed(2)}`;
            document.getElementById('viewVat').textContent = `₱${data.vat.toFixed(2)}`;
            document.getElementById('viewDiscount').textContent = data.discount > 0 ? `-₱${data.discount.toFixed(2)}` : '₱0.00';
            document.getElementById('viewTotal').textContent = `₱${data.total.toFixed(2)}`;
            document.getElementById('viewAmountPaid').textContent = `₱${data.amountPaid.toFixed(2)}`;
            document.getElementById('viewChange').textContent = `₱${data.change.toFixed(2)}`;
            document.getElementById('viewNotes').textContent = data.notes;

            // Update status badge
            const statusElement = document.getElementById('viewStatus');
            statusElement.textContent = data.status;
            statusElement.className = 'px-2.5 py-0.5 text-xs font-medium rounded-full ' + 
                (data.status === 'Completed' ? 'bg-green-100 text-green-800' :
                 data.status === 'Pending' ? 'bg-yellow-100 text-yellow-800' :
                 data.status === 'Voided' ? 'bg-red-100 text-red-800' :
                 data.status === 'Cancelled' ? 'bg-red-100 text-red-800' :
                 'bg-blue-100 text-blue-800');

            // Show/hide void button based on status
            if (data.status === 'Voided' || data.status === 'Cancelled') {
                voidTransactionBtn.classList.add('hidden');
            } else {
                voidTransactionBtn.classList.remove('hidden');
            }

            // Populate items list
            const itemsContainer = document.getElementById('viewItemsList');
            itemsContainer.innerHTML = '';
            data.items.forEach(item => {
                const itemElement = document.createElement('div');
                itemElement.className = 'flex justify-between items-center border-b border-gray-100 pb-2';
                itemElement.innerHTML = `
                    <div>
                        <p class="font-medium text-gray-800">${item.name}</p>
                        <p class="text-sm text-gray-600">Qty: ${item.quantity}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-gray-800">₱${(item.price * item.quantity).toFixed(2)}</p>
                        <p class="text-sm text-gray-600">₱${item.price.toFixed(2)} each</p>
                    </div>
                `;
                itemsContainer.appendChild(itemElement);
            });

            viewModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeViewModal() {
        viewModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        currentTransactionId = null;
    }

    // Void Modal Functions
    function openVoidModal(transactionId) {
        currentTransactionId = transactionId;
        const data = transactionData[transactionId];
        
        if (data) {
            document.getElementById('voidTransactionId').textContent = `#${data.transactionId}`;
            
            // Reset form
            voidReasonSelect.value = '';
            otherReasonContainer.classList.add('hidden');
            otherReasonTextarea.value = '';
            document.getElementById('voidNotes').value = '';
            confirmVoidCheckbox.checked = false;
            confirmVoidBtn.disabled = true;
            
            voidModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeVoidModal() {
        voidModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        currentTransactionId = null;
    }

    function confirmVoidTransaction() {
        const reason = voidReasonSelect.value;
        const otherReason = otherReasonTextarea.value;
        const notes = document.getElementById('voidNotes').value;
        
        if (!reason) {
            showToast('Please select a reason for voiding the transaction.', 'error');
            return;
        }

        if (reason === 'other' && !otherReason.trim()) {
            showToast('Please specify the reason for voiding.', 'error');
            return;
        }

        // Update transaction status to voided
        if (transactionData[currentTransactionId]) {
            transactionData[currentTransactionId].status = 'Voided';
            transactionData[currentTransactionId].voidReason = reason;
            transactionData[currentTransactionId].voidNotes = reason === 'other' ? otherReason : notes;
            
            // Update UI
            updateTransactionUI(currentTransactionId);
            
            showToast('Transaction has been successfully voided.', 'success');
            closeVoidModal();
            closeViewModal();
        }
    }

    function updateTransactionUI(transactionId) {
        // Update the table row for the voided transaction
        const data = transactionData[transactionId];
        if (data) {
            // This would typically update the DOM, but for this example, we'll just reload the page
            // In a real application, you would update the specific row via JavaScript
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        }
    }

    // Receipt Modal Functions
    function openReceiptModal(transactionId) {
        const data = transactionData[transactionId];
        if (data) {
            // Populate receipt data
            document.getElementById('receiptTransactionId').textContent = `#${data.transactionId}`;
            document.getElementById('receiptDate').textContent = data.date;
            document.getElementById('receiptCashier').textContent = data.customerName;
            document.getElementById('receiptSubtotal').textContent = `₱${data.subtotal.toFixed(2)}`;
            document.getElementById('receiptVat').textContent = `₱${data.vat.toFixed(2)}`;
            document.getElementById('receiptDiscount').textContent = data.discount > 0 ? `-₱${data.discount.toFixed(2)}` : '₱0.00';
            document.getElementById('receiptTotal').textContent = `₱${data.total.toFixed(2)}`;
            document.getElementById('receiptPaymentMethod').textContent = data.paymentMethod;
            document.getElementById('receiptAmountPaid').textContent = `₱${data.amountPaid.toFixed(2)}`;
            document.getElementById('receiptChange').textContent = `₱${data.change.toFixed(2)}`;

            // Populate items
            const itemsContainer = document.getElementById('receiptItems');
            itemsContainer.innerHTML = '';
            data.items.forEach(item => {
                const itemElement = document.createElement('div');
                itemElement.className = 'flex justify-between text-sm';
                itemElement.innerHTML = `
                    <span>${item.name} (${item.quantity}x)</span>
                    <span>₱${(item.price * item.quantity).toFixed(2)}</span>
                `;
                itemsContainer.appendChild(itemElement);
            });

            receiptModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeReceiptModal() {
        receiptModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Print receipt function
    function printReceipt() {
        const receiptContent = receiptModal.querySelector('.bg-white.p-6').cloneNode(true);
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Receipt - ${document.getElementById('receiptTransactionId').textContent}</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    .text-center { text-align: center; }
                    .border-b { border-bottom: 1px solid #000; }
                    .border-t { border-top: 1px solid #000; }
                    .border-y { border-top: 1px solid #000; border-bottom: 1px solid #000; }
                    .flex { display: flex; }
                    .justify-between { justify-content: space-between; }
                    .font-bold { font-weight: bold; }
                    .text-sm { font-size: 12px; }
                    .text-xs { font-size: 10px; }
                    .mb-2 { margin-bottom: 8px; }
                    .mb-4 { margin-bottom: 16px; }
                    .mt-2 { margin-top: 8px; }
                    .py-3 { padding-top: 12px; padding-bottom: 12px; }
                    .pb-4 { padding-bottom: 16px; }
                    .pt-4 { padding-top: 16px; }
                    .space-y-2 > * + * { margin-top: 8px; }
                </style>
            </head>
            <body>
                ${receiptContent.outerHTML}
                <script>
                    window.onload = function() {
                        window.print();
                        setTimeout(function() {
                            window.close();
                        }, 500);
                    }
                <\/script>
            </body>
            </html>
        `);
        printWindow.document.close();
    }

    // Event Listeners
    exportBtn.addEventListener('click', openExportModal);
    closeExportBtns.forEach(btn => btn.addEventListener('click', closeExportModal));
    exportModal.addEventListener('click', function(e) {
        if (e.target === exportModal) closeExportModal();
    });

    closeViewBtns.forEach(btn => btn.addEventListener('click', closeViewModal));
    viewModal.addEventListener('click', function(e) {
        if (e.target === viewModal) closeViewModal();
    });

    viewBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const transactionId = this.getAttribute('data-transaction-id');
            openViewModal(transactionId);
        });
    });

    // Void transaction from view modal
    voidTransactionBtn.addEventListener('click', function() {
        if (currentTransactionId) {
            openVoidModal(currentTransactionId);
        }
    });

    // Void transaction from table
    voidBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const transactionId = this.getAttribute('data-transaction-id');
            openVoidModal(transactionId);
        });
    });

    closeVoidBtns.forEach(btn => btn.addEventListener('click', closeVoidModal));
    voidModal.addEventListener('click', function(e) {
        if (e.target === voidModal) closeVoidModal();
    });

    // Void confirmation logic
    confirmVoidCheckbox.addEventListener('change', function() {
        confirmVoidBtn.disabled = !this.checked;
    });

    voidReasonSelect.addEventListener('change', function() {
        if (this.value === 'other') {
            otherReasonContainer.classList.remove('hidden');
        } else {
            otherReasonContainer.classList.add('hidden');
        }
    });

    confirmVoidBtn.addEventListener('click', confirmVoidTransaction);

    closeReceiptBtns.forEach(btn => btn.addEventListener('click', closeReceiptModal));
    receiptModal.addEventListener('click', function(e) {
        if (e.target === receiptModal) closeReceiptModal();
    });

    printReceiptBtn.addEventListener('click', printReceipt);

    receiptBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const transactionId = this.getAttribute('data-transaction-id');
            openReceiptModal(transactionId);
        });
    });

    // Export form submission
    exportForm.addEventListener('submit', function(e) {
        e.preventDefault();
        showToast('Your report is being generated. You will receive it shortly.', 'success');
        closeExportModal();
    });

    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeExportModal();
            closeViewModal();
            closeVoidModal();
            closeReceiptModal();
        }
    });

    // Toast function
    function showToast(message, type = 'success') {
        let toastContainer = document.getElementById("toast-container");
        if (!toastContainer) {
            toastContainer = document.createElement("div");
            toastContainer.id = "toast-container";
            toastContainer.className = "fixed top-20 left-1/2 transform -translate-x-1/2 z-50";
            document.body.appendChild(toastContainer);
        }

        const toast = document.createElement("div");
        toast.className = `mb-2 px-4 py-3 rounded shadow-lg text-white flex items-center justify-between ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        }`;
        toast.innerHTML = `
            <span>${message}</span>
            <button class="ml-4 font-bold" onclick="this.parentElement.remove()">×</button>
        `;

        toastContainer.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
});
</script>
@endpush
@endsection