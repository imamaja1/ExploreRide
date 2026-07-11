@extends('layouts.admin')
@section('title', __('Destinasi'))
@section('content')
<div class="page-header">
    <h4>{{ __('Destinasi') }}</h4>
</div>
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex gap-2">
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal"><i class="bi bi-plus-lg"></i> {{ __('Tambah Destinasi') }}</button>
        @if(request('search'))
            <a href="{{ route('admin.destinations.index') }}" class="btn btn-outline-gray btn-sm"><i class="bi bi-x-lg"></i></a>
        @endif
    </div>
    <form method="GET" class="d-flex gap-2">
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-search text-muted"></i></span>
            <input type="text" name="search" class="form-control" style="min-width:200px;" placeholder="{{ __('Cari nama, lokasi...') }}" value="{{ request('search') }}">
        </div>
        <button class="btn btn-primary btn-sm"><i class="bi bi-funnel"></i></button>
    </form>
</div>

<div class="card"><div class="card-body p-0">
<div class="table-responsive">
<table class="table">
    <thead>
        <tr><th>{{ __('Foto') }}</th><th>{{ __('Nama') }}</th><th>{{ __('Kategori') }}</th><th>{{ __('Lokasi') }}</th><th>{{ __('Rating') }}</th><th>{{ __('Status') }}</th><th>{{ __('Aksi') }}</th></tr>
    </thead>
    <tbody>
        @forelse($destinations as $d)
        <tr>
            <td>@if($d->main_photo)<img src="{{ asset('storage/' . $d->main_photo) }}" style="width:60px;height:40px;object-fit:cover;" class="rounded">@else<span class="text-muted">-</span>@endif</td>
            <td class="fw-bold">{{ $d->name }}</td>
            <td>{{ __($d->category) }}</td>
            <td>{{ $d->location }}</td>
            <td><i class="bi bi-star-fill" style="color:#f59e0b;font-size:0.8rem;"></i> {{ number_format($d->rating, 1) }}</td>
            <td><span class="badge" style="{{ $d->is_active ? 'background:#d1fae5;color:#065f46;' : 'background:#fee2e2;color:#991b1b;' }}">{{ $d->is_active ? __('Aktif') : __('Nonaktif') }}</span></td>
            <td>
                <button class="btn btn-sm btn-outline-gray" data-url="{{ route('admin.destinations.update', $d) }}" data-name="{{ $d->name }}" data-category="{{ $d->category }}" data-location="{{ $d->location }}" data-rating="{{ $d->rating }}" data-is-active="{{ $d->is_active ? '1' : '0' }}" data-description="{{ addslashes($d->description ?? '') }}" onclick="openEdit(this)"><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('admin.destinations.destroy', $d) }}" class="d-inline" data-confirm="{{ __('Hapus destinasi?') }}">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center py-5"><div class="d-flex flex-column align-items-center"><i class="bi bi-inbox text-muted" style="font-size:3rem;opacity:0.4;"></i><p class="text-muted mt-2 mb-0">{{ __('Belum ada destinasi ditemukan') }}</p></div></td></tr>
        @endforelse
    </tbody>
</table>
</div></div></div>
<div class="mt-3">{{ $destinations->links() }}</div>

{{-- CREATE MODAL --}}
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 14px; border: 1px solid var(--gray-200);">
            <form method="POST" action="{{ route('admin.destinations.store') }}" enctype="multipart/form-data">@csrf
                <div class="modal-header" style="border-bottom: 1px solid var(--gray-200);">
                    <h5 class="modal-title fw-bold">{{ __('Tambah Destinasi') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">{{ __('Nama') }} <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" required></div>
                        <div class="col-md-3"><label class="form-label">{{ __('Kategori') }} <span class="text-danger">*</span></label>
                            <select name="category" class="form-select" required><option value="">{{ __('-- Pilih --') }}</option>@foreach($categories as $cat)<option value="{{ $cat->slug }}">{{ $cat->name }}</option>@endforeach</select>
                        </div>
                        <div class="col-md-3"><label class="form-label">{{ __('Rating') }}</label><input type="number" name="rating" class="form-control" value="4" min="0" max="5" step="0.1"></div>
                        <div class="col-md-6"><label class="form-label">{{ __('Lokasi') }} <span class="text-danger">*</span></label><input type="text" name="location" class="form-control" required></div>
                        <div class="col-md-3"><label class="form-label">{{ __('Foto') }}</label><input type="file" name="main_photo" class="form-control" accept="image/*"></div>
                        <div class="col-md-3 d-flex align-items-end"><div class="form-check"><input type="checkbox" name="is_active" class="form-check-input" id="isActiveCreate" value="1" checked><label class="form-check-label" for="isActiveCreate">{{ __('Aktif') }}</label></div></div>
                        <div class="col-12"><label class="form-label">{{ __('Deskripsi') }}</label><textarea name="description" class="form-control" rows="3"></textarea></div>
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

{{-- EDIT MODAL (SINGLE) --}}
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 14px; border: 1px solid var(--gray-200);">
            <form method="POST" id="editForm" action="" enctype="multipart/form-data">@csrf @method('PUT')
                <div class="modal-header" style="border-bottom: 1px solid var(--gray-200);">
                    <h5 class="modal-title fw-bold">{{ __('Edit Destinasi') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">{{ __('Nama') }} <span class="text-danger">*</span></label><input type="text" name="name" id="editName" class="form-control" required></div>
                        <div class="col-md-3"><label class="form-label">{{ __('Kategori') }} <span class="text-danger">*</span></label>
                            <select name="category" id="editCategory" class="form-select" required>@foreach($categories as $cat)<option value="{{ $cat->slug }}">{{ $cat->name }}</option>@endforeach</select>
                        </div>
                        <div class="col-md-3"><label class="form-label">{{ __('Rating') }}</label><input type="number" name="rating" id="editRating" class="form-control" min="0" max="5" step="0.1"></div>
                        <div class="col-md-6"><label class="form-label">{{ __('Lokasi') }} <span class="text-danger">*</span></label><input type="text" name="location" id="editLocation" class="form-control" required></div>
                        <div class="col-md-3"><label class="form-label">{{ __('Foto') }}</label><input type="file" name="main_photo" class="form-control" accept="image/*"><small class="text-muted">{{ __('Kosongkan jika tidak ganti') }}</small></div>
                        <div class="col-md-3 d-flex align-items-end"><div class="form-check"><input type="checkbox" name="is_active" class="form-check-input" id="editIsActive" value="1"><label class="form-check-label" for="editIsActive">{{ __('Aktif') }}</label></div></div>
                        <div class="col-12"><label class="form-label">{{ __('Deskripsi') }}</label><textarea name="description" id="editDescription" class="form-control" rows="3"></textarea></div>
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
    document.getElementById('editCategory').value = btn.dataset.category;
    document.getElementById('editLocation').value = btn.dataset.location;
    document.getElementById('editRating').value = btn.dataset.rating;
    document.getElementById('editIsActive').checked = btn.dataset.isActive === '1';
    document.getElementById('editDescription').value = btn.dataset.description;
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>
@endpush
