@extends('layouts.admin')
@section('title', __('Tambah Driver'))
@section('content')
<div class="page-header">
    <h4>{{ __('Tambah Driver') }}</h4>
</div>
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.drivers.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">{{ __('Nama') }} <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('Email') }} <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('Password') }} <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required minlength="8">
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('No. HP') }}</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('WhatsApp') }}</label>
                    <input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('Plat Nomor') }} <span class="text-danger">*</span></label>
                    <input type="text" name="plate_number" class="form-control @error('plate_number') is-invalid @enderror" value="{{ old('plate_number') }}" required>
                    @error('plate_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-12">
                    <label class="form-label">{{ __('Alamat') }}</label>
                    <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('Foto SIM') }}</label>
                    <input type="file" name="sim_photo" class="form-control" accept="image/*">
                </div>
                <div class="col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">{{ __('Aktif') }}</label>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
            <a href="{{ route('admin.drivers.index') }}" class="btn btn-outline-gray">{{ __('Batal') }}</a>
        </form>
    </div>
</div>
@endsection
