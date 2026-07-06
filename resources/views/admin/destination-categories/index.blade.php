@extends('layouts.admin')
@section('title', __('Kategori Destinasi'))
@section('content')
<div class="page-title-border">
    <h4 class="page-title">{{ __('Kategori Destinasi') }}</h4>
</div>
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <a href="{{ route('admin.destination-categories.create') }}" class="btn btn-success btn-sm"><i class="bi bi-plus-lg"></i> {{ __('Tambah Kategori') }}</a>
    </div>
    <div></div>
</div>

<div class="card"><div class="card-body p-0">
<div class="table-responsive">
<table class="table table-hover mb-0">
    <thead class="table-light">
        <tr><th>{{ __('No') }}</th><th>{{ __('Nama') }}</th><th>{{ __('Slug') }}</th><th>{{ __('Status') }}</th><th>{{ __('Aksi') }}</th></tr>
    </thead>
    <tbody>
        @forelse($categories as $c)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td class="fw-bold">{{ $c->name }}</td>
            <td><code>{{ $c->slug }}</code></td>
            <td><span class="badge rounded-pill bg-{{ $c->is_active ? 'success' : 'danger' }}">{{ $c->is_active ? __('Aktif') : __('Nonaktif') }}</span></td>
            <td>
                <form method="POST" action="{{ route('admin.destination-categories.toggle', $c) }}" class="d-inline">
                    @csrf
                    <button class="btn btn-sm btn-{{ $c->is_active ? 'warning' : 'success' }}" title="{{ $c->is_active ? __('Nonaktifkan') : __('Aktifkan') }}">
                        <i class="bi bi-{{ $c->is_active ? 'toggle-off' : 'toggle-on' }}"></i>
                    </button>
                </form>
                <a href="{{ route('admin.destination-categories.edit', $c) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                <form method="POST" action="{{ route('admin.destination-categories.destroy', $c) }}" class="d-inline" data-confirm="{{ __('Hapus kategori ini? Destinasi dengan kategori ini tidak akan terhapus.') }}">@csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
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
<p class="text-muted small mt-2"><i class="bi bi-info-circle"></i> {{ __('Kategori yang dinonaktifkan tidak akan tampil di halaman utama.') }}</p>
@endsection
