@extends('layouts.app')
@section('title', __('Detail Pesanan'))
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-3"><i class="bi bi-receipt"></i> {{ __('Detail Pesanan') }}</h4>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">{{ __('Kode Booking') }}</div>
                        <div class="col-sm-8 fw-bold">{{ $booking->booking_code }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">{{ __('Status') }}</div>
                        <div class="col-sm-8">
                            @php
                                $badge = match($booking->status) {
                                    'pending' => 'warning',
                                    'waiting_payment' => 'info',
                                    'confirmed' => 'success',
                                    'in_progress' => 'primary',
                                    'completed' => 'secondary',
                                    'cancelled' => 'danger',
                                    default => 'secondary',
                                };
                            @endphp
                            <span class="badge bg-{{ $badge }}">{{ __($booking->status) }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">{{ __('Layanan') }}</div>
                        <div class="col-sm-8">{{ $booking->service->name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">{{ __('Mobil') }}</div>
                        <div class="col-sm-8">{{ $booking->car->brand }} {{ $booking->car->name }} ({{ $booking->car->plate_number }})</div>
                    </div>
                    @if($booking->tourPackage)
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">{{ __('Paket Wisata') }}</div>
                        <div class="col-sm-8">{{ $booking->tourPackage->name }}</div>
                    </div>
                    @endif
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">{{ __('Tanggal') }}</div>
                        <div class="col-sm-8">{{ $booking->start_date }} {{ __('s.d') }} {{ $booking->end_date }} ({{ $booking->duration_days }} {{ __('hari') }})</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">{{ __('Total Harga') }}</div>
                        <div class="col-sm-8 fw-bold text-success">{{ __('Rp') }} {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                    </div>

                    @if($booking->payment)
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">{{ __('Pembayaran') }}</div>
                        <div class="col-sm-8">
                            <span class="badge bg-{{ $booking->payment->status == 'verified' ? 'success' : 'warning' }}">
                                {{ __($booking->payment->status) }}
                            </span>
                            @if($booking->payment->proof_photo)
                                <br><a href="{{ asset('storage/' . $booking->payment->proof_photo) }}" target="_blank" class="small">{{ __('Lihat Bukti Transfer') }}</a>
                            @endif
                        </div>
                    </div>
                    @endif

                    <hr>
                    <div id="driverInfo">
                        @if($booking->driver)
                            <div class="alert alert-success">
<h5><i class="bi bi-person-badge"></i> {{ __('Sopir Ditugaskan') }}</h5>
                                <p class="mb-1"><strong>{{ __('Nama:') }}</strong> {{ $booking->driver->name }}</p>
                                <p class="mb-1"><strong>{{ __('No. HP:') }}</strong> {{ $booking->driver->phone }}</p>
                                <p class="mb-0"><strong>{{ __('Plat Nomor:') }}</strong> {{ $booking->driver->plate_number }}</p>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class="bi bi-clock"></i> {{ __('Menunggu penugasan sopir...') }}
                            </div>
                        @endif
                    </div>

                    <a href="{{ route('booking.my') }}" class="btn btn-outline-success">{{ __('Kembali') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    if (typeof EventSource !== 'undefined') {
        const evtSource = new EventSource("{{ route('sse.booking', $booking->id) }}");
        evtSource.addEventListener('update', function(e) {
            const data = JSON.parse(e.data);
            const statusBadge = document.querySelector('.badge.bg-\\' + window.getComputedStyle(document.querySelector('.badge')).backgroundColor + '');
            if (data.driver) {
                document.getElementById('driverInfo').innerHTML = `
                    <div class="alert alert-success">
                        <h5><i class="bi bi-person-badge"></i> {{ __("Sopir Ditugaskan") }}</h5>
                        <p class="mb-1"><strong>{{ __("Nama:") }}</strong> ${data.driver.name}</p>
                        <p class="mb-1"><strong>{{ __("No. HP:") }}</strong> ${data.driver.phone}</p>
                        <p class="mb-0"><strong>{{ __("Plat Nomor:") }}</strong> ${data.driver.plate_number}</p>
                    </div>
                `;
            }
        });
        evtSource.addEventListener('error', function() {
            evtSource.close();
        });
    }
</script>
@endpush
