@extends('layouts.admin')
@section('title', __('Edit Destinasi'))
@section('content')
<div class="page-title-border mb-4">
    <h4 class="page-title">{{ __('Edit Destinasi') }}</h4>
</div>
<div class="card"><div class="card-body">
<form method="POST" action="{{ route('admin.destinations.update', $destination) }}" enctype="multipart/form-data">@csrf @method('PUT')
<div class="row g-3">
    <div class="col-md-6"><label class="form-label">{{ __('Nama') }} <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" value="{{ old('name', $destination->name) }}" required></div>
    <div class="col-md-4"><label class="form-label">{{ __('Kategori') }} <span class="text-danger">*</span></label>
        <select name="category" class="form-select" required>
            <option value="pantai" @selected(old('category', $destination->category) == 'pantai')>{{ __('Pantai') }}</option>
            <option value="gunung" @selected(old('category', $destination->category) == 'gunung')>{{ __('Gunung') }}</option>
            <option value="air-terjun" @selected(old('category', $destination->category) == 'air-terjun')>{{ __('Air Terjun') }}</option>
        </select>
    </div>
    <div class="col-md-4"><label class="form-label">{{ __('Lokasi') }} <span class="text-danger">*</span></label><input type="text" name="location" class="form-control" value="{{ old('location', $destination->location) }}" required></div>
    <div class="col-md-4"><label class="form-label">{{ __('Rating') }}</label><input type="number" name="rating" class="form-control" value="{{ old('rating', $destination->rating) }}" min="0" max="5" step="0.1"></div>
    <div class="col-md-6"><label class="form-label">{{ __('Foto') }}</label><input type="file" name="main_photo" class="form-control" accept="image/*">
    @if($destination->main_photo) <small class="text-muted">{{ __('Biarkan kosong jika tidak ganti') }}</small> @endif</div>
    <div class="col-md-6 d-flex align-items-end pb-2">
        <div class="form-check">
            <input type="checkbox" name="is_active" class="form-check-input" id="isActive" value="1" {{ old('is_active', $destination->is_active) ? 'checked' : '' }}>
            <label class="form-check-label" for="isActive">{{ __('Aktif') }}</label>
        </div>
    </div>
    <div class="col-12"><label class="form-label">{{ __('Deskripsi') }}</label><textarea name="description" class="form-control" rows="4">{{ old('description', $destination->description) }}</textarea></div>
</div>
<hr>
<button type="submit" class="btn btn-success">{{ __('Update') }}</button>
<a href="{{ route('admin.destinations.index') }}" class="btn btn-secondary">{{ __('Batal') }}</a>
</form>
</div></div>
@endsection
