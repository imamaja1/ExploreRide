@extends('layouts.app')
@section('title', $package->name)
@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb" style="font-size: 0.85rem;">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: var(--green-600); text-decoration: none;">{{ __('Beranda') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('packages') }}" style="color: var(--green-600); text-decoration: none;">{{ __('Paket Wisata') }}</a></li>
            <li class="breadcrumb-item active" style="color: var(--gray-500);">{{ $package->name }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-lg-7">
            @if($package->main_photo)
                <img src="{{ asset('storage/' . $package->main_photo) }}" class="w-100 rounded-3" style="height: 400px; object-fit: cover;" alt="{{ $package->name }}">
            @else
                <div class="rounded-3 d-flex align-items-center justify-content-center" style="height: 400px; background: var(--gray-100);">
                    <i class="bi bi-map text-muted" style="font-size: 5rem;"></i>
                </div>
            @endif

            <div class="mt-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <span class="badge" style="background: var(--green-100); color: var(--green-700); font-size: 0.78rem; padding: 5px 12px;">
                        <i class="bi bi-clock me-1"></i>{{ $package->duration_days }} {{ __('hari') }}
                    </span>
                </div>
                <h2 class="fw-bold mb-3" style="color: var(--gray-900);">{{ $package->name }}</h2>
                <h3 class="fw-bold mb-4" style="color: var(--green-600);">{{ __('Rp') }} {{ number_format($package->price, 0, ',', '.') }}</h3>

                @if($package->description)
                    <p style="color: var(--gray-600); line-height: 1.7;">{{ $package->description }}</p>
                @endif

                <div class="row g-3 mt-3">
                    @if($package->includes)
                    <div class="col-md-6">
                        <div class="card border-0 h-100" style="background: var(--green-50); border-radius: 12px;">
                            <div class="card-body p-3">
                                <h6 class="fw-bold mb-2" style="color: var(--green-700);"><i class="bi bi-check-circle me-1"></i>{{ __('Termasuk') }}</h6>
                                <p class="mb-0 small" style="color: var(--gray-600);">{{ $package->includes }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($package->excludes)
                    <div class="col-md-6">
                        <div class="card border-0 h-100" style="background: #fef2f2; border-radius: 12px;">
                            <div class="card-body p-3">
                                <h6 class="fw-bold mb-2" style="color: #dc2626;"><i class="bi bi-x-circle me-1"></i>{{ __('Tidak Termasuk') }}</h6>
                                <p class="mb-0 small" style="color: var(--gray-600);">{{ $package->excludes }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            @if($package->destinations->count() > 0)
            <div class="card border-0 shadow-sm mb-3" style="border-radius: 14px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3" style="color: var(--gray-900);"><i class="bi bi-geo-alt me-2" style="color: var(--green-600);"></i>{{ __('Rute Perjalanan') }}</h5>
                    @foreach($package->destinations as $dest)
                    <div class="d-flex {{ !$loop->last ? 'mb-3 pb-3' : '' }}" style="{{ !$loop->last ? 'border-bottom: 1px solid var(--gray-100);' : '' }}">
                        <div class="me-3">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--green-100); color: var(--green-600); display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 700;">{{ $loop->iteration }}</div>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1" style="color: var(--gray-900); font-size: 0.9rem;">{{ $dest->name }}</h6>
                            @if($dest->description)
                                <p class="small mb-1" style="color: var(--gray-500);">{{ $dest->description }}</p>
                            @endif
                            @if($dest->estimated_arrival && $dest->estimated_departure)
                                <small style="color: var(--gray-400);"><i class="bi bi-clock me-1"></i>{{ $dest->estimated_arrival }} - {{ $dest->estimated_departure }}</small>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="card border-0 shadow-sm" style="border-radius: 14px;">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3" style="color: var(--gray-900);">{{ __('Pesan Paket Ini') }}</h6>
                    <div class="mb-3 p-3 rounded-3" style="background: var(--green-50);">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small" style="color: var(--gray-600);">{{ __('Total Harga') }}</span>
                            <span class="fw-bold" style="color: var(--green-700); font-size: 1.1rem;">{{ __('Rp') }} {{ number_format($package->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @auth('customer')
                        <a href="{{ route('booking.create') }}?package_id={{ $package->id }}" class="btn btn-green w-100"><i class="bi bi-calendar-check me-2"></i>{{ __('Pesan Sekarang') }}</a>
                    @else
                        <a href="#" class="btn btn-green w-100" data-bs-toggle="modal" data-bs-target="#loginModal"><i class="bi bi-box-arrow-in-right me-2"></i>{{ __('Masuk untuk Pesan') }}</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
