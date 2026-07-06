@extends('layouts.admin')
@section('title', __('Pesanan'))
@section('content')
<div class="page-title-border">
    <h4 class="page-title">{{ __('Semua Pesanan') }}</h4>
</div>

<div class="card"><div class="card-body p-0">
<div class="table-responsive">
<table class="table table-hover mb-0">
    <thead class="table-light">
        <tr>
            <th>{{ __('Kode') }}</th>
            <th>{{ __('Pelanggan') }}</th>
            <th>{{ __('Mobil') }}</th>
            <th>{{ __('Tanggal') }}</th>
            <th>{{ __('Total') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Aksi') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse($bookings as $b)
        <tr>
            <td class="fw-bold"><a href="{{ route('admin.bookings.show', $b) }}">{{ $b->booking_code }}</a></td>
            <td>{{ $b->customer->name ?? '-' }}</td>
            <td>{{ $b->car->name ?? ($b->tourPackage->name ?? '-') }}</td>
            <td>{{ $b->start_date->format('d/m/Y') }} - {{ $b->end_date->format('d/m/Y') }}</td>
            <td>Rp {{ number_format($b->total_price, 0, ',', '.') }}</td>
            <td>
                @php
                    $badge = match($b->status) {
                        'pending' => 'secondary',
                        'waiting_payment' => 'warning',
                        'confirmed' => 'primary',
                        'in_progress' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'secondary',
                    };
                @endphp
                <span class="badge rounded-pill bg-{{ $badge }}">{{ __($b->status) }}</span>
            </td>
            <td>
                <a href="{{ route('admin.bookings.show', $b) }}" class="btn btn-sm btn-outline-success"><i class="bi bi-eye"></i></a>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center text-muted py-4">{{ __('Belum ada pesanan') }}</td></tr>
        @endforelse
    </tbody>
</table>
</div></div></div>
<div class="mt-3 d-flex justify-content-center">{{ $bookings->links() }}</div>
@endsection
