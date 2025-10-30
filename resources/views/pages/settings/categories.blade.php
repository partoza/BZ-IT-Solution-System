@extends('layout.sidebarmenu')

@section('pages-content')
    <!-- Stats Section -->
    <div class="grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2 gap-5 mb-8">
        <!-- Total Categories -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Total Categories</h2>
            <div class="flex items-end justify-between">
                <div>
                    <h3 class="text-2xl font-semibold text-gray-900">{{ $totalCategories }}</h3>
                    <div class="mt-1 space-y-0.5">
                        <div class="flex items-center text-xs text-green-600">
                            {{ $totalCategories ? round((($activeCategories/$totalCategories)*100),0) : 0 }}% Active
                        </div>
                        <div class="flex items-center text-xs text-red-600">
                            {{ $totalCategories ? round((($inactiveCategories/$totalCategories)*100),0) : 0 }}% Inactive
                        </div>
                    </div>
                </div>
                <p class="text-xs text-gray-500">Real Time Total</p>
            </div>
        </div>

        <!-- No. of Subcategories -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">No. of Subcategories</h2>
            <h3 class="text-2xl font-semibold text-gray-900">{{ $totalSubcategories }}</h3>
            <p class="text-sm text-gray-500 mt-1">Total Subcategories</p>
        </div>

        <!-- Active -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Active Categories</h2>
            <h3 class="text-2xl font-semibold text-gray-900">{{ $activeCategories }}</h3>
            <p class="text-sm text-gray-500 mt-1">Currently Active</p>
        </div>

        <!-- Inactive -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Inactive Categories</h2>
            <h3 class="text-2xl font-semibold text-gray-900">{{ $inactiveCategories }}</h3>
            <p class="text-sm text-gray-500 mt-1">Currently Inactive</p>
        </div>
    </div>

    <!-- Category Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
        <!-- Category List Header (controls) -->
        <div class="bg-white shadow-sm p-5 mb-2">
        <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-3">
            <h2 class="text-lg font-semibold text-gray-800">Category List</h2>

            <form id="categoriesFiltersForm" method="GET" action="{{ route('categories.index') }}" class="flex flex-col xl:flex-row gap-3 w-full xl:w-auto">
            <!-- Search Input -->
            <div class="relative flex-1 xl:w-72">
                <input
                type="text"
                name="search"
                value="{{ request('search', $search ?? '') }}"
                placeholder="Search Category Name ..."
                class="w-full pl-9 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:text-gray-400"
                aria-label="Search categories"
                >
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                </div>
            </div>

            <!-- Search Button -->
            <button type="submit" id="categoriesSearchBtn" class="px-5 py-2.5 text-sm bg-primary hover:bg-emerald-700 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                Search
            </button>

            <!-- View (Main Category / Subcategory) -->
            <select name="view" class="px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                <option value="categories" {{ (request('view', $view ?? '') === 'categories') ? 'selected' : '' }}>Main Category</option>
                <option value="subcategories" {{ (request('view', $view ?? '') === 'subcategories') ? 'selected' : '' }}>Subcategory</option>
            </select>

            <!-- Status -->
            <select name="status" class="px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                <option value="" {{ (request('status', $statusFilter ?? '') === '') ? 'selected' : '' }}>All Status</option>
                <option value="Active" {{ (request('status', $statusFilter ?? '') === 'Active') ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ (request('status', $statusFilter ?? '') === 'Inactive') ? 'selected' : '' }}>Inactive</option>
            </select>

            <!-- Add Category -->
            <button id="addCategoryBtn" type="button" class="px-5 py-2.5 bg-primary hover:bg-emerald-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium flex items-center justify-center">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Category
            </button>
            </form>
        </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Category Name</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Type</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">
                            {{ request('view') === 'subcategories' ? 'Parent Category' : 'Sub-Categories' }}
                        </th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Products</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Total Products</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Inventory Value</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Status</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($rows as $cat)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-800">{{ $cat->name }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-3">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800">{{ ucfirst($cat->category_type) }}</span>
                            </td>

                            <td class="px-6 py-3 text-gray-600">
                                @if (request('view') === 'subcategories')
                                    {{ $cat->parent ? $cat->parent->name : '— None —' }}
                                @else
                                    {{ $cat->subcategories_count }}
                                @endif
                            </td>

                            <td class="px-6 py-3 text-gray-600">{{ $cat->direct_products_count }}</td>

                            <td class="px-6 py-3 text-gray-600">{{ $cat->total_products_count }}</td>

                            <td class="px-6 py-3 text-gray-600">₱ {{ number_format($cat->inventory_value, 2) }}</td>

                            <td class="px-6 py-3">
                                @if($cat->status === 'Active')
                                    <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-800">Active</span>
                                @else
                                    <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-red-100 text-red-800">Inactive</span>
                                @endif
                            </td>

                            <td class="px-6 py-3">
                                <div class="flex gap-2">
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900">
                                        <!-- edit icon -->
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/></svg>
                                    </a>
                                    <button data-id="{{ $cat->id }}" class="text-red-600 hover:text-red-900 deleteCategoryBtn">
                                        <!-- delete icon -->
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-6 text-center text-gray-500">No records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Showing <span class="font-medium">{{ $rows->firstItem() ?? 0 }}</span> to <span class="font-medium">{{ $rows->lastItem() ?? 0 }}</span> of <span class="font-medium">{{ $rows->total() }}</span> results
                </div>
                <div>
                    {{ $rows->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Add Category Modal (styled like addproduct's brandModal) -->
    <div id="addCategoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 backdrop-blur-sm">
        <div class="bg-white p-5 rounded-2xl shadow-2xl w-full max-w-4xl mx-4 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-2xl font-bold text-primary">Add New Category</h2>
                    <p class="text-sm text-gray-600 mt-1">Please fill up all the required fields to add new category.</p>
                </div>
                <button type="button" class="closeModalBtn text-gray-400 hover:text-red-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <hr class="mb-2">

            <form id="categoryForm" enctype="multipart/form-data" class="global-focus flex flex-col">
                <!-- Scrollable body -->
                <div class="overflow-y-auto max-h-[60vh] space-y-4 mt-4">
                    <div>
                        <label for="categoryName" class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                        <input id="categoryName" type="text" name="name" required placeholder="Electronics"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Category Type</label>
                            <select name="category_type" id="categoryTypeSelect"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 bg-white">
                                <option value="product">Product</option>
                                <option value="service">Service</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Parent Category</label>
                            <select name="parent_id" id="parentCategorySelect"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 bg-white">
                                <option value="">None</option>
                                @foreach($categories->where('parent_id', null) as $parent)
                                    <option value="{{ $parent->id }}" data-type="{{ $parent->category_type }}">
                                        {{ $parent->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" rows="3"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500"
                            placeholder="Brief description of the category"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <div class="flex items-center gap-3 px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl">
                            <input type="checkbox" name="is_active" id="isActive"
                                class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" checked>
                            <label for="isActive" class="text-sm text-gray-800 select-none cursor-pointer">Active</label>
                        </div>
                    </div>
                </div>

                <!-- Footer pinned to bottom -->
                <div class="mt-4 pt-4 border-t flex justify-end gap-3">
                    <button type="button" class="closeModalBtn px-4 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-100 transition-colors font-medium">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-3 bg-primary hover:bg-emerald-700 text-white rounded-xl font-medium shadow-sm hover:shadow-md transition-all duration-200">
                        Create Category
                    </button>
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

    // ----- Modal open / close -----
    function openModal() { 
        modal.classList.remove('hidden'); 
        document.body.style.overflow = 'hidden'; 
    }

    function closeModal() { 
        modal.classList.add('hidden'); 
        document.body.style.overflow = 'auto'; 
        form.reset();
        resetImagePreview();
    }

    openBtn.addEventListener('click', openModal);
    closeBtns.forEach(btn => btn.addEventListener('click', closeModal));
    modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

    // ----- Image preview (guarded) -----
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    const imageTextContainer = document.getElementById('imageTextContainer');
    const imageUploadArea = document.getElementById('imageUploadArea');
    const changeImageBtn = document.getElementById('changeImageBtn');

    if (imageUploadArea && imageInput) {
        imageUploadArea.addEventListener('click', () => imageInput.click());
    }

    if (changeImageBtn && imageInput) {
        changeImageBtn.addEventListener('click', () => imageInput.click());
    }

    if (imageInput) {
        imageInput.addEventListener('change', function () {
            const file = this.files && this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => {
                    if (imagePreview) {
                        imagePreview.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                    }
                    if (imageTextContainer) imageTextContainer.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
    }

    function resetImagePreview() {
        if (imagePreview) {
            imagePreview.src = '';
            imagePreview.classList.add('hidden');
        }
        if (imageTextContainer) imageTextContainer.classList.remove('hidden');
    }


    // ----- Dynamic parent category filtering based on category type -----
    const parentSelect = document.getElementById('parentCategorySelect');
    const categoryTypeSelect = document.getElementById('categoryTypeSelect');

    function updateParentOptions() {
        const selectedType = categoryTypeSelect.value;
        const allOptions = parentSelect.querySelectorAll('option');

        allOptions.forEach(option => {
            if (!option.value) return; // skip "None"
            const isProduct = option.dataset.type === 'product';
            const isService = option.dataset.type === 'service';

            // Only show parent options matching the selected type
            if ((selectedType === 'product' && isProduct) || (selectedType === 'service' && isService)) {
                option.classList.remove('hidden');
            } else {
                option.classList.add('hidden');
            }
        });

        // Reset to default None
        parentSelect.value = '';
    }

    // When category type changes, update available parent categories
    categoryTypeSelect.addEventListener('change', updateParentOptions);

    // ----- AJAX form submission -----
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(form);

        formData.set('is_active', form.querySelector('#isActive').checked ? 1 : 0);

        axios.post("{{ route('categories.store') }}", formData)
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

    // Use the global `showToast(message, type)` provided by resources/js/utils/toast.js
});
</script>
@endpush
@endsection