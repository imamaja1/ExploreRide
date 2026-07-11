@extends('layouts.app')
@section('title', __('Beranda'))
@section('content')

<section class="hero-section text-center" style="position:relative;">
    <div class="container" style="position:relative;z-index:1;">
        <div data-aos="fade-up">
            <span class="hero-badge">{{ __('Selamat Datang di ExploreRide') }}</span>
            <h1 class="mb-3">{{ __('Temukan & Rencanakan Perjalanan Wisata Anda dengan Mudah') }}</h1>
            <p class="lead mx-auto">{{ __('Sewa mobil, driver, dan paket wisata dalam satu platform terpercaya') }}</p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="{{ route('packages') }}" class="btn btn-green-ghost btn-lg px-5">{{ __('Lihat Paket Wisata') }}</a>
                <a href="{{ route('cars') }}" class="btn btn-green-ghost btn-lg px-5">{{ __('Lihat Sewa Mobil') }}</a>
            </div>
        </div>
    </div>
</section>

@if($packages->count() > 0)
<section class="py-5" style="background: var(--gray-50);">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <h2>{{ __('Paket Wisata') }}</h2>
            <p>{{ __('Paket lengkap untuk liburan sempurna') }}</p>
            <div class="section-line"></div>
        </div>
        <div class="row g-4">
            @foreach($packages as $p)
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
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
                        <p class="card-text mb-1"><i class="bi bi-clock me-1"></i> {{ $p->duration_days }} {{ __('hari') }}</p>
                        <p class="card-text mb-2 fw-bold" style="color: var(--green-600);">Rp {{ number_format($p->price, 0, ',', '.') }}</p>
                        <p class="card-text mb-3">{{ Str::limit($p->description, 60) }}</p>
                        <div class="mt-auto">
                            <a href="{{ route('package.detail', $p->slug) }}" class="btn btn-green w-100">{{ __('Lihat Detail') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('packages') }}" class="btn btn-green-outline btn-lg">{{ __('Lihat Semua Paket') }}</a>
        </div>
    </div>
</section>
@endif

@foreach($activeCategories as $cat)
    @if(isset($destinations[$cat->slug]) && $destinations[$cat->slug]->count() > 0)
    <section class="py-5 {{ $loop->even ? '' : '' }}" style="{{ $loop->even ? 'background: var(--gray-50);' : '' }}">
        <div class="container">
            <div class="category-header" data-aos="fade-up">
                <div>
                    <h2>{{ $categoryLabels[$cat->slug] }}</h2>
                    <div class="category-line"></div>
                </div>
                <a href="{{ route('destinations.category', $cat->slug) }}" class="btn btn-green-outline">{{ __('Lihat Semua') }}</a>
            </div>
            <div class="row g-4">
                @foreach($destinations[$cat->slug]->take(4) as $dest)
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                    <div class="card h-100">
                        @if($dest->main_photo)
                            <img src="{{ asset('storage/' . $dest->main_photo) }}" class="card-img-top" style="height: 180px; object-fit: cover;" alt="{{ $dest->name }}">
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
                                    <i class="bi bi-star{{ $i <= round($dest->rating) ? '-fill' : '' }}" style="color: #f59e0b; font-size: 0.8rem;"></i>
                                @endfor
                                <span class="text-muted ms-1" style="font-size:0.78rem;">{{ number_format($dest->rating, 1) }}</span>
                            </p>
                            <div class="mt-auto">
                                <a href="{{ route('destination.detail', $dest->slug) }}" class="btn btn-green w-100">{{ __('Lihat Detail') }}</a>
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
<section class="py-5" style="background: var(--gray-50);">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <h2>{{ __('Apa Kata Mereka?') }}</h2>
            <p>{{ __('Testimoni dari pelanggan yang puas') }}</p>
            <div class="section-line"></div>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach($testimonials->take(6) as $t)
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                <div class="testimonial-card">
                    @if($t->photo)
                        <img src="{{ asset('storage/' . $t->photo) }}" class="rounded-circle mb-3" width="56" height="56" style="object-fit: cover;" alt="{{ $t->name }}">
                    @else
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px; background: var(--green-100); color: var(--green-600);">
                            <i class="bi bi-person fs-5"></i>
                        </div>
                    @endif
                    <h6 class="fw-bold mb-1" style="color: var(--gray-900);">{{ $t->name }}</h6>
                    <p class="mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star{{ $i <= $t->rating ? '-fill' : '' }}" style="color: #f59e0b; font-size: 0.8rem;"></i>
                        @endfor
                    </p>
                    <p class="mb-0" style="font-size: 0.85rem; color: var(--gray-500); line-height: 1.6;">"{{ $t->message }}"</p>
                </div>
            </div>
            @endforeach
        </div>
        @auth('customer')
        <div class="text-center mt-5" data-aos="fade-up">
            <button class="btn btn-green btn-lg" data-bs-toggle="modal" data-bs-target="#testimonialModal">{{ __('Tulis Testimoni') }}</button>
        </div>
        @endauth
    </div>
</section>
@endif

@guest
<section class="cta-section">
    <div class="container" data-aos="fade-up">
        <h3>{{ __('Siap Berpetualang?') }}</h3>
        <p class="lead mx-auto" style="max-width: 480px;">{{ __('Pesan mobil atau paket wisata sekarang, nikmati liburan Anda!') }}</p>
        <a href="{{ route('customer.register') }}" class="btn btn-light btn-lg" data-bs-toggle="modal" data-bs-target="#registerModal">{{ __('Daftar Sekarang') }}</a>
    </div>
</section>
@endguest

@include('components.testimonial-modal')
@endsection
