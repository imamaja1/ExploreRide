@extends('layouts.admin')
@section('title', __('Edit Layanan'))
@section('content')
<div class="page-header mb-4">
    <h4 >{{ __('Edit Layanan') }}</h4>
</div>
<div class="card"><div class="card-body">
<form method="POST" action="{{ route('admin.services.update', $service) }}">@csrf @method('PUT')
<div class="mb-3">
    <label class="form-label">{{ __('Nama Layanan') }}</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $service->name) }}" required>
</div>
<div class="mb-3">
    <label class="form-label">{{ __('Deskripsi') }}</label>
    <textarea name="description" class="form-control" rows="3">{{ old('description', $service->description) }}</textarea>
</div>
<div class="form-check mb-3">
    <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">{{ __('Aktif') }}</label>
</div>
<button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
<a href="{{ route('admin.services.index') }}" class="btn btn-outline-gray">{{ __('Batal') }}</a>
</form>
</div></div>
@endsection
