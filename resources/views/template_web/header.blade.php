<header class="header __js_fixed-header">
    <div class="header__container container container--size-large">
        @php
            $profil = \App\Models\Profil::first();
        @endphp
        <a class="header__logo logo">
            @if ($profil && $profil->logo_perusahaan)
                <img src="{{ asset('upload/profil/' . $profil->logo_perusahaan) }}" alt="Logo">
            @else
                <img src="{{ asset('env/logo.png') }}" alt="Logo">
            @endif
        </a>
        <div class="header__mobile mobile-canvas">
            <nav class="mobile-canvas__nav navigation">
                <ul class="navigation__list">
                    @auth
                        <li class="navigation__item mobile-only">
                            <a class="navigation__link animsition-link" href="{{ route('booking.index') }}">
                                My Order
                                <span class="navigation__link-icon">
                                    <svg width="12" height="13">
                                        <use xlink:href="#link-arrow"></use>
                                    </svg>
                                </span>
                            </a>
                        </li>
                    @endauth
                    @guest
                        <li class="navigation__item mobile-only">
                            <a class="navigation__link animsition-link" href="{{ route('login') }}">
                                Login
                                <span class="navigation__link-icon">
                                    <svg width="12" height="13">
                                        <use xlink:href="#link-arrow"></use>
                                    </svg>
                                </span>
                            </a>
                        </li>
                        <li class="navigation__item mobile-only">
                            <a class="navigation__link animsition-link" href="{{ route('register') }}">
                                Register
                                <span class="navigation__link-icon">
                                    <svg width="12" height="13">
                                        <use xlink:href="#link-arrow"></use>
                                    </svg>
                                </span>
                            </a>
                        </li>
                    @endguest
                    <li class="navigation__item">
                        <a class="navigation__link animsition-link" href="/">Home</a>
                    </li>
                    <li class="navigation__item">
                        <a class="navigation__link animsition-link" href="/about">About</a>
                    </li>
                    <li class="navigation__item">
                        <a class="navigation__link animsition-link" href="/services">Services</a>
                    </li>
                    <li class="navigation__item">
                        <a class="navigation__link animsition-link" href="/gallery">Gallery</a>
                    </li>
                    <li class="navigation__item">
                        <a class="navigation__link animsition-link" href="/contact">Contact</a>
                    </li>
                    @guest
                        <li class="navigation__item desktop-nav-link">
                            <a class="navigation__link animsition-link" href="{{ route('login') }}">
                                Login
                            </a>
                        </li>
                        <li class="navigation__item desktop-nav-link">
                            <a class="navigation__link animsition-link" href="{{ route('register') }}">
                                Register
                            </a>
                        </li>
                    @endguest
                    @auth
                        <li class="navigation__item desktop-nav-link">
                            <a class="navigation__link animsition-link" href="{{ route('booking.index') }}">
                                My Order
                            </a>
                        </li>
                    @endauth
                </ul>
            </nav>
            @php
                use Illuminate\Support\Str;
            @endphp
            <ul class="header__social social--white social">
                @guest
                @else
                    @php
                        $user = auth()->user();
                        $fotoProfile = $user->foto_profile ?? null;
                        if ($fotoProfile) {
                            if (Str::startsWith($fotoProfile, ['http://', 'https://'])) {
                                $srcFoto = $fotoProfile;
                            } else {
                                $srcFoto = asset('upload/foto_profile/' . $fotoProfile);
                            }
                        } else {
                            $srcFoto = asset('env/logo.jpg');
                        }
                    @endphp
                    {{-- Desktop: Dropdown menu with photo and name (only Logout in dropdown) --}}
                    <li class="navigation__item user-dropdown-wrapper desktop-user-link"
                        style="margin-bottom: 8px; position: relative;">
                        <a class="navigation__link user-dropdown-trigger" href="#"
                            style="display: flex; align-items: center; cursor: pointer;">
                            <img src="{{ $srcFoto }}" alt="Foto Profil" class="user-avatar">
                            <span class="user-name">{{ $user->name }}</span>
                            <span class="navigation__link-icon user-dropdown-arrow">
                                <svg width="12" height="13">
                                    <use xlink:href="#link-arrow"></use>
                                </svg>
                            </span>
                        </a>
                        <div class="user-dropdown-menu desktop-dropdown-menu">
                            <ul class="user-dropdown-list">
                                <li class="user-dropdown-item">
                                    <a class="user-dropdown-link animsition-link" href="{{ route('profil-user') }}">
                                        <span class="user-dropdown-text">Profile</span>
                                        <span class="user-dropdown-icon">
                                            <svg width="12" height="13">
                                                <use xlink:href="#link-arrow"></use>
                                            </svg>
                                        </span>
                                    </a>
                                </li>
                                <li class="user-dropdown-item">
                                    <a class="user-dropdown-link animsition-link" href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <span class="user-dropdown-text">Logout</span>
                                        <span class="user-dropdown-icon">
                                            <i class='bx bx-log-out'></i>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    {{-- Mobile: Dropdown menu with all options --}}
                    <li class="navigation__item user-dropdown-wrapper mobile-user-dropdown"
                        style="margin-bottom: 8px; position: relative;">
                        <a class="navigation__link user-dropdown-trigger" href="#"
                            style="display: flex; align-items: center; cursor: pointer;">
                            <img src="{{ $srcFoto }}" alt="Foto Profil" class="user-avatar">
                            <span class="user-name">{{ $user->name }}</span>
                            <span class="navigation__link-icon user-dropdown-arrow">
                                <svg width="12" height="13">
                                    <use xlink:href="#link-arrow"></use>
                                </svg>
                            </span>
                        </a>
                        <div class="user-dropdown-menu">
                            <ul class="user-dropdown-list">
                                <li class="user-dropdown-item">
                                    <a class="user-dropdown-link animsition-link" href="{{ route('profil-user') }}">
                                        <span class="user-dropdown-text">Profile</span>
                                        <span class="user-dropdown-icon">
                                            <svg width="12" height="13">
                                                <use xlink:href="#link-arrow"></use>
                                            </svg>
                                        </span>
                                    </a>
                                </li>

                                <li class="user-dropdown-item">
                                    <a class="user-dropdown-link animsition-link" href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <span class="user-dropdown-text">Logout</span>
                                        <span class="user-dropdown-icon">
                                            <i class='bx bx-log-out'></i>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
        <button class="header__menu-toggle menu-toggle" type="button">
            <span class="menu-toggle__line"></span>
            <span class="visually-hidden">Menu toggle</span>
        </button>
    </div>
