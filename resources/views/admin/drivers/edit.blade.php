@extends('layouts.admin')
@section('title', __('Edit Driver'))
@section('content')
<div class="page-header">
    <h4>{{ __('Edit Driver') }}</h4>
</div>
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.drivers.update', $driver) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">{{ __('Nama') }} <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $driver->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('Email') }} <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $driver->email) }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('Password') }} <small class="text-muted">({{ __('Biarkan kosong jika tidak ganti') }})</small></label>
                    <input type="password" name="password" class="form-control" minlength="8">
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('No. HP') }}</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $driver->phone) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('WhatsApp') }}</label>
                    <input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp', $driver->whatsapp) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('Plat Nomor') }} <span class="text-danger">*</span></label>
                    <input type="text" name="plate_number" class="form-control @error('plate_number') is-invalid @enderror" value="{{ old('plate_number', $driver->plate_number) }}" required>
                    @error('plate_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-12">
                    <label class="form-label">{{ __('Alamat') }}</label>
                    <textarea name="address" class="form-control" rows="2">{{ old('address', $driver->address) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('Foto SIM') }}</label>
                    <input type="file" name="sim_photo" class="form-control" accept="image/*">
                    @if($driver->sim_photo) <small class="text-muted">{{ __('Biarkan kosong jika tidak ingin ganti') }}</small> @endif
                </div>
                <div class="col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="is_active" value="1" {{ old('is_active', $driver->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">{{ __('Aktif') }}</label>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
            <a href="{{ route('admin.drivers.index') }}" class="btn btn-outline-gray">{{ __('Batal') }}</a>
        </form>
    </div>
</div>
@endsection
