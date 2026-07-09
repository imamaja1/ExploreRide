@extends('layouts.app')
@section('title', __('Pilih Mobil'))
@section('content')
<div class="container py-5">
    <div class="mb-4">
        <h4 class="fw-bold mb-1" style="color: var(--gray-900);">{{ __('Pilih Mobil') }}</h4>
        <p class="mb-0" style="color: var(--gray-500);">{{ __('Tersedia berbagai pilihan mobil untuk perjalanan Anda') }}</p>
    </div>

    <div class="row g-4">
        @forelse($cars as $car)
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 14px; overflow: hidden;">
                @if($car->main_photo)
                    <img src="{{ asset('storage/' . $car->main_photo) }}" style="height: 180px; object-fit: cover;" alt="{{ $car->name }}">
                @else
                    <div class="d-flex align-items-center justify-content-center" style="height: 180px; background: var(--gray-100);">
                        <i class="bi bi-car-front text-muted" style="font-size: 3rem;"></i>
                    </div>
                @endif
                <div class="card-body d-flex flex-column p-3">
                    <h6 class="fw-bold mb-1" style="color: var(--gray-900);">{{ $car->brand }} {{ $car->name }}</h6>
                    <p class="fw-bold mb-2" style="color: var(--green-600);">{{ __('Rp') }} {{ number_format($car->price_per_day, 0, ',', '.') }}<small style="color: var(--gray-400); font-weight: 400;">/{{ __('hari') }}</small></p>
                    <div class="mb-2">
                        <span class="badge" style="background: var(--green-100); color: var(--green-700); font-size: 0.7rem;">{{ __($car->transmission) }}</span>
                        <span class="badge" style="background: var(--gray-100); color: var(--gray-600); font-size: 0.7rem;">{{ $car->seats }} {{ __('kursi') }}</span>
                    </div>
                    <p class="small mb-3" style="color: var(--gray-500);">{{ $car->description ? Str::limit($car->description, 80) : '' }}</p>
                    <div class="mt-auto">
                        <a href="{{ route('car.detail', $car->id) }}" class="btn btn-green w-100 btn-sm">{{ __('Detail & Pesan') }}</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-car-front text-muted" style="font-size: 4rem;"></i>
            <h5 class="mt-3" style="color: var(--gray-500);">{{ __('Belum ada mobil tersedia') }}</h5>
        </div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $cars->links() }}
    </div>
</div>
@endsection
