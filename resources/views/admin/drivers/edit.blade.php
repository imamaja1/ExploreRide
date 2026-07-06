@extends('layouts.admin')
@section('title', __('Edit Driver'))
@section('content')
<div class="page-title-border mb-4">
    <h4 class="page-title">{{ __('Edit Driver') }}</h4>
</div>
<div class="card"><div class="card-body">
<form method="POST" action="{{ route('admin.drivers.update', $driver) }}" enctype="multipart/form-data">@csrf @method('PUT')
<div class="row g-3">
    <div class="col-md-4"><label class="form-label">{{ __('Nama') }}</label><input type="text" name="name" class="form-control" value="{{ old('name', $driver->name) }}" required></div>
    <div class="col-md-4"><label class="form-label">{{ __('Email') }}</label><input type="email" name="email" class="form-control" value="{{ old('email', $driver->email) }}" required></div>
    <div class="col-md-4"><label class="form-label">{{ __('Password (biarkan jika tidak ganti)') }}</label><input type="password" name="password" class="form-control"></div>
    <div class="col-md-4"><label class="form-label">{{ __('No. HP') }}</label><input type="text" name="phone" class="form-control" value="{{ old('phone', $driver->phone) }}"></div>
    <div class="col-md-4"><label class="form-label">{{ __('WhatsApp') }}</label><input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp', $driver->whatsapp) }}"></div>
    <div class="col-md-4"><label class="form-label">{{ __('Plat Nomor') }}</label><input type="text" name="plate_number" class="form-control" value="{{ old('plate_number', $driver->plate_number) }}" required></div>
    <div class="col-12"><label class="form-label">{{ __('Alamat') }}</label><textarea name="address" class="form-control" rows="2">{{ old('address', $driver->address) }}</textarea></div>
    <div class="col-md-6"><label class="form-label">{{ __('Foto SIM') }}</label><input type="file" name="sim_photo" class="form-control" accept="image/*">
    @if($driver->sim_photo) <small class="text-muted">{{ __('Biarkan kosong jika tidak ingin ganti') }}</small> @endif</div>
    <div class="col-md-6"><div class="form-check mt-4"><input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" {{ old('is_active', $driver->is_active) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">{{ __('Aktif') }}</label></div></div>
</div>
<hr>
<button type="submit" class="btn btn-success">{{ __('Update') }}</button>
<a href="{{ route('admin.drivers.index') }}" class="btn btn-secondary">{{ __('Batal') }}</a>
</form>
</div></div>
@endsection
