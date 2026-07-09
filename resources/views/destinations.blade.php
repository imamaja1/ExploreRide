@extends('layouts.app')
@section('title', __($category))
@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb" style="font-size: 0.85rem;">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: var(--green-600); text-decoration: none;">{{ __('Beranda') }}</a></li>
            <li class="breadcrumb-item active" style="color: var(--gray-500);">{{ __($category) }}</li>
        </ol>
    </nav>

    <div class="mb-4">
        <h4 class="fw-bold mb-1" style="color: var(--gray-900);">{{ __($category) }}</h4>
        <p class="mb-0" style="color: var(--gray-500);">{{ __('Jelajahi destinasi') }} {{ __($category) }} {{ __('terbaik') }}.</p>
    </div>

    <div class="row g-4">
        @forelse($destinations as $dest)
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 14px; overflow: hidden;">
                @if($dest->main_photo)
                    <img src="{{ asset('storage/' . $dest->main_photo) }}" style="height: 180px; object-fit: cover;" alt="{{ $dest->name }}">
                @else
                    <div class="d-flex align-items-center justify-content-center" style="height: 180px; background: var(--gray-100);">
                        <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                    </div>
                @endif
                <div class="card-body d-flex flex-column p-3">
                    <h6 class="fw-bold mb-1" style="color: var(--gray-900);">{{ $dest->name }}</h6>
                    <p class="small mb-2" style="color: var(--gray-500);"><i class="bi bi-geo-alt me-1"></i>{{ $dest->location }}</p>
                    <p class="mb-3">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star{{ $i <= round($dest->rating) ? '-fill' : '' }}" style="color: #f59e0b; font-size: 0.8rem;"></i>
                        @endfor
                        <span class="ms-1" style="color: var(--gray-500); font-size: 0.78rem;">{{ number_format($dest->rating, 1) }}</span>
                    </p>
                    <div class="mt-auto">
                        <a href="{{ route('destination.detail', $dest->slug) }}" class="btn btn-green-outline w-100 btn-sm">{{ __('Lihat Detail') }}</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-map text-muted" style="font-size: 4rem;"></i>
            <h5 class="mt-3" style="color: var(--gray-500);">{{ __('Belum ada destinasi') }}</h5>
        </div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $destinations->links() }}
    </div>
</div>
@endsection
