@extends('layouts.admin')
@section('title', __('Edit Paket Wisata'))
@section('content')
<div class="page-header mb-4">
    <h4>{{ __('Edit Paket Wisata') }}</h4>
</div>
<div class="card"><div class="card-body">
<form method="POST" action="{{ route('admin.tour-packages.update', $tourPackage) }}" enctype="multipart/form-data">@csrf @method('PUT')
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">{{ __('Nama Paket') }} <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $tourPackage->name) }}" required>
    </div>
    <div class="col-md-3">
        <label class="form-label">{{ __('Harga') }} <span class="text-danger">*</span></label>
        <input type="number" name="price" class="form-control" value="{{ old('price', $tourPackage->price) }}" required>
    </div>
    <div class="col-md-3">
        <label class="form-label">{{ __('Durasi (hari)') }}</label>
        <input type="number" name="duration_days" class="form-control" value="{{ old('duration_days', $tourPackage->duration_days) }}" min="1">
    </div>
    <div class="col-md-4">
        <label class="form-label">{{ __('Foto') }}</label>
        <input type="file" name="main_photo" class="form-control" accept="image/*">
        @if($tourPackage->main_photo) <small class="text-muted">{{ __('Kosongkan jika tidak ganti') }}</small> @endif
    </div>
    <div class="col-md-8">
        <label class="form-label">{{ __('Deskripsi') }}</label>
        <textarea name="description" class="form-control" rows="2">{{ old('description', $tourPackage->description) }}</textarea>
    </div>
    <div class="col-md-6">
        <label class="form-label">{{ __('Termasuk') }}</label>
        <textarea name="includes" class="form-control" rows="2">{{ old('includes', $tourPackage->includes) }}</textarea>
    </div>
    <div class="col-md-6">
        <label class="form-label">{{ __('Tidak Termasuk') }}</label>
        <textarea name="excludes" class="form-control" rows="2">{{ old('excludes', $tourPackage->excludes) }}</textarea>
    </div>
    <div class="col-12">
        <div class="form-check">
            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" {{ old('is_active', $tourPackage->is_active) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">{{ __('Aktif') }}</label>
        </div>
    </div>
</div>
<hr>
<button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
<a href="{{ route('admin.tour-packages.index') }}" class="btn btn-outline-gray">{{ __('Batal') }}</a>
</form>
</div></div>

@if($tourPackage->destinations->count() > 0)
<hr>
<h5 class="fw-bold">{{ __('Destinasi dalam Paket') }}</h5>
<div class="table-responsive">
<table class="table table-sm">
    <thead><tr><th>{{ __('Order') }}</th><th>{{ __('Nama') }}</th><th>{{ __('Estimasi Tiba') }}</th><th>{{ __('Estimasi Pulang') }}</th></tr></thead>
    <tbody>
        @foreach($tourPackage->destinations as $dest)
        <tr><td>{{ $dest->order }}</td><td>{{ $dest->name }}</td><td>{{ $dest->estimated_arrival ?? '-' }}</td><td>{{ $dest->estimated_departure ?? '-' }}</td></tr>
        @endforeach
    </tbody>
</table>
</div>
@endif
@endsection
