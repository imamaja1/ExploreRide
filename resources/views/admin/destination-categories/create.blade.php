@extends('layouts.admin')
@section('title', __('Tambah Kategori Destinasi'))
@section('content')
<div class="page-title-border mb-4">
    <h4 class="page-title">{{ __('Tambah Kategori Destinasi') }}</h4>
</div>
<div class="card"><div class="card-body">
<form method="POST" action="{{ route('admin.destination-categories.store') }}">@csrf
<div class="row g-3">
    <div class="col-md-6"><label class="form-label">{{ __('Nama') }} <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" required></div>
    <div class="col-md-6"><label class="form-label">{{ __('Slug') }} <span class="text-danger">*</span></label><input type="text" name="slug" class="form-control" placeholder="contoh: pantai" required></div>
    <div class="col-12"><div class="form-check"><input type="checkbox" name="is_active" class="form-check-input" id="isActive" value="1" checked>
    <label class="form-check-label" for="isActive">{{ __('Aktif') }}</label></div></div>
</div>
<hr>
<button type="submit" class="btn btn-success">{{ __('Simpan') }}</button>
<a href="{{ route('admin.destination-categories.index') }}" class="btn btn-secondary">{{ __('Batal') }}</a>
</form>
</div></div>
@endsection
