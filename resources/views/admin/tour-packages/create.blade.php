@extends('layouts.admin')
@section('title', __('Tambah Paket Wisata'))
@section('content')
<div class="page-header">
    <h4>{{ __('Tambah Paket Wisata') }}</h4>
</div>
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.tour-packages.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">{{ __('Nama Paket') }} <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Harga') }} <span class="text-danger">*</span></label>
                    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>
                    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Durasi (hari)') }}</label>
                    <input type="number" name="duration_days" class="form-control" value="{{ old('duration_days', 1) }}" min="1">
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('Foto') }}</label>
                    <input type="file" name="main_photo" class="form-control" accept="image/*">
                </div>
                <div class="col-md-8">
                    <label class="form-label">{{ __('Deskripsi') }}</label>
                    <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('Termasuk') }}</label>
                    <textarea name="includes" class="form-control" rows="2" placeholder="{{ __('Mobil, Sopir, BBM, dll') }}">{{ old('includes') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('Tidak Termasuk') }}</label>
                    <textarea name="excludes" class="form-control" rows="2" placeholder="{{ __('Tiket masuk, Makan, dll') }}">{{ old('excludes') }}</textarea>
                </div>
                <div class="col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="is_active" value="1" checked>
                        <label class="form-check-label" for="is_active">{{ __('Aktif') }}</label>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
            <a href="{{ route('admin.tour-packages.index') }}" class="btn btn-outline-gray">{{ __('Batal') }}</a>
        </form>
    </div>
</div>
@endsection
