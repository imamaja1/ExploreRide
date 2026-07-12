@extends('layouts.driver')
@section('title', __('Dashboard'))
@section('content')
<h4 class="fw-bold mb-4"><i class="bi bi-speedometer2"></i> {{ __('Dashboard Driver') }}</h4>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">{{ __('Total Tugas') }}</div>
                <div class="stat-number">{{ $stats['total'] }}</div>
            </div>
            <div class="stat-icon" style="background: #dbeafe; color: #2563eb;">
                <i class="bi bi-list-task"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">{{ __('Dikonfirmasi') }}</div>
                <div class="stat-number">{{ $stats['confirmed'] }}</div>
            </div>
            <div class="stat-icon" style="background: #fef3c7; color: #d97706;">
                <i class="bi bi-hourglass-split"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">{{ __('Berjalan') }}</div>
                <div class="stat-number">{{ $stats['in_progress'] }}</div>
            </div>
            <div class="stat-icon" style="background: #e0e7ff; color: #4f46e5;">
                <i class="bi bi-play-circle"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">{{ __('Selesai') }}</div>
                <div class="stat-number">{{ $stats['completed'] }}</div>
            </div>
            <div class="stat-icon" style="background: #d1fae5; color: #059669;">
                <i class="bi bi-check-circle"></i>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header"><i class="bi bi-list-task me-2"></i>{{ __('Tugas Saya') }}</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table">
                <caption class="d-none">{{ __('Daftar tugas pengemudi') }}</caption>
                <thead>
                    <tr>
                        <th>{{ __('Kode') }}</th>
                        <th>{{ __('Pelanggan') }}</th>
                        <th>{{ __('Mobil') }}</th>
                        <th>{{ __('Tanggal') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Aksi') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr>
                        <td class="fw-semibold">{{ $booking->booking_code }}</td>
                        <td>{{ $booking->customer?->name ?? '-' }}</td>
                        <td>{{ $booking->car?->brand }} {{ $booking->car?->name }}</td>
                        <td>{{ $booking->start_date }} ({{ $booking->duration_days }} {{ __('hari') }})</td>
                        <td>
                            @php $bs = $booking->getStatusBadgeStyle(); @endphp
                            <span class="badge" style="background:{{ $bs['bg'] }};color:{{ $bs['color'] }};">{{ __($booking->status) }}</span>
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
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">{{ __('Belum ada tugas') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
