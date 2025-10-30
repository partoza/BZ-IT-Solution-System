@extends('layout.sidebarmenu')

@section('pages-content')
    <!-- Stats Section -->
    <div class="grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2 gap-5 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Total Suppliers</h2>
            <div class="flex items-end justify-between">
                <div>
                    <h3 class="text-2xl font-semibold text-gray-900">{{ $totalSuppliers }}</h3>
                    <div class="mt-1 space-y-0.5">
                        <div class="flex items-center text-xs text-green-600">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            {{ round(($activeSuppliers / max($totalSuppliers, 1)) * 100, 0) }}% Active
                        </div>
                        <div class="flex items-center text-xs text-red-600">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            {{ round(($inactiveSuppliers / max($totalSuppliers, 1)) * 100, 0) }}% Inactive
                        </div>
                    </div>
                </div>
                <p class="text-xs text-gray-500">Real Time Total</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Active Suppliers</h2>
            <h3 class="text-2xl font-semibold text-gray-900">{{ $activeSuppliers }}</h3>
            <p class="text-sm text-gray-500 mt-1">Currently Active</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Inactive Suppliers</h2>
            <h3 class="text-2xl font-semibold text-gray-900">{{ $inactiveSuppliers }}</h3>
            <p class="text-sm text-gray-500 mt-1">Currently Inactive</p>
        </div>
    </div>

    <!-- Supplier Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
        <!-- Supplier List Header -->
        <div class="bg-white shadow-sm p-5 mb-2">
            <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-3">
                <h2 class="text-lg font-semibold text-gray-800">Suppliers</h2>
                
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
                    <button class="px-5 py-2.5 text-sm bg-primary hover:bg-primary-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                        Search
                    </button>

                    <select class="px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <option>All Status</option>
                        <option>Pending</option>
                        <option>Completed</option>
                        <option>Cancelled</option>
                    </select>

                    <!-- Add Supplier -->
                    <button id="addSupplierBtn" class="px-5 py-2.5 bg-primary hover:bg-emerald-600 text-white rounded-lg transition-colors text-sm font-medium flex items-center justify-center">
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
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Company Name</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Contact Person</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Email</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Phone</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($suppliers as $supplier)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $supplier->company_name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $supplier->contact_person }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $supplier->email }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $supplier->phone_number }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Active</span>
                                <!-- @if ($supplier->status === 'active')
                                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Active</span>
                                @else
                                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Inactive</span>
                                @endif -->
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No suppliers found.</td>
                        </tr>
                    @endforelse
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

    <!-- Add Supplier Modal (addproduct style) -->
    <div id="addSupplierModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 backdrop-blur-sm">
        <div class="bg-white p-5 rounded-2xl shadow-2xl w-full max-w-4xl mx-4 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Add New Supplier</h2>
                    <p class="text-sm text-gray-600 mt-1">Please fill up all the required fields to add new supplier.</p>
                </div>
                <button type="button" class="closeModalBtn text-gray-400 hover:text-red-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <hr class="mb-2">

            <form id="supplierForm" enctype="multipart/form-data" class="global-focus flex flex-col">
                @csrf

                <!-- Scrollable body -->
                <div class="overflow-y-auto max-h-[60vh] space-y-4 mt-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Supplier Information</h3>

                        <!-- Company Name -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Company Name <span class="text-red-500">*</span></label>
                            <input type="text" name="company_name"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder:font-normal placeholder:text-gray-400 transition-all duration-200 bg-gray-50"
                                placeholder="NVIDIA Supplier"
                                required>
                        </div>

                        <!-- Contact Person -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Contact Person <span class="text-red-500">*</span></label>
                            <input type="text" name="contact_person"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder:font-normal placeholder:text-gray-400 transition-all duration-200 bg-gray-50"
                                placeholder="John Rex"
                                required>
                        </div>

                        <!-- Email & Phone Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                                <input type="email" name="email"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder:font-normal placeholder:text-gray-400 transition-all duration-200 bg-gray-50"
                                    placeholder="contact@nvidia.com"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number <span class="text-red-500">*</span></label>
                                <input type="tel" name="phone_number"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder:font-normal placeholder:text-gray-400 transition-all duration-200 bg-gray-50"
                                    placeholder="09123456789"
                                    required>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Complete Address <span class="text-red-500">*</span></label>
                            <textarea name="address" rows="3"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder:font-normal placeholder:text-gray-400 transition-all duration-200 bg-gray-50"
                                placeholder="Enter complete supplier address including street, city, and postal code"
                                required></textarea>
                        </div>

                        <!-- Additional Information -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Additional Notes</label>
                            <textarea name="notes" rows="2"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder:font-normal placeholder:text-gray-400 transition-all duration-200 bg-gray-50"
                                placeholder="Any additional information about this supplier"></textarea>
                            <p class="text-xs text-gray-500 mt-1">Optional: Special requirements, payment terms, or other relevant details</p>
                        </div>
                    </div>
                </div>

                <!-- Footer pinned to bottom -->
                <div class="mt-4 pt-4 border-t flex justify-end gap-3">
                    <button type="button" class="closeModalBtn px-4 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-100 transition-colors font-medium">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-3 bg-primary hover:bg-emerald-600 text-white rounded-xl font-medium shadow-sm hover:shadow-md transition-all duration-200">
                        Add Supplier
                    </button>
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
    const closeBtns = modal ? modal.querySelectorAll('.closeModalBtn') : [];

    function openModal() { if (!modal) return; modal.classList.remove('hidden'); document.body.style.overflow = 'hidden'; }
    function closeModal() { if (!modal) return; modal.classList.add('hidden'); document.body.style.overflow = 'auto'; }

    if (openBtn) openBtn.addEventListener('click', openModal);
    if (closeBtns && closeBtns.length) closeBtns.forEach(btn => btn.addEventListener('click', closeModal));
    if (modal) modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

    // AJAX Submission
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(form);

            axios.post("{{ route('suppliers.store') }}", formData)
                .then(response => {
                    showToast(response.data.message, 'success');
                    closeModal();
                    setTimeout(() => window.location.reload(), 1000);
                })
                .catch(error => {
                    if (error.response && error.response.data.errors) {
                        Object.values(error.response.data.errors).forEach(errArray => {
                            errArray.forEach(msg => showToast(msg, 'error'));
                        });
                    } else {
                        showToast('Something went wrong.', 'error');
                    }
                });
        });
    }

    // Use the global `showToast(message, type)` provided by resources/js/utils/toast.js
});
</script>
@endpush
@endsection