@extends('layouts.app')
@section('title', __('Pilih Mobil'))
@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-2">{{ __('Pilih Mobil') }}</h2>
    <p class="text-muted mb-4">{{ __('Tersedia berbagai pilihan mobil untuk perjalanan Anda') }}</p>

    <div class="row g-4">
        @forelse($cars as $car)
        <div class="col-md-4 col-lg-3">
            <div class="card h-100">
                @if($car->main_photo)
                    <img src="{{ asset('storage/' . $car->main_photo) }}" class="card-img-top" style="height: 180px; object-fit: cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                        <i class="bi bi-car-front text-muted" style="font-size: 4rem;"></i>
                    </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $car->brand }} {{ $car->name }}</h5>
                    <p class="text-success fw-bold fs-5">{{ __('Rp') }} {{ number_format($car->price_per_day, 0, ',', '.') }}/{{ __('hari') }}</p>
                    <div class="mb-2">
                        <span class="badge bg-success">{{ __($car->transmission) }}</span>
                        <span class="badge bg-secondary">{{ $car->seats }} {{ __('kursi') }}</span>
                        <span class="badge bg-info">{{ __($car->fuel_type) }}</span>
                    </div>
                    <p class="small text-muted">{{ $car->description ? Str::limit($car->description, 100) : '' }}</p>
                </div>
                <div class="card-footer bg-white border-0 pb-3">
                    <a href="{{ route('car.detail', $car->id) }}" class="btn btn-success w-100">{{ __('Detail & Pesan') }}</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-car-front text-muted" style="font-size: 4rem;"></i>
            <h4 class="mt-3">{{ __('Belum ada mobil tersedia') }}</h4>
        </div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $cars->links() }}
    </div>
</div>
@endsection
