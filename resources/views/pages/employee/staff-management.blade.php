@extends('layout.sidebarmenu')

@section('pages-content')
    <!-- Stats Section -->
    <div class="grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2 gap-5 mb-8">
        <!-- Total Employee Card -->
        <!-- Total Employee Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Total Employee</h2>
            <div class="flex items-end justify-between">
                <div>
                    <h3 class="text-2xl font-semibold text-gray-900">{{ $totalEmployees }}</h3>
                    <div class="mt-1 space-y-0.5">
                        <div class="flex items-center text-xs text-green-600">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            {{ $totalEmployees > 0 ? round(($activeEmployees / $totalEmployees) * 100) : 0 }}% Active
                        </div>
                        <div class="flex items-center text-xs text-red-600">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            {{ $totalEmployees > 0 ? round(($inactiveEmployees / $totalEmployees) * 100) : 0 }}% Inactive
                        </div>
                    </div>
                </div>
                <p class="text-xs text-gray-500">Real Time Total</p>
            </div>
        </div>

        <!-- No. of Roles Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">No. of Roles</h2>
            <h3 class="text-2xl font-semibold text-gray-900">{{ $rolesCount }}</h3>
            <p class="text-sm text-gray-500 mt-1">Roles of Employee</p>
        </div>

        <!-- Active Employee Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Active Employee</h2>
            <h3 class="text-2xl font-semibold text-gray-900">{{ $activeEmployees }}</h3>
            <p class="text-sm text-gray-500 mt-1">Current Employee</p>
        </div>

        <!-- Inactive Employee Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <h2 class="text-base font-medium text-gray-700 mb-1">Inactive Employee</h2>
            <h3 class="text-2xl font-semibold text-gray-900">{{ $inactiveEmployees }}</h3>
            <p class="text-sm text-gray-500 mt-1">Past Employee</p>
        </div>
    </div>

    <!-- Employee Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
        <!-- Employee List Header -->
        <div class="bg-white shadow-sm p-5 mb-2">
            <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-3">
                <h2 class="text-lg font-semibold text-gray-800">Employee List</h2>
                
                <div class="flex flex-col xl:flex-row gap-3 w-full xl:w-auto">
                    <!-- Search Input -->
                    <div class="relative flex-1 xl:w-72">
                        <input 
                            type="text" 
                            placeholder="Search Employee Name ..." 
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
                        <option>All Roles</option>
                        <option>Cashier</option>
                        <option>Manager</option>
                        <option>Admin</option>
                        <option>Staff</option>
                    </select>

                    <select class="px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <option>All Status</option>
                        <option>Active</option>
                        <option>Inactive</option>
                    </select>

                    <!-- Add Employee -->
                    <button id="addEmployeeBtn" class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium flex items-center justify-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Employee
                    </button>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Employee Name</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Username</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Role</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Phone Number</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Created</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Last Login</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Status</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700 uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                @forelse ($employees as $employee)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-3 text-gray-800 font-medium">{{ $employee->full_name }}</td>
                        <td class="px-6 py-3 text-gray-600">{{ $employee->username }}</td>
                        <td class="px-6 py-3 text-gray-600">{{ $employee->role }}</td>
                        <td class="px-6 py-3 text-gray-600">{{ $employee->phone_number ?? 'N/A' }}</td>
                        <td class="px-6 py-3 text-gray-600">
                            {{ $employee->created_date ? $employee->created_date->format('M d, Y h:i A') : 'N/A' }}
                        </td>
                        <td class="px-6 py-3 text-gray-600">
                            {{ $employee->last_login ? $employee->last_login->format('M d, Y h:i A') : 'Never' }}
                        </td>
                        <td class="px-6 py-3">
                            @if ($employee->active_status)
                                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-800">Active</span>
                            @else
                                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-red-100 text-red-800">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-3">
                            <div class="flex space-x-2">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900">✏️</a>
                                <form action="#" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-6 text-center text-gray-500">
                            No employees found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white px-6 py-4 border-t border-gray-200">
            {{ $employees->links() }}
        </div>
    </div>