</header>

@auth
    <form id="logout-form" action="{{ route('logout.post') }}" method="POST" style="display: none;">
        @csrf
    </form>
@endauth


<style>
    /* Hide desktop user links on mobile */
    @media (max-width: 991px) {
        .desktop-user-link {
            display: none !important;
        }

        .desktop-nav-link {
            display: none !important;
        }
    }

    /* Hide mobile dropdown on desktop */
    @media (min-width: 992px) {
        .mobile-user-dropdown {
            display: none !important;
        }

        /* Balance logo (left) and nav (center) */
        .header__container {
            display: flex;
            align-items: center;
        }

        .header__logo {
            flex: 0 0 auto;
        }

        .navigation {
            flex: 1 1 auto;
            display: flex;
            justify-content: center;
        }

        .navigation__list {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 18px;
            margin: 0 auto;
        }

        .header__menu-toggle {
            /* ensure no extra space on desktop */
            flex: 0 0 auto;
        }

        /* hide mobile-only items on desktop */
        .mobile-only {
            display: none !important;
        }
    }

    @media (max-width: 991px) {

        html body header.header.__js_fixed-header,
        html body header.header.__js_fixed-header.header--white-text {
            background-color: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: saturate(180%) blur(20px) !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08) !important;
        }

        html body header.header.__js_fixed-header.is-fixed {
            background-color: rgba(255, 255, 255, 0.95) !important;
        }

        html body header.header.__js_fixed-header .header__container {
            background: transparent !important;
        }

        html body header.header.__js_fixed-header::before,
        html body header.header.__js_fixed-header::after {
            background: transparent !important;
        }

        html body .header__mobile,
        html body .mobile-canvas {
            background-color: #ffffff !important;
            box-shadow: -10px 0 40px rgba(0,0,0,0.1) !important;
        }

        html body .menu-toggle__line {
            background-color: #1d1d1f !important;
        }

        html body header.header.__js_fixed-header .navigation__link,
        html body header.header.__js_fixed-header .user-name {
            color: #1d1d1f !important;
        }
        
        html body .navigation__link-icon svg {
            fill: #1d1d1f !important;
        }
    }

    /* Center navigation items */
    @media (min-width: 992px) {
        .navigation {
            width: 100%;
        }

        .navigation__list {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 18px;
        }
    }

    @media (max-width: 991px) {

        /* revert mobile nav alignment to original */
        .mobile-canvas__nav .navigation__list {
            align-items: flex-start;
        }

        .mobile-canvas__nav .navigation__link {
            display: block;
            justify-content: initial;
            width: auto;
        }
    }

    /* User Avatar - Memastikan foto profil selalu lingkaran sempurna */
    .user-avatar {
        width: 32px !important;
        height: 32px !important;
        min-width: 32px !important;
        min-height: 32px !important;
        max-width: 32px !important;
        max-height: 32px !important;
        border-radius: 50% !important;
        object-fit: cover !important;
        object-position: center !important;
        display: inline-block !important;
        flex-shrink: 0 !important;
        aspect-ratio: 1 / 1 !important;
        overflow: hidden !important;
        vertical-align: middle !important;
        margin-right: 8px !important;
        border: 2px solid rgba(255, 255, 255, 0.3) !important;
        transition: border-color 0.3s ease !important;
        background-color: #f0f0f0 !important;
        background-image: none !important;
    }

    /* Desktop - Ukuran sedikit lebih besar */
    @media (min-width: 992px) {
        .user-avatar {
            width: 36px !important;
            height: 36px !important;
            min-width: 36px !important;
            min-height: 36px !important;
            max-width: 36px !important;
            max-height: 36px !important;
        }
    }

    /* Hover effect */
    .user-dropdown-trigger:hover .user-avatar {
        border-color: rgba(255, 255, 255, 0.6) !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const header = document.querySelector('.header');
        const currentPath = window.location.pathname;
        const whiteTextUrls = ['/', '/about'];

        if (whiteTextUrls.includes(currentPath)) {
            header.classList.add('header--white-text');
        }

        // Enable dropdown functionality for both desktop and mobile
        const dropdownTriggers = document.querySelectorAll('.user-dropdown-trigger');
        const dropdownMenus = document.querySelectorAll('.user-dropdown-menu');
        const dropdownWrappers = document.querySelectorAll('.user-dropdown-wrapper');

        dropdownTriggers.forEach((dropdownTrigger, index) => {
            const dropdownMenu = dropdownMenus[index];
            const dropdownWrapper = dropdownWrappers[index];

            if (dropdownTrigger && dropdownMenu && dropdownWrapper) {
                dropdownTrigger.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const isActive = dropdownMenu.classList.contains('active');

                    // Close all other dropdowns
                    document.querySelectorAll('.user-dropdown-menu.active').forEach(menu => {
                        menu.classList.remove('active');
                    });
                    document.querySelectorAll('.user-dropdown-trigger.active').forEach(
                        trigger => {
                            trigger.classList.remove('active');
                        });

                    if (!isActive) {
                        dropdownMenu.classList.add('active');
                        dropdownTrigger.classList.add('active');
                    } else {
                        dropdownMenu.classList.remove('active');
                        dropdownTrigger.classList.remove('active');
                    }
                });

                document.addEventListener('click', function(e) {
                    if (!dropdownWrapper.contains(e.target)) {
                        dropdownMenu.classList.remove('active');
                        dropdownTrigger.classList.remove('active');
                    }
                });

                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        dropdownMenu.classList.remove('active');
                        dropdownTrigger.classList.remove('active');
                    }
                });

                const dropdownLinks = dropdownMenu.querySelectorAll('.user-dropdown-link');
                dropdownLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        if (!this.getAttribute('onclick')) {
                            dropdownMenu.classList.remove('active');
                            dropdownTrigger.classList.remove('active');
                        }
                    });
                });

                dropdownMenu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
        });
    });
</script>
