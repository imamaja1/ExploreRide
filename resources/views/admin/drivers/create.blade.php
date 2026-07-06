@extends('layouts.admin')
@section('title', __('Tambah Driver'))
@section('content')
<div class="page-title-border mb-4">
    <h4 class="page-title">{{ __('Tambah Driver') }}</h4>
</div>
<div class="card"><div class="card-body">
<form method="POST" action="{{ route('admin.drivers.store') }}" enctype="multipart/form-data">@csrf
<div class="row g-3">
    <div class="col-md-4"><label class="form-label">{{ __('Nama') }}</label><input type="text" name="name" class="form-control" required></div>
    <div class="col-md-4"><label class="form-label">{{ __('Email') }}</label><input type="email" name="email" class="form-control" required></div>
    <div class="col-md-4"><label class="form-label">{{ __('Password') }}</label><input type="password" name="password" class="form-control" required></div>
    <div class="col-md-4"><label class="form-label">{{ __('No. HP') }}</label><input type="text" name="phone" class="form-control"></div>
    <div class="col-md-4"><label class="form-label">{{ __('WhatsApp') }}</label><input type="text" name="whatsapp" class="form-control"></div>
    <div class="col-md-4"><label class="form-label">{{ __('Plat Nomor') }}</label><input type="text" name="plate_number" class="form-control" required></div>
    <div class="col-12"><label class="form-label">{{ __('Alamat') }}</label><textarea name="address" class="form-control" rows="2"></textarea></div>
    <div class="col-md-6"><label class="form-label">{{ __('Foto SIM') }}</label><input type="file" name="sim_photo" class="form-control" accept="image/*"></div>
    <div class="col-md-6 d-flex align-items-end pb-2">
        <div class="form-check">
            <input type="checkbox" name="is_active" class="form-check-input" id="isActiveDr" value="1" checked>
            <label class="form-check-label" for="isActiveDr">{{ __('Aktif') }}</label>
        </div>
    </div>
</div>
<hr>
<button type="submit" class="btn btn-success">{{ __('Simpan') }}</button>
<a href="{{ route('admin.drivers.index') }}" class="btn btn-secondary">{{ __('Batal') }}</a>
</form>
</div></div>
@endsection
