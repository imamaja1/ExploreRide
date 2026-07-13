@extends('layouts.app')
@section('title', __('Daftar'))
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h4 class="text-center fw-bold mb-4 text-success">{{ __('Daftar Akun') }}</h4>
                    <form method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ __('Nama Lengkap') }}</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Email') }}</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('No. WhatsApp') }}</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required>
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Password') }}</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Konfirmasi Password') }}</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">{{ __('Daftar') }}</button>
                    </form>

                    <div class="text-center my-3"><small class="text-muted">{{ __('atau') }}</small></div>

                    <a href="{{ route('customer.google.login') }}" class="btn btn-outline-dark w-100 mb-3">
                        <i class="bi bi-google"></i> {{ __('Daftar dengan Google') }}
                    </a>

                    <hr>
                    <p class="text-center mb-0">{{ __('Sudah punya akun?') }} <a href="{{ route('customer.login') }}" class="text-success">{{ __('Masuk') }}</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
