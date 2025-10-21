@extends('layout.sidebarmenu')

@section('pages-content')
    <!-- Stats Section -->
    <div class="grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2 gap-5 mb-8">
        <!-- Total Categories Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Total Categories</h2>
            <div class="flex items-end justify-between">
                <div>
                    <h3 class="text-2xl font-semibold text-gray-900">24</h3>
                    <div class="mt-1 space-y-0.5">
                        <div class="flex items-center text-xs text-green-600">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            79% Active
                        </div>
                        <div class="flex items-center text-xs text-red-600">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            21% Inactive
                        </div>
                    </div>
                </div>
                <p class="text-xs text-gray-500">Real Time Total</p>
            </div>
        </div>

        <!-- No. of Subcategories Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">No. of Subcategories</h2>
            <h3 class="text-2xl font-semibold text-gray-900">42</h3>
            <p class="text-sm text-gray-500 mt-1">Total Subcategories</p>
        </div>

        <!-- Active Categories Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Active Categories</h2>
            <h3 class="text-2xl font-semibold text-gray-900">19</h3>
            <p class="text-sm text-gray-500 mt-1">Currently Active</p>
        </div>

        <!-- Inactive Categories Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Inactive Categories</h2>
            <h3 class="text-2xl font-semibold text-gray-900">5</h3>
            <p class="text-sm text-gray-500 mt-1">Currently Inactive</p>
        </div>
    </div>

    <!-- Category Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
        <!-- Category List Header -->
        <div class="bg-white shadow-sm p-5 mb-2">
            <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-3">
                <h2 class="text-lg font-semibold text-gray-800">Category List</h2>
                
                <div class="flex flex-col xl:flex-row gap-3 w-full xl:w-auto">
                    <!-- Search Input -->
                    <div class="relative flex-1 xl:w-72">
                        <input 
                            type="text" 
                            placeholder="Search Category Name ..." 
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
                        <option>All Types</option>
                        <option>Main Category</option>
                        <option>Subcategory</option>
                    </select>

                    <select class="px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <option>All Status</option>
                        <option>Active</option>
                        <option>Inactive</option>
                    </select>

                    <!-- Add Category -->
                    <button id="addCategoryBtn" class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium flex items-center justify-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Category
                    </button>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Category Name</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Type</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Sub-Categories</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Products Count</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Total Products</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Total Earnings</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Status</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    <!-- Sample Category Data -->
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-3 text-gray-800 font-medium">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                    </svg>
                                </div>
                                Peripherals
                            </div>
                        </td>
                        <td class="px-6 py-3 text-gray-600">
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800">Product</span>
                        </td>
                        <td class="px-6 py-3 text-gray-600">0</td>
                        <td class="px-6 py-3 text-gray-600">156</td>
                        <td class="px-6 py-3 text-gray-600">157</td>
                        <td class="px-6 py-3 text-gray-600">₱ 153,034.00</td>
                        <td class="px-6 py-3">
                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-800">Active</span>
                        </td>
                        <td class="px-6 py-3">
                            <div class="flex space-x-2">
                                <button class="text-indigo-600 hover:text-indigo-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button class="text-red-600 hover:text-red-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    Showing <span class="font-medium">1</span> to <span class="font-medium">1</span> of <span class="font-medium">1</span> results
                </div>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 text-sm border border-gray-300 rounded bg-white text-gray-700 hover:bg-gray-50">Previous</button>
                    <button class="px-3 py-1 text-sm border border-gray-300 rounded bg-white text-gray-700 hover:bg-gray-50">Next</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div id="addCategoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-8 border w-full max-w-6xl shadow-lg rounded-2xl bg-white">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-4 border-b">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Add New Category</h2>
                    <p class="text-sm text-gray-600 mt-1">Please fill up all the required fields to add new category.</p>
                </div>
                <button type="button" class="closeModalBtn text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal Content -->
            <form id="categoryForm" enctype="multipart/form-data">
                <div class="mt-8">
                    <!-- Two-column layout -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                        <!-- Left Column: Category Information (wider) -->
                        <div class="lg:col-span-2">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Category Information</h3>

                            <!-- Category Name -->
                            <div class="mb-5">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                                <input type="text" name="name"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:font-normal placeholder:text-gray-400"
                                    placeholder="Electronics">
                            </div>

                            <!-- Category Type & Parent Category Row -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Category Type</label>
                                    <select name="category_type" id="categoryTypeSelect"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 bg-white">
                                        <option value="main">Product</option>
                                        <option value="subcategory">Service</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Parent Category</label>
                                    <select name="parent_id" id="parentCategorySelect"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 bg-white">
                                        <option value="">Select Parent Category</option>
                                        <option value="1">Electronics</option>>
                                    </select>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-5">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <textarea name="description" rows="3"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:font-normal placeholder:text-gray-400"
                                    placeholder="Brief description of the category"></textarea>
                            </div>

                            <!-- Status -->
                            <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Status</label>
                                <div class="flex items-center gap-3 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg">
                                    <input
                                        type="checkbox"
                                        name="is_active"
                                        id="isActive"
                                        class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                        checked
                                        >
                                    <label for="isActive" class="text-sm text-gray-800 select-none cursor-pointer">Active</label>
                                </div>
                            </div>

                        </div>

                        <!-- Right Column: Upload Image -->
                        <div class="flex flex-col">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Category Image</h3>

                            <input type="file" name="image" id="imageInput" class="hidden" accept="image/*">
                            <!-- Image Upload Area -->
                            <div id="imageUploadArea" class="border-2 border-dashed border-gray-300 rounded-lg p-6 h-[250px] mb-4 
                                        flex items-center justify-center text-center cursor-pointer flex-col">
                                
                                <!-- Image preview container -->
                                <div id="imagePreviewContainer" class="w-full h-full flex items-center justify-center">
                                    <img id="imagePreview" class="max-h-full hidden rounded-lg" src="" alt="Preview">
                                </div>

                                <!-- Text / SVG container -->
                                <div id="imageTextContainer" class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="text-sm text-gray-600 mb-2">Drag and drop your image here or click to browse</p>
                                    <p class="text-xs text-gray-500">Accepted file types: .jpg, .png</p>
                                </div>
                            </div>

                            <!-- Action Buttons - Stacked with same width -->
                            <div class="flex flex-col gap-3 w-full">
                                <button type="button" id="changeImageBtn"
                                    class="w-full px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium">
                                    Change Image
                                </button>
                                <button type="reset"
                                    class="w-full px-4 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors text-sm font-medium">
                                    Reset
                                </button>
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
                            Create Category
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById('addCategoryModal');
    const form = document.getElementById('categoryForm');
    const openBtn = document.getElementById('addCategoryBtn'); 
    const closeBtns = modal.querySelectorAll('.closeModalBtn'); 

    // Image elements
    const imageArea = document.getElementById('imageUploadArea');
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const imageTextContainer = document.getElementById('imageTextContainer');
    const changeImageBtn = document.getElementById('changeImageBtn');

    // Category type and parent category elements
    const categoryTypeSelect = document.getElementById('categoryTypeSelect');
    const parentCategorySelect = document.getElementById('parentCategorySelect');

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

    // Image upload area click
    imageArea.addEventListener('click', () => imageInput.click());
    changeImageBtn.addEventListener('click', () => imageInput.click());

    // Image input change
    imageInput.addEventListener('change', function () {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.classList.remove('hidden');
                imageTextContainer.classList.add('hidden');
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Category type change handler
    categoryTypeSelect.addEventListener('change', function() {
        if (this.value === 'subcategory') {
            parentCategorySelect.disabled = false;
            parentCategorySelect.required = true;
        } else {
            parentCategorySelect.disabled = true;
            parentCategorySelect.required = false;
            parentCategorySelect.value = '';
        }
    });


    // Reset button
    const resetBtn = form.querySelector('button[type="reset"]');
    resetBtn.addEventListener('click', () => {
        // Reset image preview
        imagePreview.src = '';
        imagePreview.classList.add('hidden');
        imageTextContainer.classList.remove('hidden');

        // Clear file input
        imageInput.value = '';

        // Reset category type
        categoryTypeSelect.value = 'main';
        parentCategorySelect.disabled = true;
        parentCategorySelect.required = false;
        parentCategorySelect.value = '';
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Category created successfully!');
        closeModal();
    });
});
</script>
@endpush
@endsection