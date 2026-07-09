@extends('layouts.admin')
@section('title', __('Paket Wisata'))
@section('content')
<div class="page-header">
    <h4>{{ __('Paket Wisata') }}</h4>
</div>
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex gap-2">
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal"><i class="bi bi-plus-lg"></i> {{ __('Tambah Paket') }}</button>
        @if(request('search'))
            <a href="{{ route('admin.tour-packages.index') }}" class="btn btn-outline-gray btn-sm"><i class="bi bi-x-lg"></i></a>
        @endif
    </div>
    <form method="GET" class="d-flex gap-2">
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-search text-muted"></i></span>
            <input type="text" name="search" class="form-control" style="min-width:200px;" placeholder="{{ __('Cari nama paket...') }}" value="{{ request('search') }}">
        </div>
        <button class="btn btn-primary btn-sm"><i class="bi bi-funnel"></i></button>
    </form>
</div>

<div class="card"><div class="card-body p-0">
<div class="table-responsive">
<table class="table">
    <thead>
        <tr><th>{{ __('Foto') }}</th><th>{{ __('Nama') }}</th><th>{{ __('Harga') }}</th><th>{{ __('Durasi') }}</th><th>{{ __('Destinasi') }}</th><th>{{ __('Status') }}</th><th>{{ __('Aksi') }}</th></tr>
    </thead>
    <tbody>
        @forelse($packages as $pkg)
        <tr>
            <td>@if($pkg->main_photo)<img src="{{ asset('storage/' . $pkg->main_photo) }}" style="width:60px;height:40px;object-fit:cover;" class="rounded">@else<span class="text-muted">-</span>@endif</td>
            <td class="fw-bold">{{ $pkg->name }}</td>
            <td>Rp {{ number_format($pkg->price, 0, ',', '.') }}</td>
            <td>{{ $pkg->duration_days }} {{ __('hari') }}</td>
            <td>{{ $pkg->destinations_count }} {{ __('destinasi') }}</td>
            <td><span class="badge" style="{{ $pkg->is_active ? 'background:#d1fae5;color:#065f46;' : 'background:#fee2e2;color:#991b1b;' }}">{{ $pkg->is_active ? __('Aktif') : __('Nonaktif') }}</span></td>
            <td>
                <button class="btn btn-sm btn-outline-gray" data-url="{{ route('admin.tour-packages.update', $pkg) }}" data-name="{{ $pkg->name }}" data-price="{{ $pkg->price }}" data-duration-days="{{ $pkg->duration_days }}" data-description="{{ $pkg->description }}" data-includes="{{ $pkg->includes }}" data-excludes="{{ $pkg->excludes }}" data-is-active="{{ $pkg->is_active ? '1' : '0' }}" onclick="openEdit(this)"><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('admin.tour-packages.destroy', $pkg) }}" class="d-inline" data-confirm="{{ __('Hapus paket?') }}">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center py-5"><div class="d-flex flex-column align-items-center"><i class="bi bi-inbox text-muted" style="font-size:3rem;opacity:0.4;"></i><p class="text-muted mt-2 mb-0">{{ __('Belum ada paket wisata ditemukan') }}</p></div></td></tr>
        @endforelse
    </tbody>
</table>
</div></div></div>
<div class="mt-3">{{ $packages->links() }}</div>

<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 14px; border: 1px solid var(--gray-200);">
            <form method="POST" action="{{ route('admin.tour-packages.store') }}" enctype="multipart/form-data">@csrf
                <div class="modal-header" style="border-bottom: 1px solid var(--gray-200);">
                    <h5 class="modal-title fw-bold">{{ __('Tambah Paket Wisata') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">{{ __('Nama Paket') }} <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" value="{{ old('name') }}" required></div>
                        <div class="col-md-3"><label class="form-label">{{ __('Harga') }} <span class="text-danger">*</span></label><input type="number" name="price" class="form-control" value="{{ old('price') }}" required></div>
                        <div class="col-md-3"><label class="form-label">{{ __('Durasi (hari)') }}</label><input type="number" name="duration_days" class="form-control" value="{{ old('duration_days', 1) }}" min="1"></div>
                        <div class="col-md-4"><label class="form-label">{{ __('Foto') }}</label><input type="file" name="main_photo" class="form-control" accept="image/*"></div>
                        <div class="col-md-8"><label class="form-label">{{ __('Deskripsi') }}</label><textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea></div>
                        <div class="col-md-6"><label class="form-label">{{ __('Termasuk') }}</label><textarea name="includes" class="form-control" rows="2" placeholder="{{ __('Mobil, Sopir, BBM, dll') }}">{{ old('includes') }}</textarea></div>
                        <div class="col-md-6"><label class="form-label">{{ __('Tidak Termasuk') }}</label><textarea name="excludes" class="form-control" rows="2" placeholder="{{ __('Tiket masuk, Makan, dll') }}">{{ old('excludes') }}</textarea></div>
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
                    <h5 class="modal-title fw-bold">{{ __('Edit Paket Wisata') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">{{ __('Nama Paket') }} <span class="text-danger">*</span></label><input type="text" name="name" id="editName" class="form-control" required></div>
                        <div class="col-md-3"><label class="form-label">{{ __('Harga') }} <span class="text-danger">*</span></label><input type="number" name="price" id="editPrice" class="form-control" required></div>
                        <div class="col-md-3"><label class="form-label">{{ __('Durasi (hari)') }}</label><input type="number" name="duration_days" id="editDurationDays" class="form-control" min="1"></div>
                        <div class="col-md-4"><label class="form-label">{{ __('Foto') }}</label><input type="file" name="main_photo" class="form-control" accept="image/*"><small class="text-muted">{{ __('Kosongkan jika tidak ganti') }}</small></div>
                        <div class="col-md-8"><label class="form-label">{{ __('Deskripsi') }}</label><textarea name="description" id="editDescription" class="form-control" rows="2"></textarea></div>
                        <div class="col-md-6"><label class="form-label">{{ __('Termasuk') }}</label><textarea name="includes" id="editIncludes" class="form-control" rows="2"></textarea></div>
                        <div class="col-md-6"><label class="form-label">{{ __('Tidak Termasuk') }}</label><textarea name="excludes" id="editExcludes" class="form-control" rows="2"></textarea></div>
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
    document.getElementById('editPrice').value = btn.dataset.price;
    document.getElementById('editDurationDays').value = btn.dataset.durationDays;
    document.getElementById('editDescription').value = btn.dataset.description;
    document.getElementById('editIncludes').value = btn.dataset.includes;
    document.getElementById('editExcludes').value = btn.dataset.excludes;
    document.getElementById('editIsActive').checked = btn.dataset.isActive === '1';
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>
@endpush
