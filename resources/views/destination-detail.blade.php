@extends('layouts.app')
@section('title', $destination->name)
@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb" style="font-size: 0.85rem;">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: var(--green-600); text-decoration: none;">{{ __('Beranda') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('destinations.category', $destination->category) }}" style="color: var(--green-600); text-decoration: none;">{{ __($destination->category) }}</a></li>
            <li class="breadcrumb-item active" style="color: var(--gray-500);">{{ $destination->name }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-lg-7">
            @if($destination->main_photo)
                <img src="{{ asset('storage/' . $destination->main_photo) }}" class="w-100 rounded-3" style="height: 420px; object-fit: cover;" alt="{{ $destination->name }}">
            @else
                <div class="rounded-3 d-flex align-items-center justify-content-center" style="height: 420px; background: var(--gray-100);">
                    <i class="bi bi-image text-muted" style="font-size: 5rem;"></i>
                </div>
            @endif
        </div>
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 14px;">
                <div class="card-body p-4">
                    <span class="badge mb-3" style="background: var(--green-100); color: var(--green-700); font-size: 0.78rem; padding: 5px 12px;">{{ __($destination->category) }}</span>
                    <h2 class="fw-bold mb-2" style="color: var(--gray-900);">{{ $destination->name }}</h2>
                    <p class="mb-3" style="color: var(--gray-500);"><i class="bi bi-geo-alt me-1"></i>{{ $destination->location }}</p>
                    <div class="mb-3">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star{{ $i <= round($destination->rating) ? '-fill' : '' }}" style="color: #f59e0b; font-size: 1rem;"></i>
                        @endfor
                        <span class="ms-2 fw-semibold" style="color: var(--gray-700);">{{ number_format($destination->rating, 1) }}</span>
                    </div>

                    @if($destination->description)
                        <p style="color: var(--gray-600); line-height: 1.7; font-size: 0.9rem;">{{ $destination->description }}</p>
                    @endif

                    <hr style="border-color: var(--gray-200);">

                    <div class="mt-3">
                        <h6 class="fw-bold mb-2" style="color: var(--gray-900);">{{ __('Tertarik untuk berkunjung?') }}</h6>
                        <p class="small mb-3" style="color: var(--gray-500);">{{ __('Pesan mobil atau paket wisata untuk perjalanan Anda ke') }} {{ $destination->name }}.</p>
                        @auth('customer')
                            <a href="{{ route('booking.create') }}" class="btn btn-green w-100"><i class="bi bi-calendar-check me-2"></i>{{ __('Pesan Sekarang') }}</a>
                        @else
                            <a href="#" class="btn btn-green w-100" data-bs-toggle="modal" data-bs-target="#registerModal"><i class="bi bi-person-plus me-2"></i>{{ __('Daftar & Pesan') }}</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
