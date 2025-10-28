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
                                            data-po-id="{{ $po->id }}" data-po-number="{{ $po->po_number }}"
                                            data-po-order-date="{{ $po->order_date?->toDateString() ?? '' }}"
                                            data-po-received-date="{{ $po->received_date?->toDateString() ?? '' }}"
                                            data-po-created-by="{{ $po->creator?->full_name ?? '' }}"
                                            data-po-supplier="{{ $po->supplier?->company_name ?? '' }}"
                                            data-po-status="{{ $po->status ?? '' }}">View Items</button>
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
    <div id="receive-modal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 backdrop-blur-sm global-focus">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-4xl overflow-hidden max-h-[90vh] flex flex-col">
            <!-- Header -->
            <div
                class="flex items-center justify-between gap-4 p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-blue-50">
                <div class="flex items-center gap-3">
                    <div class="rounded-full bg-green-100 p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-6 text-green-600">
                            <path fill-rule="evenodd"
                                d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z"
                                clip-rule="evenodd" />
                            <path fill-rule="evenodd"
                                d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Receive Purchase Order</h2>
                        <p class="text-sm text-gray-600">Confirm received items and serial numbers</p>
                    </div>
                </div>

                <button id="receive-close-x"
                    class="text-gray-500 hover:text-red-500 transition-colors p-1 rounded-full hover:bg-red-50">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Body (scrollable) -->
            <div class="p-6 overflow-y-auto flex-1 bg-gray-50">
                <form id="receive-form">
                    <div id="receive-products-container" class="space-y-5">
                        <!-- Dynamically filled with products & serial inputs & markup -->
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="flex items-center justify-end p-5 border-t border-gray-200 bg-white">

                <div class="flex items-center gap-3">
                    <button id="receive-cancel" type="button"
                        class="px-5 py-2.5 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 font-medium transition-colors">Cancel</button>
                    <button form="receive-form" type="submit" id="confirm-receive-btn"
                        class="px-5 py-2.5 bg-primary hover:bg-emerald-700 text-white rounded-lg hover:bg-green-700 font-medium transition-colors shadow-sm disabled:bg-gray-400 disabled:cursor-not-allowed">Confirm
                        Receive</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Items Modal -->
    <div id="view-items-modal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 backdrop-blur-sm">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-4xl overflow-hidden max-h-[90vh] flex flex-col">
            <!-- Header -->
            <div class="flex items-start gap-4 p-5 border-b border-gray-200 bg-gradient-to-r from-green-50 to-blue-50">
                <div class="flex items-start gap-4">
                    <div class="rounded-full bg-primary/20 p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-6 text-primary">
                            <path fill-rule="evenodd"
                                d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z"
                                clip-rule="evenodd" />
                            <path fill-rule="evenodd"
                                d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375ZM6 12a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V12Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 15a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V15Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 18a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V18Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <!-- make this supplier block a vertical flex so status can be placed at the bottom -->
                    <div class="flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800" id="po-number">—</h3>
                            <p class="text-sm text-gray-600 mt-1" id="po-supplier">Supplier: —</p>
                        </div>

                        <!-- moved status into supplier column so it's positioned under supplier info -->
                        <div class="mt-1">
                            <span class="text-xs text-gray-500">Status</span>
                            <span id="po-status"
                                class="px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">—</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-start gap-3 self-end justify-end ml-auto">

                    <!-- Export & Print buttons -->
                    <div class="flex items-center gap-2">
                        <button id="export-pdf-btn"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-primary text-white rounded-lg hover:bg-emerald-700 transition-colors text-sm font-medium w-36">
                            <!-- small PDF icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-4 text-white">
                                <path fill-rule="evenodd"
                                    d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875Zm5.845 17.03a.75.75 0 0 0 1.06 0l3-3a.75.75 0 1 0-1.06-1.06l-1.72 1.72V12a.75.75 0 0 0-1.5 0v4.19l-1.72-1.72a.75.75 0 0 0-1.06 1.06l3 3Z"
                                    clip-rule="evenodd" />
                                <path
                                    d="M14.25 5.25a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963A5.23 5.23 0 0 0 16.5 7.5h-1.875a.375.375 0 0 1-.375-.375V5.25Z" />
                            </svg>

                            <span>Export PDF</span>
                        </button>

                        <button id="print-btn"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition-colors text-sm font-medium w-36">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                <path fill-rule="evenodd"
                                    d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 0 0 3 3h.27l-.155 1.705A1.875 1.875 0 0 0 7.232 22.5h9.536a1.875 1.875 0 0 0 1.867-2.045l-.155-1.705h.27a3 3 0 0 0 3-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0 0 18 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM16.5 6.205v-2.83A.375.375 0 0 0 16.125 3h-8.25a.375.375 0 0 0-.375.375v2.83a49.353 49.353 0 0 1 9 0Zm-.217 8.265c.178.018.317.16.333.337l.526 5.784a.375.375 0 0 1-.374.409H7.232a.375.375 0 0 1-.374-.409l.526-5.784a.373.373 0 0 1 .333-.337 41.741 41.741 0 0 1 8.566 0Zm.967-3.97a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H18a.75.75 0 0 1-.75-.75V10.5ZM15 9.75a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V10.5a.75.75 0 0 0-.75-.75H15Z"
                                    clip-rule="evenodd" />
                            </svg>

                            <span>Print</span>
                        </button>
                    </div>
                </div>
                <!-- Close (X) button -->
                <button id="view-close-x" class="text-gray-400 hover:text-red-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Body: scrollable -->
            <div id="view-items-body" class="p-5 overflow-y-auto space-y-6 flex-1">
                <!-- Summary Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                        <div class="text-sm text-blue-600 font-medium">Total Line Items</div>
                        <div id="po-total-items" class="text-xl font-bold text-gray-800 mt-1">0</div>
                    </div>
                    <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-100">
                        <div class="text-sm text-yellow-600 font-medium">Total Quantity</div>
                        <div id="po-total-qty" class="text-xl font-bold text-gray-800 mt-1">0</div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                        <div class="text-sm font-medium text-green-600">Estimated Total</div>
                        <div id="po-total-amount" class="text-xl font-bold text-gray-800 mt-1">₱ 0.00</div>
                    </div>
                </div>

                <!-- PO meta information -->
                <div id="po-meta-row" class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Order Details</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        <div>
                            <div class="text-xs text-gray-500">PO Number</div>
                            <div id="po-number-meta" class="text-sm font-medium">—</div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">Order Date</div>
                            <div id="po-order-date" class="text-sm font-medium">—</div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">Received Date</div>
                            <div id="po-received-date" class="text-sm font-medium">—</div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">Created By</div>
                            <div id="po-created-by" class="text-sm font-medium">—</div>
                        </div>
                    </div>
                </div>

                <!-- Products list -->
                <div>
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Order Items</h4>
                    <div id="view-items-container" class="space-y-4">
                        <!-- Dynamically filled product cards -->
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex items-center justify-end gap-3 p-4 border-t border-gray-200 bg-gray-50">
                <button id="view-close"
                    class="px-5 py-2.5 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 font-medium transition-colors">Close</button>
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
                                    // add a specific class so we only select top-level product cards later
                                    div.className = 'border border-2 border-dashed rounded p-3 po-receive-item';

                                    // store structured dataset values (strings are fine; we'll parse them later)
                                    div.dataset.productId = item.product_id ?? '';
                                    div.dataset.poItemId = item.id ?? '';
                                    // keep quantity explicitly in dataset so we don't have to parse text
                                    div.dataset.qty = String(item.quantity_ordered ?? 0);


                                    // store base purchase price (unit price from PO item)
                                    const basePrice = parseFloat(item.unit_price || 0);
                                    div.dataset.basePrice = basePrice;

                                    // Build markup + unit cost UI
                                    div.innerHTML = `
                                                        <div class="flex justify-between items-center mb-2">
                                                            <span class="font-semibold">${item.product_name}</span>
                                                            <span class="qty-span font-medium">Qty: ${item.quantity_ordered}</span>
                                                        </div>

                                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-start">
                                                            <div class="mt-1">
                                                                <label class="block mb-1 text-sm font-medium text-gray-500">Purchase Price</label>
                                                                <div class="font-medium">₱ ${basePrice.toFixed(2)}</div>
                                                            </div>

                                                            <div class="flex flex-col justify-center">
                                                                <label class="block mb-1 font-medium">Unit Cost (₱)</label>
                                                                <input type="number" min="0" step="0.01" class="border rounded px-2 py-1 w-full unit-cost-input" value="${(basePrice * 1.2).toFixed(2)}">
                                                            </div>

                                                            <div class="flex flex-col justify-center">
                                                                <label class="block mb-1 font-medium">Markup %</label>
                                                                <input type="number" min="0" step="0.01" value="20" class="border rounded px-2 py-1 w-full markup-input">
                                                            </div>
                                                        </div>


                                                        <div class="mt-2 track-info">
                                                        <hr class="my-3 border-t">
                                                            <label class="block mb-1 font-medium">Serial Numbers</label>
                                                                    <div class="serial-inputs mt-1" style="display:block"></div>
                                                                </div>

                                                        <div class="mt-2">
                                                            <div class="receive-error text-red-600 text-sm mt-2 hidden">Unit cost must be >= purchase price (no negative markup allowed).</div>
                                                        </div>
                                                    `;
                                    // Serial inputs container
                                    const serialInputsContainer = div.querySelector('.serial-inputs');

                                    if (item.track_serials) {
                                        // Use a responsive grid: up to 3 columns; if more inputs than columns, grid will create new rows
                                        const cols = Math.min(item.quantity_ordered, 3) || 1;
                                        serialInputsContainer.style.display = 'grid';
                                        serialInputsContainer.style.gridTemplateColumns = `repeat(${cols}, minmax(0, 1fr))`;
                                        serialInputsContainer.style.gap = '8px';
                                        serialInputsContainer.style.alignItems = 'start';

                                        for (let i = 0; i < item.quantity_ordered; i++) {
                                            const wrapper = document.createElement('div');
                                            wrapper.className = 'flex';
                                            const input = document.createElement('input');
                                            input.type = 'text';
                                            input.placeholder = 'Serial #' + (i + 1);
                                            // make inputs fill the column — for narrow screens they will be full width
                                            input.className = 'border rounded px-2 py-1 w-full block';
                                            wrapper.appendChild(input);
                                            serialInputsContainer.appendChild(wrapper);
                                        }
                                    } else {
                                        // show not-tracked message similar to view modal
                                        serialInputsContainer.innerHTML = `
                                                            <div class="flex items-center gap-3 p-3 bg-amber-50 rounded-lg border border-amber-100">
                                                                <svg class="w-3  h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                </svg>
                                                                <span class="text-amber-700 text-xs">This product does not use serial numbers.</span>
                                                            </div>
                                                        `;
                                    }

                                    receiveProductsContainer.appendChild(div);

                                    // Hook up sync logic between markup and unit cost
                                    const markupInput = div.querySelector('.markup-input');
                                    const unitCostInput = div.querySelector('.unit-cost-input');
                                    const errorEl = div.querySelector('.receive-error');

                                    const setError = (msg) => {
                                        errorEl.textContent = msg;
                                        errorEl.classList.remove('hidden');
                                        div.dataset.invalid = '1';
                                    };

                                    const clearError = () => {
                                        errorEl.classList.add('hidden');
                                        div.dataset.invalid = '0';
                                    };

                                    // initialize validity
                                    clearError();

                                    // When markup changes, update unit cost (based on basePrice)
                                    markupInput.addEventListener('input', () => {
                                        let m = parseFloat(markupInput.value);
                                        if (isNaN(m)) m = 0;
                                        if (m < 0) {
                                            setError('Markup cannot be negative.');
                                            m = 0;
                                            markupInput.value = '0';
                                        }
                                        const newUnit = +(basePrice * (1 + (m / 100))).toFixed(2);
                                        unitCostInput.value = newUnit;
                                        // clear error if profitable
                                        if (newUnit >= basePrice) clearError();
                                    });

                                    // When unit cost changes, update markup
                                    unitCostInput.addEventListener('input', () => {
                                        let uc = parseFloat(unitCostInput.value);
                                        if (isNaN(uc) || uc < 0) {
                                            setError('Unit cost must be a positive number.');
                                            return;
                                        }
                                        const computedMarkup = ((uc / basePrice) - 1) * 100;
                                        if (isFinite(computedMarkup) && !isNaN(computedMarkup)) {
                                            const rounded = Math.round(computedMarkup * 100) / 100;
                                            markupInput.value = rounded < 0 ? '0' : rounded;
                                        }
                                        // validate profitability
                                        if (uc < basePrice) {
                                            setError('Unit cost must be >= purchase price (no negative markup allowed).');
                                        } else {
                                            clearError();
                                        }
                                    });
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

                // Close (X) button in receive modal (matches view modal behavior)
                const receiveCloseX = document.getElementById('receive-close-x');
                if (receiveCloseX) {
                    receiveCloseX.addEventListener('click', () => receiveModal.classList.add('hidden'));
                }

                // Submit receive form
                document.getElementById('receive-form').addEventListener('submit', e => {
                    e.preventDefault();
                    if (!currentPoId) return;

                    const itemsPayload = [];
                    let hasInvalid = false;
                    const invalidEntries = [];

                    // ONLY select the top-level product cards we created earlier
                    receiveProductsContainer.querySelectorAll('.po-receive-item').forEach(div => {
                        // read dataset (strings) — parse safely
                        const productIdRaw = div.dataset.productId;
                        const poItemIdRaw = div.dataset.poItemId;
                        const qtyRaw = div.dataset.qty;

                        const productId = productIdRaw ? (isNaN(productIdRaw) ? productIdRaw : parseInt(productIdRaw)) : null;
                        const poItemId = poItemIdRaw ? (isNaN(poItemIdRaw) ? poItemIdRaw : parseInt(poItemIdRaw)) : null;
                        const qty = parseInt(qtyRaw || '0', 10) || 0;

                        const basePrice = parseFloat(div.dataset.basePrice || 0);

                        const markupInputEl = div.querySelector('.markup-input');
                        const unitCostEl = div.querySelector('.unit-cost-input');
                        const serialInputs = div.querySelectorAll('.serial-inputs input');

                        const serials = [];
                        serialInputs.forEach(inp => { if (inp.value.trim()) serials.push(inp.value.trim()); });

                        const unit_cost = parseFloat(unitCostEl?.value) || basePrice;
                        let markup = parseFloat(markupInputEl?.value);
                        if (isNaN(markup)) {
                            markup = basePrice > 0 ? (((unit_cost / basePrice) - 1) * 100) : 0;
                            markup = Math.round(markup * 100) / 100;
                        }

                        // validate minimal server requirements before pushing
                        if (!poItemId || !productId || qty < 1) {
                            hasInvalid = true;
                            invalidEntries.push({ poItemId, productId, qty });
                            // Optionally mark UI
                            div.classList.add('ring', 'ring-red-300');
                            return; // skip adding invalid entry
                        } else {
                            // ensure any previous error highlight is removed
                            div.classList.remove('ring', 'ring-red-300');
                        }

                        itemsPayload.push({
                            po_item_id: poItemId,
                            product_id: productId,
                            quantity: qty,
                            // rename to whichever key your backend expects; you used "serials" in your code
                            serials: serials,
                            markup: parseFloat(markup.toFixed(2)),
                            unit_cost: parseFloat(unit_cost.toFixed(2))
                        });
                    });

                    if (hasInvalid) {
                        console.warn('Invalid receive items:', invalidEntries);
                        showToast('One or more items are missing required data (po_item_id / product_id / quantity). Please refresh or re-open the modal.', 'error');
                        return;
                    }

                    // Debug: inspect payload in console (Network tab will show same payload)
                    console.log('receive itemsPayload', JSON.parse(JSON.stringify(itemsPayload)));

                    axios.post(`/purchase-orders/${currentPoId}/receive`, { items: itemsPayload })
                        .then(res => {
                            showToast(res.data.message || 'PO received successfully', 'success');
                            receiveModal.classList.add('hidden');
                            window.location.reload();
                        })
                        .catch(err => {
                            console.error('Receive POST failed:', err, err?.response?.data);
                            showToast(err.response?.data?.message || 'Failed to receive PO', 'error');
                        });
                });


                //View Items Modal Logic

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

                // Status mapping for consistent styling
                const statusMap = {
                    'pending': { class: 'bg-yellow-100 text-yellow-800', label: 'Pending' },
                    'received': { class: 'bg-green-100 text-green-800', label: 'Received' },
                    'partial': { class: 'bg-blue-100 text-blue-800', label: 'Partial' },
                    'cancelled': { class: 'bg-red-100 text-red-800', label: 'Cancelled' },
                    'void': { class: 'bg-red-100 text-red-800', label: 'Void' },
                    'voided': { class: 'bg-red-100 text-red-800', label: 'Voided' }
                };

                // Helper functions
                const formatCurrency = (amount) => `₱ ${parseFloat(amount || 0).toFixed(2)}`;
                const formatDate = (dateString) => dateString ? new Date(dateString).toLocaleDateString() : '—';

                const updatePOMetadata = (po, poId) => {
                    const rawStatus = (po.status || '').toLowerCase();
                    const statusConfig = statusMap[rawStatus] || { class: 'bg-gray-100 text-gray-600', label: rawStatus || '—' };

                    poNumberEl.textContent = po.po_number || poId;
                    poNumberMeta.textContent = po.po_number || poId;
                    poSupplier.textContent = `Supplier: ${po.supplier?.company_name || '—'}`;
                    poOrderDate.textContent = formatDate(po.order_date);
                    poReceivedDate.textContent = formatDate(po.received_date);
                    poCreatedBy.textContent = po.creator?.full_name || '—';

                    poStatus.textContent = statusConfig.label.charAt(0).toUpperCase() + statusConfig.label.slice(1);
                    poStatus.className = `px-3 py-1 rounded-full text-xs font-medium ${statusConfig.class}`;
                };

                // Keep the currently viewed PO & items available for export/print
                window.currentViewedPO = null;

                // Build printable HTML for PO (simple professional layout)
                const buildPrintableHtml = ({ po, items }) => {
                    // small inline logo SVG
                    const logoSvg = `
                                                        <svg width="120" height="36" viewBox="0 0 240 72" xmlns="http://www.w3.org/2000/svg">
                                                            <rect rx="8" width="240" height="72" fill="#10b981"></rect>
                                                            <text x="28" y="46" font-family="Arial, Helvetica, sans-serif" font-size="28" fill="#ffffff">BZ Solutions</text>
                                                        </svg>`;

                    const poNumber = po.po_number || '—';
                    const supplier = po.supplier?.company_name || '—';
                    const orderDate = po.order_date ? new Date(po.order_date).toLocaleDateString() : '—';
                    const receivedDate = po.received_date ? new Date(po.received_date).toLocaleDateString() : '—';
                    const createdBy = po.creator?.full_name || '—';
                    const status = po.status ? po.status.charAt(0).toUpperCase() + po.status.slice(1) : '—';

                    const rows = (items || []).map(it => {
                        const unit = parseFloat(it.unit_price || 0);
                        const qty = parseInt(it.quantity_ordered || 0) || 0;
                        const line = unit * qty;
                        return `
                                                            <tr>
                                                                <td class="td">${it.product_name || '—'}</td>
                                                                <td class="td">${it.sku || '—'}</td>
                                                                <td class="td" style="text-align:center">${qty}</td>
                                                                <td class="td" style="text-align:right">${unit ? `₱ ${unit.toFixed(2)}` : '—'}</td>
                                                                <td class="td" style="text-align:right">₱ ${line.toFixed(2)}</td>
                                                            </tr>
                                                        `;
                    }).join('');

                    const totalAmount = (items || []).reduce((s, it) => s + (parseFloat(it.unit_price || 0) * (parseInt(it.quantity_ordered || 0) || 0)), 0);

                    return `
                                                    <!doctype html>
                                                    <html>
                                                    <head>
                                                        <meta charset="utf-8" />
                                                        <title>PO ${poNumber}</title>
                                                        <meta name="viewport" content="width=device-width,initial-scale=1" />
                                                        <style>
                                                            body { font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif; color: #111827; padding: 24px; }
                                                            .header { display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; }
                                                            .meta { text-align:right; }
                                                            h1 { margin:0; font-size:20px; }
                                                            .box { border:1px solid #e5e7eb; padding:12px; border-radius:6px; }
                                                            table { width:100%; border-collapse:collapse; margin-top:12px; }
                                                            th { text-align:left; padding:8px 6px; border-bottom:1px solid #e5e7eb; font-size:12px; color:#6b7280; }
                                                            td.td { padding:10px 6px; border-bottom:1px solid #f3f4f6; font-size:13px; }
                                                            .totals { margin-top:12px; text-align:right; font-weight:600; }
                                                            @media print { @page { size: A4; margin: 20mm; } body { padding:0; } .no-print { display:none !important } }
                                                        </style>
                                                    </head>
                                                    <body>
                                                        <div class="header">
                                                            <div class="brand">${logoSvg}</div>
                                                            <div class="meta">
                                                                <div style="font-size:12px;color:#6b7280">Purchase Order</div>
                                                                <h1>PO ${poNumber}</h1>
                                                                <div style="font-size:12px;color:#374151">${supplier}</div>
                                                            </div>
                                                        </div>

                                                        <div class="grid" style="display:flex; gap:12px; margin-bottom:12px;">
                                                            <div class="box" style="flex:1">
                                                                <div style="font-size:12px;color:#6b7280">Order Date</div>
                                                                <div style="font-weight:600">${orderDate}</div>
                                                            </div>
                                                            <div class="box" style="flex:1">
                                                                <div style="font-size:12px;color:#6b7280">Received Date</div>
                                                                <div style="font-weight:600">${receivedDate}</div>
                                                            </div>
                                                            <div class="box" style="flex:1">
                                                                <div style="font-size:12px;color:#6b7280">Created By</div>
                                                                <div style="font-weight:600">${createdBy}</div>
                                                            </div>
                                                            <div class="box" style="flex:1">
                                                                <div style="font-size:12px;color:#6b7280">Status</div>
                                                                <div style="font-weight:600">${status}</div>
                                                            </div>
                                                        </div>

                                                        <table>
                                                            <thead>
                                                                <tr>
                                                                    <th>Item</th>
                                                                    <th>SKU</th>
                                                                    <th style="text-align:center">Qty</th>
                                                                    <th style="text-align:right">Unit</th>
                                                                    <th style="text-align:right">Line Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                ${rows}
                                                            </tbody>
                                                        </table>

                                                        <div class="totals">Estimated Total: ₱ ${totalAmount.toFixed(2)}</div>

                                                    </body>
                                                    </html>
                                                    `;
                };

                // NOTE: removed named openPrintableWindow per request; handlers below inline the open/print flow

                const createProductCard = (item, inventoryItems, totalAmount) => {
                    const unitPrice = parseFloat(item.unit_price || 0);
                    const qtyOrdered = parseInt(item.quantity_ordered || 0) || 0;
                    const lineTotal = unitPrice * qtyOrdered;

                    const card = document.createElement('div');
                    card.className = 'bg-white border border-2 border-dashed border-gray-200 rounded-lg p-4 hover:shadow-sm transition-shadow';

                    const skuLabel = item.sku ?
                        `<span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">SKU: ${item.sku}</span>` : '';

                    const trackingBadge = item.track_serials ?
                        '<span class="px-2 py-1 text-xs rounded bg-emerald-100 text-emerald-800 border border-emerald-200">Tracked</span>' :
                        '<span class="px-2 py-1 text-xs rounded bg-amber-100 text-amber-800 border border-amber-200">Not tracked</span>';

                    card.innerHTML = `
                                                        <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                                                            <div class="flex-1">
                                                                <div class="flex flex-col sm:flex-row sm:items-center gap-2 mb-2">
                                                                    <h5 class="font-semibold text-gray-800 text-lg">${item.product_name || 'Unnamed product'}</h5>
                                                                    <div class="flex flex-wrap gap-2">
                                                                        ${skuLabel}
                                                                        ${trackingBadge}
                                                                    </div>
                                                                </div>
                                                                <div class="text-sm text-gray-600 mt-2">
                                                                    <div class="flex flex-wrap gap-4">
                                                                        <span>Ordered: <strong class="text-gray-800">${qtyOrdered}</strong> unit(s)</span>
                                                                        ${unitPrice ? `<span>Unit Price: <strong class="text-gray-800">${formatCurrency(unitPrice)}</strong></span>` : ''}
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="text-right">
                                                                <div class="text-sm font-medium text-gray-500">Line Total</div>
                                                                <div class="text-xl font-bold text-primary">${formatCurrency(lineTotal)}</div>
                                                            </div>
                                                        </div>
                                                        <div class="mt-4 pt-4 border-t border-gray-100">
                                                            <div class="flex items-center gap-2 mb-2">
                                                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                                </svg>
                                                                <h6 class="text-sm font-medium text-gray-700">Serial ID</h6>
                                                            </div>
                                                            <div class="text-sm text-gray-700" id="serials-${item.product_id}"></div>
                                                        </div>
                                                    `;

                    return { card, lineTotal, qtyOrdered, productId: item.product_id };
                };

                const populateSerialsInfo = (productId, trackSerials, inventoryItems) => {
                    const serialsEl = document.getElementById(`serials-${productId}`);

                    if (!serialsEl) return;

                    if (!trackSerials) {
                        serialsEl.innerHTML = `
                                                            <div class="flex items-center gap-3 p-3 bg-amber-50 rounded-lg border border-amber-100">
                                                                <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                                                </svg>
                                                                <span class="text-amber-700">This product does not use serial numbers.</span>
                                                            </div>
                                                        `;
                    } else if (inventoryItems.length === 0) {
                        serialsEl.innerHTML = `
                                                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                                                                <svg class="w-5 h-5 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m8-8V4a1 1 0 00-1-1h-2a1 1 0 00-1 1v1M9 7h6"></path>
                                                                </svg>
                                                                <span class="text-gray-600">No serials recorded for this product.</span>
                                                            </div>
                                                        `;
                    } else {
                        const tableContainer = document.createElement('div');
                        // give a small horizontal margin so the table doesn't stretch too wide
                        tableContainer.className = 'overflow-x-auto rounded-lg border border-gray-200 mx-2';

                        const table = document.createElement('table');
                        // use w-full and reduce horizontal paddings for narrower width
                        table.className = 'w-full divide-y divide-gray-200 text-center text-sm';

                        table.innerHTML = `
                                                            <thead class="bg-gray-50">
                                                                <tr>
                                                                    <th class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                                                    <th class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Serial Number</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="bg-white divide-y divide-gray-200">
                                                                ${inventoryItems.map(inv => `
                                                                    <tr class="hover:bg-gray-50">
                                                                        <td class="px-2 py-3 text-sm text-gray-700">${inv.id}</td>
                                                                        <td class="px-2 py-3 text-sm text-gray-700 font-mono">${inv.serial_number || 'N/A'}</td>
                                                                    </tr>
                                                                `).join('')}
                                                            </tbody>
                                                        `;

                        tableContainer.appendChild(table);
                        serialsEl.appendChild(tableContainer);
                    }
                };

                const renderItems = (items) => {
                    viewContainer.innerHTML = '';

                    let totalQty = 0;
                    let totalLines = items.length;
                    let totalAmount = 0;

                    items.forEach(item => {
                        const inventoryItems = Array.isArray(item.inventory_items) ? item.inventory_items : [];

                        const { card, lineTotal, qtyOrdered, productId } = createProductCard(item, inventoryItems, totalAmount);
                        viewContainer.appendChild(card);

                        totalQty += qtyOrdered;
                        totalAmount += lineTotal;

                        // Populate serials information after card is added to DOM
                        setTimeout(() => {
                            populateSerialsInfo(productId, item.track_serials, inventoryItems);
                        }, 0);
                    });

                    // Update totals
                    poTotalItems.textContent = totalLines;
                    poTotalQty.textContent = totalQty;
                    poTotalAmount.textContent = formatCurrency(totalAmount);
                };

                // Event listeners for view buttons
                document.querySelectorAll('.view-btn').forEach(btn => {
                    btn.addEventListener('click', e => {
                        closeAllDropdowns();
                        const poId = btn.dataset.poId;
                        const url = `/purchase-orders/${poId}/items?inventory=1`;

                        // Show loading state
                        viewContainer.innerHTML = `
                                                            <div class="flex justify-center items-center py-12">
                                                                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                                                                <span class="ml-3 text-gray-600">Loading purchase order details...</span>
                                                            </div>
                                                        `;

                        viewModal.classList.remove('hidden');

                        axios.get(url)
                            .then(res => {
                                const items = Array.isArray(res.data.items) ? res.data.items : [];
                                const po = res.data.po || res.data.purchase_order || {};

                                // Merge dataset with API response
                                const ds = btn.dataset || {};
                                po.po_number = po.po_number || ds.poNumber || poId;
                                po.supplier = po.supplier || { company_name: ds.poSupplier || '' };
                                po.order_date = po.order_date || ds.poOrderDate || '';
                                po.received_date = po.received_date || ds.poReceivedDate || '';
                                po.creator = po.creator || { full_name: ds.poCreatedBy || '' };
                                po.status = po.status || ds.poStatus || '';

                                updatePOMetadata(po, poId);
                                renderItems(items);

                                // keep a snapshot for export/print
                                window.currentViewedPO = { po: po, items: items };
                            })
                            .catch(err => {
                                console.error('Failed to fetch PO items:', err);
                                viewContainer.innerHTML = `
                                                                    <div class="text-center py-8">
                                                                        <svg class="w-12 h-12 text-red-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                        </svg>
                                                                        <h3 class="text-lg font-medium text-gray-900 mb-2">Failed to load purchase order</h3>
                                                                        <p class="text-gray-600 mb-4">Please try again or contact support if the problem persists.</p>
                                                                        <button onclick="viewModal.classList.add('hidden')" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                                                                            Close
                                                                        </button>
                                                                    </div>
                                                                `;
                                showToast('Failed to fetch purchase order details', 'error');
                            });
                    });
                });

                // Export / Print button handlers
                const exportBtn = document.getElementById('export-pdf-btn');
                const printBtn = document.getElementById('print-btn');

                if (exportBtn) {
                    exportBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        if (!window.currentViewedPO) {
                            showToast('No purchase order loaded to export', 'error');
                            return;
                        }

                        // Inline flow: open new window with printable HTML and call print()
                        try {
                            const html = buildPrintableHtml(window.currentViewedPO);
                            const w = window.open('', '_blank', 'noopener');
                            if (!w) {
                                showToast('Pop-up blocked. Please allow pop-ups for this site to export/print.', 'error');
                                return;
                            }
                            w.document.open();
                            w.document.write(html);
                            w.document.close();
                            w.focus();
                            // give the browser a short moment to render
                            setTimeout(() => {
                                try { w.print(); } catch (err) { console.error('Print failed', err); }
                            }, 400);
                        } catch (err) {
                            console.error('Export failed', err);
                            showToast('Failed to export PO', 'error');
                        }
                    });
                }

                if (printBtn) {
                    printBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        if (!window.currentViewedPO) {
                            showToast('No purchase order loaded to print', 'error');
                            return;
                        }

                        // Inline flow: open new window with printable HTML and call print()
                        try {
                            const html = buildPrintableHtml(window.currentViewedPO);
                            const w = window.open('', '_blank', 'noopener');
                            if (!w) {
                                showToast('Pop-up blocked. Please allow pop-ups for this site to export/print.', 'error');
                                return;
                            }
                            w.document.open();
                            w.document.write(html);
                            w.document.close();
                            w.focus();
                            setTimeout(() => {
                                try { w.print(); } catch (err) { console.error('Print failed', err); }
                            }, 400);
                        } catch (err) {
                            console.error('Print failed', err);
                            showToast('Failed to print PO', 'error');
                        }
                    });
                }

                // Close modal handlers
                document.getElementById('view-close').addEventListener('click', () => {
                    viewModal.classList.add('hidden');
                });

                document.getElementById('view-close-x').addEventListener('click', () => {
                    viewModal.classList.add('hidden');
                });

                // Close modal when clicking outside
                viewModal.addEventListener('click', (e) => {
                    if (e.target === viewModal) {
                        viewModal.classList.add('hidden');
                    }
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