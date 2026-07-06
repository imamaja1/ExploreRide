@extends('layouts.app')
@section('title', __('Paket Wisata'))
@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-2">{{ __('Paket Wisata') }}</h2>
    <p class="text-muted mb-4">{{ __('Nikmati liburan dengan paket lengkap mobil + sopir + rute wisata') }}</p>

    <div class="row g-4">
        @forelse($packages as $package)
        <div class="col-md-4">
            <div class="card h-100">
                @if($package->main_photo)
                    <img src="{{ asset('storage/' . $package->main_photo) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="bi bi-map text-muted" style="font-size: 4rem;"></i>
                    </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $package->name }}</h5>
                    <p class="text-success fw-bold fs-5">{{ __('Rp') }} {{ number_format($package->price, 0, ',', '.') }}</p>
                    <div class="mb-2">
                        <span class="badge bg-info"><i class="bi bi-clock"></i> {{ $package->duration_days }} {{ __('hari') }}</span>
                    </div>
                    <p class="small text-muted">{{ $package->description ? Str::limit($package->description, 150) : '' }}</p>
                </div>
                <div class="card-footer bg-white border-0 pb-3">
                    <a href="{{ route('package.detail', $package->slug) }}" class="btn btn-success w-100">{{ __('Lihat Detail') }}</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-map text-muted" style="font-size: 4rem;"></i>
            <h4 class="mt-3">{{ __('Belum ada paket wisata') }}</h4>
        </div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $packages->links() }}
    </div>
</div>
@endsection
