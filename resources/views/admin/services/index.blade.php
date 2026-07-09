@extends('layouts.admin')
@section('title', __('Layanan'))
@section('content')
<div class="page-header">
    <h4>{{ __('Pengaturan Layanan') }}</h4>
</div>
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        @if(request('search'))
            <a href="{{ route('admin.services.index') }}" class="btn btn-outline-gray btn-sm"><i class="bi bi-x-lg"></i> {{ __('Reset') }}</a>
        @endif
    </div>
    <form method="GET" class="d-flex gap-2">
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-search text-muted"></i></span>
            <input type="text" name="search" class="form-control" style="min-width:200px;" placeholder="{{ __('Cari layanan...') }}" value="{{ request('search') }}">
        </div>
        <button class="btn btn-primary btn-sm"><i class="bi bi-funnel"></i></button>
    </form>
</div>

<div class="card"><div class="card-body p-0">
<div class="table-responsive">
<table class="table">
    <thead>
        <tr><th>{{ __('No') }}</th><th>{{ __('Nama Layanan') }}</th><th>{{ __('Deskripsi') }}</th><th>{{ __('Status') }}</th><th>{{ __('Aksi') }}</th></tr>
    </thead>
    <tbody>
        @forelse($services as $service)
        <tr>
            <td>{{ $services->firstItem() + $loop->index }}</td>
            <td class="fw-bold">{{ $service->name }}</td>
            <td>{{ $service->description }}</td>
            <td><span class="badge" style="{{ $service->is_active ? 'background:#d1fae5;color:#065f46;' : 'background:#fee2e2;color:#991b1b;' }}">{{ $service->is_active ? __('Aktif') : __('Nonaktif') }}</span></td>
            <td>
                <button class="btn btn-sm btn-outline-gray" data-url="{{ route('admin.services.update', $service) }}" data-name="{{ $service->name }}" data-description="{{ $service->description }}" data-is-active="{{ $service->is_active ? '1' : '0' }}" onclick="openEdit(this)"><i class="bi bi-pencil"></i></button>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center py-5">
                <div class="d-flex flex-column align-items-center">
                    <i class="bi bi-inbox text-muted" style="font-size:3rem;opacity:0.4;"></i>
                    <p class="text-muted mt-2 mb-0">{{ __('Belum ada layanan') }}</p>
                </div>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
</div></div></div>
<div class="mt-3">{{ $services->links() }}</div>
<p class="text-muted small mt-2"><i class="bi bi-info-circle"></i> {{ __('Nonaktifkan layanan untuk menyembunyikannya dari halaman utama pelanggan.') }}</p>

<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 14px; border: 1px solid var(--gray-200);">
            <form id="editForm" method="POST">@csrf @method('PUT')
                <div class="modal-header" style="border-bottom: 1px solid var(--gray-200);">
                    <h5 class="modal-title fw-bold">{{ __('Edit Layanan') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">{{ __('Nama Layanan') }}</label><input type="text" name="name" id="editName" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label">{{ __('Deskripsi') }}</label><textarea name="description" id="editDescription" class="form-control" rows="2"></textarea></div>
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
    document.getElementById('editDescription').value = btn.dataset.description;
    document.getElementById('editIsActive').checked = btn.dataset.isActive === '1';
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>
@endpush
