@extends('layouts.admin')
@section('title', __('Layanan'))
@section('content')
<div class="page-title-border">
    <h4 class="page-title">{{ __('Pengaturan Layanan') }}</h4>
</div>
<div class="d-flex justify-content-between align-items-center mb-3">
    <div></div>
</div>

<div class="card"><div class="card-body p-0">
<div class="table-responsive">
<table class="table table-hover mb-0">
    <thead class="table-light">
        <tr><th>{{ __('No') }}</th><th>{{ __('Nama Layanan') }}</th><th>{{ __('Deskripsi') }}</th><th>{{ __('Status') }}</th><th>{{ __('Aksi') }}</th></tr>
    </thead>
    <tbody>
        @forelse($services as $service)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td class="fw-bold">{{ $service->name }}</td>
            <td>{{ $service->description }}</td>
            <td>
                <span class="badge rounded-pill bg-{{ $service->is_active ? 'success' : 'danger' }}">
                    {{ $service->is_active ? __('Aktif') : __('Nonaktif') }}
                </span>
            </td>
            <td>
                <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i> {{ __('Edit') }}</a>
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
<p class="text-muted small mt-2"><i class="bi bi-info-circle"></i> {{ __('Nonaktifkan layanan untuk menyembunyikannya dari halaman utama pelanggan.') }}</p>
@endsection
