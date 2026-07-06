<!DOCTYPE html>
    <html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ExploreRide - @yield('title', __('Sewa Mobil & Paket Wisata'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --er-primary: #198754;
            --er-dark: #145c32;
            --er-light: #f8f9fa;
        }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar-brand { font-weight: 700; font-size: 1.5rem; }
        .hero-section { background: var(--er-primary); color: white; padding: 120px 0; }
        .hero-section h1 { font-family: 'Poppins', sans-serif; font-weight: 800; }
        .hero-section .btn { transition: all 0.3s ease; }
        .hero-section .btn-light:hover { background: transparent; color: #fff; border-color: #fff; }
        .hero-section .btn-outline-light:hover { background: #fff; color: var(--er-primary); }
        .card { border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.08); transition: transform 0.2s; }
        .card:hover { transform: translateY(-3px); }
        .service-icon { font-size: 2.5rem; color: var(--er-primary); }
        .footer { background-color: var(--er-dark); color: white; padding: 30px 0; }
        .footer hr { border-color: rgba(255,255,255,0.2); }
        .nav-link.active { color: var(--er-primary) !important; font-weight: 600; }
        .card-img-fixed { height: 200px; object-fit: cover; }
        .card-img-car { height: 180px; object-fit: cover; }
        .stat-card { border-radius: 12px; padding: 20px; }
        .table-header-green { --bs-table-bg: var(--er-primary); --bs-table-color: #fff; }

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
        @media (max-width: 991.98px) {
            main { padding-bottom: 68px; }
            .footer { padding-bottom: 90px; }
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
                        <li class="nav-item"><a class="btn btn-outline-success btn-sm mt-1" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">{{ __('Masuk') }}</a></li>
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
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="bi bi-car-front-fill"></i> ExploreRide</h5>
                    <p class="small">{{ __('Solusi transportasi & wisata terpercaya untuk liburan Anda.') }}</p>
                </div>
                <div class="col-md-3">
                    <h6>{{ __('Layanan') }}</h6>
                    <ul class="list-unstyled small">
                        <li>{{ __('Sewa Mobil Lepas Kunci') }}</li>
                        <li>{{ __('Sewa Mobil + Sopir') }}</li>
                        <li>{{ __('Paket Wisata') }}</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>{{ __('Kontak') }}</h6>
                    <ul class="list-unstyled small">
                        <li><i class="bi bi-whatsapp"></i> 0812-3456-7890</li>
                        <li><i class="bi bi-envelope"></i> info@exploreride.com</li>
                    </ul>
                </div>
            </div>
            <hr class="mt-3">
            <p class="text-center small mb-0">&copy; {{ date('Y') }} ExploreRide. All rights reserved.</p>
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
