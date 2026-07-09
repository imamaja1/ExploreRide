@extends('layouts.app')
@section('title', __('Paket Wisata'))
@section('content')
<div class="container py-5">
    <div class="mb-4">
        <h4 class="fw-bold mb-1" style="color: var(--gray-900);">{{ __('Paket Wisata') }}</h4>
        <p class="mb-0" style="color: var(--gray-500);">{{ __('Nikmati liburan dengan paket lengkap mobil + sopir + rute wisata') }}</p>
    </div>

    <div class="row g-4">
        @forelse($packages as $package)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 14px; overflow: hidden;">
                @if($package->main_photo)
                    <img src="{{ asset('storage/' . $package->main_photo) }}" style="height: 200px; object-fit: cover;" alt="{{ $package->name }}">
                @else
                    <div class="d-flex align-items-center justify-content-center" style="height: 200px; background: var(--gray-100);">
                        <i class="bi bi-map text-muted" style="font-size: 3rem;"></i>
                    </div>
                @endif
                <div class="card-body d-flex flex-column p-3">
                    <h6 class="fw-bold mb-1" style="color: var(--gray-900);">{{ $package->name }}</h6>
                    <p class="fw-bold mb-2" style="color: var(--green-600);">{{ __('Rp') }} {{ number_format($package->price, 0, ',', '.') }}</p>
                    <span class="badge mb-2" style="background: var(--green-100); color: var(--green-700); font-size: 0.7rem; width: fit-content;">
                        <i class="bi bi-clock me-1"></i>{{ $package->duration_days }} {{ __('hari') }}
                    </span>
                    <p class="small mb-3" style="color: var(--gray-500);">{{ $package->description ? Str::limit($package->description, 120) : '' }}</p>
                    <div class="mt-auto">
                        <a href="{{ route('package.detail', $package->slug) }}" class="btn btn-green w-100 btn-sm">{{ __('Lihat Detail') }}</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-map text-muted" style="font-size: 4rem;"></i>
            <h5 class="mt-3" style="color: var(--gray-500);">{{ __('Belum ada paket wisata') }}</h5>
        </div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $packages->links() }}
    </div>
</div>
@endsection
