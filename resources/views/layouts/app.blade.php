<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🚗</text></svg>">
    <title>ExploreRide - @yield('title', __('Sewa Mobil & Paket Wisata'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" integrity="sha384-XGjxtQfXaH2tnPFa9x+ruJTuLE3Aa6LhHSWRr1XeTyhezb4abCG4ccI5AkVDxqC+" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" integrity="sha384-/rJKQnzOkEo+daG0jMjU1IwwY9unxt1NBw3Ef2fmOJ3PW/TfAg2KXVoWwMZQZtw9" crossorigin="anonymous">
    <style>
        :root {
            --green-50: #f0fdf4;
            --green-100: #dcfce7;
            --green-200: #bbf7d0;
            --green-500: #22c55e;
            --green-600: #16a34a;
            --green-700: #15803d;
            --green-800: #166534;
            --green-900: #14532d;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--gray-700);
            line-height: 1.6;
            background: #fff;
        }

        h1, h2, h3, h4 { line-height: 1.2; color: var(--gray-900); }

        /* ===== NAVBAR ===== */
        .navbar {
            padding: 14px 0;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--gray-100);
            transition: box-shadow 0.3s;
        }

        .navbar.scrolled {
            box-shadow: 0 1px 8px rgba(0,0,0,0.06);
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.3rem;
            color: var(--green-700) !important;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .navbar-brand i {
            font-size: 1.4rem;
        }

        .nav-link {
            font-weight: 500;
            color: var(--gray-600) !important;
            padding: 8px 14px !important;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: all 0.15s;
        }

        .nav-link:hover {
            color: var(--green-700) !important;
            background: var(--green-50);
        }

        .nav-link.active {
            color: var(--green-700) !important;
            font-weight: 600;
        }

        /* ===== BUTTONS ===== */
        .btn-green {
            background: var(--green-600);
            border-color: var(--green-600);
            color: #fff;
            border-radius: 10px;
            padding: 10px 24px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .btn-green:hover {
            background: var(--green-700);
            border-color: var(--green-700);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(22,163,74,0.25);
        }

        .btn-green-outline {
            border: 2px solid var(--green-600);
            color: var(--green-700);
            border-radius: 10px;
            padding: 10px 24px;
            font-weight: 600;
            font-size: 0.9rem;
            background: transparent;
            transition: all 0.2s;
        }

        .btn-green-outline:hover {
            background: var(--green-600);
            color: #fff;
            transform: translateY(-1px);
        }

        .btn-green-ghost {
            border: 2px solid rgba(255,255,255,0.4);
            color: #fff;
            border-radius: 10px;
            padding: 10px 24px;
            font-weight: 600;
            font-size: 0.9rem;
            background: transparent;
            transition: all 0.2s;
        }

        .btn-green-ghost:hover {
            background: #fff;
            color: var(--green-700);
            border-color: #fff;
            transform: translateY(-1px);
        }

        /* ===== HERO ===== */
        .hero-section {
            background: var(--green-700);
            color: #fff;
            padding: 80px 0 100px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -40%;
            right: -15%;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
        }

        .hero-section::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 350px;
            height: 350px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }

        .hero-section h1 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: clamp(1.75rem, 4vw, 2.5rem);
            letter-spacing: -0.5px;
            color: #fff;
            line-height: 1.15;
        }

        .hero-section .lead {
            font-size: 1rem;
            opacity: 0.9;
            max-width: 550px;
            margin: 0 auto 2rem;
            color: rgba(255,255,255,0.9);
        }

        .hero-badge {
            display: inline-block;
            background: rgba(255,255,255,0.15);
            color: #fff;
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 16px;
            backdrop-filter: blur(4px);
        }

        /* ===== CARDS ===== */
        .card {
            border: 1px solid var(--gray-200);
            border-radius: 14px;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
            background: #fff;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0,0,0,0.08);
            border-color: var(--green-200);
        }

        .card-img-top {
            border-radius: 0;
        }

        .card-body { padding: 18px; }

        .card-title {
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--gray-900);
        }

        .card-text {
            font-size: 0.85rem;
            color: var(--gray-500);
        }

        /* ===== SECTIONS ===== */
        .section-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .section-header h2 {
            font-weight: 800;
            font-size: 1.6rem;
            color: var(--gray-900);
            margin-bottom: 8px;
        }

        .section-header p {
            font-size: 0.95rem;
            color: var(--gray-500);
            max-width: 500px;
            margin: 0 auto;
        }

        .section-line {
            width: 40px;
            height: 3px;
            background: var(--green-500);
            border-radius: 2px;
            margin: 12px auto 0;
        }

        /* ===== CATEGORY SECTION ===== */
        .category-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .category-header h2 {
            font-weight: 700;
            font-size: 1.35rem;
            color: var(--gray-900);
            margin: 0;
        }

        .category-line {
            width: 32px;
            height: 3px;
            background: var(--green-500);
            border-radius: 2px;
            margin-top: 8px;
        }

        /* ===== TESTIMONIALS ===== */
        .testimonial-card {
            border: 1px solid var(--gray-200);
            border-radius: 14px;
            padding: 24px;
            background: #fff;
            transition: all 0.2s;
            height: 100%;
        }

        .testimonial-card:hover {
            border-color: var(--green-200);
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        }

        /* ===== CTA SECTION ===== */
        .cta-section {
            background: var(--green-700);
            color: #fff;
            padding: 60px 0;
            text-align: center;
        }

        .cta-section h3 {
            font-weight: 800;
            color: #fff;
            margin-bottom: 8px;
        }

        .cta-section .lead {
            color: rgba(255,255,255,0.85);
            margin-bottom: 24px;
        }

        .cta-section .btn-light {
            border-radius: 10px;
            font-weight: 600;
            padding: 12px 32px;
            color: var(--green-700);
        }

        /* ===== FOOTER ===== */
        .footer {
            background: var(--gray-900);
            color: var(--gray-400);
            padding: 56px 0 0;
        }

        .footer-brand {
            font-weight: 800;
            font-size: 1.2rem;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
        }

        .footer-brand i {
            color: var(--green-500);
        }

        .footer-desc {
            font-size: 0.85rem;
            color: var(--gray-400);
            line-height: 1.7;
            max-width: 300px;
        }

        .footer h6 {
            color: #fff;
            font-weight: 700;
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 16px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: var(--gray-400);
            text-decoration: none;
            font-size: 0.85rem;
            transition: all 0.15s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .footer-links a:hover {
            color: #fff;
            transform: translateX(3px);
        }

        .footer-contact li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 12px;
            font-size: 0.85rem;
            color: var(--gray-400);
        }

        .footer-contact li i {
            color: var(--green-500);
            font-size: 0.9rem;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .footer-social {
            display: flex;
            gap: 8px;
            margin-top: 20px;
        }

        .footer-social a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: rgba(255,255,255,0.06);
            color: var(--gray-400);
            font-size: 1rem;
            transition: all 0.2s;
            text-decoration: none;
        }

        .footer-social a:hover {
            background: var(--green-600);
            color: #fff;
            transform: translateY(-2px);
        }

        .footer-divider {
            border: none;
            border-top: 1px solid rgba(255,255,255,0.06);
            margin: 40px 0 0;
        }

        .footer-bottom {
            padding: 20px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.8rem;
            color: var(--gray-500);
        }

        @media (max-width: 991.98px) {
            .footer-bottom {
                flex-direction: column;
                gap: 8px;
                text-align: center;
            }
        }

        /* ===== BOTTOM NAV (Mobile) ===== */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            background: #fff;
            border-top: 1px solid var(--gray-200);
            box-shadow: 0 -2px 8px rgba(0,0,0,0.04);
        }

        .bottom-nav .nav-item { flex: 1; text-align: center; padding: 6px 0 4px; }

        .bottom-nav .nav-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 0.65rem;
            color: var(--gray-400) !important;
            padding: 0;
            border: 0;
            background: none;
            font-weight: 500;
        }

        .bottom-nav .nav-link i { font-size: 1.2rem; margin-bottom: 2px; }

        .bottom-nav .nav-link.active {
            color: var(--green-600) !important;
            font-weight: 600;
        }

        .bottom-nav .dropdown-menu {
            bottom: 100%;
            margin-bottom: 8px;
            left: 50%;
            transform: translateX(-50%);
            min-width: 160px;
            border-radius: 12px;
            box-shadow: 0 -4px 16px rgba(0,0,0,0.1);
            border: 1px solid var(--gray-200);
            padding: 6px;
        }

        .bottom-nav .dropdown-menu .dropdown-item {
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.85rem;
        }

        .bottom-nav .dropdown-menu .dropdown-item:hover {
            background: var(--green-50);
            color: var(--green-700);
        }

        /* ===== NAV DROPDOWN ===== */
        .nav-dropdown-menu {
            min-width: 160px;
            border-radius: 10px;
            border: 1px solid var(--gray-200);
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            padding: 6px;
            background: #fff;
            margin-top: 4px !important;
        }

        .nav-dropdown-menu .dropdown-item {
            border-radius: 6px;
            padding: 8px 14px;
            font-size: 0.85rem;
            color: var(--gray-700);
        }

        .nav-dropdown-menu .dropdown-item:hover {
            background: var(--green-50);
            color: var(--green-700);
        }

        .nav-dropdown-menu .dropdown-item.active {
            background: var(--green-600) !important;
            color: #fff !important;
        }

        /* ===== MISC ===== */
        .card-img-fixed { height: 200px; object-fit: cover; }
        .card-img-car { height: 180px; object-fit: cover; }

        /* ===== FLOATING WHATSAPP ===== */
        .wa-float {
            position: fixed;
            bottom: 80px;
            right: 20px;
            z-index: 1040;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 52px;
            height: 52px;
            background: #25D366;
            color: #fff;
            border-radius: 50%;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(37,211,102,0.3);
        }

        .wa-float:hover {
            transform: scale(1.08);
            color: #fff;
            box-shadow: 0 6px 20px rgba(37,211,102,0.4);
        }

        .wa-float i { font-size: 1.5rem; }

        @media (min-width: 992px) {
            .wa-float { bottom: 30px; right: 30px; width: 56px; height: 56px; }
            .wa-float i { font-size: 1.7rem; }
        }

        /* ===== MOBILE ===== */
        @media (max-width: 991.98px) {
            main { padding-bottom: 68px; }
            .footer { padding-bottom: 90px; }
            .hero-section { padding: 50px 0 70px; }
        }

        /* ===== MOBILE LANG DROPDOWN ===== */
        .mobile-lang-toggle {
            font-size: 0.85rem !important;
            padding: 4px 8px !important;
            border-radius: 6px !important;
            color: var(--gray-600) !important;
        }

        .navbar-nav.flex-row .nav-item.dropdown {
            position: relative;
        }

        .navbar-nav .mobile-lang-dropdown {
            min-width: 140px;
            border-radius: 10px;
            border: 1px solid var(--gray-200);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            padding: 6px;
            background: #fff;
            position: absolute;
            right: 0;
            top: 100%;
        }

        .navbar-nav .mobile-lang-dropdown .dropdown-item {
            border-radius: 6px;
            padding: 8px 12px;
            font-size: 0.85rem;
            color: var(--gray-700);
        }

        .navbar-nav .mobile-lang-dropdown .dropdown-item.active {
            background: var(--green-600) !important;
            color: #fff !important;
        }

        .dropdown-menu .dropdown-item.active { color: #fff !important; }

        .modal-content { border: 1px solid var(--gray-200); border-radius: 14px; }

        /* ===== PAGINATION ===== */
        .pagination {
            gap: 4px;
        }

        .pagination .page-link {
            border-radius: 8px !important;
            border: 1px solid #e5e7eb !important;
            color: #4b5563 !important;
            padding: 7px 13px !important;
            font-size: 0.85rem !important;
            background-color: #fff !important;
            line-height: 1.4 !important;
            min-width: 36px !important;
            text-align: center !important;
        }

        .pagination .page-link:hover {
            background-color: #f3f4f6 !important;
            color: #111827 !important;
            border-color: #d1d5db !important;
        }

        .pagination .page-item.active .page-link {
            background-color: #16a34a !important;
            border-color: #16a34a !important;
            color: #fff !important;
        }

        .pagination .page-item.disabled .page-link {
            background-color: #f9fafb !important;
            color: #d1d5db !important;
            border-color: #f3f4f6 !important;
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top" id="mainNav" aria-label="Main navigation">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-car-front-fill"></i> ExploreRide
            </a>

            <ul class="navbar-nav flex-row d-lg-none align-items-center">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle mobile-lang-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-globe"></i> {{ session('locale', 'id') == 'en' ? 'EN' : 'ID' }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end mobile-lang-dropdown">
                        <li><a class="dropdown-item {{ session('locale') == 'id' || !session('locale') ? 'active' : '' }}" href="{{ route('lang.switch', 'id') }}">{{ __('Indonesia') }}</a></li>
                        <li><a class="dropdown-item {{ session('locale') == 'en' ? 'active' : '' }}" href="{{ route('lang.switch', 'en') }}">{{ __('Inggris') }}</a></li>
                    </ul>
                </li>
            </ul>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">{{ __('Beranda') }}</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">{{ __('Destinasi') }}</a>
                        <ul class="dropdown-menu nav-dropdown-menu">
                            @foreach($navCategories as $cat)
                            <li><a class="dropdown-item" href="{{ route('destinations.category', $cat->slug) }}">{{ __($cat->name) }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('cars') ? 'active' : '' }}" href="{{ route('cars') }}">{{ __('Mobil') }}</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('packages') ? 'active' : '' }}" href="{{ route('packages') }}">{{ __('Paket Wisata') }}</a></li>
                </ul>
                <ul class="navbar-nav d-none d-lg-flex">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-globe"></i> {{ session('locale', 'id') == 'en' ? __('Inggris') : __('Indonesia') }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end nav-dropdown-menu">
                            <li><a class="dropdown-item {{ session('locale') == 'id' || !session('locale') ? 'active' : '' }}" href="{{ route('lang.switch', 'id') }}">{{ __('Indonesia') }}</a></li>
                            <li><a class="dropdown-item {{ session('locale') == 'en' ? 'active' : '' }}" href="{{ route('lang.switch', 'en') }}">{{ __('Inggris') }}</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    @auth('customer')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i> {{ Auth::guard('customer')->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end nav-dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('booking.my') }}"><i class="bi bi-receipt me-2"></i>{{ __('Pesanan Saya') }}</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bi bi-box-arrow-right me-2"></i>{{ __('Logout') }}</a></li>
                            </ul>
                            <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" class="d-none">@csrf</form>
                        </li>
                    @else
                        <li class="nav-item"><a class="btn btn-green btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#loginModal" style="font-size:0.85rem;padding:7px 20px;">{{ __('Masuk') }}</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @php $currentRoute = request()->route()?->getName() ?? ''; @endphp

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="footer-brand">
                        <i class="bi bi-car-front-fill"></i> ExploreRide
                    </div>
                    <p class="footer-desc">{{ __('Solusi transportasi & wisata terpercaya untuk liburan Anda.') }}</p>
                    <div class="footer-social">
                        @if(!empty($siteSettings['instagram']))
                        <a href="{{ $siteSettings['instagram'] }}" target="_blank" rel="noopener"><i class="bi bi-instagram"></i></a>
                        @endif
                        @if(!empty($siteSettings['facebook']))
                        <a href="{{ $siteSettings['facebook'] }}" target="_blank" rel="noopener"><i class="bi bi-facebook"></i></a>
                        @endif
                        @if(!empty($siteSettings['twitter']))
                        <a href="{{ $siteSettings['twitter'] }}" target="_blank" rel="noopener"><i class="bi bi-twitter-x"></i></a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <h6>{{ __('Layanan') }}</h6>
                    <ul class="footer-links">
                        <li><a href="{{ route('cars') }}">{{ __('Sewa Mobil') }}</a></li>
                        <li><a href="{{ route('packages') }}">{{ __('Paket Wisata') }}</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-6">
                    <h6>{{ __('Destinasi') }}</h6>
                    <ul class="footer-links">
                        @foreach($navCategories as $cat)
                        <li><a href="{{ route('destinations.category', $cat->slug) }}">{{ __($cat->name) }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h6>{{ __('Kontak') }}</h6>
                    <ul class="footer-contact list-unstyled">
                        @if(!empty($siteSettings['address']))
                        <li><i class="bi bi-geo-alt"></i><span>{{ $siteSettings['address'] }}</span></li>
                        @endif
                        @if(!empty($siteSettings['phone']))
                        <li><i class="bi bi-telephone"></i><span>{{ $siteSettings['phone'] }}</span></li>
                        @endif
                        @if(!empty($siteSettings['email']))
                        <li><i class="bi bi-envelope"></i><span>{{ $siteSettings['email'] }}</span></li>
                        @endif
                    </ul>
                </div>
            </div>
            <hr class="footer-divider">
            <div class="footer-bottom">
                <span>&copy; {{ date('Y') }} ExploreRide. {{ __('All rights reserved.') }}</span>
                <span>{{ __('Dibuat dengan') }} <i class="bi bi-heart-fill" style="color: #ef4444; font-size: 0.7rem;"></i> {{ __('di Indonesia') }}</span>
            </div>
        </div>
    </footer>

    @if(!empty($siteSettings['whatsapp']))
    <a href="https://wa.me/{{ $siteSettings['whatsapp'] }}?text=Halo%20ExploreRide%2C%20saya%20ingin%20bertanya" class="wa-float" target="_blank" rel="noopener" title="Chat WhatsApp">
        <i class="bi bi-whatsapp"></i>
    </a>
    @endif

    <nav class="nav bottom-nav d-lg-none" aria-label="Mobile navigation">
        <li class="nav-item">
            <a class="nav-link {{ $currentRoute == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                <i class="bi bi-house{{ $currentRoute == 'home' ? '-fill' : '' }}"></i>
                <span>{{ __('Beranda') }}</span>
            </a>
        </li>
        <li class="nav-item dropup">
            <a class="nav-link dropdown-toggle {{ str_starts_with($currentRoute, 'destinations') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown">
                <i class="bi bi-compass{{ str_starts_with($currentRoute, 'destinations') ? '-fill' : '' }}"></i>
                <span>{{ __('Destinasi') }}</span>
            </a>
            <ul class="dropdown-menu mobile-lang-dropdown">
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
        <li class="nav-item dropup">
            @auth('customer')
            <a class="nav-link dropdown-toggle {{ str_starts_with($currentRoute, 'booking') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown">
                <i class="bi bi-person{{ str_starts_with($currentRoute, 'booking') ? '-fill' : '' }}"></i>
                <span>{{ Auth::guard('customer')->user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('booking.my') }}"><i class="bi bi-receipt me-2"></i>{{ __('Pesanan Saya') }}</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('bottom-logout-form').submit();"><i class="bi bi-box-arrow-right me-2"></i>{{ __('Logout') }}</a></li>
            </ul>
            <form id="bottom-logout-form" action="{{ route('customer.logout') }}" method="POST" class="d-none">@csrf</form>
            @else
            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>{{ __('Masuk') }}</span>
            </a>
            @endauth
        </li>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js" integrity="sha384-wziAfh6b/qT+3LrqebF9WeK4+J5sehS6FA10J1t3a866kJ/fvU5UwofWnQyzLtwu" crossorigin="anonymous"></script>
    <script>AOS.init({ duration: 500, once: true, offset: 40 });</script>

    <script>
    window.addEventListener('scroll', function() {
        var nav = document.getElementById('mainNav');
        if (nav) { nav.classList.toggle('scrolled', window.scrollY > 10); }
    });
    </script>

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
