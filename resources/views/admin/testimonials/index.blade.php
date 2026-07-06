@extends('layouts.admin')
@section('title', __('Testimoni'))
@section('content')
<div class="page-title-border">
    <h4 class="page-title">{{ __('Testimoni') }}</h4>
</div>
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex gap-2">
        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-success btn-sm"><i class="bi bi-plus-lg"></i> {{ __('Tambah Testimoni') }}</a>
        @if(request('search'))
            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-x-lg"></i></a>
        @endif
    </div>
    <form method="GET" class="d-flex gap-2">
        <div class="input-group">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
            <input type="text" name="search" class="form-control border-start-0 ps-0" style="min-width:200px;" placeholder="{{ __('Cari nama, pesan...') }}" value="{{ request('search') }}">
        </div>
        <button class="btn btn-success-er btn-sm"><i class="bi bi-funnel"></i></button>
    </form>
</div>

<div class="card"><div class="card-body p-0">
<div class="table-responsive">
<table class="table table-hover mb-0">
    <thead class="table-light">
        <tr><th>{{ __('No') }}</th><th>{{ __('Nama') }}</th><th>{{ __('Rating') }}</th><th>{{ __('Pesan') }}</th><th>{{ __('Status') }}</th><th>{{ __('Aksi') }}</th></tr>
    </thead>
    <tbody>
        @forelse($testimonials as $t)
        <tr>
            <td>{{ $testimonials->firstItem() + $loop->index }}</td>
            <td class="fw-bold">{{ $t->name }}</td>
            <td>@for($i = 1; $i <= 5; $i++)<i class="bi bi-star{{ $i <= $t->rating ? '-fill' : '' }} text-warning"></i>@endfor</td>
            <td class="text-muted" style="max-width:300px;">{{ Str::limit($t->message, 80) }}</td>
            <td><span class="badge rounded-pill bg-{{ $t->is_active ? 'success' : 'warning' }}">{{ $t->is_active ? __('Aktif') : __('Pending') }}</span></td>
            <td>
                <a href="{{ route('admin.testimonials.edit', $t) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                <form method="POST" action="{{ route('admin.testimonials.destroy', $t) }}" class="d-inline" data-confirm="{{ __('Hapus testimoni?') }}">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button></form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center py-5"><div class="d-flex flex-column align-items-center"><i class="bi bi-inbox text-muted" style="font-size:3rem;opacity:0.4;"></i><p class="text-muted mt-2 mb-0">{{ __('Belum ada testimoni ditemukan') }}</p></div></td></tr>
        @endforelse
    </tbody>
</table>
</div></div></div>
<div class="mt-3 d-flex justify-content-center">{{ $testimonials->links() }}</div>
@endsection
