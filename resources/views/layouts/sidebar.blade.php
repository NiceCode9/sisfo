<nav class="navbar navbar-dark navbar-theme-primary px-4 col-12 d-lg-none">
    <a class="navbar-brand me-lg-5" href="../index.html">
        <img class="navbar-brand-dark" src="../assets/img/brand/light.svg" alt="Volt logo" /> <img
            class="navbar-brand-light" src="../assets/img/brand/dark.svg" alt="Volt logo" />
    </a>
    <div class="d-flex align-items-center">
        <button class="navbar-toggler d-lg-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
    <div class="sidebar-inner px-4 pt-3">
        <!-- User Card (Mobile) -->
        <div
            class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">
            <div class="d-flex align-items-center">
                <div class="avatar-lg me-4">
                    <img src="{{ asset('assets') }}/assets/img/team/profile-picture-3.jpg"
                        class="card-img-top rounded-circle border-white" alt="User Profile">
                </div>
                <div class="d-block">
                    <h2 class="h5 mb-3">Hi, {{ Auth::user()->name }}</h2>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="btn btn-secondary btn-sm d-inline-flex align-items-center">
                        <svg class="icon icon-xxs me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Sign Out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
            <div class="collapse-close d-md-none">
                <a href="#sidebarMenu" data-bs-toggle="collapse" data-bs-target="#sidebarMenu"
                    aria-controls="sidebarMenu" aria-expanded="true" aria-label="Toggle navigation">
                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Logo Brand -->
        <ul class="nav flex-column pt-3 pt-md-0">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link d-flex align-items-center">
                    <span class="sidebar-icon">
                        <img src="{{ asset('assets') }}/assets/img/brand/light.svg" height="20" width="20"
                            alt="App Logo">
                    </span>
                    <span class="mt-1 ms-1 sidebar-text">PPDB System</span>
                </a>
            </li>

            <!-- Dynamic Menu Items -->
            @php
                $currentGroup = null;
                $user = auth()->user();
            @endphp

            @foreach ($sidebarMenu as $menu)
                @if (
                    !$menu->permission ||
                        ($menu->permission && $user->hasPermissionTo($menu->permission)) ||
                        $user->hasRole('super-admin'))
                    @if ($menu->group !== $currentGroup)
                        <li role="separator" class="dropdown-divider mt-4 mb-3 border-gray-700"></li>
                        <li class="nav-item">
                            <span class="nav-link text-uppercase text-xs font-weight-bold">
                                {{ $menu->group }}
                            </span>
                        </li>
                        @php
                            $currentGroup = $menu->group;
                        @endphp
                    @endif

                    @if ($menu->hasActiveChildren())
                        <li class="nav-item @if ($menu->isActive()) active @endif">
                            <span class="nav-link collapsed d-flex justify-content-between align-items-center"
                                data-bs-toggle="collapse" data-bs-target="#submenu-{{ $menu->id }}">
                                <span>
                                    <span class="sidebar-icon">{!! $menu->icon_html !!}</span>
                                    <span class="sidebar-text">{{ $menu->name }}</span>
                                </span>
                                <span class="link-arrow">
                                    <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                            </span>
                            <div class="multi-level collapse @if ($menu->isActive()) show @endif"
                                role="list" id="submenu-{{ $menu->id }}"
                                aria-expanded="@if ($menu->isActive()) true @else false @endif">
                                <ul class="flex-column nav">
                                    @foreach ($menu->children as $child)
                                        @if (
                                            !$child->permission ||
                                                ($child->permission && ($user->hasPermissionTo($child->permission) || $user->hasRole('super-admin'))))
                                            <li class="nav-item @if ($child->isActive()) active @endif">
                                                <a class="nav-link" href="{{ $child->full_url }}">
                                                    <span class="sidebar-text">{{ $child->name }}</span>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @else
                        <li class="nav-item @if ($menu->isActive()) active @endif">
                            <a href="{{ $menu->full_url }}" class="nav-link">
                                <span class="sidebar-icon">{!! $menu->icon_html !!}</span>
                                <span class="sidebar-text">{{ $menu->name }}</span>
                            </a>
                        </li>
                    @endif
                @endif
            @endforeach

            <!-- Logout Button -->
            <li role="separator" class="dropdown-divider mt-4 mb-3 border-gray-700"></li>
            <li class="nav-item">
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();"
                    class="btn btn-secondary d-flex align-items-center justify-content-center btn-upgrade-pro">
                    <span class="sidebar-icon d-inline-flex align-items-center justify-content-center">
                        <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </span>
                    <span>Logout</span>
                </a>
                <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST"
                    style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</nav>
