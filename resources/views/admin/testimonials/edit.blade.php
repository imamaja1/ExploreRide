@extends('layouts.admin')
@section('title', __('Edit Testimoni'))
@section('content')
<div class="page-header">
    <h4>{{ __('Edit Testimoni') }}</h4>
</div>
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">{{ __('Nama') }} <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $testimonial->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Rating') }} <span class="text-danger">*</span></label>
                    <select name="rating" class="form-select" required>
                        @for($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" @selected(old('rating', $testimonial->rating) == $i)>{{ $i }} {{ __('bintang') }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Foto') }}</label>
                    <input type="file" name="photo" class="form-control" accept="image/*">
                    @if($testimonial->photo) <small class="text-muted">{{ __('Kosongkan jika tidak ganti') }}</small> @endif
                </div>
                <div class="col-12">
                    <label class="form-label">{{ __('Pesan') }} <span class="text-danger">*</span></label>
                    <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="3" required>{{ old('message', $testimonial->message) }}</textarea>
                    @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="is_active" value="1" {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">{{ __('Aktif') }}</label>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-gray">{{ __('Batal') }}</a>
        </form>
    </div>
</div>
@endsection
