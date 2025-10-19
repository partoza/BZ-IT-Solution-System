@extends('layout.app')

@section('content')
<div class="min-h-screen flex">
    <!-- Sidebar -->
    <aside id="sidebar" class="bg-white border-r border-neutral-200 w-64 hidden md:flex flex-col">
        <div class="p-4 flex items-center gap-3">
            <img src="/assets/img/logo.png" alt="logo" class="w-12 h-12 object-contain">
            <div>
                <div class="font-semibold text-lg">BZ IT Solutions</div>
                <div class="text-xs text-neutral-500">Affordable IT Solutions</div>
            </div>
        </div>

        <nav class="flex-1 px-2 py-4 overflow-y-auto">
            <ul class="space-y-1">
                <li><a href="/"
                        class="flex items-center gap-3 p-2 rounded-md hover:bg-neutral-100"><span>Dashboard</span></a>
                </li>
                <li><a href="#"
                        class="flex items-center gap-3 p-2 rounded-md hover:bg-neutral-100"><span>Inventory</span></a>
                </li>
                <li><a href="#"
                        class="flex items-center gap-3 p-2 rounded-md hover:bg-neutral-100"><span>Services</span></a>
                </li>
                <li><a href="#"
                        class="flex items-center gap-3 p-2 rounded-md hover:bg-neutral-100"><span>Customer</span></a>
                </li>
                <li><a href="#"
                        class="flex items-center gap-3 p-2 rounded-md hover:bg-neutral-100"><span>Employee</span></a>
                </li>
                <li><a href="#"
                        class="flex items-center gap-3 p-2 rounded-md hover:bg-neutral-100"><span>History</span></a>
                </li>
                <li><a href="#"
                        class="flex items-center gap-3 p-2 rounded-md hover:bg-neutral-100"><span>Settings</span></a>
                </li>
            </ul>
        </nav>
        <div class="p-4 border-t border-neutral-100">
            <div class="text-sm">John Rex</div>
            <div class="text-xs text-neutral-500">Admin</div>
        </div>
    </aside>

<<<<<<< HEAD
        <!-- Main content area -->
        <div class="flex-1 flex flex-col my-5 mx-10">
            <!-- Top container: search + profile. On small screens show mobile toggle and stack elements. No dark mode icon. -->
            <header class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <div class="flex items-center gap-3">
                            <!-- Mobile: sidebar toggle -->
                            <button id="mobile-toggle" class="md:hidden p-2 rounded-md hover:bg-neutral-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>

                            <!-- Search -->
                            <div class="relative w-full max-w-xl">
                                <input type="search" name="q" placeholder="Search..."
                                    class="w-full border border-neutral-200 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-300" />
                            </div>
=======
    <!-- Main content area -->
    <div class="flex-1 flex flex-col">
        <!-- Top container: search + profile. On small screens show mobile toggle and stack elements. No dark mode icon. -->
        <header class="bg-white border-b border-neutral-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center gap-3">
                        <!-- Mobile: sidebar toggle -->
                        <button id="mobile-toggle" class="md:hidden p-2 rounded-md hover:bg-neutral-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <!-- Search -->
                        <div class="relative w-full max-w-xl">
                            <input type="search" name="q" placeholder="Search..."
                                class="w-full border border-neutral-200 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-300" />
>>>>>>> parent of b3ca02e (Sidebar Changes)
                        </div>
                    </div>

                    <!-- Right side: profile only (no dark mode icon) -->
                    <div class="flex items-center gap-4">
                        <div class="text-right hidden sm:block">
                            <div class="font-medium">John Rex</div>
                            <div class="text-xs text-neutral-500">Admin</div>
                        </div>
                        <div class="flex items-center gap-2">
                            <img src="/assets/img/avatar.png" alt="avatar" class="w-10 h-10 rounded-full object-cover">
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page content: ensure pages like dashboard render below the top container -->
        <main class="flex-1 overflow-y-auto bg-neutral-50 p-6">
            <div class="max-w-7xl mx-auto">
                {{-- Page specific content will be injected here --}}
                @yield('pages-content')
            </div>
        </main>
    </div>
</div>

@push('scripts')
<script>
    // Simple mobile sidebar toggle
    (function () {
        const btn = document.getElementById('mobile-toggle');
        const sidebar = document.getElementById('sidebar');
        if (!btn || !sidebar) return;
        btn.addEventListener('click', function () {
            // toggle visible on small screens
            if (sidebar.classList.contains('hidden')) {
                sidebar.classList.remove('hidden');
                sidebar.classList.add('fixed', 'inset-y-0', 'left-0', 'z-40', 'w-64', 'bg-white', 'shadow-lg');
            } else {
                sidebar.classList.add('hidden');
                sidebar.classList.remove('fixed', 'inset-y-0', 'left-0', 'z-40', 'w-64', 'bg-white', 'shadow-lg');
            }
        });
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function (e) {
            if (window.innerWidth >= 768) return; // only for mobile
            if (!sidebar.classList.contains('hidden')) {
                const isClickInside = sidebar.contains(e.target) || btn.contains(e.target);
                if (!isClickInside) {
                    sidebar.classList.add('hidden');
                    sidebar.classList.remove('fixed', 'inset-y-0', 'left-0', 'z-40', 'w-64', 'bg-white', 'shadow-lg');
                }
            }
        });
    })();
</script>
@endsection