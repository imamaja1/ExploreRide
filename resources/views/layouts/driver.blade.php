<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🚗</text></svg>">
    <title>Driver ExploreRide - @yield('title', __('Dashboard'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" integrity="sha384-XGjxtQfXaH2tnPFa9x+ruJTuLE3Aa6LhHSWRr1XeTyhezb4abCG4ccI5AkVDxqC+" crossorigin="anonymous">
    <style>
        .card { border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.06); }
        .stat-card { background: #198754; color: white; border-radius: 10px; padding: 20px; }
        .stat-card .number { font-size: 2rem; font-weight: 700; }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-dark bg-success shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('driver.dashboard') }}">
                <i class="bi bi-person-badge"></i> ExploreRide Driver
            </a>
            <ul class="navbar-nav ms-auto flex-row align-items-center">
                <li class="nav-item dropdown me-2">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-globe"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item {{ session('locale') == 'id' || !session('locale') ? 'active' : '' }}" href="{{ route('lang.switch', 'id') }}">{{ __('Indonesia') }}</a></li>
                        <li><a class="dropdown-item {{ session('locale') == 'en' ? 'active' : '' }}" href="{{ route('lang.switch', 'en') }}">{{ __('Inggris') }}</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bi bi-box-arrow-right"></i> {{ __('Logout') }}</a></li>
                    </ul>
                    <form id="logout-form" action="{{ route('driver.logout') }}" method="POST" class="d-none">@csrf</form>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid p-4 bg-light" style="min-height: calc(100vh - 56px);">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>
