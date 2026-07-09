@extends('layouts.admin')
@section('title', __('Mobil'))
@section('content')
<div class="page-header">
    <h4>{{ __('Mobil') }}</h4>
</div>
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex gap-2">
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal"><i class="bi bi-plus-lg"></i> {{ __('Tambah Mobil') }}</button>
        @if(request('search'))
            <a href="{{ route('admin.cars.index') }}" class="btn btn-outline-gray btn-sm"><i class="bi bi-x-lg"></i></a>
        @endif
    </div>
    <form method="GET" class="d-flex gap-2">
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-search text-muted"></i></span>
            <input type="text" name="search" class="form-control" style="min-width:200px;" placeholder="{{ __('Cari nama, plat...') }}" value="{{ request('search') }}">
        </div>
        <button class="btn btn-primary btn-sm"><i class="bi bi-funnel"></i></button>
    </form>
</div>

<div class="card"><div class="card-body p-0">
<div class="table-responsive">
<table class="table">
    <thead>
        <tr><th>{{ __('Foto') }}</th><th>{{ __('Nama') }}</th><th>{{ __('Plat') }}</th><th>{{ __('Harga/hari') }}</th><th>{{ __('Transmisi') }}</th><th>{{ __('Status') }}</th><th>{{ __('Aksi') }}</th></tr>
    </thead>
    <tbody>
        @forelse($cars as $car)
        <tr>
            <td>@if($car->main_photo)<img src="{{ asset('storage/' . $car->main_photo) }}" style="width:60px;height:40px;object-fit:cover;" class="rounded">@else<span class="text-muted">-</span>@endif</td>
            <td class="fw-bold">{{ $car->brand }} {{ $car->name }}</td>
            <td>{{ $car->plate_number }}</td>
            <td>Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</td>
            <td>{{ __($car->transmission) }}</td>
            <td><span class="badge" style="{{ $car->is_active ? 'background:#d1fae5;color:#065f46;' : 'background:#fee2e2;color:#991b1b;' }}">{{ $car->is_active ? __('Aktif') : __('Nonaktif') }}</span></td>
            <td>
                <button class="btn btn-sm btn-outline-gray" data-url="{{ route('admin.cars.update', $car) }}" data-name="{{ $car->name }}" data-brand="{{ $car->brand }}" data-model="{{ $car->model }}" data-year="{{ $car->year }}" data-plate-number="{{ $car->plate_number }}" data-color="{{ $car->color }}" data-transmission="{{ $car->transmission }}" data-fuel-type="{{ $car->fuel_type }}" data-seats="{{ $car->seats }}" data-price-per-day="{{ $car->price_per_day }}" data-description="{{ $car->description }}" data-is-active="{{ $car->is_active ? '1' : '0' }}" onclick="openEdit(this)"><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('admin.cars.destroy', $car) }}" class="d-inline" data-confirm="{{ __('Hapus mobil?') }}">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center py-5"><div class="d-flex flex-column align-items-center"><i class="bi bi-inbox text-muted" style="font-size:3rem;opacity:0.4;"></i><p class="text-muted mt-2 mb-0">{{ __('Belum ada mobil') }}</p></div></td></tr>
        @endforelse
    </tbody>
</table>
</div></div></div>
<div class="mt-3">{{ $cars->links() }}</div>

