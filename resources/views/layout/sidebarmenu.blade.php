@extends('layout.app')

@section('content')
    <div class="min-h-screen flex">
    <!-- Sidebar -->
    <aside id="sidebar" class="bg-white shadow-sm w-72 px-4 hidden md:flex md:fixed md:inset-y-0 md:left-0 md:w-72 flex-col">
            <div
                class="p-4 flex items-center my-5 mx-2 bg-gradient-to-r from-emerald-600 to-emerald-500 rounded-lg text-white">
                <img src="{{ asset('assets/img/logo/bz-logo-white.png') }}" alt="logo" class="w-16 h-16 object-contain">
                <div>
                    <div class="font-semibold text-lg">BZ IT Solutions</div>
                    <div class="text-xs">Affordable IT Solutions</div>
                </div>
            </div>

            @php
                // menu definition (static defaults). If a pages folder exists for a key, it'll be used instead.
                $menu = [
                    ['key' => 'dashboard', 'title' => 'Dashboard', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5"><path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z"/><path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z"/></svg>', 'subitems' => [['title' => 'Overview', 'route' => 'overview'], ['title' => 'Point of Sales', 'route' => null], ['title' => 'Sales and Analytics', 'route' => null]]],
                    ['key' => 'inventory', 'title' => 'Inventory', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5"><path d="M12.378 1.602a.75.75 0 0 0-.756 0L3 6.632l9 5.25 9-5.25-8.622-5.03ZM21.75 7.93l-9 5.25v9l8.628-5.032a.75.75 0 0 0 .372-.648V7.93ZM11.25 22.18v-9l-9-5.25v8.57a.75.75 0 0 0 .372.648l8.628 5.033Z"/></svg>', 'subitems' => [['title' => 'Products', 'route' => 'inventory.products'], ['title' => 'Stock In', 'route' => 'inventory.stock-in']]],
                    ['key' => 'services', 'title' => 'Services', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5"><path fill-rule="evenodd" d="M12 6.75a5.25 5.25 0 0 1 6.775-5.025.75.75 0 0 1 .313 1.248l-3.32 3.319c.063.475.276.934.641 1.299.365.365.824.578 1.3.64l3.318-3.319a.75.75 0 0 1 1.248.313 5.25 5.25 0 0 1-5.472 6.756c-1.018-.086-1.87.1-2.309.634L7.344 21.3A3.298 3.298 0 1 1 2.7 16.657l8.684-7.151c.533-.44.72-1.291.634-2.309A5.342 5.342 0 0 1 12 6.75ZM4.117 19.125a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Z" clip-rule="evenodd"/><path d="m10.076 8.64-2.201-2.2V4.874a.75.75 0 0 0-.364-.643l-3.75-2.25a.75.75 0 0 0-.916.113l-.75.75a.75.75 0 0 0-.113.916l2.25 3.75a.75.75 0 0 0 .643.364h1.564l2.062 2.062 1.575-1.297Z"/><path fill-rule="evenodd" d="m12.556 17.329 4.183 4.182a3.375 3.375 0 0 0 4.773-4.773l-3.306-3.305a6.803 6.803 0 0 1-1.53.043c-.394-.034-.682-.006-.867.042a.589.589 0 0 0-.167.063l-3.086 3.748Zm3.414-1.36a.75.75 0 0 1 1.06 0l1.875 1.876a.75.75 0 1 1-1.06 1.06L15.97 17.03a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>', 'subitems' => [['title' => 'Service Ticket', 'route' => 'services.service-ticket'], ['title' => 'Ticket Tracking', 'route' => 'services.ticket-tracking']]],
                    ['key' => 'customer', 'title' => 'Customer', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5"><path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z"/><path d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z"/></svg>', 'subitems' => [['title' => 'Customer Management', 'route' => 'customers.customer-management'], ['title' => 'After Sales', 'route' => 'customers.after-sales']]],
                    ['key' => 'employee', 'title' => 'Employee', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5"><path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z"/></svg>', 'subitems' => [['title' => 'Staff Management', 'route' => 'employee.index']]],
                    ['key' => 'history', 'title' => 'History', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5"><path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z"/><path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375ZM6 12a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V12Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 15a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V15Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 18a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V18Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75Z"/></svg>', 'subitems' => [['title' => 'Transaction History', 'route' => 'history.transaction-history'], ['title' => 'Resolution History', 'route' => 'history.resolution-history'], ['title' => 'Audit Logs', 'route' => 'history.audit-logs']]],
                    [
                        'key' => 'settings',
                        'title' => 'Settings',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                  <path fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 0 0-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 0 0-2.282.819l-.922 1.597a1.875 1.875 0 0 0 .432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 0 0 0 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 0 0-.432 2.385l.922 1.597a1.875 1.875 0 0 0 2.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 0 0 2.28-.819l.923-1.597a1.875 1.875 0 0 0-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 0 0 0-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 0 0-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 0 0-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 0 0-1.85-1.567h-1.843ZM12 15.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z" clip-rule="evenodd" />
                                </svg>
                                ',
                        'subitems' => [['title' => 'Promotions', 'route' => 'history.promotions'], ['title' => 'Suppliers', 'route' => 'history.suppliers']]
                    ]
                ];

                // current path and guest default behavior
                $currentPath = trim(request()->path(), '/');
                $guestDefault = false;
                if (!\Illuminate\Support\Facades\Auth::check() && ($currentPath === '' || $currentPath === 'login')) {
                    $guestDefault = true;
                    $currentPath = 'dashboard/overview';
                }
            @endphp

            <nav class="flex-1 px-2 py-4 overflow-y-auto">
                <ul class="space-y-1">
                    @foreach ($menu as $m)
                        @php
                            $pagesDir = resource_path('views/pages/' . $m['key']);
                            $subitemsToRender = [];
                            if (\Illuminate\Support\Facades\File::isDirectory($pagesDir)) {
                                $files = \Illuminate\Support\Facades\File::files($pagesDir);
                                foreach ($files as $f) {
                                    $filename = $f->getFilename();
                                    $slug = pathinfo($filename, PATHINFO_FILENAME);
                                    $slug = preg_replace('/(\\.blade|\\.php)$/', '', $slug);
                                    $title = \Illuminate\Support\Str::of($slug)->replace(['-', '_'], ' ')->title();
                                    $subitemsToRender[] = ['title' => (string) $title, 'url' => url($m['key'] . '/' . $slug)];
                                }
                            } else {
                                foreach ($m['subitems'] as $s) {
                                    if (isset($s['route']) && $s['route'] && \Illuminate\Support\Facades\Route::has($s['route'])) {
                                        $subitemsToRender[] = ['title' => $s['title'], 'url' => route($s['route'])];
                                    } elseif (isset($s['url'])) {
                                        $subitemsToRender[] = ['title' => $s['title'], 'url' => $s['url']];
                                    } else {
                                        $subitemsToRender[] = ['title' => $s['title'], 'url' => '#'];
                                    }
                                }
                            }

                            // Determine if any submenu item matches the current path. The parent
                            // should only be marked active when a submenu link is the current page.
                            $subActiveFound = false;
                            foreach ($subitemsToRender as $s) {
                                $subUrlPath = trim(parse_url($s['url'], PHP_URL_PATH) ?: '', '/');
                                if ($subUrlPath === $currentPath) {
                                    $subActiveFound = true;
                                    break;
                                }
                            }

                            $isTopActive = $guestDefault ? ($m['key'] === 'dashboard') : $subActiveFound;
                        @endphp

                        <li class="menu-item">
                            <button data-menu="{{ $m['key'] }}"
                                class="w-full flex items-center justify-between gap-3 p-2 rounded-md hover:bg-neutral-100 {{ $isTopActive ? 'text-primary bg-primary/10' : '' }}">
                                <div class="flex items-center gap-3">
                                    {{-- SVG icons inherit the text color so they turn primary when the parent has
                                    text-primary --}}
                                    <span class="inline-flex items-center">{!! $m['icon'] !!}</span>
                                    <span class="font-medium">{{ $m['title'] }}</span>
                                </div>
                                <svg class="chev h-4 w-4 text-neutral-500 transform transition-transform"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>

                            <ul data-submenu="{{ $m['key'] }}"
                                class="{{ $isTopActive ? 'mt-1 ml-5 space-y-1 pl-1' : 'hidden mt-1 ml-5 space-y-1 pl-1' }}">
                                @foreach ($subitemsToRender as $sub)
                                    @php
                                        $subUrlPath = trim(parse_url($sub['url'], PHP_URL_PATH) ?: '', '/');
                                        $subActive = ($subUrlPath === $currentPath) || ($subUrlPath === trim(request()->path(), '/'));
                                    @endphp
                                    <li>
                                        <a href="{{ $sub['url'] }}"
                                                class="group flex items-center gap-2 block px-3 py-2 rounded-md text-sm transition-all duration-150 {{ $subActive ? 'text-primary text-base font-medium' : 'hover:bg-neutral-100' }}">
                                                <span
                                                    class="bullet-outer inline-flex items-center justify-center w-5 h-5 bg-transparent transform transition-all duration-150">
                                                    <span
                                                        class="bullet-inner w-[6px] h-[6px] rounded-full {{ $subActive ? 'bg-primary' : 'bg-neutral-800' }}"></span>
                                                </span>
                                                <span class="flex-1">{{ $sub['title'] }}</span>
                                            </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <div class="p-4 border-t border-neutral-100">
                @php
                    $user = null;
                    if (\Illuminate\Support\Facades\Auth::guard('employee')->check()) {
                        $user = \Illuminate\Support\Facades\Auth::guard('employee')->user();
                    } elseif (\Illuminate\Support\Facades\Auth::check()) {
                        $user = \Illuminate\Support\Facades\Auth::user();
                    }
                @endphp
                <div class="text-sm">{{ $user->full_name ?? $user->name ?? 'John Rex' }}</div>
                <div class="text-xs text-neutral-500">{{ $user->role ?? 'Admin' }}</div>
            </div>
        </aside>

    <!-- Main content area -->
    <div class="flex-1 flex flex-col md:ml-72">
            <header class="bg-white shadow-sm mx-8 my-5  rounded-lg p-2">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <div class="flex items-center gap-3">
                            <button id="mobile-toggle" class="md:hidden p-2 rounded-md hover:bg-neutral-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>

                            <div class="relative w-full max-w-xl">
                                <input type="search" name="q" placeholder="Search..."
                                    class="w-full border border-neutral-200 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-300" />
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="text-right hidden sm:block">
                                <div class="font-medium">{{ $user->full_name ?? $user->name ?? 'John Rex' }}</div>
                                <div class="text-xs text-neutral-500">{{ $user->role ?? 'Admin' }}</div>
                            </div>
                            <div class="flex items-center gap-2">
                                <img src="#" alt="avatar" class="w-10 h-10 rounded-full object-cover">
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto mx-8 mb-5 rounded-lg">
                    @yield('pages-content')
                
            </main>
        </div>
    </div>

    @push('scripts')
        <script>
            (function () {
                const btn = document.getElementById('mobile-toggle');
                const sidebar = document.getElementById('sidebar');
                if (!btn || !sidebar) return;

                function openSidebar() {
                    sidebar.classList.remove('hidden');
                    sidebar.classList.add('fixed', 'inset-y-0', 'left-0', 'z-40', 'w-72', 'bg-white', 'shadow-lg');
                }
                function closeSidebar() {
                    sidebar.classList.add('hidden');
                    sidebar.classList.remove('fixed', 'inset-y-0', 'left-0', 'z-40', 'w-72', 'bg-white', 'shadow-lg');
                }

                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    if (sidebar.classList.contains('hidden')) openSidebar(); else closeSidebar();
                });

                document.addEventListener('click', function (e) {
                    if (window.innerWidth >= 768) return; // only for mobile
                    if (!sidebar.classList.contains('hidden')) {
                        const isClickInside = sidebar.contains(e.target) || btn.contains(e.target);
                        if (!isClickInside) closeSidebar();
                    }
                });

                // Accordion: only one open at a time
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
                        } else {
                            submenu.classList.add('hidden');
                            if (chev) chev.classList.remove('rotate-90');
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
                            submenu.classList.add('hidden');
                            if (chev) chev.classList.remove('rotate-90');
                        }
                    });
                });
            })();
        </script>
    @endpush

@endsection