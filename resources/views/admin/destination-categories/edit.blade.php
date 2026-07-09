@extends('layouts.admin')
@section('title', __('Edit Kategori Destinasi'))
@section('content')
<div class="page-header mb-4">
    <h4 >{{ __('Edit Kategori Destinasi') }}</h4>
</div>
<div class="card"><div class="card-body">
<form method="POST" action="{{ route('admin.destination-categories.update', $category) }}">@csrf @method('PUT')
<div class="row g-3">
    <div class="col-md-6"><label class="form-label">{{ __('Nama') }} <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required></div>
    <div class="col-12"><div class="form-check"><input type="checkbox" name="is_active" class="form-check-input" id="isActive" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
    <label class="form-check-label" for="isActive">{{ __('Aktif') }}</label></div></div>
</div>
<hr>
<button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
<a href="{{ route('admin.destination-categories.index') }}" class="btn btn-outline-gray">{{ __('Batal') }}</a>
</form>
</div></div>
@endsection
