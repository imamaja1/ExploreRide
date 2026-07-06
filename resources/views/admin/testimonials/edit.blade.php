@extends('layouts.admin')
@section('title', __('Edit Testimoni'))
@section('content')
<div class="page-title-border mb-4">
    <h4 class="page-title">{{ __('Edit Testimoni') }}</h4>
</div>
<div class="card"><div class="card-body">
<form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}" enctype="multipart/form-data">@csrf @method('PUT')
<div class="row g-3">
    <div class="col-md-6"><label class="form-label">{{ __('Nama') }} <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" value="{{ old('name', $testimonial->name) }}" required></div>
    <div class="col-md-3"><label class="form-label">{{ __('Rating') }} <span class="text-danger">*</span></label>
        <select name="rating" class="form-select" required>
            @for($i = 5; $i >= 1; $i--)
                <option value="{{ $i }}" @selected(old('rating', $testimonial->rating) == $i)>{{ $i }} {{ __('bintang') }}</option>
            @endfor
        </select>
    </div>
    <div class="col-md-3"><label class="form-label">{{ __('Foto') }}</label><input type="file" name="photo" class="form-control" accept="image/*">
    @if($testimonial->photo) <small class="text-muted">{{ __('Biarkan kosong jika tidak ganti') }}</small> @endif</div>
    <div class="col-12"><label class="form-label">{{ __('Pesan') }} <span class="text-danger">*</span></label><textarea name="message" class="form-control" rows="4" required>{{ old('message', $testimonial->message) }}</textarea></div>
    <div class="col-12"><div class="form-check"><input type="checkbox" name="is_active" class="form-check-input" id="isActive" value="1" {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }}>
    <label class="form-check-label" for="isActive">{{ __('Aktif') }}</label></div></div>
</div>
<hr>
<button type="submit" class="btn btn-success">{{ __('Update') }}</button>
<a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">{{ __('Batal') }}</a>
</form>
</div></div>
@endsection
