@extends('layouts.admin')
@section('title', __('Detail Pesanan') . ' - ' . $booking->booking_code)
@section('content')
<div class="page-header">
    <h4 >{{ __('Detail Pesanan') }}: {{ $booking->booking_code }}</h4>
    <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-gray"><i class="bi bi-arrow-left"></i> {{ __('Kembali') }}</a>
</div>

@php
    $badge = match($booking->status) {
        'pending' => 'secondary',
        'waiting_payment' => 'warning',
        'confirmed' => 'primary',
        'in_progress' => 'info',
        'completed' => 'success',
        'cancelled' => 'danger',
        default => 'secondary',
    };
@endphp

<div class="row g-4">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">{{ __('Info Pesanan') }}</div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4 text-muted">{{ __('Kode Booking') }}</div>
                    <div class="col-sm-8 fw-bold">{{ $booking->booking_code }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 text-muted">{{ __('Status') }}</div>
                    <div class="col-sm-8"><span class="badge rounded-pill bg-{{ $badge }} fs-6">{{ __($booking->status) }}</span></div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 text-muted">{{ __('Tanggal Mulai') }}</div>
                    <div class="col-sm-8">{{ $booking->start_date->format('d/m/Y') }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 text-muted">{{ __('Tanggal Selesai') }}</div>
                    <div class="col-sm-8">{{ $booking->end_date->format('d/m/Y') }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 text-muted">{{ __('Durasi') }}</div>
                    <div class="col-sm-8">{{ $booking->duration_days }} {{ __('hari') }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 text-muted">{{ __('Lokasi Jemput') }}</div>
                    <div class="col-sm-8">{{ $booking->pickup_location ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 text-muted">{{ __('Jam Jemput') }}</div>
                    <div class="col-sm-8">{{ $booking->pickup_time ? \Carbon\Carbon::parse($booking->pickup_time)->format('H:i') : '-' }}</div>
                </div>
                @if($booking->notes)
                <div class="row mb-2">
                    <div class="col-sm-4 text-muted">{{ __('Catatan') }}</div>
                    <div class="col-sm-8">{{ $booking->notes }}</div>
                </div>
                @endif
                <div class="row mb-0">
                    <div class="col-sm-4 text-muted">{{ __('Total Harga') }}</div>
                    <div class="col-sm-8 fw-bold fs-5 text-success">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">{{ __('Info Pelanggan') }}</div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4 text-muted">{{ __('Nama') }}</div>
                    <div class="col-sm-8">{{ $booking->customer->name ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 text-muted">{{ __('Email') }}</div>
                    <div class="col-sm-8">{{ $booking->customer->email ?? '-' }}</div>
                </div>
                <div class="row mb-0">
                    <div class="col-sm-4 text-muted">{{ __('No. HP') }}</div>
                    <div class="col-sm-8">{{ $booking->customer->phone ?? '-' }}</div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">{{ __('Info Kendaraan / Paket') }}</div>
            <div class="card-body">
                @if($booking->car)
                <div class="row mb-2">
                    <div class="col-sm-4 text-muted">{{ __('Mobil') }}</div>
                    <div class="col-sm-8">{{ $booking->car->name }} ({{ $booking->car->plate_number }})</div>
                </div>
                <div class="row mb-0">
                    <div class="col-sm-4 text-muted">{{ __('Layanan') }}</div>
                    <div class="col-sm-8">{{ $booking->service->name ?? '-' }}</div>
                </div>
                @elseif($booking->tourPackage)
                <div class="row mb-0">
                    <div class="col-sm-4 text-muted">{{ __('Paket Wisata') }}</div>
                    <div class="col-sm-8">{{ $booking->tourPackage->name }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        @if($booking->payment)
        <div class="card mb-4">
            <div class="card-header">{{ __('Pembayaran') }}</div>
            <div class="card-body">
                <div class="mb-2">
                    <small class="text-muted">{{ __('Status') }}</small>
                    <span class="badge rounded-pill bg-{{ $booking->payment->status == 'verified' ? 'success' : 'warning' }} d-block mt-1">
                        {{ $booking->payment->status == 'verified' ? __('Terverifikasi') : __('Pending') }}
                    </span>
                </div>
                <div class="mb-2">
                    <small class="text-muted">{{ __('Jumlah') }}</small>
                    <div class="fw-bold">Rp {{ number_format($booking->payment->amount, 0, ',', '.') }}</div>
                </div>
                @if($booking->payment->bank_name)
                <div class="mb-2">
                    <small class="text-muted">{{ __('Bank Tujuan') }}</small>
                    <div>{{ $booking->payment->bank_name }} - {{ $booking->payment->account_number }} ({{ $booking->payment->account_name }})</div>
                </div>
                @endif
                @if($booking->payment->proof_photo)
                <div class="mb-2">
                    <small class="text-muted">{{ __('Bukti Transfer') }}</small>
                    <a href="{{ Storage::url($booking->payment->proof_photo) }}" target="_blank" class="btn btn-sm btn-outline-success d-block mt-1">
                        <i class="bi bi-image"></i> {{ __('Lihat Bukti') }}
                    </a>
                </div>
                @endif

                @if($booking->payment && $booking->payment->status != 'verified' && $booking->status == 'waiting_payment')
                <hr>
                <form method="POST" action="{{ route('admin.bookings.confirm-payment', $booking) }}" data-confirm="{{ __('Konfirmasi pembayaran ini?') }}" data-confirm-button="{{ __('Ya, konfirmasi!') }}" data-confirm-color="#198754">
                    @csrf
                    <button class="btn btn-primary w-100"><i class="bi bi-check-circle"></i> {{ __('Konfirmasi Pembayaran') }}</button>
                </form>
                @endif
            </div>
        </div>
        @endif

        <div class="card mb-4">
            <div class="card-header">{{ __('Driver') }}</div>
            <div class="card-body">
                @if($booking->driver)
                <div class="mb-2">
                    <small class="text-muted">{{ __('Driver Ditugaskan') }}</small>
                    <div class="fw-bold">{{ $booking->driver->name }}</div>
                    <div>{{ $booking->driver->phone }}</div>
                </div>
                @else
                <p class="text-muted mb-2">{{ __('Belum ada driver ditugaskan') }}</p>
                @endif

                @if(in_array($booking->status, ['confirmed', 'pending', 'waiting_payment']))
                <hr>
                <form method="POST" action="{{ route('admin.bookings.assign-driver', $booking) }}">
                    @csrf
                    <div class="mb-2">
                        <select name="driver_id" class="form-select" required>
                            <option value="">{{ __('-- Pilih Driver --') }}</option>
                            @foreach($drivers as $d)
                                <option value="{{ $d->id }}" @selected($booking->driver_id == $d->id)>{{ $d->name }} - {{ $d->phone }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-primary w-100"><i class="bi bi-person-check"></i> {{ __('Tugaskan') }}</button>
                </form>
                @endif
            </div>
        </div>

        @if(!in_array($booking->status, ['completed', 'cancelled']))
        <div class="card mb-4">
            <div class="card-header" style="background:#dc3545;">{{ __('Aksi') }}</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}" data-confirm="{{ __('Batalkan pesanan ini?') }}" data-confirm-button="{{ __('Ya, batalkan!') }}" data-confirm-color="#dc3545">
                    @csrf
                    <button class="btn btn-danger w-100"><i class="bi bi-x-circle"></i> {{ __('Batalkan Pesanan') }}</button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
