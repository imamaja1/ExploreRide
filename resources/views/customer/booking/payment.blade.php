@extends('layouts.app')
@section('title', __('Pembayaran'))
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-3 text-center"><i class="bi bi-credit-card"></i> {{ __('Pembayaran') }}</h4>

                    <div class="alert alert-info">
                        <strong>{{ __('Kode Booking:') }}</strong> {{ $booking->booking_code }}<br>
                        <strong>{{ __('Total Bayar:') }}</strong> {{ __('Rp') }} {{ number_format($booking->total_price, 0, ',', '.') }}
                    </div>

                    <h5 class="mb-3">{{ __('Transfer ke salah satu rekening berikut:') }}</h5>
                    @foreach($banks as $bank)
                    <div class="card mb-2">
                        <div class="card-body py-2">
                            <strong>{{ $bank->name }}</strong><br>
                            <span class="text-muted small">{{ $bank->account_number }} {{ __('a.n.') }} {{ $bank->account_name }}</span>
                        </div>
                    </div>
                    @endforeach

                    <hr>
                    <h5>{{ __('Upload Bukti Transfer') }}</h5>
                    <form method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ __('Tujuan Bank') }}</label>
                            <select name="bank_id" class="form-select @error('bank_id') is-invalid @enderror" required>
                                <option value="">{{ __('-- Pilih Bank --') }}</option>
                                @foreach($banks as $bank)
                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                @endforeach
                            </select>
                            @error('bank_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Nama Pengirim') }}</label>
                            <input type="text" name="account_name" class="form-control @error('account_name') is-invalid @enderror" value="{{ old('account_name', Auth::guard('customer')->user()->name) }}" required>
                            @error('account_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Foto Bukti Transfer') }}</label>
                            <input type="file" name="proof_photo" class="form-control @error('proof_photo') is-invalid @enderror" accept="image/*" required>
                            @error('proof_photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">{{ __('Format: JPG/PNG, Maks: 2MB') }}</small>
                        </div>
                        <button type="submit" class="btn btn-success w-100">{{ __('Upload Bukti Transfer') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
