@extends('layouts.app')
@section('title', __('Beranda'))
@section('content')

<section class="hero-section text-center">
    <div class="container">
        <h1 class="display-3 fw-bold">{{ __('Temukan & Rencanakan Perjalanan Wisata Anda dengan Mudah') }}</h1>
        <p class="lead mb-4">{{ __('Sewa mobil, driver, dan paket wisata dalam satu platform') }}</p>
        <a href="{{ route('packages') }}" class="btn btn-light btn-lg px-5 me-2">{{ __('Lihat Paket Wisata') }}</a>
        <a href="{{ route('cars') }}" class="btn btn-outline-light btn-lg px-5">{{ __('Lihat Sewa Mobil') }}</a>
    </div>
</section>

@if($packages->count() > 0)
<section class="py-5">
    <div class="container">
        <h2 class="fw-bold mb-4">{{ __('Paket Wisata') }}</h2>
        <div class="row g-4">
            @foreach($packages as $p)
            <div class="col-md-4 col-lg-3">
                <div class="card h-100">
                    @if($p->main_photo)
                        <img src="{{ asset('storage/' . $p->main_photo) }}" class="card-img-top card-img-fixed" alt="{{ $p->name }}">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center card-img-fixed">
                            <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h6 class="fw-bold mb-1">{{ $p->name }}</h6>
                        <p class="small text-muted mb-1">{{ $p->duration_days }} {{ __('hari') }}</p>
                        <p class="small text-muted mb-2">{{ Str::limit($p->description, 80) }}</p>
                        <div class="mt-auto">
                            <a href="{{ route('package.detail', $p->slug) }}" class="btn btn-outline-success w-100">{{ __('Lihat Detail') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('packages') }}" class="btn btn-success px-4">{{ __('Lihat Semua Paket') }}</a>
        </div>
    </div>
</section>
@endif

@php
    $categoryLabels = $activeCategories->pluck('name', 'slug')->toArray();
@endphp

@foreach($activeCategories as $cat)
    @if(isset($destinations[$cat->slug]) && $destinations[$cat->slug]->count() > 0)
    <section class="py-5 {{ $loop->even ? 'bg-light' : '' }}">
        <div class="container">
            <div class="mb-4">
                <h2 class="fw-bold mb-0">{{ $categoryLabels[$cat->slug] }}</h2>
            </div>
            <div class="row g-4">
                @foreach($destinations[$cat->slug]->take(4) as $dest)
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100">
                        @if($dest->main_photo)
                            <img src="{{ asset('storage/' . $dest->main_photo) }}" class="card-img-top" style="height: 180px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                                <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title fw-bold mb-1">{{ $dest->name }}</h6>
                            <p class="small text-muted mb-1"><i class="bi bi-geo-alt"></i> {{ $dest->location }}</p>
                            <p class="small text-warning mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= round($dest->rating) ? '-fill' : '' }}"></i>
                                @endfor
                                <span class="text-muted ms-1">{{ number_format($dest->rating, 1) }}</span>
                            </p>
                            <div class="mt-auto">
                                <a href="{{ route('destination.detail', $dest->slug) }}" class="btn btn-outline-success w-100">{{ __('Lihat Detail') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('destinations.category', $cat->slug) }}" class="btn btn-success px-4">{{ __('Lihat Semua') }}</a>
            </div>
        </div>
    </section>
    @endif
@endforeach

@if($testimonials->count() > 0)
<section class="py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">{{ __('Apa Kata Mereka?') }}</h2>
        <div class="row g-4">
            @foreach($testimonials as $t)
            <div class="col-md-4">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        @if($t->photo)
                            <img src="{{ asset('storage/' . $t->photo) }}" class="rounded-circle mb-3" width="64" height="64" style="object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                                <i class="bi bi-person text-success fs-3"></i>
                            </div>
                        @endif
                        <h6 class="fw-bold">{{ $t->name }}</h6>
                        <p class="text-warning mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= $t->rating ? '-fill' : '' }}"></i>
                            @endfor
                        </p>
                        <p class="text-muted mb-0">"{{ $t->message }}"</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            @auth('customer')
            <button class="btn btn-outline-success btn-lg px-5" data-bs-toggle="modal" data-bs-target="#testimonialModal">{{ __('Tulis Testimoni') }}</button>
            @endauth
        </div>
    </div>
</section>
@endif

<section class="py-5 bg-success text-white text-center">
    <div class="container">
        <h3 class="fw-bold">{{ __('Siap Berpetualang?') }}</h3>
        <p class="lead">{{ __('Pesan mobil atau paket wisata sekarang, nikmati liburan Anda!') }}</p>
        <a href="{{ route('customer.register') }}" class="btn btn-light btn-lg px-5" data-bs-toggle="modal" data-bs-target="#registerModal">{{ __('Daftar Sekarang') }}</a>
    </div>
</section>

@include('components.testimonial-modal')
@endsection
