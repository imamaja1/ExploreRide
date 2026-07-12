@extends('layouts.admin')
@section('title', __('WhatsApp API'))
@section('content')
<div class="page-header mb-4">
    <h4><i class="bi bi-whatsapp me-2" style="color: #25d366;"></i>{{ __('WhatsApp API') }}</h4>
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

@php
    $statusData = $status['data'] ?? $status ?? [];
    $statusText = $statusData['status'] ?? $statusData['state'] ?? '';
    $isConnected = $status['success'] && in_array(strtolower($statusText), ['connected', 'ready', 'open', 'true', '1', 'authenticated']);
@endphp

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-gear me-2"></i>{{ __('Pengaturan API') }}</span>
                <span class="badge {{ $isConnected ? 'bg-success' : 'bg-secondary' }}">
                    <i class="bi {{ $isConnected ? 'bi-check-circle' : 'bi-x-circle' }} me-1"></i>
                    {{ $isConnected ? __('Terhubung') : __('Terputus') }}
                </span>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.whatsapp.update') }}">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">{{ __('Automation URL') }}</label>
                        <input type="url" name="automation_url" class="form-control"
                            value="{{ old('automation_url', $settings['automation_url'] ?? 'https://otomasi.punyaku.online') }}"
                            placeholder="https://otomasi.punyaku.online" required>
                        <small class="text-muted">{{ __('Base URL dari web service WhatsApp') }}</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('API Key') }}</label>
                        @php $apiKey = $settings['automation_api_key'] ?? null; @endphp
                        <input type="text" class="form-control" disabled
                            value="{{ $apiKey ? str_repeat('*', 20) . substr($apiKey, -8) : '-' }}">
                        <small class="text-muted">{{ __('API Key akan otomatis tersimpan setelah Generate') }}</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('Application ID') }}</label>
                        <input type="text" class="form-control" disabled
                            value="{{ $settings['automation_app_id'] ?? '-' }}">
                    </div>

                    <hr class="my-3">

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="whatsapp_enabled" id="whatsappEnabled"
                                value="1" {{ ($settings['whatsapp_enabled'] ?? '0') === '1' ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="whatsappEnabled">
                                {{ __('Aktifkan Notifikasi WhatsApp') }}
                            </label>
                        </div>
                        <small class="text-muted">{{ __('Aktifkan setelah queue worker jalan: php artisan queue:work') }}</small>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-check-lg me-1"></i>{{ __('Simpan Pengaturan') }}
                    </button>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <i class="bi bi-send me-2"></i>{{ __('Test Kirim Pesan') }}
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.whatsapp.test-send') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">{{ __('Nomor WhatsApp') }}</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-whatsapp"></i></span>
                            <input type="text" name="phone" class="form-control" placeholder="6281234567890" required
                                value="{{ old('phone') }}">
                        </div>
                        <small class="text-muted">{{ __('Format: 628xxx (tanpa +). Pesan test akan dikirim ke nomor ini.') }}</small>
                    </div>
                    <button type="submit" class="btn btn-success w-100" style="background-color: #25d366; border-color: #25d366;">
                        <i class="bi bi-send me-1"></i>{{ __('Kirim Pesan Test') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-lightning me-2"></i>{{ __('Aksi') }}
            </div>
            <div class="card-body d-grid gap-2">
                <form method="POST" action="{{ route('admin.whatsapp.register') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary w-100 mb-2" title="{{ __('Daftarkan aplikasi ke server') }}">
                        <i class="bi bi-registry me-1"></i>{{ __('Daftarkan Aplikasi') }}
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.whatsapp.generate-key') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary w-100 mb-2" title="{{ __('Generate API Key baru') }}">
                        <i class="bi bi-key me-1"></i>{{ __('Generate API Key') }}
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.whatsapp.check-status') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary w-100 mb-2" title="{{ __('Cek status koneksi WA') }}">
                        <i class="bi bi-activity me-1"></i>{{ __('Cek Status') }}
                    </button>
                </form>

                <button type="button" class="btn btn-outline-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#qrModal" onclick="loadQR()">
                    <i class="bi bi-qr-code me-1"></i>{{ __('Tampilkan QR Code') }}
                </button>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <i class="bi bi-info-circle me-2"></i>{{ __('Informasi') }}
            </div>
            <div class="card-body">
                <ol class="mb-0 ps-3" style="font-size: 0.85rem;">
                    <li class="mb-2">{{ __('Isi Automation URL') }}</li>
                    <li class="mb-2">{{ __('Klik "Daftarkan Aplikasi"') }}</li>
                    <li class="mb-2">{{ __('Klik "Generate API Key"') }}</li>
                    <li class="mb-2">{{ __('Klik "Cek Status" untuk memastikan koneksi') }}</li>
                    <li class="mb-2">{{ __('Jika terputus, klik "Tampilkan QR Code" lalu scan') }}</li>
                    <li class="mb-0">{{ __('Pastikan nomor WA admin terisi di profil') }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="qrModalLabel"><i class="bi bi-qr-code me-2"></i>{{ __('Scan QR Code WhatsApp') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div id="qrLoading" class="py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">{{ __('Memuat QR Code...') }}</p>
                </div>
                <div id="qrContent" style="display: none;">
                    <img id="qrImage" src="" alt="QR Code"
                         style="max-width: 300px; width: 100%; border: 1px solid #e5e7eb; border-radius: 8px;">
                    <p class="mt-3 mb-0"><small class="text-muted">{{ __('Scan QR Code ini dengan WhatsApp Anda') }}</small></p>
                </div>
                <div id="qrError" style="display: none;">
                    <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                    <p class="mt-2 text-muted">{{ __('Gagal memuat QR Code') }}</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="loadQR()">
                    <i class="bi bi-arrow-clockwise me-1"></i>{{ __('Refresh') }}
                </button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">{{ __('Tutup') }}</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function loadQR() {
    var loading = document.getElementById('qrLoading');
    var content = document.getElementById('qrContent');
    var error = document.getElementById('qrError');
    var img = document.getElementById('qrImage');

    loading.style.display = 'block';
    content.style.display = 'none';
    error.style.display = 'none';

    img.onload = function() {
        loading.style.display = 'none';
        content.style.display = 'block';
    };
    img.onerror = function() {
        loading.style.display = 'none';
        error.style.display = 'block';
    };
    img.src = '{{ route("admin.whatsapp.qr-image") }}?t=' + Date.now();
}
</script>
@endpush
@endsection
