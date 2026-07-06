@extends('layouts.app')
@section('title', __($category))
@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success">{{ __('Beranda') }}</a></li>
            <li class="breadcrumb-item active">{{ __($category) }}</li>
        </ol>
    </nav>

    <h2 class="fw-bold mb-2">{{ __($category) }}</h2>
    <p class="text-muted mb-4">{{ __('Jelajahi destinasi') }} {{ __($category) }} {{ __('terbaik') }}.</p>

    <div class="row g-4">
        @forelse($destinations as $dest)
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
                    <h5 class="card-title fw-bold">{{ $dest->name }}</h5>
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
        @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-map text-muted" style="font-size: 4rem;"></i>
            <h4 class="mt-3">{{ __('Belum ada destinasi') }}</h4>
        </div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $destinations->links() }}
    </div>
</div>
@endsection
