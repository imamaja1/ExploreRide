@extends('layouts.admin')
@section('title', __('Bank'))
@section('content')
<div class="page-header">
    <h4>{{ __('Rekening Bank') }}</h4>
</div>
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex gap-2">
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal"><i class="bi bi-plus-lg"></i> {{ __('Tambah Bank') }}</button>
        @if(request('search'))
            <a href="{{ route('admin.banks.index') }}" class="btn btn-outline-gray btn-sm"><i class="bi bi-x-lg"></i></a>
        @endif
    </div>
    <form method="GET" class="d-flex gap-2">
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-search text-muted"></i></span>
            <input type="text" name="search" class="form-control" style="min-width:200px;" placeholder="{{ __('Cari nama bank, rekening...') }}" value="{{ request('search') }}">
        </div>
        <button class="btn btn-primary btn-sm"><i class="bi bi-funnel"></i></button>
    </form>
</div>

<div class="card"><div class="card-body p-0">
<div class="table-responsive">
<table class="table">
    <thead>
        <tr><th>{{ __('Nama Bank') }}</th><th>{{ __('No. Rekening') }}</th><th>{{ __('Atas Nama') }}</th><th>{{ __('Status') }}</th><th>{{ __('Aksi') }}</th></tr>
    </thead>
    <tbody>
        @forelse($banks as $bank)
        <tr>
            <td class="fw-bold">{{ $bank->name }}</td>
            <td>{{ $bank->account_number }}</td>
            <td>{{ $bank->account_name }}</td>
            <td><span class="badge" style="{{ $bank->is_active ? 'background:#d1fae5;color:#065f46;' : 'background:#fee2e2;color:#991b1b;' }}">{{ $bank->is_active ? __('Aktif') : __('Nonaktif') }}</span></td>
            <td>
                <button class="btn btn-sm btn-outline-gray" data-url="{{ route('admin.banks.update', $bank) }}" data-name="{{ $bank->name }}" data-account-number="{{ $bank->account_number }}" data-account-name="{{ $bank->account_name }}" data-is-active="{{ $bank->is_active ? '1' : '0' }}" onclick="openEdit(this)"><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('admin.banks.destroy', $bank) }}" class="d-inline" data-confirm="{{ __('Hapus bank?') }}">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
            </td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center py-5"><div class="d-flex flex-column align-items-center"><i class="bi bi-inbox text-muted" style="font-size:3rem;opacity:0.4;"></i><p class="text-muted mt-2 mb-0">{{ __('Belum ada bank ditemukan') }}</p></div></td></tr>
        @endforelse
    </tbody>
</table>
</div></div></div>
<div class="mt-3">{{ $banks->links() }}</div>

<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 14px; border: 1px solid var(--gray-200);">
            <form method="POST" action="{{ route('admin.banks.store') }}" enctype="multipart/form-data">@csrf
                <div class="modal-header" style="border-bottom: 1px solid var(--gray-200);">
                    <h5 class="modal-title fw-bold">{{ __('Tambah Bank') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label">{{ __('Nama Bank') }}</label><input type="text" name="name" class="form-control" value="{{ old('name') }}" required></div>
                        <div class="col-md-4"><label class="form-label">{{ __('No. Rekening') }}</label><input type="text" name="account_number" class="form-control" value="{{ old('account_number') }}" required></div>
                        <div class="col-md-4"><label class="form-label">{{ __('Atas Nama') }}</label><input type="text" name="account_name" class="form-control" value="{{ old('account_name') }}" required></div>
                        <div class="col-md-4"><label class="form-label">{{ __('Logo') }}</label><input type="file" name="logo" class="form-control" accept="image/*"></div>
                        <div class="col-md-4 d-flex align-items-end pb-2">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" class="form-check-input" id="isActiveCreate" value="1" checked>
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
                    <h5 class="modal-title fw-bold">{{ __('Edit Bank') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label">{{ __('Nama Bank') }}</label><input type="text" name="name" id="editName" class="form-control" required></div>
                        <div class="col-md-4"><label class="form-label">{{ __('No. Rekening') }}</label><input type="text" name="account_number" id="editAccountNumber" class="form-control" required></div>
                        <div class="col-md-4"><label class="form-label">{{ __('Atas Nama') }}</label><input type="text" name="account_name" id="editAccountName" class="form-control" required></div>
                        <div class="col-md-4"><label class="form-label">{{ __('Logo') }}</label><input type="file" name="logo" class="form-control" accept="image/*"><small class="text-muted">{{ __('Kosongkan jika tidak ganti') }}</small></div>
                        <div class="col-md-4 d-flex align-items-end pb-2">
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
    document.getElementById('editAccountNumber').value = btn.dataset.accountNumber;
    document.getElementById('editAccountName').value = btn.dataset.accountName;
    document.getElementById('editIsActive').checked = btn.dataset.isActive === '1';
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>
@endpush
