@extends('layouts.app')
@section('title', $car->brand . ' ' . $car->name)
@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb" style="font-size: 0.85rem;">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: var(--green-600); text-decoration: none;">{{ __('Beranda') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cars') }}" style="color: var(--green-600); text-decoration: none;">{{ __('Mobil') }}</a></li>
            <li class="breadcrumb-item active" style="color: var(--gray-500);">{{ $car->brand }} {{ $car->name }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-lg-7">
            @if($car->main_photo)
                <img src="{{ asset('storage/' . $car->main_photo) }}" class="w-100 rounded-3" style="height: 400px; object-fit: cover;" alt="{{ $car->name }}">
            @else
                <div class="rounded-3 d-flex align-items-center justify-content-center" style="height: 400px; background: var(--gray-100);">
                    <i class="bi bi-car-front text-muted" style="font-size: 5rem;"></i>
                </div>
            @endif

            @if($car->description)
            <div class="mt-4">
                <h5 class="fw-bold mb-2" style="color: var(--gray-900);">{{ __('Deskripsi') }}</h5>
                <p style="color: var(--gray-600); line-height: 1.7;">{{ $car->description }}</p>
            </div>
            @endif
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm" style="border-radius: 14px;">
                <div class="card-body p-4">
                    <h2 class="fw-bold mb-1" style="color: var(--gray-900);">{{ $car->brand }} {{ $car->name }}</h2>
                    <p class="mb-3" style="color: var(--gray-500);">{{ $car->model }} ({{ $car->year }})</p>
                    <h3 class="fw-bold mb-4" style="color: var(--green-600);">
                        {{ __('Rp') }} {{ number_format($car->price_per_day, 0, ',', '.') }}
                        <small class="fw-normal" style="color: var(--gray-400); font-size: 0.85rem;">/{{ __('hari') }}</small>
                    </h3>

                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="p-3 rounded-3" style="background: var(--gray-50);">
                                <small class="d-block" style="color: var(--gray-400); font-size: 0.75rem;">{{ __('Plat Nomor') }}</small>
                                <strong style="color: var(--gray-800);">{{ $car->plate_number }}</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-3" style="background: var(--gray-50);">
                                <small class="d-block" style="color: var(--gray-400); font-size: 0.75rem;">{{ __('Transmisi') }}</small>
                                <strong style="color: var(--gray-800);">{{ __($car->transmission) }}</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-3" style="background: var(--gray-50);">
                                <small class="d-block" style="color: var(--gray-400); font-size: 0.75rem;">{{ __('Kursi') }}</small>
                                <strong style="color: var(--gray-800);">{{ $car->seats }} {{ __('kursi') }}</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-3" style="background: var(--gray-50);">
                                <small class="d-block" style="color: var(--gray-400); font-size: 0.75rem;">{{ __('Bahan Bakar') }}</small>
                                <strong style="color: var(--gray-800);">{{ __($car->fuel_type) }}</strong>
                            </div>
                        </div>
                        @if($car->color)
                        <div class="col-6">
                            <div class="p-3 rounded-3" style="background: var(--gray-50);">
                                <small class="d-block" style="color: var(--gray-400); font-size: 0.75rem;">{{ __('Warna') }}</small>
                                <strong style="color: var(--gray-800);">{{ $car->color }}</strong>
                            </div>
                        </div>
                        @endif
                    </div>

                    @auth('customer')
                        <a href="{{ route('booking.create') }}?car_id={{ $car->id }}" class="btn btn-green w-100 btn-lg"><i class="bi bi-calendar-check me-2"></i>{{ __('Pesan Sekarang') }}</a>
                    @else
                        <a href="#" class="btn btn-green w-100 btn-lg" data-bs-toggle="modal" data-bs-target="#loginModal"><i class="bi bi-box-arrow-in-right me-2"></i>{{ __('Masuk untuk Pesan') }}</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
