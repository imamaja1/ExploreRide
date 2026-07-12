<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🚗</text></svg>">
    <title>{{ __('Driver Login') }} - ExploreRide</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" integrity="sha384-XGjxtQfXaH2tnPFa9x+ruJTuLE3Aa6LhHSWRr1XeTyhezb4abCG4ccI5AkVDxqC+" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --green-50: #f0fdf4; --green-100: #dcfce7; --green-600: #16a34a; --green-700: #15803d;
            --gray-50: #f9fafb; --gray-100: #f3f4f6; --gray-200: #e5e7eb; --gray-400: #9ca3af; --gray-500: #6b7280; --gray-700: #374151; --gray-900: #111827;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--gray-50);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            max-width: 420px;
            width: 100%;
        }
        .login-header {
            background: var(--green-700);
            padding: 32px 24px 28px;
            text-align: center;
        }
        .login-header .icon-circle {
            width: 64px; height: 64px;
            background: rgba(255,255,255,0.15);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }
        .login-header .icon-circle i { font-size: 1.6rem; color: #fff; }
        .login-header h4 { color: #fff; font-weight: 700; margin: 0 0 4px; font-size: 1.2rem; }
        .login-header p { color: rgba(255,255,255,0.7); font-size: 0.85rem; margin: 0; }
        .login-body { padding: 28px 24px; }
        .form-label { font-weight: 600; font-size: 0.85rem; color: var(--gray-700); }
        .form-control { border-radius: 10px; border: 1px solid var(--gray-200); padding: 10px 14px; font-size: 0.9rem; transition: border-color 0.2s; }
        .form-control:focus { border-color: var(--green-600); box-shadow: 0 0 0 3px rgba(22,163,74,0.12); }
        .btn-login {
            background: var(--green-600); border-color: var(--green-600);
            color: #fff; border-radius: 10px; padding: 11px; font-weight: 600; font-size: 0.95rem;
            transition: all 0.2s;
        }
        .btn-login:hover { background: var(--green-700); border-color: var(--green-700); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(22,163,74,0.25); color: #fff; }
        .back-link { font-size: 0.85rem; color: var(--gray-500); text-decoration: none; }
        .back-link:hover { color: var(--green-700); }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <div class="icon-circle">
                <i class="bi bi-person-badge"></i>
            </div>
            <h4>{{ __('Masuk Driver') }}</h4>
            <p>{{ __('Akses panel driver ExploreRide') }}</p>
        </div>
        <div class="login-body">
            <div id="loginError" class="alert alert-danger d-none"></div>

            <form method="POST" action="{{ route('driver.login') }}" id="driverLoginForm">@csrf
                <div class="mb-3">
                    <label class="form-label" for="driverEmail">{{ __('Email') }}</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="driverEmail" value="{{ old('email') }}" autocomplete="username" required placeholder="{{ __('Masukkan email') }}">
                    </div>
                    @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="mb-4">
                    <label class="form-label" for="driverPassword">{{ __('Password') }}</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="driverPassword" autocomplete="current-password" required placeholder="{{ __('Masukkan password') }}">
                    </div>
                    @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
                <button type="submit" class="btn btn-login w-100" id="loginBtn">{{ __('Masuk') }}</button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('home') }}" class="back-link"><i class="bi bi-arrow-left me-1"></i>{{ __('Kembali ke Beranda') }}</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
