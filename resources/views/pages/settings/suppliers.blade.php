@extends('layout.sidebarmenu')

@section('pages-content')
    <!-- Stats Section -->
    <div class="grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2 gap-5 mb-8">
        <!-- Total Suppliers Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Total Suppliers</h2>
            <div class="flex items-end justify-between">
                <div>
                    <h3 class="text-2xl font-semibold text-gray-900">325</h3>
                    <div class="mt-1 space-y-0.5">
                        <div class="flex items-center text-xs text-green-600">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            85% Active
                        </div>
                        <div class="flex items-center text-xs text-red-600">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            15% Inactive
                        </div>
                    </div>
                </div>
                <p class="text-xs text-gray-500">Real Time Total</p>
            </div>
        </div>

        <!-- Total Orders Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Total Orders</h2>
            <div class="flex items-end justify-between">
                <div>
                    <h3 class="text-2xl font-semibold text-gray-900">500</h3>
                    <div class="flex items-center text-xs text-green-600 mt-1">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                        +10 Last Month
                    </div>
                </div>
                <p class="text-xs text-gray-500">Real Time Total</p>
            </div>
        </div>

        <!-- Active Suppliers Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Active Suppliers</h2>
            <h3 class="text-2xl font-semibold text-gray-900">276</h3>
            <p class="text-sm text-gray-500 mt-1">Currently Active</p>
        </div>

        <!-- Pending Orders Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Pending Orders</h2>
            <h3 class="text-2xl font-semibold text-gray-900">24</h3>
            <p class="text-sm text-gray-500 mt-1">Awaiting Delivery</p>
        </div>
    </div>

    <!-- Supplier Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
        <!-- Supplier List Header -->
        <div class="bg-white shadow-sm p-5 mb-2">
            <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-3">
                <h2 class="text-lg font-semibold text-gray-800">Supplier Orders</h2>
                
                <div class="flex flex-col xl:flex-row gap-3 w-full xl:w-auto">
                    <!-- Search Input -->
                    <div class="relative flex-1 xl:w-72">
                        <input 
                            type="text" 
                            placeholder="Search Supplier Name ..." 
                            class="w-full pl-9 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:text-gray-400"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Buttons and Filters -->
                    <button class="px-5 py-2.5 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                        Search
                    </button>

                    <select class="px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <option>All Status</option>
                        <option>Pending</option>
                        <option>Completed</option>
                        <option>Cancelled</option>
                    </select>

                    <!-- Add Supplier -->
                    <button id="addSupplierBtn" class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium flex items-center justify-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Supplier
                    </button>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Supplier Name</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Contact Person</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Phone Number</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Total Cost</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Expected Arrival</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Date Received</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Status</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    <!-- Sample Supplier Data -->
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-gray-800 font-medium">NVIDIA Supplier</td>
                        <td class="px-6 py-4 text-gray-600">John Rex</td>
                        <td class="px-6 py-4 text-gray-600">09123456789</td>
                        <td class="px-6 py-4 text-gray-800 font-semibold">₱ 15,000</td>
                        <td class="px-6 py-4 text-gray-600">2025-05-14</td>
                        <td class="px-6 py-4 text-gray-600">2025-09-13</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">Pending</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <button class="text-indigo-600 hover:text-indigo-900 p-1 rounded hover:bg-indigo-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
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
                    Showing <span class="font-medium">1</span> to <span class="font-medium">5</span> of <span class="font-medium">325</span> results
                </div>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 text-sm border border-gray-300 rounded bg-white text-gray-700 hover:bg-gray-50 transition-colors">Previous</button>
                    <button class="px-3 py-1 text-sm border border-gray-300 rounded bg-white text-gray-700 hover:bg-gray-50 transition-colors">Next</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Supplier Modal -->
    <div id="addSupplierModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-8 border w-full max-w-4xl shadow-lg rounded-2xl bg-white">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Add New Supplier</h2>
                    <p class="text-sm text-gray-600 mt-1">Please fill up all the required fields to add new supplier.</p>
                </div>
                <button type="button" class="closeModalBtn text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal Content -->
            <form id="supplierForm" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 gap-8">
                    <!-- Supplier Information Only -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-6 pb-3 border-b nt-4 border-gray-200">Supplier Information</h3>

                        <!-- Company Name -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Company Name <span class="text-red-500">*</span></label>
                            <input type="text" name="company_name"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:font-normal placeholder:text-gray-400 transition-colors"
                                placeholder="NVIDIA Supplier"
                                required>
                        </div>

                        <!-- Contact Person -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Contact Person <span class="text-red-500">*</span></label>
                            <input type="text" name="contact_person"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:font-normal placeholder:text-gray-400 transition-colors"
                                placeholder="John Rex"
                                required>
                        </div>

                        <!-- Email & Phone Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                                <input type="email" name="email"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:font-normal placeholder:text-gray-400 transition-colors"
                                    placeholder="contact@nvidia.com"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number <span class="text-red-500">*</span></label>
                                <input type="tel" name="phone_number"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:font-normal placeholder:text-gray-400 transition-colors"
                                    placeholder="09123456789"
                                    required>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Complete Address <span class="text-red-500">*</span></label>
                            <textarea name="address" rows="3"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:font-normal placeholder:text-gray-400 transition-colors"
                                placeholder="Enter complete supplier address including street, city, and postal code"
                                required></textarea>
                        </div>

                        <!-- Additional Information -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Additional Notes</label>
                            <textarea name="notes" rows="2"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:font-normal placeholder:text-gray-400 transition-colors"
                                placeholder="Any additional information about this supplier"></textarea>
                            <p class="text-xs text-gray-500 mt-1">Optional: Special requirements, payment terms, or other relevant details</p>
                        </div>
                    </div>
                </div>

                    <!-- Modal Footer -->
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-8 border-t mt-8">
                        <button type="button" class="closeModalBtn w-full sm:w-auto px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                            Back
                        </button>
                        <button type="submit"
                            class="w-full sm:w-auto px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                            Add Supplier
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById('addSupplierModal');
    const form = document.getElementById('supplierForm');
    const openBtn = document.getElementById('addSupplierBtn'); 
    const closeBtns = modal.querySelectorAll('.closeModalBtn'); 

    // Open modal
    function openModal() {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    // Close modal
    function closeModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Attach open button event
    openBtn.addEventListener('click', openModal);

    // Close modal with all designated close buttons
    closeBtns.forEach(btn => btn.addEventListener('click', closeModal));

    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) closeModal();
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeModal();
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Supplier added successfully!');
        closeModal();
    });
});
</script>
@endpush
@endsection