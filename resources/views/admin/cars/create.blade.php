@extends('layouts.admin')
@section('title', __('Tambah Mobil'))
@section('content')
<div class="page-title-border mb-4">
    <h4 class="page-title">{{ __('Tambah Mobil') }}</h4>
</div>
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.cars.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">{{ __('Nama Mobil') }} <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('Merek') }} <span class="text-danger">*</span></label>
                    <input type="text" name="brand" class="form-control @error('brand') is-invalid @enderror" value="{{ old('brand') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('Model') }}</label>
                    <input type="text" name="model" class="form-control" value="{{ old('model') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Tahun') }}</label>
                    <input type="number" name="year" class="form-control" value="{{ old('year') }}" min="2000" max="2030">
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Plat Nomor') }} <span class="text-danger">*</span></label>
                    <input type="text" name="plate_number" class="form-control @error('plate_number') is-invalid @enderror" value="{{ old('plate_number') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Warna') }}</label>
                    <input type="text" name="color" class="form-control" value="{{ old('color') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Transmisi') }}</label>
                    <select name="transmission" class="form-select">
                        <option value="Manual">{{ __('Manual') }}</option>
                        <option value="Matic">{{ __('Matic') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Bahan Bakar') }}</label>
                    <select name="fuel_type" class="form-select">
                        <option value="Bensin">{{ __('Bensin') }}</option>
                        <option value="Diesel">{{ __('Diesel') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Kursi') }}</label>
                    <input type="number" name="seats" class="form-control" value="4" min="1">
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Harga/Hari') }} <span class="text-danger">*</span></label>
                    <input type="number" name="price_per_day" class="form-control @error('price_per_day') is-invalid @enderror" value="{{ old('price_per_day') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Foto') }}</label>
                    <input type="file" name="main_photo" class="form-control" accept="image/*">
                </div>
                <div class="col-12">
                    <label class="form-label">{{ __('Deskripsi') }}</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" checked>
                        <label class="form-check-label" for="is_active">{{ __('Aktif') }}</label>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-success">{{ __('Simpan') }}</button>
            <a href="{{ route('admin.cars.index') }}" class="btn btn-secondary">{{ __('Batal') }}</a>
        </form>
    </div>
</div>
@endsection
