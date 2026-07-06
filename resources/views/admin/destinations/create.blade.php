@extends('layouts.admin')
@section('title', __('Tambah Destinasi'))
@section('content')
<div class="page-title-border mb-4">
    <h4 class="page-title">{{ __('Tambah Destinasi') }}</h4>
</div>
<div class="card"><div class="card-body">
<form method="POST" action="{{ route('admin.destinations.store') }}" enctype="multipart/form-data">@csrf
<div class="row g-3">
    <div class="col-md-6"><label class="form-label">{{ __('Nama') }} <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" required></div>
    <div class="col-md-6"><label class="form-label">{{ __('Slug') }} <span class="text-danger">*</span></label><input type="text" name="slug" class="form-control" placeholder="{{ __('nama-destinasi') }}" required></div>
    <div class="col-md-4"><label class="form-label">{{ __('Kategori') }} <span class="text-danger">*</span></label>
        <select name="category" class="form-select" required>
            <option value="">{{ __('-- Pilih Kategori --') }}</option>
            <option value="pantai">{{ __('Pantai') }}</option>
            <option value="gunung">{{ __('Gunung') }}</option>
            <option value="air-terjun">{{ __('Air Terjun') }}</option>
        </select>
    </div>
    <div class="col-md-4"><label class="form-label">{{ __('Lokasi') }} <span class="text-danger">*</span></label><input type="text" name="location" class="form-control" required></div>
    <div class="col-md-4"><label class="form-label">{{ __('Rating') }}</label><input type="number" name="rating" class="form-control" value="4" min="0" max="5" step="0.1"></div>
    <div class="col-md-6"><label class="form-label">{{ __('Foto') }}</label><input type="file" name="main_photo" class="form-control" accept="image/*"></div>
    <div class="col-md-6 d-flex align-items-end pb-2">
        <div class="form-check">
            <input type="checkbox" name="is_active" class="form-check-input" id="isActive" value="1" checked>
            <label class="form-check-label" for="isActive">{{ __('Aktif') }}</label>
        </div>
    </div>
    <div class="col-12"><label class="form-label">{{ __('Deskripsi') }}</label><textarea name="description" class="form-control" rows="4"></textarea></div>
</div>
<hr>
<button type="submit" class="btn btn-success">{{ __('Simpan') }}</button>
<a href="{{ route('admin.destinations.index') }}" class="btn btn-secondary">{{ __('Batal') }}</a>
</form>
</div></div>
@endsection
