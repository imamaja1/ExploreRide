@extends('layouts.app')
@section('title', $destination->name)
@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success">{{ __('Beranda') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('destinations.category', $destination->category) }}" class="text-success">{{ __($destination->category) }}</a></li>
            <li class="breadcrumb-item active">{{ $destination->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-7">
            @if($destination->main_photo)
                <img src="{{ asset('storage/' . $destination->main_photo) }}" class="img-fluid rounded shadow-sm w-100" style="height: 400px; object-fit: cover;">
            @else
                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 400px;">
                    <i class="bi bi-image text-muted" style="font-size: 6rem;"></i>
                </div>
            @endif
        </div>
        <div class="col-md-5">
            <h1 class="fw-bold mb-2">{{ $destination->name }}</h1>
            <p class="text-muted mb-2"><i class="bi bi-geo-alt"></i> {{ $destination->location }}</p>
            <p class="mb-2">
                @for($i = 1; $i <= 5; $i++)
                    <i class="bi bi-star{{ $i <= round($destination->rating) ? '-fill' : '' }} text-warning"></i>
                @endfor
                <span class="text-muted ms-1">{{ number_format($destination->rating, 1) }}</span>
            </p>
            <span class="badge bg-success mb-3 fs-6">{{ __($destination->category) }}</span>
            @if($destination->description)
                <p class="mt-3">{{ $destination->description }}</p>
            @endif

            <hr>
            <div class="mt-4">
                <h5>{{ __('Tertarik untuk berkunjung?') }}</h5>
                <p class="text-muted small">{{ __('Pesan mobil atau paket wisata sekarang untuk perjalanan Anda ke') }} {{ $destination->name }}.</p>
                @auth('customer')
                    <a href="{{ route('booking.create') }}" class="btn btn-success btn-lg px-5">{{ __('Pesan Sekarang') }}</a>
                @else
                    <a href="{{ route('customer.register') }}" class="btn btn-success btn-lg px-5" data-bs-toggle="modal" data-bs-target="#registerModal">{{ __('Daftar & Pesan') }}</a>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
