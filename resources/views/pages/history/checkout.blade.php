@extends('layout.sidebarmenu')

@section('title', 'Purchase Summary')

@section('pages-content')
<div class="flex flex-col lg:flex-row gap-6 min-h-screen p-4">
    <!-- Left: Product Summary -->
    <div class="flex-[8] flex flex-col min-h-0 bg-white rounded-xl shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="p-6 border-b">
            <h1 class="text-2xl font-bold text-gray-800">Purchase Summary</h1>
            <p class="text-gray-500 mt-1">Review your order details before completing your purchase. Ensure everything is accurate for a smooth checkout experience.</p>
        </div>
        
        <!-- Current Transaction -->
        <div class="px-6 pt-4">
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-600 font-medium">Current Transactions</div>
                <div class="text-xs text-gray-500">Monday, 09/11/2025</div>
            </div>
        </div>
        <!-- Main Product -->
        <div class="p-6 border-b">
            <div class="border border-dashed border-gray-300 rounded-lg p-4 relative">
                <!-- Remove button -->
                <button 
                    class="absolute top-2 right-2 text-gray-400 hover:text-red-500 transition-colors"
                    title="Remove item"
                >
                    ✕
                </button>

                <div class="font-semibold text-lg text-gray-800">NVIDIA RTX 4060</div>
                <div class="text-blue-600 font-bold text-xl mt-1">₱20,800.00</div>
                <div class="text-sm text-gray-600 mt-2">Qty: 1</div>
            </div>
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
                <div class="flex gap-3">
                    <button class="flex-[2] border border-gray-300 rounded-lg px-5 py-3 text-sm hover:bg-gray-50 transition-colors">
                        Search Customer
                    </button>
                    <button class="flex-[1] bg-blue-600 text-white rounded-lg px-6 py-3 text-sm font-medium hover:bg-blue-700 transition-colors">
                        Add Customer
                    </button>
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