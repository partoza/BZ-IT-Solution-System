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

        @php
            // menu definition (static defaults). If a pages folder exists for a key, it'll be used instead.
            $menu = [
                ['key' => 'dashboard', 'title' => 'Dashboard', 'icon' => '<svg xmlns="htt" class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" /></svg>', 'subitems' => [['title'=>'Overview','route'=>'overview'], ['title'=>'Point of Sales','route'=>null], ['title'=>'Sales and Analytics','route'=>null]]],
                ['key' => 'inventory', 'title' => 'Inventory', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-neutral-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" /></svg>', 'subitems'=>[['title'=>'Products','route'=>'inventory.products'],['title'=>'Categories','route'=>'inventory.categories'],['title'=>'Suppliers','route'=>'inventory.suppliers']]],
                ['key' => 'services', 'title' => 'Services', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-neutral-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.567-3 3.5S10.343 15 12 15s3-1.567 3-3.5S13.657 8 12 8z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2" /></svg>', 'subitems'=>[['title'=>'List','route'=>'services.index'],['title'=>'Add Service','route'=>'services.create'],['title'=>'Reports','route'=>'services.reports']]],
                ['key' => 'customer', 'title' => 'Customer', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-neutral-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11c1.657 0 3-1.567 3-3.5S17.657 4 16 4s-3 1.567-3 3.5S14.343 11 16 11zM8 11c1.657 0 3-1.567 3-3.5S9.657 4 8 4 5 5.567 5 7.5 6.343 11 8 11z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2" /></svg>', 'subitems'=>[['title'=>'List','route'=>'customers.index'],['title'=>'Add Customer','route'=>'customers.create'],['title'=>'Segments','route'=>'customers.segments']]],
                ['key' => 'employee', 'title' => 'Employee', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-neutral-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422A12.083 12.083 0 0119 10.5v6.25A2.25 2.25 0 0116.75 19h-9.5A2.25 2.25 0 015 16.75V10.5c0-.346.04-.684.12-1.012L12 14z" /></svg>', 'subitems'=>[['title'=>'Staff List','route'=>'employee.index'],['title'=>'Attendance','route'=>'employee.attendance'],['title'=>'Roles','route'=>'employee.roles']]],
                ['key' => 'history', 'title' => 'History', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-neutral-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12A9 9 0 113 12a9 9 0 0118 0z" /></svg>', 'subitems'=>[['title'=>'Activity','route'=>'history.activity'],['title'=>'Logs','route'=>'history.logs'],['title'=>'Exports','route'=>'history.exports']]],
                ['key' => 'settings', 'title' => 'Settings', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-neutral-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.567-3 3.5S10.343 15 12 15s3-1.567 3-3.5S13.657 8 12 8z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 01-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09a1.65 1.65 0 00-1-1.51 1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09a1.65 1.65 0 001.51-1 1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06a1.65 1.65 0 001.82.33H9c.27-.58.59-1.12.96-1.62" /></svg>', 'subitems'=>[['title'=>'General','route'=>'settings.general'],['title'=>'Billing','route'=>'settings.billing'],['title'=>'Integrations','route'=>'settings.integrations']]],
            ];
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
                                // PATHINFO_FILENAME returns e.g. "overview.blade" for overview.blade.php
                                $slug = pathinfo($filename, PATHINFO_FILENAME);
                                // remove common template suffixes if present
                                $slug = preg_replace('/(\.blade|\.php)$/', '', $slug);
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
                        $isTopActive = request()->is($m['key'] . '/*') || request()->is($m['key']);
                    @endphp

                    <li class="menu-item">
                        <button data-menu="{{ $m['key'] }}" class="w-full flex items-center justify-between gap-3 p-2 rounded-md hover:bg-neutral-100 {{ $isTopActive ? 'text-primary bg-primary/50' : '' }}">
                            <div class="flex items-center gap-3">
                                {!! $m['icon'] !!}
                                <span class="font-medium">{{ $m['title'] }}</span>
                            </div>
                            <svg class="chev h-4 w-4 text-neutral-500 transform transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                        </button>

                        <ul data-submenu="{{ $m['key'] }}" class="{{ $isTopActive ? 'mt-1 ml-5 space-y-1 pl-1' : 'hidden mt-1 ml-5 space-y-1 pl-1' }}">
                            @foreach ($subitemsToRender as $sub)
                                @php
                                    $subUrlPath = parse_url($sub['url'], PHP_URL_PATH) ?: '';
                                    $subActive = trim($subUrlPath, '/') === trim(request()->path(), '/');
                                @endphp
                                <li>
                                    <a href="{{ $sub['url'] }}" class="group flex items-center gap-2 block px-3 py-2 rounded-md text-sm hover:bg-neutral-100 transition-all duration-150 {{ $subActive ? 'text-primary text-base font-medium' : '' }}">
                                        <span class="bullet-outer inline-flex items-center justify-center w-5 h-5 bg-transparent transform transition-all duration-150 {{ $subActive ? 'bg-primary/50 rounded-full w-[10px] h-[10px] scale-110' : '' }}">
                                            <span class="bullet-inner w-[6px] h-[6px] rounded-full {{ $subActive ? 'bg-primary' : 'bg-neutral-800' }}"></span>
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
    <div class="flex-1 flex flex-col">
        <header class="bg-white border-b border-neutral-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center gap-3">
                        <!-- Mobile: sidebar toggle -->
                        <button id="mobile-toggle" class="md:hidden p-2 rounded-md hover:bg-neutral-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                        </button>

                        <!-- Search -->
                        <div class="relative w-full max-w-xl">
                            <input type="search" name="q" placeholder="Search..." class="w-full border border-neutral-200 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-300" />
                        </div>
                    </div>

                    <!-- Right side: profile only -->
                    <div class="flex items-center gap-4">
                        <div class="text-right hidden sm:block">
                            <div class="font-medium">{{ $user->full_name ?? $user->name ?? 'John Rex' }}</div>
                            <div class="text-xs text-neutral-500">{{ $user->role ?? 'Admin' }}</div>
                        </div>
                        <div class="flex items-center gap-2">
                            <img src="/assets/img/avatar.png" alt="avatar" class="w-10 h-10 rounded-full object-cover">
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto bg-neutral-50 p-6">
            <div class="max-w-7xl mx-auto">
                @yield('pages-content')
            </div>
        </main>
    </div>
</div>

@push('scripts')
<script>
    // Simple mobile sidebar toggle + accordion behaviour
    (function () {
        const btn = document.getElementById('mobile-toggle');
        const sidebar = document.getElementById('sidebar');
        if (!btn || !sidebar) return;

        function openSidebar() {
            sidebar.classList.remove('hidden');
            sidebar.classList.add('fixed', 'inset-y-0', 'left-0', 'z-40', 'w-64', 'bg-white', 'shadow-lg');
        }
        function closeSidebar() {
            sidebar.classList.add('hidden');
            sidebar.classList.remove('fixed', 'inset-y-0', 'left-0', 'z-40', 'w-64', 'bg-white', 'shadow-lg');
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
                    menuButtons.forEach(ob => ob.classList.remove('text-primary', 'bg-primary/50'));
                    b.classList.add('text-primary', 'bg-primary/50');
                    if (chev) chev.classList.add('text-primary');
                } else {
                    submenu.classList.add('hidden');
                    if (chev) chev.classList.remove('rotate-90');
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
                if (isHidden) closeAllExcept(key); else { submenu.classList.add('hidden'); if (chev) chev.classList.remove('rotate-90'); }
            });
        });
    })();
</script>
@endpush

@endsection
