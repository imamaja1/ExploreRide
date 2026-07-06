@extends('layouts.admin')
@section('title', __('Driver'))
@section('content')
<div class="page-title-border">
    <h4 class="page-title">{{ __('Driver') }}</h4>
    <a href="{{ route('admin.drivers.create') }}" class="btn btn-success"><i class="bi bi-plus-lg"></i> {{ __('Tambah Driver') }}</a>
</div>
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr><th>{{ __('Nama') }}</th><th>{{ __('Email') }}</th><th>{{ __('No. HP') }}</th><th>{{ __('Plat Nomor') }}</th><th>{{ __('Status') }}</th><th>{{ __('Aksi') }}</th></tr>
                </thead>
                <tbody>
                    @foreach($drivers as $driver)
                    <tr>
                        <td>{{ $driver->name }}</td>
                        <td>{{ $driver->email }}</td>
                        <td>{{ $driver->phone ?? '-' }}</td>
                        <td>{{ $driver->plate_number }}</td>
                                                 <td><span class="badge rounded-pill bg-{{ $driver->is_active ? 'success' : 'danger' }}">{{ $driver->is_active ? __('Aktif') : __('Nonaktif') }}</span></td>
                        <td>
                            <a href="{{ route('admin.drivers.edit', $driver) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                             <form method="POST" action="{{ route('admin.drivers.destroy', $driver) }}" class="d-inline" data-confirm="{{ __('Hapus driver?') }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-3 d-flex justify-content-center">{{ $drivers->links() }}</div>
@endsection
