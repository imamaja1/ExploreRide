@extends('layouts.admin')
@section('title', __('Driver'))
@section('content')
<div class="page-header">
    <h4>{{ __('Driver') }}</h4>
</div>
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex gap-2">
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal"><i class="bi bi-plus-lg"></i> {{ __('Tambah Driver') }}</button>
        @if(request('search'))
            <a href="{{ route('admin.drivers.index') }}" class="btn btn-outline-gray btn-sm"><i class="bi bi-x-lg"></i></a>
        @endif
    </div>
    <form method="GET" class="d-flex gap-2">
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-search text-muted"></i></span>
            <input type="text" name="search" class="form-control" style="min-width:200px;" placeholder="{{ __('Cari nama, email, plat...') }}" value="{{ request('search') }}">
        </div>
        <button class="btn btn-primary btn-sm"><i class="bi bi-funnel"></i></button>
    </form>
</div>

<div class="card"><div class="card-body p-0">
<div class="table-responsive">
<table class="table">
    <thead>
        <tr><th>{{ __('Nama') }}</th><th>{{ __('Email') }}</th><th>{{ __('No. HP') }}</th><th>{{ __('Plat Nomor') }}</th><th>{{ __('Status') }}</th><th>{{ __('Aksi') }}</th></tr>
    </thead>
    <tbody>
        @forelse($drivers as $driver)
        <tr>
            <td class="fw-bold">{{ $driver->name }}</td>
            <td>{{ $driver->email }}</td>
            <td>{{ $driver->phone ?? '-' }}</td>
            <td>{{ $driver->plate_number }}</td>
            <td><span class="badge" style="{{ $driver->is_active ? 'background:#d1fae5;color:#065f46;' : 'background:#fee2e2;color:#991b1b;' }}">{{ $driver->is_active ? __('Aktif') : __('Nonaktif') }}</span></td>
            <td>
                <button class="btn btn-sm btn-outline-gray" data-url="{{ route('admin.drivers.update', $driver) }}" data-name="{{ $driver->name }}" data-email="{{ $driver->email }}" data-phone="{{ $driver->phone }}" data-whatsapp="{{ $driver->whatsapp }}" data-plate-number="{{ $driver->plate_number }}" data-address="{{ $driver->address }}" data-is-active="{{ $driver->is_active ? '1' : '0' }}" onclick="openEdit(this)"><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('admin.drivers.destroy', $driver) }}" class="d-inline" data-confirm="{{ __('Hapus driver?') }}">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center py-5"><div class="d-flex flex-column align-items-center"><i class="bi bi-inbox text-muted" style="font-size:3rem;opacity:0.4;"></i><p class="text-muted mt-2 mb-0">{{ __('Belum ada driver ditemukan') }}</p></div></td></tr>
        @endforelse
    </tbody>
</table>
</div></div></div>
<div class="mt-3">{{ $drivers->links() }}</div>

<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 14px; border: 1px solid var(--gray-200);">
            <form method="POST" action="{{ route('admin.drivers.store') }}" enctype="multipart/form-data">@csrf
                <div class="modal-header" style="border-bottom: 1px solid var(--gray-200);">
                    <h5 class="modal-title fw-bold">{{ __('Tambah Driver') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label">{{ __('Nama') }}</label><input type="text" name="name" class="form-control" value="{{ old('name') }}" required></div>
                        <div class="col-md-4"><label class="form-label">{{ __('Email') }}</label><input type="email" name="email" class="form-control" value="{{ old('email') }}" required></div>
                        <div class="col-md-4"><label class="form-label">{{ __('Password') }}</label><input type="password" name="password" class="form-control" required></div>
                        <div class="col-md-4"><label class="form-label">{{ __('No. HP') }}</label><input type="text" name="phone" class="form-control" value="{{ old('phone') }}"></div>
                        <div class="col-md-4"><label class="form-label">{{ __('WhatsApp') }}</label><input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp') }}"></div>
                        <div class="col-md-4"><label class="form-label">{{ __('Plat Nomor') }}</label><input type="text" name="plate_number" class="form-control" value="{{ old('plate_number') }}" required></div>
                        <div class="col-12"><label class="form-label">{{ __('Alamat') }}</label><textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea></div>
                        <div class="col-md-6"><label class="form-label">{{ __('Foto SIM') }}</label><input type="file" name="sim_photo" class="form-control" accept="image/*"></div>
                        <div class="col-md-6 d-flex align-items-end pb-2">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" class="form-check-input" id="isActiveCreate" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="isActiveCreate">{{ __('Aktif') }}</label>
                            </div>
                        </div>
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
                    <h5 class="modal-title fw-bold">{{ __('Edit Driver') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label">{{ __('Nama') }}</label><input type="text" name="name" id="editName" class="form-control" required></div>
                        <div class="col-md-4"><label class="form-label">{{ __('Email') }}</label><input type="email" name="email" id="editEmail" class="form-control" required></div>
                        <div class="col-md-4"><label class="form-label">{{ __('Password (biarkan jika tidak ganti)') }}</label><input type="password" name="password" class="form-control"></div>
                        <div class="col-md-4"><label class="form-label">{{ __('No. HP') }}</label><input type="text" name="phone" id="editPhone" class="form-control"></div>
                        <div class="col-md-4"><label class="form-label">{{ __('WhatsApp') }}</label><input type="text" name="whatsapp" id="editWhatsapp" class="form-control"></div>
                        <div class="col-md-4"><label class="form-label">{{ __('Plat Nomor') }}</label><input type="text" name="plate_number" id="editPlateNumber" class="form-control" required></div>
                        <div class="col-12"><label class="form-label">{{ __('Alamat') }}</label><textarea name="address" id="editAddress" class="form-control" rows="2"></textarea></div>
                        <div class="col-md-6"><label class="form-label">{{ __('Foto SIM') }}</label><input type="file" name="sim_photo" class="form-control" accept="image/*"><small class="text-muted">{{ __('Kosongkan jika tidak ganti') }}</small></div>
                        <div class="col-md-6 d-flex align-items-end pb-2">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" class="form-check-input" id="editIsActive" value="1">
                                <label class="form-check-label" for="editIsActive">{{ __('Aktif') }}</label>
                            </div>
                        </div>
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
    document.getElementById('editEmail').value = btn.dataset.email;
    document.getElementById('editPhone').value = btn.dataset.phone;
    document.getElementById('editWhatsapp').value = btn.dataset.whatsapp;
    document.getElementById('editPlateNumber').value = btn.dataset.plateNumber;
    document.getElementById('editAddress').value = btn.dataset.address;
    document.getElementById('editIsActive').checked = btn.dataset.isActive === '1';
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>
@endpush
