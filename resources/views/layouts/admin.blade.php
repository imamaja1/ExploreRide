<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin ExploreRide - @yield('title', __('Dashboard'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar { background-color: #145c32; min-height: calc(100vh - 56px); }
        .sidebar a { color: rgba(255,255,255,0.8); padding: 12px 20px; white-space: nowrap; display: block; text-decoration: none; border-left: 3px solid transparent; }
        .sidebar a:hover { background-color: rgba(255,255,255,0.1); color: white; }
        .sidebar a.active { border-left-color: #22c55e; background-color: rgba(255,255,255,0.12); color: white; font-weight: 600; }
        .sidebar a i { margin-right: 10px; width: 20px; text-align: center; }
        .content-area { background-color: #f0f2f5; min-height: calc(100vh - 56px); }
        .card { border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.06); border-radius: 10px; transition: box-shadow 0.2s; }
        .card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .card-header { background: #198754; color: #fff; font-weight: 600; padding: 12px 20px; border: 0; border-radius: 10px 10px 0 0 !important; }

        .table thead th { background: #198754; color: #fff; font-weight: 500; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.04em; border: 0; padding: 12px 16px; }
        .table thead th:first-child { border-radius: 8px 0 0 0; }
        .table thead th:last-child { border-radius: 0 8px 0 0; }
        .table tbody tr { transition: background 0.15s; }
        .table tbody tr:hover { background: #f0fdf4; }
        .table td { padding: 12px 16px; vertical-align: middle; }

        .badge { font-weight: 500; font-size: 0.75rem; padding: 4px 12px; }
        .badge.rounded-pill { padding: 4px 14px; }

        .form-control, .form-select { border-radius: 8px; border: 1.5px solid #e5e7eb; padding: 10px 14px; transition: all 0.2s; font-size: 0.9rem; }
        .form-control:focus, .form-select:focus { border-color: #198754; box-shadow: 0 0 0 3px rgba(25,135,84,0.12); }

        .btn { border-radius: 8px; font-weight: 500; padding: 10px 22px; transition: all 0.2s; font-size: 0.875rem; }
        .btn-sm { border-radius: 6px; padding: 8px 16px; font-size: 0.8rem; }
        .btn-success { background: #198754; border-color: #198754; }
        .btn-success:hover { background: #145c32; border-color: #145c32; }

        .page-link { border-radius: 8px !important; margin: 0 2px; border: 0; color: #198754; padding: 8px 14px; }
        .page-item.active .page-link { background: #198754 !important; border-color: #198754 !important; color: #fff; }
        .page-item.disabled .page-link { background: transparent; color: #ccc; }

        .page-title { font-weight: 700; font-size: 1.25rem; margin-bottom: 0; color: #1f2937; }
        .page-title-border { border-bottom: 2px solid #198754; padding-bottom: 10px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; }

        .stat-card { border-radius: 12px; padding: 20px; }
        .stat-card .number { font-size: 1.75rem; font-weight: 700; }

        nav.navbar { position: relative; z-index: 1050; }
        .navbar .nav-item.dropdown { position: relative; }

        .pagination { gap: 2px; }

        .btn-success-er { background: #198754; border-color: #198754; color: #fff; border-radius: 8px; padding: 8px 18px; font-weight: 500; transition: all 0.2s; }
        .btn-success-er:hover { background: #145c32; border-color: #145c32; color: #fff; }

        .input-group-text { border-color: #e5e7eb; }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
        <div class="container-fluid">
            <button class="btn btn-outline-light btn-sm d-lg-none me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminSidebar">
                <i class="bi bi-list"></i>
            </button>
            <a class="navbar-brand fw-bold fs-6 fs-lg-5" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-car-front-fill"></i> ExploreRide
            </a>
            <div class="collapse navbar-collapse justify-content-end" id="adminNavbar">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item dropdown me-2">
                        <a class="nav-link dropdown-toggle text-white py-1" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-globe"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item {{ session('locale') == 'id' || !session('locale') ? 'active' : '' }}" href="{{ route('lang.switch', 'id') }}">{{ __('Indonesia') }}</a></li>
                            <li><a class="dropdown-item {{ session('locale') == 'en' ? 'active' : '' }}" href="{{ route('lang.switch', 'en') }}">{{ __('Inggris') }}</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white py-1" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i>
                            <span class="d-none d-lg-inline">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('home') }}" target="_blank"><i class="bi bi-eye"></i> {{ __('Lihat Website') }}</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bi bi-box-arrow-right"></i> {{ __('Logout') }}</a></li>
                        </ul>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">@csrf</form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="d-flex">
        <div class="offcanvas offcanvas-start d-lg-none sidebar text-white border-0" tabindex="-1" id="adminSidebar" style="width:280px;">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title text-white fw-bold"><i class="bi bi-car-front-fill"></i> ExploreRide</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body p-0 d-flex flex-column">
                @include('admin._sidebar')
            </div>
        </div>

        <div class="d-none d-lg-block sidebar" style="width:250px;flex-shrink:0;">
            @include('admin._sidebar')
        </div>

        <div class="content-area p-3 p-lg-4 w-100" style="min-width:0;">
            <div id="flash-success" data-message="{{ session('success', '') }}" style="display:none;"></div>
            <div id="flash-error" data-message="{{ session('error', '') }}" style="display:none;"></div>
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var success = document.getElementById('flash-success');
        if (success && success.dataset.message) {
            Swal.fire({ icon: 'success', title: success.dataset.message, toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true });
        }
        var error = document.getElementById('flash-error');
        if (error && error.dataset.message) {
            Swal.fire({ icon: 'error', title: error.dataset.message, toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true });
        }
    });

    document.addEventListener('submit', function(e) {
        var form = e.target;
        if (form.dataset.confirm) {
            e.preventDefault();
            Swal.fire({
                title: form.dataset.confirm || '{{ __("Yakin?") }}',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: form.dataset.confirmColor || '#dc3545',
                confirmButtonText: form.dataset.confirmButton || '{{ __("Ya, hapus!") }}',
                cancelButtonText: '{{ __("Batal") }}',
            }).then(function(result) {
                if (result.isConfirmed) {
                    form.dataset.confirm = '';
                    form.submit();
                }
            });
        }
    });
    </script>
    @stack('scripts')
</body>
</html>
