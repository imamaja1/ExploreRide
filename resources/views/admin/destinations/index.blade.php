@extends('layouts.admin')
@section('title', __('Destinasi'))
@section('content')
<div class="page-title-border">
    <h4 class="page-title">{{ __('Destinasi') }}</h4>
    <a href="{{ route('admin.destinations.create') }}" class="btn btn-success"><i class="bi bi-plus-lg"></i> {{ __('Tambah Destinasi') }}</a>
</div>
<div class="card"><div class="card-body p-0">
<div class="table-responsive">
<table class="table table-hover mb-0">
    <thead class="table-light">
        <tr><th>{{ __('Foto') }}</th><th>{{ __('Nama') }}</th><th>{{ __('Kategori') }}</th><th>{{ __('Lokasi') }}</th><th>{{ __('Rating') }}</th><th>{{ __('Status') }}</th><th>{{ __('Aksi') }}</th></tr>
    </thead>
    <tbody>
        @foreach($destinations as $d)
        <tr>
            <td>
                @if($d->main_photo)
                    <img src="{{ asset('storage/' . $d->main_photo) }}" style="width: 60px; height: 40px; object-fit: cover;" class="rounded">
                @else <span class="text-muted">-</span> @endif
            </td>
            <td class="fw-bold">{{ $d->name }}</td>
            <td>{{ __($d->category) }}</td>
            <td>{{ $d->location }}</td>
            <td><i class="bi bi-star-fill text-warning"></i> {{ number_format($d->rating, 1) }}</td>
            <td><span class="badge rounded-pill bg-{{ $d->is_active ? 'success' : 'danger' }}">{{ $d->is_active ? __('Aktif') : __('Nonaktif') }}</span></td>
            <td>
                <a href="{{ route('admin.destinations.edit', $d) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                <form method="POST" action="{{ route('admin.destinations.destroy', $d) }}" class="d-inline" data-confirm="{{ __('Hapus destinasi?') }}">@csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div></div></div>
<div class="mt-3 d-flex justify-content-center">{{ $destinations->links() }}</div>
@endsection
