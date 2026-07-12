@extends('layouts.admin')
@section('title', __('Notifikasi Email'))
@section('content')
<div class="page-header mb-4">
    <h4><i class="bi bi-envelope me-2" style="color: #0d6efd;"></i>{{ __('Notifikasi Email') }}</h4>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-gear me-2"></i>{{ __('Pengaturan SMTP') }}</span>
                <span class="badge {{ ($settings['email_enabled'] ?? '0') === '1' ? 'bg-success' : 'bg-secondary' }}">
                    <i class="bi {{ ($settings['email_enabled'] ?? '0') === '1' ? 'bi-check-circle' : 'bi-x-circle' }} me-1"></i>
                    {{ ($settings['email_enabled'] ?? '0') === '1' ? __('Aktif') : __('Nonaktif') }}
                </span>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.email.update') }}">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="email_enabled" id="emailEnabled"
                                value="1" {{ ($settings['email_enabled'] ?? '0') === '1' ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="emailEnabled">
                                {{ __('Aktifkan Notifikasi Email') }}
                            </label>
                        </div>
                        <small class="text-muted">{{ __('Kirim notifikasi email ke customer dan driver') }}</small>
                    </div>

                    <hr class="my-3">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('Mailer') }}</label>
                            <select name="mail_mailer" class="form-select">
                                <option value="smtp" {{ ($settings['mail_mailer'] ?? 'smtp') === 'smtp' ? 'selected' : '' }}>SMTP</option>
                                <option value="sendmail" {{ ($settings['mail_mailer'] ?? '') === 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('Encryption') }}</label>
                            <select name="mail_encryption" class="form-select">
                                <option value="tls" {{ ($settings['mail_encryption'] ?? 'tls') === 'tls' ? 'selected' : '' }}>TLS</option>
                                <option value="ssl" {{ ($settings['mail_encryption'] ?? '') === 'ssl' ? 'selected' : '' }}>SSL</option>
                                <option value="none" {{ ($settings['mail_encryption'] ?? '') === 'none' ? 'selected' : '' }}>None</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('SMTP Host') }}</label>
                        <input type="text" name="mail_host" class="form-control"
                            value="{{ old('mail_host', $settings['mail_host'] ?? '') }}"
                            placeholder="smtp.gmail.com">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('SMTP Port') }}</label>
                            <input type="text" name="mail_port" class="form-control"
                                value="{{ old('mail_port', $settings['mail_port'] ?? '587') }}"
                                placeholder="587">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('SMTP Username') }}</label>
                            <input type="text" name="mail_username" class="form-control"
                                value="{{ old('mail_username', $settings['mail_username'] ?? '') }}"
                                placeholder="your-email@gmail.com">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('SMTP Password') }}</label>
                        <input type="password" name="mail_password" class="form-control"
                            value="{{ old('mail_password', $settings['mail_password'] ?? '') }}"
                            placeholder="{{ $settings['mail_password'] ?? '' ? '••••••••' : '' }}">
                        <small class="text-muted">{{ __('Gunakan App Password untuk Gmail') }}</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('From Address') }}</label>
                            <input type="email" name="mail_from_address" class="form-control"
                                value="{{ old('mail_from_address', $settings['mail_from_address'] ?? 'noreply@exploreride.com') }}"
                                required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('From Name') }}</label>
                            <input type="text" name="mail_from_name" class="form-control"
                                value="{{ old('mail_from_name', $settings['mail_from_name'] ?? 'ExploreRide') }}"
                                required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-check-lg me-1"></i>{{ __('Simpan Pengaturan') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-send me-2"></i>{{ __('Test Kirim Email') }}
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.email.test-send') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">{{ __('Email Tujuan') }}</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="test_email" class="form-control"
                                placeholder="contoh@email.com" required
                                value="{{ old('test_email') }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-send me-1"></i>{{ __('Kirim Email Test') }}
                    </button>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <i class="bi bi-info-circle me-2"></i>{{ __('Informasi') }}
            </div>
            <div class="card-body">
                <ol class="mb-0 ps-3" style="font-size: 0.85rem;">
                    <li class="mb-2">{{ __('Isi SMTP Host, Port, Username, Password') }}</li>
                    <li class="mb-2">{{ __('Untuk Gmail, gunakan App Password (bukan password biasa)') }}</li>
                    <li class="mb-2">{{ __('Aktifkan toggle "Notifikasi Email"') }}</li>
                    <li class="mb-2">{{ __('Klik "Kirim Email Test" untuk verifikasi') }}</li>
                    <li class="mb-0">{{ __('Email akan dikirim saat: booking dibuat, pembayaran dikonfirmasi, driver ditugaskan, trip dimulai/selesai') }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection
