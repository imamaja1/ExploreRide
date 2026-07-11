@extends('layouts.admin')
@section('title', __('Pesanan'))
@section('content')
<div class="page-header">
    <h4>{{ __('Semua Pesanan') }}</h4>
</div>
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex gap-2">
        @if(request('search') || request('status'))
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-gray btn-sm"><i class="bi bi-x-lg"></i> {{ __('Reset') }}</a>
        @endif
    </div>
    <form method="GET" class="d-flex gap-2">
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-search text-muted"></i></span>
            <input type="text" name="search" class="form-control" style="min-width:200px;" placeholder="{{ __('Cari kode booking...') }}" value="{{ request('search') }}">
        </div>
        <select name="status" class="form-select" style="width:auto;min-width:140px;">
            <option value="">{{ __('Semua Status') }}</option>
            @foreach(['pending','waiting_payment','confirmed','in_progress','completed','cancelled'] as $s)
                <option value="{{ $s }}" @selected(request('status') == $s)>{{ __($s) }}</option>
            @endforeach
        </select>
        <button class="btn btn-primary btn-sm"><i class="bi bi-funnel"></i></button>
    </form>
</div>

<div class="card"><div class="card-body p-0">
<div class="table-responsive">
<table class="table">
    <thead>
        <tr><th>{{ __('Kode') }}</th><th>{{ __('Pelanggan') }}</th><th>{{ __('Mobil') }}</th><th>{{ __('Tanggal') }}</th><th>{{ __('Total') }}</th><th>{{ __('Status') }}</th><th>{{ __('Aksi') }}</th></tr>
    </thead>
    <tbody>
        @forelse($bookings as $b)
        <tr>
            <td class="fw-bold"><a href="{{ route('admin.bookings.show', $b) }}" style="color: var(--primary); text-decoration: none;">{{ $b->booking_code }}</a></td>
            <td>{{ $b->customer?->name ?? '-' }}</td>
            <td>{{ $b->car?->name ?? ($b->tourPackage?->name ?? '-') }}</td>
            <td>{{ $b->start_date->format('d/m/Y') }} - {{ $b->end_date->format('d/m/Y') }}</td>
            <td>Rp {{ number_format($b->total_price, 0, ',', '.') }}</td>
            <td>
                @php $bs = $b->getStatusBadgeStyle(); @endphp
                <span class="badge" style="background:{{ $bs['bg'] }};color:{{ $bs['color'] }};">{{ __($b->status) }}</span>
            </td>
            <td><a href="{{ route('admin.bookings.show', $b) }}" class="btn btn-sm btn-outline-gray"><i class="bi bi-eye"></i></a></td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center py-5"><div class="d-flex flex-column align-items-center"><i class="bi bi-inbox text-muted" style="font-size:3rem;opacity:0.4;"></i><p class="text-muted mt-2 mb-0">{{ __('Belum ada pesanan ditemukan') }}</p></div></td></tr>
        @endforelse
    </tbody>
</table>
</div></div></div>
<div class="mt-3">{{ $bookings->links() }}</div>
@endsection
