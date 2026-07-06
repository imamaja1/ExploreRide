@extends('layouts.admin')
@section('title', __('Edit Mobil'))
@section('content')
<div class="page-title-border mb-4">
    <h4 class="page-title">{{ __('Edit Mobil') }}</h4>
</div>
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.cars.update', $car) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">{{ __('Nama Mobil') }}</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $car->name) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('Merek') }}</label>
                    <input type="text" name="brand" class="form-control" value="{{ old('brand', $car->brand) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('Model') }}</label>
                    <input type="text" name="model" class="form-control" value="{{ old('model', $car->model) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Tahun') }}</label>
                    <input type="number" name="year" class="form-control" value="{{ old('year', $car->year) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Plat Nomor') }}</label>
                    <input type="text" name="plate_number" class="form-control" value="{{ old('plate_number', $car->plate_number) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Warna') }}</label>
                    <input type="text" name="color" class="form-control" value="{{ old('color', $car->color) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Transmisi') }}</label>
                    <select name="transmission" class="form-select">
                        <option value="Manual" @selected($car->transmission == 'Manual')>{{ __('Manual') }}</option>
                        <option value="Matic" @selected($car->transmission == 'Matic')>{{ __('Matic') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Bahan Bakar') }}</label>
                    <select name="fuel_type" class="form-select">
                        <option value="Bensin" @selected($car->fuel_type == 'Bensin')>{{ __('Bensin') }}</option>
                        <option value="Diesel" @selected($car->fuel_type == 'Diesel')>{{ __('Diesel') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Kursi') }}</label>
                    <input type="number" name="seats" class="form-control" value="{{ old('seats', $car->seats) }}" min="1">
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Harga/Hari') }}</label>
                    <input type="number" name="price_per_day" class="form-control" value="{{ old('price_per_day', $car->price_per_day) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Foto') }}</label>
                    <input type="file" name="main_photo" class="form-control" accept="image/*">
                    @if($car->main_photo) <small class="text-muted">{{ __('Biarkan kosong jika tidak ingin ganti foto') }}</small> @endif
                </div>
                <div class="col-12">
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $car->description) }}</textarea>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" {{ old('is_active', $car->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">{{ __('Aktif') }}</label>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-success">{{ __('Update') }}</button>
            <a href="{{ route('admin.cars.index') }}" class="btn btn-secondary">{{ __('Batal') }}</a>
        </form>
    </div>
</div>
@endsection
