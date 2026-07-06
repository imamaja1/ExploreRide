@extends('layouts.admin')
@section('title', __('Kategori Destinasi'))
@section('content')
<div class="page-title-border">
    <h4 class="page-title">{{ __('Kategori Destinasi') }}</h4>
    <a href="{{ route('admin.destination-categories.create') }}" class="btn btn-success"><i class="bi bi-plus-lg"></i> {{ __('Tambah Kategori') }}</a>
</div>
<div class="card"><div class="card-body p-0">
<div class="table-responsive">
<table class="table table-hover mb-0">
    <thead class="table-light">
        <tr><th>{{ __('No') }}</th><th>{{ __('Nama') }}</th><th>{{ __('Slug') }}</th><th>{{ __('Status') }}</th><th>{{ __('Aksi') }}</th></tr>
    </thead>
    <tbody>
        @foreach($categories as $c)
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
        @endforeach
    </tbody>
</table>
</div></div></div>
<p class="text-muted small mt-2"><i class="bi bi-info-circle"></i> {{ __('Kategori yang dinonaktifkan tidak akan tampil di halaman utama.') }}</p>
@endsection