<!-- Add Employee Modal -->
<div id="addEmployeeModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-8 border w-full max-w-6xl shadow-lg rounded-2xl bg-white">
        <!-- Modal Header -->
        <div class="flex justify-between items-center pb-4 border-b">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Add New Employee</h2>
                <p class="text-sm text-gray-600 mt-1">Please fill up all the required fields to add new employee.</p>
            </div>
            <button type="button" class="closeModalBtn text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Modal Content -->
        <form id="employeeForm" enctype="multipart/form-data">
            @csrf
            <div class="mt-8">
                <!-- Two-column layout with adjusted widths -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                    <!-- Left Column: Employee Information (wider) -->
                    <div class="lg:col-span-2">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Employee Information</h3>

                        <!-- First Name & Last Name Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                                <input type="text" name="first_name"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:font-normal placeholder:text-gray-400"
                                    placeholder="Juan">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                                <input type="text" name="last_name"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:font-normal placeholder:text-gray-400"
                                    placeholder="Dela Cruz">
                            </div>
                        </div>

                        <!-- Email & Contact Number Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" name="email_address"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:font-normal placeholder:text-gray-400"
                                    placeholder="juan@gmail.com">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Contact Number</label>
                                <input type="tel" name="phone_number"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:font-normal placeholder:text-gray-400"
                                    placeholder="09498521132">
                            </div>
                        </div>
                        
                        <!-- Branch Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Branch</label>
                                <select name="branch_id" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 bg-white">
                                    @foreach(\App\Models\Branch::all() as $branch)
                                        <option value="{{ $branch->branch_id }}">{{ $branch->name }} ({{ $branch->location }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Role & Username Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                                <select name="role" id="roleSelect"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 bg-white">
                                    @if(auth()->user()->role === 'superadmin')
                                        <option value="cashier">Cashier</option>
                                        <option value="admin">Admin</option>
                                        <option value="staff">Staff</option>
                                        <option value="technician">Technician</option>
                                    @elseif(auth()->user()->role === 'admin')
                                        <option value="cashier">Cashier</option>
                                        <option value="staff">Staff</option>
                                        <option value="technician">Technician</option>
                                    @endif
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                                <input type="text" name="username"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:font-normal placeholder:text-gray-400"
                                    placeholder="juancashier12">
                            </div>
                        </div>

                        <!-- Password & Confirm Password Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Password -->
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                <input 
                                    type="password" 
                                    name="password"
                                    id="password"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:font-normal placeholder:text-gray-400 pr-10"
                                    placeholder="••••••••">
                                <button 
                                    type="button" 
                                    id="togglePassword" 
                                    class="absolute right-3 top-10 text-gray-500 hover:text-gray-700 focus:outline-none"
                                >
                                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg id="eyeOffIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.973 9.973 0 012.065-3.368m2.905-2.423A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.043 5.091M15 12a3 3 0 00-3-3m0 0a3 3 0 013 3m-3-3L3 3" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Confirm Password -->
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                                <input 
                                    type="password" 
                                    name="password_confirmation"
                                    id="confirmPassword"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:font-normal placeholder:text-gray-400 pr-10"
                                    placeholder="••••••••">
                                <button 
                                    type="button" 
                                    id="toggleConfirmPassword" 
                                    class="absolute right-3 top-10 text-gray-500 hover:text-gray-700 focus:outline-none"
                                >
                                    <svg id="eyeIconConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg id="eyeOffIconConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.973 9.973 0 012.065-3.368m2.905-2.423A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.043 5.091M15 12a3 3 0 00-3-3m0 0a3 3 0 013 3m-3-3L3 3" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Upload Image (slimmer) -->
                    <div class="flex flex-col">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Upload Image</h3>

                        <input type="file" name="avatar" id="avatarInput" class="hidden" accept="image/*">
                        <!-- Profile Image Upload Area -->
                        <div id="avatarUploadArea" class="border-2 border-dashed border-gray-300 rounded-lg p-6 h-[250px] mb-4 
                                    flex items-center justify-center text-center cursor-pointer flex-col">
                            
                            <!-- Image preview container -->
                            <div id="avatarPreviewContainer" class="w-full h-full flex items-center justify-center">
                                <img id="avatarPreview" class="max-h-full hidden rounded-lg" src="" alt="Preview">
                            </div>

                            <!-- Text / SVG container -->
                            <div id="avatarTextContainer" class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400 mb-3" ...></svg>
                                <p class="text-sm text-gray-600 mb-2">Drag and drop your image here or click to browse</p>
                                <p class="text-xs text-gray-500">Accepted file types: .jpg, .png</p>
                            </div>
                        </div>

                        <!-- Action Buttons - Stacked with same width -->
                        <div class="flex flex-col gap-3 w-full">
                            <button type="button"
                                class="w-full px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium">
                                Change Profile
                            </button>
                            <button type="reset"
                                class="w-full px-4- py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors text-sm font-medium">
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
                        Create Account
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById('addEmployeeModal');
    const form = document.getElementById('employeeForm');
    const openBtn = document.getElementById('addEmployeeBtn'); 
    const closeBtns = modal.querySelectorAll('.closeModalBtn'); 

    // Avatar elements
    const avatarArea = document.getElementById('avatarUploadArea');
    const avatarInput = document.getElementById('avatarInput');
    const avatarPreview = document.getElementById('avatarPreview');
    const avatarTextContainer = document.getElementById('avatarTextContainer');

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

    // Avatar upload area click
    avatarArea.addEventListener('click', () => avatarInput.click());

    // Avatar input change
    avatarInput.addEventListener('change', function () {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                avatarPreview.src = e.target.result;
                avatarPreview.classList.remove('hidden');
                avatarTextContainer.classList.add('hidden');
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Reset button
    const resetBtn = form.querySelector('button[type="reset"]');
    resetBtn.addEventListener('click', () => {
        // Reset avatar preview
        avatarPreview.src = '';
        avatarPreview.classList.add('hidden');
        avatarTextContainer.classList.remove('hidden');

        // Clear file input
        avatarInput.value = '';
    });

    // AJAX submission for toast + reload page
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(form);

        axios.post("{{ route('employees.store') }}", formData)
            .then(response => {
                console.log('Submitted Data:', response.data.submitted_data); // debug
                
                // Use Tailwind toast instead of Toastr
                showToast(response.data.message, 'success');

                // Close modal
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';

                // Reload page after toast disappears
                setTimeout(() => {
                    window.location.reload();
                }, 1000); // matches your toast duration
            })
            .catch(error => {
                if (error.response && error.response.data.errors) {
                    Object.values(error.response.data.errors).forEach(errArray => {
                        errArray.forEach(msg => showToast(msg, 'error'));
                    });
                } else {
                    showToast('Something went wrong.', 'error');
                    console.error(error.response || error);
                }
            });
    });


    function showToast(message, type = 'success') {
        // Create toast container if not exists
        let toastContainer = document.getElementById("toast-container");
        if (!toastContainer) {
            toastContainer = document.createElement("div");
            toastContainer.id = "toast-container";
            toastContainer.className = "fixed top-20 left-1/2 transform -translate-x-1/2 z-50";
            document.body.appendChild(toastContainer);
        }

        // Create toast element
        const toast = document.createElement("div");
        toast.className = `mb-2 px-4 py-3 rounded shadow-lg text-white flex items-center justify-between ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        }`;
        toast.innerHTML = `
            <span>${message}</span>
            <button class="ml-4 font-bold" onclick="this.parentElement.remove()">×</button>
        `;

        toastContainer.appendChild(toast);

        // Auto remove after 1.5 seconds
        setTimeout(() => {
            toast.remove();
        }, 1000);
    }

    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    const eyeOffIcon = document.getElementById('eyeOffIcon');

    togglePassword.addEventListener('click', () => {
        const isHidden = passwordInput.type === 'password';
        passwordInput.type = isHidden ? 'text' : 'password';
        eyeIcon.classList.toggle('hidden', !isHidden);
        eyeOffIcon.classList.toggle('hidden', isHidden);
    });

    // Confirm password toggle
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    const eyeIconConfirm = document.getElementById('eyeIconConfirm');
    const eyeOffIconConfirm = document.getElementById('eyeOffIconConfirm');

    toggleConfirmPassword.addEventListener('click', () => {
        const isHidden = confirmPasswordInput.type === 'password';
        confirmPasswordInput.type = isHidden ? 'text' : 'password';
        eyeIconConfirm.classList.toggle('hidden', !isHidden);
        eyeOffIconConfirm.classList.toggle('hidden', isHidden);
    });
});
</script>
@endpush
@endsection