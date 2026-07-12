@extends('layouts.driver')
@section('title', __('Riwayat Tugas'))
@section('content')
<h4 class="fw-bold mb-4"><i class="bi bi-calendar-check"></i> {{ __('Riwayat Tugas') }}</h4>
<div class="card"><div class="card-body p-0">
<div class="table-responsive">
<table class="table table-hover mb-0">
    <caption class="d-none">{{ __('Riwayat tugas pengemudi') }}</caption>
    <thead class="table-light">
        <tr>
            <th scope="col">{{ __('Kode') }}</th>
            <th scope="col">{{ __('Pelanggan') }}</th>
            <th scope="col">{{ __('Mobil') }}</th>
            <th scope="col">{{ __('Tanggal') }}</th>
            <th scope="col">{{ __('Total') }}</th>
            <th scope="col">{{ __('Status') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse($bookings as $booking)
        <tr>
            <td class="fw-bold">{{ $booking->booking_code }}</td>
            <td>{{ $booking->customer?->name }}</td>
            <td>{{ $booking->car?->brand }} {{ $booking->car?->name }}</td>
            <td>{{ $booking->start_date }} ({{ $booking->duration_days }} {{ __('hari') }})</td>
            <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
            <td>
                @php $bs = $booking->getStatusBadgeStyle(); @endphp
                <span class="badge" style="background:{{ $bs['bg'] }};color:{{ $bs['color'] }};">{{ __($booking->status) }}</span>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center py-3">{{ __('Belum ada tugas') }}</td></tr>
        @endforelse
    </tbody>
</table>
</div></div></div>
<div class="mt-3 d-flex justify-content-center">{{ $bookings->links() }}</div>
@endsection
