@extends('layouts.admin')
@section('title', __('Pesanan'))
@section('content')
<div class="page-title-border">
    <h4 class="page-title">{{ __('Semua Pesanan') }}</h4>
</div>
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex gap-2">
        @if(request('search') || request('status'))
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-x-lg"></i> {{ __('Reset') }}</a>
        @endif
    </div>
    <form method="GET" class="d-flex gap-2">
        <div class="input-group">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
            <input type="text" name="search" class="form-control border-start-0 ps-0" style="min-width:220px;" placeholder="{{ __('Cari kode booking, nama...') }}" value="{{ request('search') }}">
        </div>
        <select name="status" class="form-select" style="width:auto;min-width:140px;">
            <option value="">{{ __('Semua Status') }}</option>
            @foreach(['pending','waiting_payment','confirmed','in_progress','completed','cancelled'] as $s)
                <option value="{{ $s }}" @selected(request('status') == $s)>{{ __($s) }}</option>
            @endforeach
        </select>
        <button class="btn btn-success-er btn-sm"><i class="bi bi-funnel"></i></button>
    </form>
</div>

<div class="card"><div class="card-body p-0">
<div class="table-responsive">
<table class="table table-hover mb-0">
    <thead class="table-light">
        <tr><th>{{ __('Kode') }}</th><th>{{ __('Pelanggan') }}</th><th>{{ __('Mobil') }}</th><th>{{ __('Tanggal') }}</th><th>{{ __('Total') }}</th><th>{{ __('Status') }}</th><th>{{ __('Aksi') }}</th></tr>
    </thead>
    <tbody>
        @forelse($bookings as $b)
        <tr>
            <td class="fw-bold"><a href="{{ route('admin.bookings.show', $b) }}">{{ $b->booking_code }}</a></td>
            <td>{{ $b->customer->name ?? '-' }}</td>
            <td>{{ $b->car->name ?? ($b->tourPackage->name ?? '-') }}</td>
            <td>{{ $b->start_date->format('d/m/Y') }} - {{ $b->end_date->format('d/m/Y') }}</td>
            <td>Rp {{ number_format($b->total_price, 0, ',', '.') }}</td>
            <td><span class="badge rounded-pill bg-{{ match($b->status) { 'pending'=>'secondary', 'waiting_payment'=>'warning', 'confirmed'=>'primary', 'in_progress'=>'info', 'completed'=>'success', 'cancelled'=>'danger', default=>'secondary' } }}">{{ __($b->status) }}</span></td>
            <td><a href="{{ route('admin.bookings.show', $b) }}" class="btn btn-sm btn-outline-success"><i class="bi bi-eye"></i></a></td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center py-5"><div class="d-flex flex-column align-items-center"><i class="bi bi-inbox text-muted" style="font-size:3rem;opacity:0.4;"></i><p class="text-muted mt-2 mb-0">{{ __('Belum ada pesanan ditemukan') }}</p></div></td></tr>
        @endforelse
    </tbody>
</table>
</div></div></div>
<div class="mt-3 d-flex justify-content-center">{{ $bookings->links() }}</div>
@endsection