<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 14px; border: 1px solid var(--gray-200);">
            <form method="POST" action="{{ route('admin.cars.store') }}" enctype="multipart/form-data">@csrf
                <div class="modal-header" style="border-bottom: 1px solid var(--gray-200);">
                    <h5 class="modal-title fw-bold">{{ __('Tambah Mobil') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label">{{ __('Nama') }} <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" required></div>
                        <div class="col-md-4"><label class="form-label">{{ __('Merek') }} <span class="text-danger">*</span></label><input type="text" name="brand" class="form-control" required></div>
                        <div class="col-md-4"><label class="form-label">{{ __('Model') }}</label><input type="text" name="model" class="form-control"></div>
                        <div class="col-md-3"><label class="form-label">{{ __('Tahun') }}</label><input type="number" name="year" class="form-control" min="2000" max="2030"></div>
                        <div class="col-md-3"><label class="form-label">{{ __('Plat') }} <span class="text-danger">*</span></label><input type="text" name="plate_number" class="form-control" required></div>
                        <div class="col-md-3"><label class="form-label">{{ __('Warna') }}</label><input type="text" name="color" class="form-control"></div>
                        <div class="col-md-3"><label class="form-label">{{ __('Transmisi') }}</label><select name="transmission" class="form-select"><option value="Manual">Manual</option><option value="Matic">Matic</option></select></div>
                        <div class="col-md-3"><label class="form-label">{{ __('BBM') }}</label><select name="fuel_type" class="form-select"><option value="Bensin">Bensin</option><option value="Diesel">Diesel</option></select></div>
                        <div class="col-md-3"><label class="form-label">{{ __('Kursi') }}</label><input type="number" name="seats" class="form-control" value="4" min="1"></div>
                        <div class="col-md-3"><label class="form-label">{{ __('Harga/hari') }} <span class="text-danger">*</span></label><input type="number" name="price_per_day" class="form-control" required></div>
                        <div class="col-md-3"><label class="form-label">{{ __('Foto') }}</label><input type="file" name="main_photo" class="form-control" accept="image/*"></div>
                        <div class="col-12"><label class="form-label">{{ __('Deskripsi') }}</label><textarea name="description" class="form-control" rows="2"></textarea></div>
                        <div class="col-12"><div class="form-check"><input type="checkbox" name="is_active" class="form-check-input" id="isActiveCreate" value="1" checked><label class="form-check-label" for="isActiveCreate">{{ __('Aktif') }}</label></div></div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--gray-200);">
                    <button type="button" class="btn btn-outline-gray" data-bs-dismiss="modal">{{ __('Batal') }}</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i> {{ __('Simpan') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 14px; border: 1px solid var(--gray-200);">
            <form id="editForm" method="POST" enctype="multipart/form-data">@csrf @method('PUT')
                <div class="modal-header" style="border-bottom: 1px solid var(--gray-200);">
                    <h5 class="modal-title fw-bold">{{ __('Edit Mobil') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label">{{ __('Nama') }} <span class="text-danger">*</span></label><input type="text" name="name" id="editName" class="form-control" required></div>
                        <div class="col-md-4"><label class="form-label">{{ __('Merek') }} <span class="text-danger">*</span></label><input type="text" name="brand" id="editBrand" class="form-control" required></div>
                        <div class="col-md-4"><label class="form-label">{{ __('Model') }}</label><input type="text" name="model" id="editModel" class="form-control"></div>
                        <div class="col-md-3"><label class="form-label">{{ __('Tahun') }}</label><input type="number" name="year" id="editYear" class="form-control" min="2000" max="2030"></div>
                        <div class="col-md-3"><label class="form-label">{{ __('Plat') }} <span class="text-danger">*</span></label><input type="text" name="plate_number" id="editPlateNumber" class="form-control" required></div>
                        <div class="col-md-3"><label class="form-label">{{ __('Warna') }}</label><input type="text" name="color" id="editColor" class="form-control"></div>
                        <div class="col-md-3"><label class="form-label">{{ __('Transmisi') }}</label><select name="transmission" id="editTransmission" class="form-select"><option value="Manual">Manual</option><option value="Matic">Matic</option></select></div>
                        <div class="col-md-3"><label class="form-label">{{ __('BBM') }}</label><select name="fuel_type" id="editFuelType" class="form-select"><option value="Bensin">Bensin</option><option value="Diesel">Diesel</option></select></div>
                        <div class="col-md-3"><label class="form-label">{{ __('Kursi') }}</label><input type="number" name="seats" id="editSeats" class="form-control" min="1"></div>
                        <div class="col-md-3"><label class="form-label">{{ __('Harga/hari') }} <span class="text-danger">*</span></label><input type="number" name="price_per_day" id="editPricePerDay" class="form-control" required></div>
                        <div class="col-md-3"><label class="form-label">{{ __('Foto') }}</label><input type="file" name="main_photo" class="form-control" accept="image/*"><small class="text-muted">{{ __('Kosongkan jika tidak ganti') }}</small></div>
                        <div class="col-12"><label class="form-label">{{ __('Deskripsi') }}</label><textarea name="description" id="editDescription" class="form-control" rows="2"></textarea></div>
                        <div class="col-12"><div class="form-check"><input type="checkbox" name="is_active" class="form-check-input" id="editIsActive" value="1"><label class="form-check-label" for="editIsActive">{{ __('Aktif') }}</label></div></div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--gray-200);">
                    <button type="button" class="btn btn-outline-gray" data-bs-dismiss="modal">{{ __('Batal') }}</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i> {{ __('Update') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openEdit(btn) {
    document.getElementById('editForm').action = btn.dataset.url;
    document.getElementById('editName').value = btn.dataset.name;
    document.getElementById('editBrand').value = btn.dataset.brand;
    document.getElementById('editModel').value = btn.dataset.model;
    document.getElementById('editYear').value = btn.dataset.year;
    document.getElementById('editPlateNumber').value = btn.dataset.plateNumber;
    document.getElementById('editColor').value = btn.dataset.color;
    document.getElementById('editTransmission').value = btn.dataset.transmission;
    document.getElementById('editFuelType').value = btn.dataset.fuelType;
    document.getElementById('editSeats').value = btn.dataset.seats;
    document.getElementById('editPricePerDay').value = btn.dataset.pricePerDay;
    document.getElementById('editDescription').value = btn.dataset.description;
    document.getElementById('editIsActive').checked = btn.dataset.isActive === '1';
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>
@endpush
