@extends('layouts.admin')
@section('title', __('Tambah Testimoni'))
@section('content')
<div class="page-title-border mb-4">
    <h4 class="page-title">{{ __('Tambah Testimoni') }}</h4>
</div>
<div class="card"><div class="card-body">
<form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data">@csrf
<div class="row g-3">
    <div class="col-md-6"><label class="form-label">{{ __('Nama') }} <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" required></div>
    <div class="col-md-3"><label class="form-label">{{ __('Rating') }} <span class="text-danger">*</span></label>
        <select name="rating" class="form-select" required>
            @for($i = 5; $i >= 1; $i--)
                <option value="{{ $i }}">{{ $i }} {{ __('bintang') }}</option>
            @endfor
        </select>
    </div>
    <div class="col-md-3"><label class="form-label">{{ __('Foto') }}</label><input type="file" name="photo" class="form-control" accept="image/*"></div>
    <div class="col-12"><label class="form-label">{{ __('Pesan') }} <span class="text-danger">*</span></label><textarea name="message" class="form-control" rows="4" required></textarea></div>
    <div class="col-12"><div class="form-check"><input type="checkbox" name="is_active" class="form-check-input" id="isActive" value="1" checked>
    <label class="form-check-label" for="isActive">{{ __('Aktif') }}</label></div></div>
</div>
<hr>
<button type="submit" class="btn btn-success">{{ __('Simpan') }}</button>
<a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">{{ __('Batal') }}</a>
</form>
</div></div>
@endsection
