@extends('layout.sidebarmenu')

@section('pages-content')
    <!-- Stats Section -->
    <div class="grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2 gap-3 mb-3">

        <!-- Total Orders Card -->
        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <div class="flex items-center gap-3 mb-1">
                <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center">
                    <div class="w-8 h-8 bg-gradient-to-r from-emerald-600 to-emerald-500 flex items-center justify-center"
                        style="clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%)">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-4 text-white">
                            <path fill-rule="evenodd"
                                d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z"
                                clip-rule="evenodd" />
                            <path fill-rule="evenodd"
                                d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375ZM6 12a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V12Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 15a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V15Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 18a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V18Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75Z"
                                clip-rule="evenodd" />
                        </svg>

                    </div>
                </div>
                <h2 class="text-base font-medium text-gray-700">Total Orders</h2>
            </div>
            <div class="ps-14">
                <h3 class="text-2xl font-semibold text-gray-900">{{ $totalPOs }}</h3>
                <p class="text-xs text-gray-500 mt-1">Real Time Tracking</p>
                <div class="flex items-center gap-2 mt-2">
                    <!-- Badge with tooltip (group for hover/focus) -->
                    <div class="relative inline-block group" tabindex="0" aria-label="Weekly activities">
                        <div
                            class="flex items-center text-green-600 text-xs bg-primary/10 px-2 py-1 rounded-lg font-medium cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-3 mr-1">
                                <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                <path fill-rule="evenodd"
                                    d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>This Week</span>
                        </div>

                        <!-- Tooltip -->
                        <div
                            class="z-50 pointer-events-none opacity-0 group-hover:opacity-100 group-focus:opacity-100 transition-opacity duration-150 absolute top-full mt-3 left-1/2 transform -translate-x-1/2 w-60 bg-white border border-gray-200 rounded-lg shadow-lg p-3 text-sm text-gray-700">
                            <!-- arrow removed -->
                            <div class="font-medium text-gray-800 mb-2">Weekly Activities</div>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-yellow-400 inine-block"></span>
                                        <span class="text-xs text-gray-600">Pending</span>
                                    </div>
                                    <span class="font-semibold text-gray-800">{{ $pendingThisWeek }}</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span>
                                        <span class="text-xs text-gray-600">Completed</span>
                                    </div>
                                    <span class="font-semibold text-gray-800">{{ $completedThisWeek }}</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-red-400 inline-block"></span>
                                        <span class="text-xs text-gray-600">Void</span>
                                    </div>
                                    <span class="font-semibold text-gray-800">{{ $voidThisWeek }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <div class="flex items-center gap-3 mb-1">
                <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center">
                    <div class="w-8 h-8 bg-gradient-to-r from-emerald-600 to-emerald-500 flex items-center justify-center"
                        style="clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%)">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-4 text-white">
                            <path fill-rule="evenodd"
                                d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                                clip-rule="evenodd" />
                        </svg>

                    </div>
                </div>
                <h2 class="text-base font-medium text-gray-700">Total Suppliers</h2>
            </div>
            <div class="ps-14">
                <h3 class="text-2xl font-semibold text-gray-900">{{ $totalSuppliers }}</h3>
                <p class="text-xs text-gray-500 mt-1">Real Time Tracking</p>
                <div class="flex items-center gap-2 mt-2">
                    <div class="flex items-center text-green-600 text-xs">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>Active Suppliers</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <div class="flex items-center gap-3 mb-1">
                <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center">
                    <div class="w-8 h-8 bg-gradient-to-r from-emerald-600 to-emerald-500 flex items-center justify-center"
                        style="clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%)">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-4 text-white">
                            <path fill-rule="evenodd"
                                d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z"
                                clip-rule="evenodd" />
                        </svg>

                    </div>
                </div>
                <h2 class="text-base font-medium text-gray-700">Pending Orders</h2>
            </div>
            <div class="ps-14">
                <h3 class="text-2xl font-semibold text-gray-900">{{ $pendingPOs }}</h3>
                <p class="text-xs text-gray-500 mt-1">Awaiting Delivery</p>
                <div class="flex items-center gap-2 mt-2">
                    <div class="flex items-center text-yellow-400 text-xs">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-3 mr-1">
                            <path fill-rule="evenodd"
                                d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z"
                                clip-rule="evenodd" />
                        </svg>

                        <span>{{ $pendingThisWeek }} Pending This Week</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <div class="flex items-center gap-3 mb-1">
                <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center">
                    <div class="w-8 h-8 bg-gradient-to-r from-emerald-600 to-emerald-500 flex items-center justify-center"
                        style="clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%)">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-5 text-white">
                            <path
                                d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 0 1-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004ZM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 0 1-.921.42Z" />
                            <path fill-rule="evenodd"
                                d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v.816a3.836 3.836 0 0 0-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 0 1-.921-.421l-.879-.66a.75.75 0 0 0-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 0 0 1.5 0v-.81a4.124 4.124 0 0 0 1.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 0 0-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 0 0 .933-1.175l-.415-.33a3.836 3.836 0 0 0-1.719-.755V6Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <h2 class="text-base font-medium text-gray-700">Monthly Purchased</h2>
            </div>
            <div class="ps-14">
                <h3 class="text-2xl font-semibold text-gray-900">₱ {{ $totalReceivedThisMonth }}</h3>
                <p class="text-xs text-gray-500 mt-1">Amount Purchased</p>
                <div class="flex items-center gap-2 mt-2">
                    <div class="flex items-center text-red-600 text-xs">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-3 mr-1">
                            <path fill-rule="evenodd"
                                d="M4.25 12a.75.75 0 0 1 .75-.75h14a.75.75 0 0 1 0 1.5H5a.75.75 0 0 1-.75-.75Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>₱ {{ $totalReceivedThisMonth }} This Week</span>
                    </div>
                </div>
            </div>
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
                    <form method="GET" class="flex flex-wrap gap-3 global-focus">
                        <div class="relative flex-1 xl:w-72">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search Product or Supplier ..."
                                class="w-full pl-9 pr-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:text-gray-400">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <select name="supplier"
                            class="px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="">All Suppliers</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ request('supplier') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->company_name }}
                                </option>
                            @endforeach
                        </select>

                        <select name="status"
                            class="px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="received" {{ request('status') == 'received' ? 'selected' : '' }}>Received</option>
                            <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>Partial</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>

                        <button type="submit"
                            class="px-5 py-2.5 text-sm bg-primary hover:bg-emerald-700 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                            Filter
                        </button>

                        <a href="{{ route('stock-in.index') }}"
                            class="px-5 py-2.5 bg-primary hover:bg-emerald-700 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium flex items-center justify-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
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
                                <span
                                    class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $statusClasses[$po->status] ?? 'bg-gray-100 text-gray-600' }}">
                                    {{ ucfirst($po->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-3">
                                <div class="relative inline-block text-left">
                                    <button id="options-menu-{{ $po->id }}" data-po-id="{{ $po->id }}"
                                        class="options-btn inline-flex items-center justify-center p-2" aria-haspopup="true"
                                        aria-expanded="false">
                                        <span class="sr-only">Open options</span>
                                        <!-- Vertical three dots icon -->
                                        <svg class="w-5 h-5 text-gray-600 hover:text-primary" viewBox="0 0 20 20"
                                            fill="currentColor" aria-hidden="true">
                                            <path
                                                d="M10 6a2 2 0 110-4 2 2 0 010 4zm0 6a2 2 0 110-4 2 2 0 010 4zm0 6a2 2 0 110-4 2 2 0 010 4z" />
                                        </svg>
                                    </button>

                                    <div id="dropdown-{{ $po->id }}" class="relative hidden w-36 rounded-md shadow-lg bg-white">
                                        @if($po->status === 'pending')
                                            <button
                                                class="block w-full text-left px-3 py-1 text-sm hover:bg-gray-100 receive-btn text-center"
                                                data-po-id="{{ $po->id }}">Receive</button>
                                            <button
                                                class="block w-full text-left px-3 py-1 text-sm hover:bg-gray-100 cancel-btn text-center"
                                                data-po-id="{{ $po->id }}">Cancel</button>
                                        @elseif($po->status === 'received')
                                            <button
                                                class="block w-full text-left px-3 py-1 text-sm hover:bg-gray-100 void-btn text-center"
                                                data-po-id="{{ $po->id }}">Void</button>
                                        @endif

                                        <button
                                            class="block w-full text-left px-3 py-1 text-sm hover:bg-gray-100 view-btn text-center"
                                            data-po-id="{{ $po->id }}">View Items</button>
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
                    <button type="button" class="px-5 py-2.5 bg-gray-200 rounded-lg mr-2"
                        id="receive-cancel">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 bg-green-600 text-white rounded-lg">Confirm Receive</button>
                </div>
            </form>
        </div>
    </div>

    <!-- View Items Modal -->
    <div id="view-items-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-4xl overflow-hidden">
            <!-- Header -->
            <div class="flex items-start justify-between gap-4 p-5 border-b">
                <div class="flex items-start gap-4">
                    <div class="rounded-full bg-primary/10 p-3">
                        <svg class="w-6 h-6 text-primary" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 7a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1V7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold" id="po-number">—</h3>
                        <p class="text-sm text-gray-500" id="po-supplier">Supplier: —</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <!-- status badge (will be styled by JS to match table badges) -->
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-500">Status</span>
                        <span id="po-status" class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">—</span>
                    </div>

                    <!-- Close (X) button -->
                    <button id="view-close-x" aria-label="Close" class="text-gray-500 hover:text-gray-700 p-2 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Body: scrollable -->
            <div id="view-items-body" class="p-5 max-h-[60vh] overflow-y-auto space-y-6">
                <!-- Summary -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="text-xs text-gray-500">Total Line Items</div>
                        <div id="po-total-items" class="text-lg font-semibold">0</div>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="text-xs text-gray-500">Total Quantity</div>
                        <div id="po-total-qty" class="text-lg font-semibold">0</div>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="text-xs text-gray-500">Estimated Total</div>
                        <div id="po-total-amount" class="text-lg font-semibold">₱ 0.00</div>
                    </div>
                </div>

                <!-- PO meta row: display values copied from the table row so modal matches table exactly -->
                <div id="po-meta-row" class="mt-4 flex flex-wrap gap-3">
                    <div class="px-3 py-2 bg-gray-50 rounded-lg text-sm text-gray-600">PO Number: <span id="po-number-meta">—</span></div>
                    <div class="px-3 py-2 bg-gray-50 rounded-lg text-sm text-gray-600">Order Date: <span id="po-order-date">—</span></div>
                    <div class="px-3 py-2 bg-gray-50 rounded-lg text-sm text-gray-600">Received: <span id="po-received-date">—</span></div>
                    <div class="px-3 py-2 bg-gray-50 rounded-lg text-sm text-gray-600">Created by: <span id="po-created-by">—</span></div>
                </div>

                <!-- Products list -->
                <div id="view-items-container" class="space-y-4">
                    <!-- Dynamically filled product cards -->
                </div>
            </div>

            <!-- Footer -->
            <div class="flex items-center justify-end gap-3 p-4 border-t">
                <button id="view-close" class="px-4 py-2 rounded-lg bg-gray-100 text-sm">Close</button>
            </div>
        </div>
    </div>
   @push('scripts')
       <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Use the global `showToast(message, type)` provided by resources/js/utils/toast.js

                // Dropdown portal logic: move dropdowns to document.body and position them fixed
                const openDropdown = (btn) => {
                    const poId = btn.dataset.poId || btn.id.split('-')[2];
                    const dropdown = document.getElementById('dropdown-' + poId);
                    if (!dropdown) return;

                    // move to body so it's not clipped by overflow/scrolling containers
                    if (dropdown.parentElement !== document.body) {
                        document.body.appendChild(dropdown);
                    }

                    // briefly show to measure size
                    dropdown.classList.remove('hidden');

                    // compute position relative to viewport and position fixed
                    const rect = btn.getBoundingClientRect();
                    const ddRect = dropdown.getBoundingClientRect();
                    const ddWidth = ddRect.width || 144; // fallback to w-36 (144px)
                    const ddHeight = ddRect.height || 120;

                    const minMargin = 8;

                    // Prefer placing BELOW the button, left-aligned with the button
                    let left = rect.left; // left edges aligned
                    let top = rect.bottom; // place dropdown below the button

                    // If dropdown would overflow horizontally, try to shift it to the right,
                    // or clamp inside the viewport
                    if (left + ddWidth > window.innerWidth - minMargin) {
                        // try aligning the dropdown's right edge to the button's right edge
                        left = rect.right - ddWidth;
                    }

                    if (left < minMargin) left = minMargin;
                    if (left + ddWidth > window.innerWidth - minMargin) {
                        left = Math.max(minMargin, window.innerWidth - ddWidth - minMargin);
                    }

                    // If there's not enough space below, try placing ABOVE the button
                    if (top + ddHeight > window.innerHeight - minMargin) {
                        if (rect.top - ddHeight > minMargin) {
                            top = rect.top - ddHeight; // place above the button
                        } else {
                            // clamp to viewport if neither fits
                            top = Math.max(minMargin, window.innerHeight - ddHeight - minMargin);
                        }
                    }

                    dropdown.style.position = 'fixed';
                    dropdown.style.top = `${top}px`;
                    dropdown.style.left = `${left}px`;
                    dropdown.style.zIndex = '9999';

                    btn.setAttribute('aria-expanded', 'true');
                };

                const closeAllDropdowns = () => {
                    document.querySelectorAll('[id^="dropdown-"]').forEach(dd => {
                        if (!dd.classList.contains('hidden')) {
                            dd.classList.add('hidden');
                            dd.style.position = '';
                            dd.style.top = '';
                            dd.style.left = '';
                            const poId = dd.id.split('-')[1];
                            const btn = document.getElementById('options-menu-' + poId);
                            if (btn) btn.setAttribute('aria-expanded', 'false');
                        }
                    });
                };

                // Ensure any open dropdowns are closed when an option is clicked
                document.querySelectorAll('.receive-btn, .cancel-btn, .void-btn, .view-btn').forEach(optBtn => {
                    optBtn.addEventListener('click', () => {
                        closeAllDropdowns();
                    });
                });

                document.querySelectorAll('.options-btn').forEach(btn => {
                    btn.addEventListener('click', e => {
                        e.stopPropagation();
                        const poId = btn.dataset.poId;
                        const dropdown = document.getElementById('dropdown-' + poId);
                        if (!dropdown) return;

                        if (!dropdown.classList.contains('hidden')) {
                            // close it
                            dropdown.classList.add('hidden');
                            dropdown.style.position = '';
                            dropdown.style.top = '';
                            dropdown.style.left = '';
                            btn.setAttribute('aria-expanded', 'false');
                        } else {
                            // close others then open this one
                            closeAllDropdowns();
                            openDropdown(btn);
                        }
                    });
                });

                // Close when clicking outside
                document.addEventListener('click', e => {
                    const clickedDropdown = e.target.closest('[id^="dropdown-"]');
                    const clickedBtn = e.target.closest('.options-btn');
                    if (!clickedDropdown && !clickedBtn) {
                        closeAllDropdowns();
                    }
                });

                const receiveModal = document.getElementById('receive-modal');
                const receiveProductsContainer = document.getElementById('receive-products-container');
                let currentPoId = null;

                // Open receive modal
                document.querySelectorAll('.receive-btn').forEach(btn => {
                    btn.addEventListener('click', e => {

                        // close dropdown before opening modal
                        closeAllDropdowns();

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
                    if (!currentPoId) return;

                    const itemsPayload = [];

                    receiveProductsContainer.querySelectorAll('div.border').forEach(div => {
                        const productId = div.dataset.productId;
                        const poItemId = div.dataset.poItemId;
                        const qty = parseInt(div.querySelector('span:last-child').textContent.split(' ')[0]);
                        const markup = parseFloat(div.querySelector('.markup-input').value) || 20;

                        // Collect serials if inputs exist
                        const serials = [];
                        div.querySelectorAll('.serial-inputs input').forEach(inp => {
                            if (inp.value.trim()) serials.push(inp.value.trim());
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
                const poNumberEl = document.getElementById('po-number');
                const poSupplier = document.getElementById('po-supplier');
                const poNumberMeta = document.getElementById('po-number-meta');
                const poOrderDate = document.getElementById('po-order-date');
                const poReceivedDate = document.getElementById('po-received-date');
                const poCreatedBy = document.getElementById('po-created-by');
                const poStatus = document.getElementById('po-status');
                const poTotalItems = document.getElementById('po-total-items');
                const poTotalQty = document.getElementById('po-total-qty');
                const poTotalAmount = document.getElementById('po-total-amount');

                document.querySelectorAll('.view-btn').forEach(btn => {
                    btn.addEventListener('click', e => {
                        closeAllDropdowns();
                        const poId = btn.dataset.poId;

                        // Use PO id to fetch items AND PO metadata from the server, then populate modal
                        const url = `/purchase-orders/${poId}/items?inventory=1`;

                        axios.get(url)
                            .then(res => {
                                const items = Array.isArray(res.data.items) ? res.data.items : [];
                                const po = res.data.po || res.data.purchase_order || {};

                                // Populate PO meta from API response (uses returned `po` object)
                                poNumberEl.textContent = po.po_number || poId;
                                poNumberMeta.textContent = po.po_number || poId;
                                poSupplier.textContent = `Supplier: ${po.supplier?.company_name || '—'}`;
                                poOrderDate.textContent = po.order_date ? new Date(po.order_date).toLocaleDateString() : '—';
                                poReceivedDate.textContent = po.received_date ? new Date(po.received_date).toLocaleDateString() : '—';
                                poCreatedBy.textContent = po.creator?.full_name || '—';

                                // Map statuses to the same badge styles used in the table
                                const statusMap = {
                                    'pending': 'bg-yellow-100 text-yellow-800',
                                    'received': 'bg-green-100 text-green-800',
                                    'partial': 'bg-blue-100 text-blue-800',
                                    'cancelled': 'bg-red-100 text-red-800',
                                    'void': 'bg-red-100 text-red-800',
                                    'voided': 'bg-red-100 text-red-800'
                                };

                                const rawStatus = (po.status || '').toLowerCase();
                                poStatus.textContent = rawStatus ? (rawStatus.charAt(0).toUpperCase() + rawStatus.slice(1)) : '—';
                                poStatus.className = 'px-2.5 py-0.5 rounded-full text-xs font-medium ' + (statusMap[rawStatus] || 'bg-gray-100 text-gray-600');

                                // Clear and render items
                                viewContainer.innerHTML = '';

                                let totalQty = 0;
                                let totalLines = items.length;
                                let totalAmount = 0;

                                items.forEach(item => {
                                    const card = document.createElement('div');
                                    card.className = 'bg-white border rounded-lg p-4 shadow-sm';

                                    const inventoryItems = Array.isArray(item.inventory_items) ? item.inventory_items : [];

                                    // calculate line totals if unit_price present
                                    const unitPrice = parseFloat(item.unit_price || 0);
                                    const qtyOrdered = parseInt(item.quantity_ordered || 0) || 0;
                                    totalQty += qtyOrdered;
                                    totalAmount += unitPrice * qtyOrdered;

                                    // build a clearer card layout with SKU, qty, price, and serials placeholder
                                    const skuLabel = item.sku ? `<span class="text-xs text-gray-400">SKU: ${item.sku}</span>` : '';
                                    const trackingBadge = item.track_serials ? '<span class="px-2 py-0.5 text-xs rounded bg-emerald-100 text-emerald-800">Tracked</span>' : '<span class="px-2 py-0.5 text-xs rounded bg-yellow-100 text-yellow-800">Not tracked</span>';

                                    card.innerHTML = `
                                        <div class="flex items-start justify-between gap-4">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-3">
                                                    <div class="font-semibold text-gray-800">${item.product_name || 'Unnamed product'}</div>
                                                    ${skuLabel}
                                                    <div class="ml-2">${trackingBadge}</div>
                                                </div>
                                                <div class="text-xs text-gray-500 mt-1">Ordered: <strong>${qtyOrdered}</strong> unit(s) ${unitPrice ? `• Unit: ₱ ${unitPrice.toFixed(2)}` : ''}</div>
                                            </div>

                                            <div class="text-right">
                                                <div class="text-sm font-medium text-gray-600">Line total</div>
                                                <div class="text-lg font-semibold">₱ ${(unitPrice * qtyOrdered).toFixed(2)}</div>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <div class="text-sm font-medium mb-2">Serials / Inventory</div>
                                            <div class="text-sm text-gray-700" id="serials-${item.product_id}"></div>
                                        </div>
                                    `;

                                    // Insert into DOM then populate serials block
                                    viewContainer.appendChild(card);

                                    const serialsEl = document.getElementById(`serials-${item.product_id}`);

                                    if (!item.track_serials) {
                                        // Product doesn't track serials: friendly message
                                        serialsEl.innerHTML = `
                                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                                <span class="px-2 py-0.5 rounded bg-yellow-100 text-yellow-800 text-xs">Not tracked</span>
                                                <span>This product does not use serials or warranty numbers.</span>
                                            </div>
                                        `;
                                    } else {
                                        // Tracks serials - list inventory items if present
                                        if (inventoryItems.length === 0) {
                                            serialsEl.innerHTML = `<div class="text-gray-500">No serials recorded for this product.</div>`;
                                        } else {
                                            const ul = document.createElement('ul');
                                            ul.className = 'list-disc list-inside text-sm space-y-1';
                                            inventoryItems.forEach(inv => {
                                                const li = document.createElement('li');
                                                li.innerHTML = `<span class="font-medium">ID:</span> ${inv.id} ${inv.serial_number ? `| Serial: ${inv.serial_number}` : '| Serial: N/A'} ${inv.warranty ? `| Warranty: ${inv.warranty}` : ''}`;
                                                ul.appendChild(li);
                                            });
                                            serialsEl.appendChild(ul);
                                        }
                                    }
                                });

                                // Totals
                                poTotalItems.textContent = totalLines;
                                poTotalQty.textContent = totalQty;
                                poTotalAmount.textContent = `₱ ${totalAmount.toFixed(2)}`;

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

                // Close (X) in header
                const viewCloseX = document.getElementById('view-close-x');
                if (viewCloseX) {
                    viewCloseX.addEventListener('click', () => viewModal.classList.add('hidden'));
                }
            }); // <-- Close document.addEventListener('DOMContentLoaded', ...)
        </script>
    @endpush

@endsection