@extends('layouts.admin')
@section('title', __('Kategori Destinasi'))
@section('content')
<div class="page-header">
    <h4>{{ __('Kategori Destinasi') }}</h4>
</div>
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex gap-2">
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal"><i class="bi bi-plus-lg"></i> {{ __('Tambah Kategori') }}</button>
        @if(request('search'))
            <a href="{{ route('admin.destination-categories.index') }}" class="btn btn-outline-gray btn-sm"><i class="bi bi-x-lg"></i></a>
        @endif
    </div>
    <form method="GET" class="d-flex gap-2">
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-search text-muted"></i></span>
            <input type="text" name="search" class="form-control" style="min-width:200px;" placeholder="{{ __('Cari nama kategori...') }}" value="{{ request('search') }}">
        </div>
        <button class="btn btn-primary btn-sm"><i class="bi bi-funnel"></i></button>
    </form>
</div>

<div class="card"><div class="card-body p-0">
<div class="table-responsive">
<table class="table">
    <thead>
        <tr><th>{{ __('No') }}</th><th>{{ __('Nama') }}</th><th>{{ __('Slug') }}</th><th>{{ __('Status') }}</th><th>{{ __('Aksi') }}</th></tr>
    </thead>
    <tbody>
        @forelse($categories as $c)
        <tr>
            <td>{{ $categories->firstItem() + $loop->index }}</td>
            <td class="fw-bold">{{ $c->name }}</td>
            <td><code>{{ $c->slug }}</code></td>
            <td><span class="badge" style="{{ $c->is_active ? 'background:#d1fae5;color:#065f46;' : 'background:#fee2e2;color:#991b1b;' }}">{{ $c->is_active ? __('Aktif') : __('Nonaktif') }}</span></td>
            <td>
                <form method="POST" action="{{ route('admin.destination-categories.toggle', $c) }}" class="d-inline">
                    @csrf
                    <button class="btn btn-sm btn-{{ $c->is_active ? 'outline-warning' : 'outline-success' }}" title="{{ $c->is_active ? __('Nonaktifkan') : __('Aktifkan') }}">
                        <i class="bi bi-{{ $c->is_active ? 'toggle-off' : 'toggle-on' }}"></i>
                    </button>
                </form>
                <button class="btn btn-sm btn-outline-gray" data-url="{{ route('admin.destination-categories.update', $c) }}" data-name="{{ $c->name }}" data-is-active="{{ $c->is_active ? '1' : '0' }}" onclick="openEdit(this)"><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('admin.destination-categories.destroy', $c) }}" class="d-inline" data-confirm="{{ __('Hapus kategori ini?') }}">@csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center py-5">
                <div class="d-flex flex-column align-items-center">
                    <i class="bi bi-inbox text-muted" style="font-size:3rem;opacity:0.4;"></i>
                    <p class="text-muted mt-2 mb-0">{{ __('Belum ada kategori destinasi') }}</p>
                </div>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
</div></div></div>
<div class="mt-3">{{ $categories->links() }}</div>

<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 14px; border: 1px solid var(--gray-200);">
            <form method="POST" action="{{ route('admin.destination-categories.store') }}">@csrf
                <div class="modal-header" style="border-bottom: 1px solid var(--gray-200);">
                    <h5 class="modal-title fw-bold">{{ __('Tambah Kategori Destinasi') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">{{ __('Nama') }} <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" value="{{ old('name') }}" required></div>
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
            <form id="editForm" method="POST">@csrf @method('PUT')
                <div class="modal-header" style="border-bottom: 1px solid var(--gray-200);">
                    <h5 class="modal-title fw-bold">{{ __('Edit Kategori Destinasi') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">{{ __('Nama') }} <span class="text-danger">*</span></label><input type="text" name="name" id="editName" class="form-control" required></div>
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
    document.getElementById('editIsActive').checked = btn.dataset.isActive === '1';
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>
@endpush
