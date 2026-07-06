@extends('layouts.admin')
@section('title', __('Testimoni'))
@section('content')
<div class="page-title-border">
    <h4 class="page-title">{{ __('Testimoni') }}</h4>
    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-success"><i class="bi bi-plus-lg"></i> {{ __('Tambah Testimoni') }}</a>
</div>
<div class="card"><div class="card-body p-0">
<div class="table-responsive">
<table class="table table-hover mb-0">
    <thead class="table-light">
        <tr><th>{{ __('No') }}</th><th>{{ __('Nama') }}</th><th>{{ __('Rating') }}</th><th>{{ __('Pesan') }}</th><th>{{ __('Status') }}</th><th>{{ __('Aksi') }}</th></tr>
    </thead>
    <tbody>
        @foreach($testimonials as $t)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td class="fw-bold">{{ $t->name }}</td>
            <td>
                @for($i = 1; $i <= 5; $i++)
                    <i class="bi bi-star{{ $i <= $t->rating ? '-fill' : '' }} text-warning"></i>
                @endfor
            </td>
            <td class="text-muted" style="max-width: 300px;">{{ Str::limit($t->message, 80) }}</td>
            <td>
                <span class="badge rounded-pill bg-{{ $t->is_active ? 'success' : 'warning' }}">
                    {{ $t->is_active ? __('Aktif') : __('Pending') }}
                </span>
            </td>
            <td>
                <a href="{{ route('admin.testimonials.edit', $t) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                <form method="POST" action="{{ route('admin.testimonials.destroy', $t) }}" class="d-inline" data-confirm="{{ __('Hapus testimoni?') }}">@csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div></div></div>
<div class="mt-3 d-flex justify-content-center">{{ $testimonials->links() }}</div>
@endsection
