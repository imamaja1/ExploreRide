@extends('layouts.app')
@section('title', __('Beranda'))
@section('content')

<section class="hero-section text-center" style="position:relative;">
    <div class="container" style="position:relative;z-index:1;">
        <div data-aos="fade-up">
            <p class="mb-3" style="font-size:0.85rem;opacity:0.8;text-transform:uppercase;letter-spacing:2px;">{{ __('Selamat Datang di ExploreRide') }}</p>
            <h1 class="mb-3">{{ __('Temukan & Rencanakan Perjalanan Wisata Anda dengan Mudah') }}</h1>
            <p class="lead mx-auto">{{ __('Sewa mobil, driver, dan paket wisata dalam satu platform terpercaya') }}</p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="{{ route('packages') }}" class="btn btn-outline-er btn-lg px-5">{{ __('Lihat Paket Wisata') }}</a>
                <a href="{{ route('cars') }}" class="btn btn-outline-er btn-lg px-5">{{ __('Lihat Sewa Mobil') }}</a>
            </div>
        </div>
    </div>
</section>

@if($packages->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="text-center mb-4" data-aos="fade-up">
            <h2 class="section-title">{{ __('Paket Wisata') }}</h2>
            <p class="section-subtitle">{{ __('Paket lengkap untuk liburan sempurna') }}</p>
        </div>
        <div class="row g-4">
            @foreach($packages as $p)
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="card h-100">
                    @if($p->main_photo)
                        <img src="{{ asset('storage/' . $p->main_photo) }}" class="card-img-top card-img-fixed" alt="{{ $p->name }}">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center card-img-fixed">
                            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">{{ $p->name }}</h6>
                        <p class="card-text mb-2"><i class="bi bi-clock me-1"></i> {{ $p->duration_days }} {{ __('hari') }}</p>
                        <p class="card-text mb-2">{{ Str::limit($p->description, 60) }}</p>
                        <div class="mt-auto">
                            <a href="{{ route('package.detail', $p->slug) }}" class="btn btn-success-er w-100">{{ __('Lihat Detail') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('packages') }}" class="btn btn-success-er btn-lg">{{ __('Lihat Semua Paket') }}</a>
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
            <div class="d-flex align-items-center justify-content-between mb-4" data-aos="fade-up">
                <div>
                    <h2 class="fw-bold mb-1" style="font-size:2rem;color:#1f2937;font-family:'Poppins',sans-serif;letter-spacing:-0.5px;">{{ $categoryLabels[$cat->slug] }}</h2>
                    <div style="width:50px;height:3px;background:var(--er-primary);border-radius:4px;"></div>
                </div>
                <a href="{{ route('destinations.category', $cat->slug) }}" class="btn btn-outline-success-er">{{ __('Lihat Semua') }}</a>
            </div>
            <div class="row g-4">
                @foreach($destinations[$cat->slug]->take(4) as $dest)
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="card h-100">
                        @if($dest->main_photo)
                            <img src="{{ asset('storage/' . $dest->main_photo) }}" class="card-img-top" style="height: 180px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                                <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title">{{ $dest->name }}</h6>
                            <p class="card-text mb-1"><i class="bi bi-geo-alt me-1"></i>{{ $dest->location }}</p>
                            <p class="mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= round($dest->rating) ? '-fill' : '' }}" style="color: #f59e0b; font-size: 0.85rem;"></i>
                                @endfor
                                <span class="text-muted ms-1" style="font-size:0.8rem;">{{ number_format($dest->rating, 1) }}</span>
                            </p>
                            <div class="mt-auto">
                                <a href="{{ route('destination.detail', $dest->slug) }}" class="btn btn-success-er w-100">{{ __('Lihat Detail') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
@endforeach

@if($testimonials->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">{{ __('Apa Kata Mereka?') }}</h2>
            <p class="section-subtitle">{{ __('Testimoni dari pelanggan yang puas') }}</p>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach($testimonials->take(6) as $t)
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        @if($t->photo)
                            <img src="{{ asset('storage/' . $t->photo) }}" class="rounded-circle mb-3" width="64" height="64" style="object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                                <i class="bi bi-person text-success fs-4"></i>
                            </div>
                        @endif
                        <h6 class="fw-bold mb-1">{{ $t->name }}</h6>
                        <p class="mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= $t->rating ? '-fill' : '' }}" style="color: #f59e0b;"></i>
                            @endfor
                        </p>
                        <p class="text-muted mb-0 small" style="line-height:1.6;">"{{ $t->message }}"</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-5" data-aos="fade-up">
            @auth('customer')
            <button class="btn btn-success-er btn-lg" data-bs-toggle="modal" data-bs-target="#testimonialModal">{{ __('Tulis Testimoni') }}</button>
            @endauth
        </div>
    </div>
</section>
@endif

@guest
<section class="py-5 bg-success text-white text-center">
    <div class="container" data-aos="fade-up">
        <h3 class="fw-bold mb-2">{{ __('Siap Berpetualang?') }}</h3>
        <p class="lead mb-4 opacity-90">{{ __('Pesan mobil atau paket wisata sekarang, nikmati liburan Anda!') }}</p>
        <a href="{{ route('customer.register') }}" class="btn btn-light btn-lg" style="font-weight:600;color:var(--er-primary);" data-bs-toggle="modal" data-bs-target="#registerModal">{{ __('Daftar Sekarang') }}</a>
    </div>
</section>
@endguest

@include('components.testimonial-modal')
@endsection
