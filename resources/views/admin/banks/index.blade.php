@extends('layouts.admin')
@section('title', __('Bank'))
@section('content')
<div class="page-title-border">
    <h4 class="page-title">{{ __('Bank') }}</h4>
    <a href="{{ route('admin.banks.create') }}" class="btn btn-success"><i class="bi bi-plus-lg"></i> {{ __('Tambah Bank') }}</a>
</div>
<div class="card"><div class="card-body p-0">
<div class="table-responsive">
<table class="table table-hover mb-0">
    <thead class="table-light">
        <tr><th>{{ __('Nama Bank') }}</th><th>{{ __('No. Rekening') }}</th><th>{{ __('Atas Nama') }}</th><th>{{ __('Status') }}</th><th>{{ __('Aksi') }}</th></tr>
    </thead>
    <tbody>
        @foreach($banks as $bank)
        <tr>
            <td class="fw-bold">{{ $bank->name }}</td>
            <td>{{ $bank->account_number }}</td>
            <td>{{ $bank->account_name }}</td>
            <td><span class="badge rounded-pill bg-{{ $bank->is_active ? 'success' : 'danger' }}">{{ $bank->is_active ? __('Aktif') : __('Nonaktif') }}</span></td>
            <td>
                <a href="{{ route('admin.banks.edit', $bank) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                <form method="POST" action="{{ route('admin.banks.destroy', $bank) }}" class="d-inline" data-confirm="{{ __('Hapus bank?') }}">@csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div></div></div>
<div class="mt-3 d-flex justify-content-center">{{ $banks->links() }}</div>
@endsection
