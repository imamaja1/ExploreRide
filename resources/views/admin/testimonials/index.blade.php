@extends('layouts.admin')
@section('title', __('Testimoni'))
@section('content')
<div class="page-header">
    <h4>{{ __('Testimoni') }}</h4>
</div>
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex gap-2">
        @if(request('search'))
            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-gray btn-sm"><i class="bi bi-x-lg"></i> {{ __('Reset') }}</a>
        @endif
    </div>
    <form method="GET" class="d-flex gap-2">
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-search text-muted"></i></span>
            <input type="text" name="search" class="form-control" style="min-width:200px;" placeholder="{{ __('Cari nama, pesan...') }}" value="{{ request('search') }}">
        </div>
        <button class="btn btn-primary btn-sm"><i class="bi bi-funnel"></i></button>
    </form>
</div>

<div class="card"><div class="card-body p-0">
<div class="table-responsive">
<table class="table">
    <thead>
        <tr><th>{{ __('No') }}</th><th>{{ __('Nama') }}</th><th>{{ __('Rating') }}</th><th>{{ __('Pesan') }}</th><th>{{ __('Status') }}</th><th>{{ __('Aksi') }}</th></tr>
    </thead>
    <tbody>
        @forelse($testimonials as $t)
        <tr>
            <td>{{ $testimonials->firstItem() + $loop->index }}</td>
            <td class="fw-bold">{{ $t->name }}</td>
            <td>@for($i = 1; $i <= 5; $i++)<i class="bi bi-star{{ $i <= $t->rating ? '-fill' : '' }}" style="color:#f59e0b;font-size:0.8rem;"></i>@endfor</td>
            <td class="text-muted" style="max-width:300px;">{{ Str::limit($t->message, 80) }}</td>
            <td><span class="badge" style="{{ $t->is_active ? 'background:#d1fae5;color:#065f46;' : 'background:#fee2e2;color:#991b1b;' }}">{{ $t->is_active ? __('Aktif') : __('Nonaktif') }}</span></td>
            <td>
                <button class="btn btn-sm btn-outline-gray" data-url="{{ route('admin.testimonials.update', $t) }}" data-name="{{ $t->name }}" data-rating="{{ $t->rating }}" data-message="{{ $t->message }}" data-is-active="{{ $t->is_active ? '1' : '0' }}" onclick="openEdit(this)"><i class="bi bi-pencil"></i></button>
                <form method="POST" action="{{ route('admin.testimonials.destroy', $t) }}" class="d-inline" data-confirm="{{ __('Hapus testimoni?') }}">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center py-5"><div class="d-flex flex-column align-items-center"><i class="bi bi-inbox text-muted" style="font-size:3rem;opacity:0.4;"></i><p class="text-muted mt-2 mb-0">{{ __('Belum ada testimoni ditemukan') }}</p></div></td></tr>
        @endforelse
    </tbody>
</table>
</div></div></div>
<div class="mt-3">{{ $testimonials->links() }}</div>

<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 14px; border: 1px solid var(--gray-200);">
            <form id="editForm" method="POST" enctype="multipart/form-data">@csrf @method('PUT')
                <div class="modal-header" style="border-bottom: 1px solid var(--gray-200);">
                    <h5 class="modal-title fw-bold">{{ __('Edit Testimoni') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">{{ __('Nama') }} <span class="text-danger">*</span></label><input type="text" name="name" id="editName" class="form-control" required></div>
                        <div class="col-md-3"><label class="form-label">{{ __('Rating') }} <span class="text-danger">*</span></label><select name="rating" id="editRating" class="form-select" required>@for($i = 5; $i >= 1; $i--)<option value="{{ $i }}">{{ $i }} {{ __('bintang') }}</option>@endfor</select></div>
                        <div class="col-md-3"><label class="form-label">{{ __('Foto') }}</label><input type="file" name="photo" class="form-control" accept="image/*"><small class="text-muted">{{ __('Kosongkan jika tidak ganti') }}</small></div>
                        <div class="col-12"><label class="form-label">{{ __('Pesan') }} <span class="text-danger">*</span></label><textarea name="message" id="editMessage" class="form-control" rows="3" required></textarea></div>
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
    document.getElementById('editRating').value = btn.dataset.rating;
    document.getElementById('editMessage').value = btn.dataset.message;
    document.getElementById('editIsActive').checked = btn.dataset.isActive === '1';
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>
@endpush
