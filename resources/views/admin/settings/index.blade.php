@extends('layouts.admin')
@section('title', __('Pengaturan Kontak'))
@section('content')
<div class="page-header mb-4">
    <h4>{{ __('Pengaturan Kontak') }}</h4>
</div>
<div class="card"><div class="card-body">
<form method="POST" action="{{ route('admin.settings.update') }}">
    @csrf @method('PUT')
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">{{ __('No. Telepon') }}</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $settings['phone'] ?? '') }}" placeholder="0812-3456-7890">
        </div>
        <div class="col-md-6">
            <label class="form-label">{{ __('No. WhatsApp') }}</label>
            <input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp', $settings['whatsapp'] ?? '') }}" placeholder="6281234567890">
            <small class="text-muted">{{ __('Format: 628xxx (tanpa +)') }}</small>
        </div>
        <div class="col-md-6">
            <label class="form-label">{{ __('Email') }}</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $settings['email'] ?? '') }}" placeholder="info@exploreride.com">
        </div>
        <div class="col-md-6">
            <label class="form-label">{{ __('Alamat') }}</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', $settings['address'] ?? '') }}" placeholder="Jl. Raya Wisata No. 123">
        </div>
    </div>

    <hr class="my-4">
    <h6 class="fw-bold mb-3">{{ __('Media Sosial') }}</h6>

    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label"><i class="bi bi-instagram me-1"></i> {{ __('Instagram URL') }}</label>
            <input type="url" name="instagram" class="form-control" value="{{ old('instagram', $settings['instagram'] ?? '') }}" placeholder="https://instagram.com/...">
        </div>
        <div class="col-md-4">
            <label class="form-label"><i class="bi bi-facebook me-1"></i> {{ __('Facebook URL') }}</label>
            <input type="url" name="facebook" class="form-control" value="{{ old('facebook', $settings['facebook'] ?? '') }}" placeholder="https://facebook.com/...">
        </div>
        <div class="col-md-4">
            <label class="form-label"><i class="bi bi-twitter-x me-1"></i> {{ __('Twitter/X URL') }}</label>
            <input type="url" name="twitter" class="form-control" value="{{ old('twitter', $settings['twitter'] ?? '') }}" placeholder="https://x.com/...">
        </div>
    </div>

    <hr class="my-4">
    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i> {{ __('Simpan Pengaturan') }}</button>
</form>
</div></div>
@endsection
