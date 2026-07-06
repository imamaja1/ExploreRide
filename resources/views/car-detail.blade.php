@extends('layouts.app')
@section('title', $car->name)
@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-6">
            @if($car->main_photo)
                <img src="{{ asset('storage/' . $car->main_photo) }}" class="img-fluid rounded">
            @else
                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 400px;">
                    <i class="bi bi-car-front text-muted" style="font-size: 6rem;"></i>
                </div>
            @endif
        </div>
        <div class="col-md-6">
            <h2 class="fw-bold">{{ $car->brand }} {{ $car->name }}</h2>
            <p class="text-muted">{{ $car->model }} ({{ $car->year }})</p>
            <h3 class="text-success fw-bold">{{ __('Rp') }} {{ number_format($car->price_per_day, 0, ',', '.') }} <small class="text-muted fs-6">/{{ __('hari') }}</small></h3>
            <hr>
            <div class="row mb-3">
                <div class="col-6 mb-2"><strong>{{ __('Plat Nomor:') }}</strong> {{ $car->plate_number }}</div>
                <div class="col-6 mb-2"><strong>{{ __('Warna:') }}</strong> {{ $car->color ?? '-' }}</div>
                <div class="col-6 mb-2"><strong>{{ __('Transmisi:') }}</strong> {{ __($car->transmission) }}</div>
                <div class="col-6 mb-2"><strong>{{ __('Kursi:') }}</strong> {{ $car->seats }}</div>
                <div class="col-6 mb-2"><strong>{{ __('Bahan Bakar:') }}</strong> {{ __($car->fuel_type) }}</div>
            </div>
            @if($car->description)
                <p>{{ $car->description }}</p>
            @endif

            @auth('customer')
                <div class="mt-4">
                    <a href="{{ route('booking.create') }}?car_id={{ $car->id }}" class="btn btn-success btn-lg px-5">{{ __('Pesan Sekarang') }}</a>
                </div>
            @else
                <div class="mt-4">
                    <a href="#" class="btn btn-success btn-lg px-5" data-bs-toggle="modal" data-bs-target="#loginModal">{{ __('Masuk untuk Pesan') }}</a>
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection
