@extends('layout.sidebarmenu')

@section('pages-content')
    <div class="overflow-hidden">
        <div class="flex items-center justify-between mb-4 bg-white rounded-xl shadow-sm px-6 py-3">
            <div>
                <h2 class="text-xl font-bold text-gray-800 whitespace-nowrap">Add New Product</h2>
                <p class="text-sm text-gray-600 mt-1">Please fill up all the required fields to add new product.</p>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" onclick="history.back()"
                    class="inline-flex items-center gap-2 px-4 py-2 border-2 border-secondary text-secondary rounded-lg hover:border-primary hover:text-primary transition-colors duration-200 font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                        <path fill-rule="evenodd"
                            d="M7.72 12.53a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 1 1 1.06 1.06L9.31 12l6.97 6.97a.75.75 0 1 1-1.06 1.06l-7.5-7.5Z"
                            clip-rule="evenodd" />
                    </svg>
                    Back</button>

                <button id="discardBtn" type="button"
                    class="inline-flex items-center gap-2 px-4 py-2 border-2 border-secondary text-secondary rounded-lg font-medium hover:bg-red-500 hover:text-white transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-4 h-4">
                        <path fill-rule="evenodd"
                            d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                            clip-rule="evenodd" />
                    </svg>
                    Discard
                </button>
            </div>
        </div>

        <form id="productForm" enctype="multipart/form-data" method="POST" action="#" class="global-focus">
            @csrf
            <div class="mt-4">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                    <div class="lg:col-span-2 bg-white py-4 px-6 rounded-lg shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Product Information</h3>
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Product Name</label>
                            <input type="text" name="product_name"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:font-normal placeholder:text-gray-400"
                                placeholder="Intel Core i9 12th">
                        </div>
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:font-normal placeholder:text-gray-400"
                                placeholder="Enter product description..."></textarea>
                        </div>
                        <div class="gap-5 grid grid-cols-1 md:grid-cols-2">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Product Image</h3>
                                <input type="file" name="product_image" id="productImageInput" class="hidden"
                                    accept="image/*">
                                <div id="productImageUploadArea"
                                    class="border-2 border-dashed border-gray-300 rounded-lg p-6 h-[250px] mb-4 flex flex-col items-center justify-center text-center cursor-pointer relative overflow-hidden">

                                    <!-- Hidden File Input (kept the one with name attribute above) -->

                                    <!-- Preview Container -->
                                    <div id="productImagePreviewContainer"
                                        class="w-full h-full flex items-center justify-center hidden">
                                        <img id="productImagePreview" class="max-h-full rounded-lg object-contain" src=""
                                            alt="Preview">
                                    </div>

                                    <!-- Text and Icon Container -->
                                    <div id="productImageTextContainer" class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <p class="text-sm text-gray-600 mb-2">Drag and drop your image here or click to
                                            browse</p>
                                        <p class="text-xs text-gray-500">Accepted file types: .jpg, .png</p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-3">Pricing</h3>
                                <div class="grid grid-rows-1 md:grid-rows-2 space-y-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Base Price</label>
                                        <input type="text" name="price"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:font-normal placeholder:text-gray-400"
                                            placeholder="Enter price">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Discounted Price</label>
                                        <input type="text" name="discounted_price"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:font-normal placeholder:text-gray-400"
                                            placeholder="Enter discounted price">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col space-y-4">
                        <!--Pricing Panel-->
                        <!-- <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                                    <h3 class="font-semibold text-gray-800 mb-3">Pricing</h3>
                                    <div class="grid grid-rows-1 md:grid-rows-2 space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Base Price</label>
                                            <input type="text" name="price"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:font-normal placeholder:text-gray-400"
                                                placeholder="Enter price">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Discounted Price</label>
                                            <input type="text" name="discounted_price"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:font-normal placeholder:text-gray-400"
                                                placeholder="Enter discounted price">
                                        </div>
                                    </div>
                                </div> -->

                        <!-- Classification Panel -->
                        <div class="bg-white rounded-lg shadow-sm p-6 shadow-sm">
                            <h3 class="text-lg font-semibold text-gray-800">Classification</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1 mt-2">Brand</label>
                                    <select class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-white">
                                        <option>Select Brand</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Categories</label>
                                    <select class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-white">
                                        <option>Select Category</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Status</label>
                                    <select class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-white">
                                        <option>Active</option>
                                        <option>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Additions Panel -->
                        <div class="bg-white rounded-lg shadow-sm p-6 shadow-sm">
                            <h4 class="text-lg font-semibold text-gray-800">Additions</h4>
                            <!-- Promotions and Warranty shown as rows (no toggle) -->
                            <div id="promotionsPanel" class="space-y-3 mb-4 mt-3">
                                <label class="block text-sm text-gray-600">Promo Code</label>
                                <div>
                                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                                        placeholder="Enter promo code">
                                </div>
                            </div>

                            <div id="warrantyPanel" class="space-y-3 mb-4">
                                <label class="block text-sm text-gray-600">Warranty</label>
                                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-white">
                                    <option value="0">No Warranty</option>
                                    <option value="3">3 Months</option>
                                    <option value="6">6 Months</option>
                                    <option value="12">12 Months</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="button" class="w-full px-4 py-3 bg-green-700 text-white rounded-lg">Publish
                                Product</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const productImageArea = document.getElementById('productImageUploadArea');
                const productImageInput = document.getElementById('productImageInput');
                const productImagePreview = document.getElementById('productImagePreview');
                const productImageTextContainer = document.getElementById('productImageTextContainer');
                const form = document.getElementById('productForm');

                // Image upload handlers
                productImageArea && productImageArea.addEventListener('click', () => productImageInput && productImageInput.click());

                productImageInput && productImageInput.addEventListener('change', function () {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            productImagePreview.src = e.target.result;
                            const previewContainer = document.getElementById('productImagePreviewContainer');
                            previewContainer && previewContainer.classList.remove('hidden');
                            productImageTextContainer.classList.add('hidden');
                        };
                        reader.readAsDataURL(this.files[0]);
                    }
                });

                // Reset/discard handling
                const discardBtn = document.getElementById('discardBtn');
                if (discardBtn) {
                    discardBtn.addEventListener('click', () => {
                        // Clear all form controls inside the form
                        if (form) {
                            // Use form.reset to handle named inputs, then additionally clear file inputs and unchecked radios/checkboxes
                            try { form.reset(); } catch (e) { /* ignore */ }

                            const elements = form.querySelectorAll('input, textarea, select');
                            elements.forEach(el => {
                                if (el.tagName.toLowerCase() === 'input') {
                                    const t = el.type.toLowerCase();
                                    if (t === 'file') {
                                        el.value = '';
                                    } else if (t === 'checkbox' || t === 'radio') {
                                        el.checked = false;
                                    } else {
                                        el.value = '';
                                    }
                                } else if (el.tagName.toLowerCase() === 'textarea') {
                                    el.value = '';
                                } else if (el.tagName.toLowerCase() === 'select') {
                                    el.selectedIndex = 0;
                                }
                            });

                            // Reset image preview area
                            const previewContainer = document.getElementById('productImagePreviewContainer');
                            if (previewContainer) previewContainer.classList.add('hidden');
                            if (productImagePreview) productImagePreview.src = '';
                            if (productImageTextContainer) productImageTextContainer.classList.remove('hidden');

                            // Remove dragover highlight if present
                            if (productImageArea) productImageArea.classList.remove('border-blue-500');
                        }
                    });
                }

                // Drag-and-drop support
                if (productImageArea) {
                    productImageArea.addEventListener('dragover', (e) => {
                        e.preventDefault();
                        productImageArea.classList.add('border-blue-500');
                    });

                    productImageArea.addEventListener('dragleave', () => {
                        productImageArea.classList.remove('border-blue-500');
                    });

                    productImageArea.addEventListener('drop', (e) => {
                        e.preventDefault();
                        productImageArea.classList.remove('border-blue-500');
                        const file = e.dataTransfer.files[0];
                        if (file && file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = (event) => {
                                productImagePreview.src = event.target.result;
                                const previewContainer = document.getElementById('productImagePreviewContainer');
                                previewContainer && previewContainer.classList.remove('hidden');
                                productImageTextContainer.classList.add('hidden');
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                }

                // Dropdown controller (clean, accessible)
                (function initDropdown() {
                    const btn = document.getElementById('dropdownButton');
                    const menu = document.getElementById('dropdownMenu');
                    if (!btn || !menu) return;

                    const items = Array.from(menu.querySelectorAll('[role="menuitem"]'));

                    function open() {
                        menu.classList.remove('hidden');
                        menu.removeAttribute('aria-hidden');
                        btn.setAttribute('aria-expanded', 'true');
                        // Focus first item for keyboard navigation
                        items[0]?.focus();
                    }
                    function close() {
                        menu.classList.add('hidden');
                        menu.setAttribute('aria-hidden', 'true');
                        btn.setAttribute('aria-expanded', 'false');
                        btn.focus();
                    }
                    function toggle() {
                        const expanded = btn.getAttribute('aria-expanded') === 'true';
                        expanded ? close() : open();
                    }

                    // Button interactions
                    btn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        toggle();
                    });

                    // Close when clicking outside
                    document.addEventListener('click', (e) => {
                        if (!menu.contains(e.target) && !btn.contains(e.target)) close();
                    });

                    // Keyboard handling (Escape closes, arrows navigate)
                    document.addEventListener('keydown', (e) => {
                        if (btn.getAttribute('aria-expanded') !== 'true') return;
                        if (e.key === 'Escape') return close();

                        const currentIndex = items.indexOf(document.activeElement);
                        if (e.key === 'ArrowDown') {
                            e.preventDefault();
                            const next = items[(currentIndex + 1) % items.length];
                            next?.focus();
                        } else if (e.key === 'ArrowUp') {
                            e.preventDefault();
                            const prev = items[(currentIndex - 1 + items.length) % items.length];
                            prev?.focus();
                        } else if (e.key === 'Home') {
                            e.preventDefault();
                            items[0]?.focus();
                        } else if (e.key === 'End') {
                            e.preventDefault();
                            items[items.length - 1]?.focus();
                        }
                    });

                    // Ensure clicking a menu item closes the menu
                    items.forEach(i => {
                        i.addEventListener('click', () => close());
                        i.addEventListener('keydown', (e) => {
                            if (e.key === 'Enter' || e.key === ' ') {
                                // allow default activation then close
                                setTimeout(close, 0);
                            }
                        });
                    });
                })();
            });
        </script>
    @endpush
@endsection