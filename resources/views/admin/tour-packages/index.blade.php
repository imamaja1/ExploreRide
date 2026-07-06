@extends('layouts.admin')
@section('title', __('Paket Wisata'))
@section('content')
<div class="page-title-border">
    <h4 class="page-title">{{ __('Paket Wisata') }}</h4>
</div>
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex gap-2">
        <a href="{{ route('admin.tour-packages.create') }}" class="btn btn-success btn-sm"><i class="bi bi-plus-lg"></i> {{ __('Tambah Paket Wisata') }}</a>
        @if(request('search'))
            <a href="{{ route('admin.tour-packages.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-x-lg"></i></a>
        @endif
    </div>
    <form method="GET" class="d-flex gap-2">
        <div class="input-group">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
            <input type="text" name="search" class="form-control border-start-0 ps-0" style="min-width:200px;" placeholder="{{ __('Cari nama paket wisata...') }}" value="{{ request('search') }}">
        </div>
        <button class="btn btn-success-er btn-sm"><i class="bi bi-funnel"></i></button>
    </form>
</div>

<div class="card"><div class="card-body p-0">
<div class="table-responsive">
<table class="table table-hover mb-0">
    <thead class="table-light">
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
            <td><span class="badge rounded-pill bg-{{ $pkg->is_active ? 'success' : 'danger' }}">{{ $pkg->is_active ? __('Aktif') : __('Nonaktif') }}</span></td>
            <td>
                <a href="{{ route('admin.tour-packages.edit', $pkg) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                <form method="POST" action="{{ route('admin.tour-packages.destroy', $pkg) }}" class="d-inline" data-confirm="{{ __('Hapus paket?') }}">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button></form>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center py-5"><div class="d-flex flex-column align-items-center"><i class="bi bi-inbox text-muted" style="font-size:3rem;opacity:0.4;"></i><p class="text-muted mt-2 mb-0">{{ __('Belum ada paket wisata ditemukan') }}</p></div></td></tr>
        @endforelse
    </tbody>
</table>
</div></div></div>
<div class="mt-3 d-flex justify-content-center">{{ $packages->links() }}</div>
@endsection
