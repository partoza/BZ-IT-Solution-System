@extends('layout.app')

@section('content')
    <div class="min-h-screen flex">

    @php
        use Illuminate\Support\Str;
        use Illuminate\Support\Facades\Auth;
        use Illuminate\Support\Facades\Route;

        $menu = config('menu', []);
        $user = null;
        if (Auth::guard('employee')->check()) {
            $user = Auth::guard('employee')->user();
        } elseif (Auth::check()) {
            $user = Auth::user();
        }

        $role = $user?->role ?? 'guest';
        $currentPath = trim(request()->path(), '/');
        $currentRouteName = optional(request()->route())->getName();

        $roleAllowed = function ($roles) use ($role) {
            if (in_array('*', (array) $roles, true)) return true;
            return in_array($role, (array) $roles, true);
        };
    @endphp
    <!-- Sidebar -->
    <aside id="sidebar" class="bg-white shadow-sm px-4 hidden md:flex md:fixed md:inset-y-0 md:left-0 md:w-72 flex-col">
        <div class="p-4 flex items-center my-5 mx-2 bg-gradient-to-r from-emerald-600 to-emerald-500 rounded-lg text-white">
            <img src="{{ asset('assets/img/logo/bz-logo-white.png') }}" alt="logo" class="w-16 h-16 object-contain">
            <div class="ml-3">
                <div class="font-semibold text-lg">BZ IT Solutions</div>
                <div class="text-xs">Affordable IT Solutions</div>
            </div>
        </div>

        <nav class="flex-1 px-2 py-4 overflow-y-auto">
            <ul class="space-y-1">
                @foreach ($menu as $m)
                    @continue(! $roleAllowed($m['roles'] ?? ['*']))

                    @php
                        $subitemsToRender = [];
                        foreach ($m['subitems'] as $s) {
                            if (! $roleAllowed($s['roles'] ?? ['*'])) continue;

                            // build url: prefer named route if available
                            $url = '#';
                            if (!empty($s['name']) && Route::has($s['name'])) {
                                $url = route($s['name']);
                            } else {
                                $uri = $s['uri'] ?? '#';
                                if (Str::startsWith($uri, ['http://', 'https://'])) {
                                    $url = $uri;
                                } else {
                                    $url = url($uri);
                                }
                            }

                            $subitemsToRender[] = [
                                'title' => $s['title'],
                                'url' => $url,
                                'name' => $s['name'] ?? null,
                                'type' => $s['type'] ?? 'view',
                            ];
                        }

                        // determine active by route name OR url path
                        $subActiveFound = false;
                        foreach ($subitemsToRender as $s) {
                            $subUrlPath = trim(parse_url($s['url'], PHP_URL_PATH) ?: '', '/');
                            if ($s['name'] && $s['name'] === $currentRouteName) {
                                $subActiveFound = true;
                                break;
                            }
                            if ($subUrlPath === $currentPath) {
                                $subActiveFound = true;
                                break;
                            }
                        }

                        $isTopActive = $subActiveFound;
                    @endphp

                    <li class="menu-item">
                        <button data-menu="{{ $m['key'] }}"
                            class="w-full flex items-center justify-between gap-3 p-2 rounded-md hover:bg-neutral-100 {{ $isTopActive ? 'text-primary bg-primary/10' : '' }}">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center">{!! $m['icon'] !!}</span>
                                <span class="font-medium">{{ $m['title'] }}</span>
                            </div>
                            <svg class="chev h-4 w-4 text-neutral-500 transform transition-transform"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <ul data-submenu="{{ $m['key'] }}" class="{{ $isTopActive ? 'mt-1 ml-5 space-y-1 pl-1' : 'hidden mt-1 ml-5 space-y-1 pl-1' }}">
                            @foreach ($subitemsToRender as $sub)
                                @php
                                    $subUrlPath = trim(parse_url($sub['url'], PHP_URL_PATH) ?: '', '/');
                                    $subActive = ($sub['name'] && $sub['name'] === $currentRouteName) || ($subUrlPath === $currentPath);
                                @endphp
                                <li>
                                    <a href="{{ $sub['url'] }}"
                                        class="group flex items-center gap-2 block px-3 py-2 rounded-md text-sm transition-all duration-150 {{ $subActive ? 'text-primary text-base font-medium' : 'hover:bg-neutral-100' }}">
                                        <span class="bullet-outer inline-flex items-center justify-center w-5 h-5 bg-transparent transform transition-all duration-150">
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
            <div class="text-sm">{{ $user->full_name ?? $user->name ?? 'John Rex' }}</div>
            <div class="text-xs text-neutral-500">{{ $user->role ?? 'Admin' }}</div>
        </div>
    </aside>

    <!-- Main content area -->
    <div class="flex-1 flex flex-col md:ml-72">
            <header class="bg-white shadow-sm mx-8 my-5 rounded-lg">
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

                            <div class="relative w-full max-w-xl global-focus">
                                <input type="search" name="q" placeholder="Search..."
                                    class="w-full border border-neutral-200 rounded-md py-2 px-3" />
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="text-right hidden sm:block">
                                <div class="font-medium">{{ $user->full_name ?? $user->name ?? 'John Rex' }}</div>
                                <div class="text-xs text-neutral-500">{{ $user->role ?? 'Admin' }}</div>
                            </div>
                            <div class="flex items-center gap-2">
                                @php
                                    // Determine avatar URL (employee.avatar exists in migration)
                                    $avatar = $user->avatar ?? $user->image ?? null;
                                    $initial = strtoupper(substr($user->full_name ?? $user->name ?? 'J', 0, 1));
                                @endphp

                                @if ($avatar)
                                    @php
                                        $avatarSrc = Str::startsWith($avatar, ['http://', 'https://', '/']) ? $avatar : asset('storage/' . $avatar);
                                    @endphp
                                    <img src="{{ $avatarSrc }}" alt="avatar" class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center bg-gradient-to-r from-emerald-600 to-emerald-500 text-white">
                                        {{ $initial }}
                                    </div>
                                @endif
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