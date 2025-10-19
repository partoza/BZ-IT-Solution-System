@extends('layout.app')

@section('content')
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="bg-white shadow-sm w-72 px-4 hidden md:flex flex-col">
            <div
                class="p-4 flex items-center my-5 mx-2 bg-gradient-to-r from-emerald-600 to-emerald-500 rounded-lg text-white">
                <img src="{{ asset('assets/img/logo/bz-logo-white.png') }}" alt="logo" class="w-16 h-16 object-contain">
                <div>
                    <div class="font-semibold text-lg">BZ IT Solutions</div>
                    <div class="text-xs">Affordable IT Solutions</div>
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
            // Simple mobile sidebar toggle + menu accordion behavior
            (function () {
                const btn = document.getElementById('mobile-toggle');
                const sidebar = document.getElementById('sidebar');

                function openSidebar() {
                    sidebar.classList.remove('hidden');
                    sidebar.classList.add('fixed', 'inset-y-0', 'left-0', 'z-40', 'w-64', 'bg-white', 'shadow-lg');
                }

                function closeSidebar() {
                    sidebar.classList.add('hidden');
                    sidebar.classList.remove('fixed', 'inset-y-0', 'left-0', 'z-40', 'w-64', 'bg-white', 'shadow-lg');
                }

                if (btn && sidebar) {
                    btn.addEventListener('click', function (e) {
                        e.stopPropagation();
                        if (sidebar.classList.contains('hidden')) openSidebar(); else closeSidebar();
                    });

                    // Close sidebar when clicking outside on mobile
                    document.addEventListener('click', function (e) {
                        if (window.innerWidth >= 768) return; // only for mobile
                        if (!sidebar.classList.contains('hidden')) {
                            const isClickInside = sidebar.contains(e.target) || btn.contains(e.target);
                            if (!isClickInside) closeSidebar();
                        }
                    });
                }

                // Accordion menu behavior
                const menuButtons = Array.from(document.querySelectorAll('#sidebar .menu-item > button'));

                function closeAllExcept(name) {
                    menuButtons.forEach(b => {
                        const key = b.getAttribute('data-menu');
                        const submenu = document.querySelector('#sidebar ul[data-submenu="' + key + '"]');
                        const chev = b.querySelector('.chev');
                        if (!submenu) return;
                        if (key === name) {
                            submenu.classList.remove('hidden');
                            if (chev) chev.classList.add('rotate-90');
                            // mark top-level active (primary bg 50% + primary text)
                            // first clear other top-level active states
                            menuButtons.forEach(ob => ob.classList.remove('text-primary', 'bg-primary/50'));
                            if (chev) menuButtons.forEach(ob => { const c = ob.querySelector('.chev'); if (c) c.classList.remove('text-primary-600'); });
                            b.classList.add('text-primary', 'bg-primary/50');
                            if (chev) chev.classList.add('text-primary');
                        } else {
                            submenu.classList.add('hidden');
                            if (chev) chev.classList.remove('rotate-90');
                            // remove active top-level styles
                            b.classList.remove('text-primary', 'bg-primary/50');
                            if (chev) chev.classList.remove('text-primary');
                        }
                    });
                }

                menuButtons.forEach(btn => {
                    btn.addEventListener('click', function (e) {
                        const key = btn.getAttribute('data-menu');
                        const submenu = document.querySelector('#sidebar ul[data-submenu="' + key + '"]');
                        const chev = btn.querySelector('.chev');
                        if (!submenu) return;
                        const isHidden = submenu.classList.contains('hidden');
                        if (isHidden) {
                            closeAllExcept(key);
                        } else {
                            // collapse this one
                            submenu.classList.add('hidden');
                            if (chev) chev.classList.remove('rotate-90');
                        }
                    });
                });

                // Submenu active selection (toggle bullet visual state)
                const submenuLinks = Array.from(document.querySelectorAll('#sidebar ul[data-submenu] a'));
                function clearActiveBullets() {
                    submenuLinks.forEach(x => {
                        x.classList.remove('text-primary', 'text-base', 'font-medium');
                        const outer = x.querySelector('.bullet-outer');
                        const inner = x.querySelector('.bullet-inner');
                        if (outer) {
                            // restore default outer size and bg
                            outer.classList.remove('bg-primary/50', 'rounded-full', 'scale-110', 'w-[10px]', 'h-[10px]');
                            outer.classList.add('bg-transparent', 'w-5', 'h-5');
                        }
                        if (inner) {
                            inner.classList.remove('bg-emerald-800');
                            inner.classList.add('bg-neutral-800');
                        }
                    });
                    // also clear active state on top-level buttons
                    menuButtons.forEach(b => {
                        b.classList.remove('text-primary', 'bg-primary/50');
                        const chev = b.querySelector('.chev');
                        if (chev) chev.classList.remove('text-primary');
                    });
                }

                submenuLinks.forEach(a => {
                    a.addEventListener('click', function (e) {
                        // mark active visual state on link text and bullet
                        clearActiveBullets();
                        a.classList.add('text-primary', 'text-base', 'font-medium');
                        const outer = a.querySelector('.bullet-outer');
                        const inner = a.querySelector('.bullet-inner');
                        if (outer) {
                            // make the background smaller and primary with 50% opacity
                            outer.classList.remove('bg-transparent', 'w-5', 'h-5');
                            outer.classList.add('bg-primary/50', 'rounded-full', 'w-[10px]', 'h-[10px]', 'scale-110');
                        }
                        if (inner) {
                            inner.classList.remove('bg-neutral-800');
                            inner.classList.add('bg-primary');
                        }

                        // set active state on the parent top-level button
                        const parentUl = a.closest('ul[data-submenu]');
                        if (parentUl) {
                            const key = parentUl.getAttribute('data-submenu');
                            const btn = document.querySelector('#sidebar button[data-menu="' + key + '"]');
                            if (btn) {
                                // clear other top-level active classes first
                                menuButtons.forEach(ob => ob.classList.remove('text-primary', 'bg-primary/50'));
                                const chev = btn.querySelector('.chev');
                                if (chev) menuButtons.forEach(ob => { const c = ob.querySelector('.chev'); if (c) c.classList.remove('text-primary-600'); });
                                btn.classList.add('text-primary', 'bg-primary/50');
                                if (chev) chev.classList.add('text-primary');
                            }
                        }
                    });
                });

                // Ensure default: open dashboard and mark Overview active
                document.addEventListener('DOMContentLoaded', function () {
                    // open dashboard
                    closeAllExcept('dashboard');
                    // mark Overview active (apply bullet active classes)
                    const overview = document.querySelector('#sidebar ul[data-submenu="dashboard"] a');
                    if (overview) {
                        clearActiveBullets();
                        overview.classList.add('text-primary-800', 'text-base', 'font-medium');
                        const outer = overview.querySelector('.bullet-outer');
                        const inner = overview.querySelector('.bullet-inner');
                        if (outer) {
                            outer.classList.remove('bg-transparent');
                            outer.classList.add('bg-primary/50', 'rounded-full', 'scale-110', 'w-[10px]', 'h-[10px]');
                        }
                        if (inner) {
                            inner.classList.remove('bg-neutral-800');
                            inner.classList.add('bg-primary-800');
                        }
                        // mark dashboard top-level active too
                        closeAllExcept('dashboard');
                    }
                });
            })();
        </script>
    @endpush

@endsection