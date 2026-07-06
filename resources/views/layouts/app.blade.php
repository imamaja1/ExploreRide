<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ExploreRide - @yield('title', __('Sewa Mobil & Paket Wisata'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@700;800;900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --er-primary: #198754;
            --er-dark: #145c32;
            --er-light: #f0f2f5;
        }
        body { font-family: 'Inter', sans-serif; color: #374151; line-height: 1.6; }
        h1, h2, h3, h4 { line-height: 1.3; }

        /* Navbar */
        .navbar-brand { font-weight: 800; font-size: 1.4rem; letter-spacing: -0.5px; }
        .navbar { padding: 12px 0; }
        .navbar .nav-link { font-weight: 500; color: #374151 !important; padding: 8px 16px; border-radius: 8px; transition: all 0.2s; }
        .navbar .nav-link:hover { background: rgba(25,135,84,0.08); color: var(--er-primary) !important; }

        /* Hero */
        .hero-section {
            background: var(--er-primary);
            color: white;
            padding: 100px 0 120px;
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
        }
        .hero-section::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }
        .hero-section h1 {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: clamp(1.75rem, 4vw, 2.75rem);
            letter-spacing: -1px;
        }
        .hero-section .lead { font-size: 1.05rem; opacity: 0.9; max-width: 600px; margin: 0 auto 2rem; }

        /* Buttons */
        .btn-primary-er {
            background: var(--er-primary);
            border-color: var(--er-primary);
            color: #fff;
            border-radius: 10px;
            padding: 12px 28px;
            font-weight: 600;
            transition: all 0.25s;
            box-shadow: 0 4px 14px rgba(25,135,84,0.3);
        }
        .btn-primary-er:hover {
            background: var(--er-dark);
            border-color: var(--er-dark);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(25,135,84,0.4);
        }
        .btn-outline-er {
            border: 2px solid rgba(255,255,255,0.4);
            color: #fff;
            border-radius: 10px;
            padding: 12px 28px;
            font-weight: 600;
            transition: all 0.25s;
            background: transparent;
        }
        .btn-outline-er:hover {
            background: #fff;
            color: var(--er-primary);
            border-color: #fff;
            transform: translateY(-2px);
        }
        .btn-outline-success-er {
            border: 2px solid var(--er-primary);
            color: var(--er-primary);
            border-radius: 10px;
            padding: 12px 28px;
            font-weight: 600;
            transition: all 0.25s;
            background: transparent;
        }
        .btn-outline-success-er:hover {
            background: var(--er-primary);
            color: #fff;
            border-color: var(--er-primary);
            transform: translateY(-2px);
        }
        .btn-success-er {
            background: var(--er-primary);
            border-color: var(--er-primary);
            color: #fff;
            border-radius: 10px;
            padding: 10px 22px;
            font-weight: 600;
            transition: all 0.25s;
        }
        .btn-success-er:hover {
            background: var(--er-dark);
            border-color: var(--er-dark);
            color: #fff;
            transform: translateY(-1px);
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
            overflow: hidden;
        }
        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.12);
        }
        .card-img-top { border-radius: 16px 16px 0 0; }
        .card-body { padding: 20px; }
        .card-title { font-weight: 700; font-size: 0.95rem; }
        .card-text { font-size: 0.85rem; color: #6b7280; }

        /* Section */
        .section-title { font-weight: 800; font-size: 1.75rem; color: #1f2937; margin-bottom: 0.5rem; }
        .section-subtitle { font-size: 0.95rem; color: #6b7280; margin-bottom: 2rem; }

        /* Footer */
        .footer { background: #0f172a; color: #94a3b8; padding: 60px 0 30px; }
        .footer h5, .footer h6 { color: #f1f5f9; font-weight: 700; }
        .footer a { color: #94a3b8; text-decoration: none; transition: color 0.2s; }
        .footer a:hover { color: #fff; }
        .footer .social-link { display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 8px; background: rgba(255,255,255,0.08); transition: all 0.2s; }
        .footer .social-link:hover { background: var(--er-primary); color: #fff; }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,0.08); margin-top: 40px; padding-top: 20px; }

        /* Bottom Nav */
        .bottom-nav { position: fixed; bottom: 0; left: 0; right: 0; z-index: 1030; background: #fff; border-top: 1px solid #e9ecef; box-shadow: 0 -2px 10px rgba(0,0,0,0.06); }
        .bottom-nav .nav-item { flex: 1; text-align: center; padding: 6px 0 4px; }
        .bottom-nav .nav-item.dropup { position: relative; }
        .bottom-nav .nav-link { display: flex; flex-direction: column; align-items: center; font-size: 0.7rem; color: #6c757d; padding: 0; border: 0; background: none; }
        .bottom-nav .nav-link i { font-size: 1.25rem; margin-bottom: 2px; }
        .bottom-nav .nav-link.active { color: var(--er-primary) !important; }
        .bottom-nav .nav-link.active i { font-weight: 700; }
        .bottom-nav .dropdown-menu { bottom: 100%; margin-bottom: 8px; left: 50%; transform: translateX(-50%); min-width: 160px; border-radius: 12px; box-shadow: 0 -4px 20px rgba(0,0,0,0.12); border: none; padding: 8px; }
        .bottom-nav .dropdown-menu .dropdown-item { border-radius: 8px; padding: 10px 14px; font-size: 0.9rem; }
        .bottom-nav .dropdown-menu .dropdown-item i { margin-right: 10px; width: 18px; text-align: center; }
        .bottom-nav .dropdown-menu .dropdown-item:hover { background: var(--er-primary); color: #fff; }

        /* Misc */
        .nav-link.active { color: var(--er-primary) !important; font-weight: 600; }
        .card-img-fixed { height: 200px; object-fit: cover; }
        .card-img-car { height: 180px; object-fit: cover; }

        @media (max-width: 991.98px) {
            main { padding-bottom: 68px; }
            .footer { padding-bottom: 90px; }
            .hero-section { padding: 60px 0 80px; }
        }
    </style>
    @stack('styles')
</head>
<body>
    @php $navCategories = \App\Models\DestinationCategory::where('is_active', true)->get(); @endphp
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand text-success" href="{{ route('home') }}">
                <i class="bi bi-car-front-fill"></i> ExploreRide
            </a>

            <ul class="navbar-nav flex-row d-lg-none align-items-center">
                <li class="nav-item dropdown" style="position:relative;">
                    <a class="nav-link dropdown-toggle py-0" href="#" data-bs-toggle="dropdown" style="font-size:0.85rem;">
                        <i class="bi bi-globe"></i> {{ session('locale', 'id') == 'en' ? 'EN' : 'ID' }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" data-bs-popper="none">
                        <li><a class="dropdown-item {{ session('locale') == 'id' || !session('locale') ? 'active' : '' }}" href="{{ route('lang.switch', 'id') }}">{{ __('Indonesia') }}</a></li>
                        <li><a class="dropdown-item {{ session('locale') == 'en' ? 'active' : '' }}" href="{{ route('lang.switch', 'en') }}">{{ __('Inggris') }}</a></li>
                    </ul>
                </li>
            </ul>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">{{ __('Beranda') }}</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">{{ __('Destinasi') }}</a>
                        <ul class="dropdown-menu">
                            @foreach($navCategories as $cat)
                            <li><a class="dropdown-item" href="{{ route('destinations.category', $cat->slug) }}">{{ __($cat->name) }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('cars') }}">{{ __('Mobil') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('packages') }}">{{ __('Paket Wisata') }}</a></li>
                </ul>
                <ul class="navbar-nav d-none d-lg-flex">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-globe"></i> {{ session('locale', 'id') == 'en' ? __('Inggris') : __('Indonesia') }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item {{ session('locale') == 'id' || !session('locale') ? 'active' : '' }}" href="{{ route('lang.switch', 'id') }}">{{ __('Indonesia') }}</a></li>
                            <li><a class="dropdown-item {{ session('locale') == 'en' ? 'active' : '' }}" href="{{ route('lang.switch', 'en') }}">{{ __('Inggris') }}</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    @auth('customer')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                {{ Auth::guard('customer')->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('booking.my') }}">{{ __('Pesanan Saya') }}</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a></li>
                            </ul>
                            <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" class="d-none">@csrf</form>
                        </li>
                    @else
                        <li class="nav-item"><a class="btn btn-primary-er btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#loginModal" style="font-size:0.85rem;padding:6px 18px;">{{ __('Masuk') }}</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @php
        $currentRoute = request()->route()?->getName() ?? '';
    @endphp

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="mb-3"><i class="bi bi-car-front-fill text-success"></i> ExploreRide</h5>
                    <p class="small mb-3">{{ __('Solusi transportasi & wisata terpercaya untuk liburan Anda.') }}</p>
                    <div class="d-flex gap-2">
                        <a href="#" class="social-link"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2">
                    <h6 class="mb-3">{{ __('Layanan') }}</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ route('cars') }}">{{ __('Sewa Mobil Lepas Kunci') }}</a></li>
                        <li class="mb-2"><a href="{{ route('cars') }}">{{ __('Sewa Mobil + Sopir') }}</a></li>
                        <li class="mb-2"><a href="{{ route('packages') }}">{{ __('Paket Wisata') }}</a></li>
                    </ul>
                </div>
                <div class="col-lg-2">
                    <h6 class="mb-3">{{ __('Destinasi') }}</h6>
                    <ul class="list-unstyled small">
                        @foreach($navCategories as $cat)
                        <li class="mb-2"><a href="{{ route('destinations.category', $cat->slug) }}">{{ __($cat->name) }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h6 class="mb-3">{{ __('Kontak') }}</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><i class="bi bi-geo-alt me-2"></i>{{ __('Solusi transportasi & wisata terpercaya.') }}</li>
                        <li class="mb-2"><i class="bi bi-telephone me-2"></i>0812-3456-7890</li>
                        <li class="mb-2"><i class="bi bi-envelope me-2"></i>info@exploreride.com</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom text-center">
                <p class="small mb-0">&copy; {{ date('Y') }} ExploreRide. {{ __('All rights reserved.') }}</p>
            </div>
        </div>
    </footer>

    <ul class="nav bottom-nav d-lg-none">
        <li class="nav-item">
            <a class="nav-link {{ $currentRoute == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                <i class="bi bi-house{{ $currentRoute == 'home' ? '-fill' : '' }}"></i>
                <span>{{ __('Beranda') }}</span>
            </a>
        </li>
        <li class="nav-item dropup" id="bottomNavDestinasi">
            <a class="nav-link dropdown-toggle {{ str_starts_with($currentRoute, 'destinations') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown">
                <i class="bi bi-compass{{ str_starts_with($currentRoute, 'destinations') ? '-fill' : '' }}"></i>
                <span>{{ __('Destinasi') }}</span>
            </a>
            <ul class="dropdown-menu" data-bs-popper="none">
                @foreach($navCategories as $cat)
                <li><a class="dropdown-item" href="{{ route('destinations.category', $cat->slug) }}">{{ __($cat->name) }}</a></li>
                @endforeach
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentRoute == 'cars' ? 'active' : '' }}" href="{{ route('cars') }}">
                <i class="bi bi-car-front{{ $currentRoute == 'cars' ? '-fill' : '' }}"></i>
                <span>{{ __('Mobil') }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentRoute == 'packages' ? 'active' : '' }}" href="{{ route('packages') }}">
                <i class="bi bi-map{{ $currentRoute == 'packages' ? '-fill' : '' }}"></i>
                <span>{{ __('Paket') }}</span>
            </a>
        </li>
        <li class="nav-item dropup" id="bottomNavProfile">
            @auth('customer')
            <a class="nav-link dropdown-toggle {{ str_starts_with($currentRoute, 'booking') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown">
                <i class="bi bi-person{{ str_starts_with($currentRoute, 'booking') ? '-fill' : '' }}"></i>
                <span>{{ Auth::guard('customer')->user()->name }}</span>
            </a>
            <ul class="dropdown-menu" data-bs-popper="none">
                <li><a class="dropdown-item" href="{{ route('booking.my') }}"><i class="bi bi-calendar-check"></i> {{ __('Pesanan Saya') }}</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('bottom-logout-form').submit();"><i class="bi bi-box-arrow-right"></i> {{ __('Logout') }}</a></li>
            </ul>
            <form id="bottom-logout-form" action="{{ route('customer.logout') }}" method="POST" class="d-none">@csrf</form>
            @else
            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>{{ __('Masuk') }}</span>
            </a>
            @endauth
        </li>
    </ul>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 600, once: true, offset: 50 });</script>

    @include('components.login-modal')
    @include('components.register-modal')

    <script>
    function switchModal(hideId, showId) {
        var hideEl = document.getElementById(hideId);
        var showEl = document.getElementById(showId);
        if (hideEl) { var hideModal = bootstrap.Modal.getInstance(hideEl); if (hideModal) hideModal.hide(); }
        if (showEl) { var showModal = new bootstrap.Modal(showEl); showModal.show(); }
    }
    document.addEventListener('DOMContentLoaded', function() {
        var params = new URLSearchParams(window.location.search);
        if (params.get('modal') === 'login') { var m = document.getElementById('loginModal'); if (m) { new bootstrap.Modal(m).show(); } }
        if (params.get('modal') === 'register') { var m = document.getElementById('registerModal'); if (m) { new bootstrap.Modal(m).show(); } }
    });
    </script>
    @stack('scripts')
</body>
</html>
