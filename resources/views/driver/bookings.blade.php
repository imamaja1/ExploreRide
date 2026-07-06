@extends('layouts.driver')
@section('title', __('Riwayat Tugas'))
@section('content')
<h4 class="fw-bold mb-4"><i class="bi bi-calendar-check"></i> {{ __('Riwayat Tugas') }}</h4>
<div class="card"><div class="card-body p-0">
<div class="table-responsive">
<table class="table table-hover mb-0">
    <thead class="table-light">
        <tr><th>{{ __('Kode') }}</th><th>{{ __('Pelanggan') }}</th><th>{{ __('Mobil') }}</th><th>{{ __('Tanggal') }}</th><th>{{ __('Total') }}</th><th>{{ __('Status') }}</th></tr>
    </thead>
    <tbody>
        @forelse($bookings as $booking)
        <tr>
            <td class="fw-bold">{{ $booking->booking_code }}</td>
            <td>{{ $booking->customer->name }}</td>
            <td>{{ $booking->car->brand }} {{ $booking->car->name }}</td>
            <td>{{ $booking->start_date }} ({{ $booking->duration_days }} {{ __('hari') }})</td>
            <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
            <td>
                @php $b = match($booking->status) { 'confirmed' => 'success', 'in_progress' => 'primary', 'completed' => 'secondary', default => 'warning' }; @endphp
                <span class="badge bg-{{ $b }}">{{ __($booking->status) }}</span>
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
