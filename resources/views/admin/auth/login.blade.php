<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Admin Login') }} - ExploreRide</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background: #198754; min-height: 100vh; display: flex; align-items: center; }
        .card { border: none; border-radius: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-lg">
                    <div class="card-body p-4">
                        <h4 class="text-center fw-bold text-success mb-4"><i class="bi bi-shield-lock"></i> {{ __('Admin Login') }}</h4>
                        <form method="POST" action="{{ route('admin.login') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">{{ __('Email') }}</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ __('Password') }}</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100">{{ __('Masuk') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
