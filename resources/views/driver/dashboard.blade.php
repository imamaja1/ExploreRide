@extends('layouts.driver')
@section('title', __('Dashboard'))
@section('content')
<h4 class="fw-bold mb-4"><i class="bi bi-speedometer2"></i> {{ __('Dashboard Driver') }}</h4>

<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="stat-card"><div class="number">{{ $stats['total'] }}</div><div>{{ __('Total Tugas') }}</div></div></div>
    <div class="col-md-3"><div class="stat-card bg-primary text-white"><div class="number">{{ $stats['confirmed'] }}</div><div>{{ __('Dikonfirmasi') }}</div></div></div>
    <div class="col-md-3"><div class="stat-card bg-warning text-dark"><div class="number">{{ $stats['in_progress'] }}</div><div>{{ __('Berjalan') }}</div></div></div>
    <div class="col-md-3"><div class="stat-card bg-secondary text-white"><div class="number">{{ $stats['completed'] }}</div><div>{{ __('Selesai') }}</div></div></div>
</div>

<div class="card">
    <div class="card-header bg-success text-white"><h5 class="mb-0">{{ __('Tugas Saya') }}</h5></div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr><th>{{ __('Kode') }}</th><th>{{ __('Pelanggan') }}</th><th>{{ __('Mobil') }}</th><th>{{ __('Tanggal') }}</th><th>{{ __('Status') }}</th><th>{{ __('Aksi') }}</th></tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr>
                        <td class="fw-bold">{{ $booking->booking_code }}</td>
                        <td>{{ $booking->customer->name }}</td>
                        <td>{{ $booking->car->brand }} {{ $booking->car->name }}</td>
                        <td>{{ $booking->start_date }} ({{ $booking->duration_days }} {{ __('hari') }})</td>
                        <td>
                            @php $b = match($booking->status) { 'confirmed' => 'success', 'in_progress' => 'primary', 'completed' => 'secondary', default => 'warning' }; @endphp
                            <span class="badge bg-{{ $b }}">{{ __($booking->status) }}</span>
                        </td>
                        <td>
                            @if($booking->status == 'confirmed')
                            <form method="POST" action="{{ route('driver.bookings.status', $booking->id) }}" class="d-inline">
                                @csrf
                                <input type="hidden" name="status" value="in_progress">
                                <button class="btn btn-sm btn-primary">{{ __('Mulai') }}</button>
                            </form>
                            @endif
                            @if($booking->status == 'in_progress')
                            <form method="POST" action="{{ route('driver.bookings.status', $booking->id) }}" class="d-inline">
                                @csrf
                                <input type="hidden" name="status" value="completed">
                                <button class="btn btn-sm btn-success">{{ __('Selesai') }}</button>
                            </form>
                            @endif
                            @if($booking->status == 'completed')
                            <span class="text-muted">{{ __('Selesai') }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-3">{{ __('Belum ada tugas') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
