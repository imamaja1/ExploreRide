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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --header-height: 56px;
            --primary: #16a34a;
            --primary-light: #dcfce7;
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

        /* ===== CONTENT ===== */
        .app-content {
            margin-top: var(--header-height);
            padding: 24px 28px;
            min-height: calc(100vh - var(--header-height));
        }

        /* ===== STAT CARDS ===== */
        .stat-card {
            background: #fff;
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            transition: transform 0.2s;
        }
        .stat-card:hover { transform: translateY(-2px); }

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

        /* ===== TABLES ===== */
        .table { margin-bottom: 0; }

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

        @media (max-width: 767.98px) {
            .app-content { padding: 16px; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <header class="app-header">
        <a class="brand" href="{{ route('driver.dashboard') }}">
            <i class="bi bi-car-front-fill"></i>
            <span>ExploreRide <small style="font-size:0.7rem; font-weight:400; color:var(--gray-400);">Driver</small></span>
        </a>

        <div class="header-actions">
            <div class="dropdown">
                <a class="btn-icon" href="#" data-bs-toggle="dropdown" title="{{ __('Bahasa') }}">
                    <i class="bi bi-globe2"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item {{ session('locale') == 'id' || !session('locale') ? 'active' : '' }}" href="{{ route('lang.switch', 'id') }}">Indonesia</a></li>
                    <li><a class="dropdown-item {{ session('locale') == 'en' ? 'active' : '' }}" href="{{ route('lang.switch', 'en') }}">English</a></li>
                </ul>
            </div>

            <div class="dropdown">
                <div class="user-menu" data-bs-toggle="dropdown">
                    <div class="user-avatar">{{ substr(auth()->user()?->name ?? 'D', 0, 1) }}</div>
                    <span class="user-name d-none d-md-inline">{{ auth()->user()?->name }}</span>
                    <i class="bi bi-chevron-down" style="font-size: 0.7rem; color: var(--gray-400);"></i>
                </div>
                <ul class="dropdown-menu dropdown-menu-end" style="min-width: 180px;">
                    <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bi bi-box-arrow-right me-2"></i> {{ __('Logout') }}</a></li>
                </ul>
                <form id="logout-form" action="{{ route('driver.logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
        </div>
    </header>

    <main class="app-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>
