@extends('layouts.app')
@section('title', $package->name)
@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-7">
            @if($package->main_photo)
                <img src="{{ asset('storage/' . $package->main_photo) }}" class="img-fluid rounded mb-3">
            @endif
            <h2 class="fw-bold">{{ $package->name }}</h2>
            <span class="badge bg-info fs-6 mb-3"><i class="bi bi-clock"></i> {{ $package->duration_days }} {{ __('hari') }}</span>
            <h3 class="text-success fw-bold">{{ __('Rp') }} {{ number_format($package->price, 0, ',', '.') }}</h3>
            <hr>
            <p>{{ $package->description }}</p>

            @if($package->includes)
                <h5 class="mt-4">{{ __('Termasuk:') }}</h5>
                <p>{{ $package->includes }}</p>
            @endif

            @if($package->excludes)
                <h5 class="mt-4">{{ __('Tidak Termasuk:') }}</h5>
                <p>{{ $package->excludes }}</p>
            @endif
        </div>
        <div class="col-md-5">
            @if($package->destinations->count() > 0)
                <div class="card">
                    <div class="card-header bg-success text-white"><h5 class="mb-0"><i class="bi bi-geo-alt"></i> {{ __('Rute Perjalanan') }}</h5></div>
                    <div class="card-body">
                        <div class="timeline">
                            @foreach($package->destinations as $destination)
                            <div class="d-flex mb-3">
                                <div class="me-3 text-success fs-4"><i class="bi bi-geo-alt-fill"></i></div>
                                <div>
                                    <h6 class="mb-1">{{ $destination->name }}</h6>
                                    @if($destination->description)
                                        <p class="small text-muted mb-1">{{ $destination->description }}</p>
                                    @endif
                                    @if($destination->estimated_arrival && $destination->estimated_departure)
                                        <small class="text-muted">{{ $destination->estimated_arrival }} - {{ $destination->estimated_departure }}</small>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <div class="mt-3">
                @auth('customer')
                    <a href="{{ route('booking.create') }}?package_id={{ $package->id }}" class="btn btn-success btn-lg w-100">{{ __('Pesan Paket Ini') }}</a>
                @else
                    <a href="#" class="btn btn-success btn-lg w-100" data-bs-toggle="modal" data-bs-target="#loginModal">{{ __('Masuk untuk Pesan') }}</a>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
