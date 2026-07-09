<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://static.cloudflareinsights.com; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com https://cdn.jsdelivr.net; img-src 'self' data: https:; connect-src 'self' https://cdn.jsdelivr.net https://static.cloudflareinsights.com;">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🚗</text></svg>">
    <title>Admin ExploreRide - @yield('title', __('Dashboard'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" integrity="sha384-XGjxtQfXaH2tnPFa9x+ruJTuLE3Aa6LhHSWRr1XeTyhezb4abCG4ccI5AkVDxqC+" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js" integrity="sha384-vsrfeLOOY6KuIYKDlmVH5UiBmgIdB1oEf7p01YgWHuqmOHfZr374+odEv96n9tNC" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js" integrity="sha384-nLoOnA/BDh8A/jxqtckg4DumuCGOBYUnNJLZdQz/zfYNp3wcjGSoWTAzgko06G/2" crossorigin="anonymous"></script>
    <style>
        :root {
            --sidebar-width: 260px;
            --header-height: 56px;
            --primary: #0ea5e9;
            --primary-light: #e0f2fe;
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
            font-family: 'Inter', sans-serif;
            background: var(--gray-50);
            color: var(--gray-800);
            margin: 0;
            padding: 0;
        }

        /* ===== HEADER ===== */
        .app-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--header-height);
            background: #fff;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            padding: 0 20px;
            z-index: 1040;
        }

        .app-header .brand {
            font-weight: 700;
            font-size: 1rem;
            color: var(--gray-900);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            width: var(--sidebar-width);
            flex-shrink: 0;
        }

        .app-header .brand i {
            font-size: 1.25rem;
            color: var(--primary);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-left: auto;
        }

        .header-actions .btn-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--gray-200);
            background: #fff;
            color: var(--gray-500);
            cursor: pointer;
            transition: all 0.15s;
            text-decoration: none;
            font-size: 1rem;
        }

        .header-actions .btn-icon:hover {
            background: var(--gray-50);
            color: var(--gray-700);
            border-color: var(--gray-300);
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 4px 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.15s;
        }

        .user-menu:hover { background: var(--gray-100); }

        .user-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .user-name {
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--gray-700);
        }

        /* ===== SIDEBAR ===== */
        .app-sidebar {
            position: fixed;
            top: var(--header-height);
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: #fff;
            border-right: 1px solid var(--gray-200);
            overflow-y: auto;
            z-index: 1030;
            padding: 16px 0;
        }

        .app-sidebar::-webkit-scrollbar { width: 4px; }
        .app-sidebar::-webkit-scrollbar-thumb { background: var(--gray-300); border-radius: 4px; }

        .sidebar-section {
            margin-bottom: 8px;
        }

        .sidebar-section-title {
            padding: 8px 20px 6px;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--gray-400);
        }

        .sidebar-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 20px;
            color: var(--gray-600);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 450;
            transition: all 0.15s;
            border-left: 3px solid transparent;
            margin: 1px 0;
        }

        .sidebar-item:hover {
            background: var(--gray-50);
            color: var(--gray-900);
        }

        .sidebar-item.active {
            background: var(--primary-light);
            color: var(--primary);
            font-weight: 600;
            border-left-color: var(--primary);
        }

        .sidebar-item i {
            width: 20px;
            text-align: center;
            font-size: 1.05rem;
            flex-shrink: 0;
        }

        .sidebar-divider {
            height: 1px;
            background: var(--gray-200);
            margin: 12px 20px;
        }

        /* ===== CONTENT ===== */
        .app-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--header-height);
            padding: 24px 28px;
            min-height: calc(100vh - var(--header-height));
        }

        /* ===== CARDS ===== */
        .card {
            background: #fff;
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.04);
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid var(--gray-200);
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--gray-800);
            padding: 14px 20px;
            border-radius: 12px 12px 0 0 !important;
        }

        .card-body { padding: 20px; }

        /* ===== STAT CARDS ===== */
        .stat-card {
            background: #fff;
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
        }

        .stat-card .stat-info .stat-label {
            font-size: 0.8rem;
            color: var(--gray-500);
            font-weight: 500;
            margin-bottom: 4px;
        }

        .stat-card .stat-info .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        .stat-card .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        /* ===== TABLES ===== */
        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: var(--gray-50);
            color: var(--gray-500);
            font-weight: 600;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--gray-200);
            padding: 10px 16px;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 12px 16px;
            vertical-align: middle;
            font-size: 0.85rem;
            color: var(--gray-700);
            border-bottom: 1px solid var(--gray-100);
        }

        .table tbody tr:last-child td { border-bottom: none; }
        .table tbody tr:hover { background: var(--gray-50); }

        /* ===== BADGES ===== */
        .badge {
            font-weight: 500;
            font-size: 0.72rem;
            padding: 4px 10px;
            border-radius: 6px;
        }

        /* ===== FORMS ===== */
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid var(--gray-300);
            padding: 9px 14px;
            font-size: 0.85rem;
            color: var(--gray-800);
            transition: all 0.15s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(14,165,233,0.1);
        }

        .form-label {
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--gray-700);
            margin-bottom: 6px;
        }

        /* ===== BUTTONS ===== */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.85rem;
            padding: 8px 18px;
            transition: all 0.15s;
        }

        .btn-sm {
            padding: 6px 14px;
            font-size: 0.78rem;
            border-radius: 6px;
        }

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background: #0284c7;
            border-color: #0284c7;
        }

        .btn-outline-gray {
            border: 1px solid var(--gray-300);
            color: var(--gray-600);
            background: #fff;
        }

        .btn-outline-gray:hover {
            background: var(--gray-50);
            border-color: var(--gray-400);
            color: var(--gray-800);
        }

        /* ===== PAGE TITLE ===== */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .page-header h4 {
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--gray-900);
            margin: 0;
        }

        /* ===== INPUT GROUP ===== */
        .input-group-text {
            border-color: var(--gray-300);
            background: var(--gray-50);
            color: var(--gray-500);
        }

        /* ===== MOBILE SIDEBAR ===== */
        .mobile-sidebar {
            width: 280px;
        }

        .mobile-sidebar .offcanvas-header {
            border-bottom: 1px solid var(--gray-200);
            padding: 16px 20px;
        }

        .mobile-sidebar .offcanvas-body {
            padding: 0;
        }

        @media (max-width: 991.98px) {
            .app-content {
                margin-left: 0;
                padding: 16px;
            }
        }

        /* ===== PAGINATION ===== */
        .pagination {
            gap: 4px;
        }

        .pagination .page-link {
            border-radius: 8px !important;
            border: 1px solid #e5e7eb !important;
            color: #4b5563 !important;
            padding: 7px 13px !important;
            font-size: 0.82rem !important;
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
            background-color: #0ea5e9 !important;
            border-color: #0ea5e9 !important;
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
    <!-- HEADER -->
    <header class="app-header">
        <button class="btn btn-icon d-lg-none me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-label="Toggle menu">
            <i class="bi bi-list"></i>
        </button>

        <a class="brand" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-car-front-fill"></i>
            <span>ExploreRide</span>
        </a>

        <div class="header-actions">
            <div class="dropdown">
                <a class="btn-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-globe2"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item {{ session('locale') == 'id' || !session('locale') ? 'active' : '' }}" href="{{ route('lang.switch', 'id') }}">Indonesia</a></li>
                    <li><a class="dropdown-item {{ session('locale') == 'en' ? 'active' : '' }}" href="{{ route('lang.switch', 'en') }}">English</a></li>
                </ul>
            </div>

            <a class="btn-icon" href="{{ route('home') }}" target="_blank" rel="noopener" title="{{ __('Lihat Website') }}">
                <i class="bi bi-box-arrow-up-right"></i>
            </a>

            <div class="dropdown">
                <div class="user-menu" data-bs-toggle="dropdown">
                    <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                    <span class="user-name d-none d-md-inline">{{ auth()->user()->name }}</span>
                    <i class="bi bi-chevron-down" style="font-size: 0.7rem; color: var(--gray-400);"></i>
                </div>
                <ul class="dropdown-menu dropdown-menu-end" style="min-width: 180px;">
                    <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bi bi-box-arrow-right me-2"></i> {{ __('Logout') }}</a></li>
                </ul>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
        </div>
    </header>

    <!-- MOBILE SIDEBAR -->
    <div class="offcanvas offcanvas-start mobile-sidebar d-lg-none" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarTitle">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title fw-bold" id="mobileSidebarTitle" style="color: var(--gray-900);">
                <i class="bi bi-car-front-fill" style="color: var(--primary);"></i> ExploreRide
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            @include('admin._sidebar')
        </div>
    </div>

    <!-- DESKTOP SIDEBAR -->
    <aside class="app-sidebar d-none d-lg-block">
        @include('admin._sidebar')
    </aside>

    <!-- MAIN CONTENT -->
    <main class="app-content">
        <div id="flash-success" data-message="{{ session('success', '') }}" style="display:none;"></div>
        <div id="flash-error" data-message="{{ session('error', '') }}" style="display:none;"></div>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

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
