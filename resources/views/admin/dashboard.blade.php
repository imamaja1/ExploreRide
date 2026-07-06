@extends('layouts.admin')
@section('title', __('Dashboard'))
@section('content')
<div class="page-title-border">
    <h4 class="page-title">{{ __('Dashboard') }}</h4>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card bg-success text-white h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div><div class="number">{{ $stats['total_bookings'] }}</div><div>{{ __('Total Pesanan') }}</div></div>
                <i class="bi bi-calendar-check fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-warning text-dark h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div><div class="number">{{ $stats['pending_bookings'] + $stats['waiting_payment'] }}</div><div>{{ __('Menunggu') }}</div></div>
                <i class="bi bi-hourglass-split fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-info text-white h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div><div class="number">{{ $stats['active_bookings'] }}</div><div>{{ __('Berjalan') }}</div></div>
                <i class="bi bi-play-circle fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-success text-white h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div><div class="number">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div><div>{{ __('Pendapatan') }}</div></div>
                <i class="bi bi-cash-stack fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-8">
        <div class="card h-100">
            <div class="card-header"><i class="bi bi-graph-up"></i> {{ __('Pesanan 7 Hari Terakhir') }}</div>
            <div class="card-body"><canvas id="dailyChart" height="200"></canvas></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header"><i class="bi bi-pie-chart"></i> {{ __('Status Pesanan') }}</div>
            <div class="card-body"><canvas id="statusChart" height="240"></canvas></div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header"><i class="bi bi-box"></i> {{ __('Sumber Daya') }}</div>
            <div class="card-body">
                <div class="row text-center g-3">
                    <div class="col-4">
                        <div class="p-3 rounded bg-light">
                            <div class="fs-2 fw-bold text-success">{{ $stats['total_cars'] }}</div>
                            <small class="text-muted">{{ __('Mobil Aktif') }}</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 rounded bg-light">
                            <div class="fs-2 fw-bold text-info">{{ $stats['total_drivers'] }}</div>
                            <small class="text-muted">{{ __('Driver Aktif') }}</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 rounded bg-light">
                            <div class="fs-2 fw-bold text-warning">{{ $stats['total_destinations'] }}</div>
                            <small class="text-muted">{{ __('Destinasi') }}</small>
                        </div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-6">
                        <div class="p-3 rounded bg-light">
                            <div class="fs-2 fw-bold text-primary">{{ $stats['total_packages'] }}</div>
                            <small class="text-muted">{{ __('Paket Wisata') }}</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded bg-light">
                            <div class="fs-2 fw-bold text-secondary">{{ $stats['completed_bookings'] }}</div>
                            <small class="text-muted">{{ __('Selesai') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header"><i class="bi bi-list-check"></i> {{ __('Ringkasan Status') }}</div>
            <div class="card-body">
                @php
                    $summaryStatuses = [
                        ['label' => __('Pending'), 'count' => $stats['pending_bookings'], 'color' => 'secondary'],
                        ['label' => __('Menunggu Pembayaran'), 'count' => $stats['waiting_payment'], 'color' => 'warning'],
                        ['label' => __('Dikonfirmasi'), 'count' => $stats['confirmed_bookings'], 'color' => 'primary'],
                        ['label' => __('Berjalan'), 'count' => $stats['in_progress_bookings'], 'color' => 'info'],
                        ['label' => __('Selesai'), 'count' => $stats['completed_bookings'], 'color' => 'success'],
                        ['label' => __('Dibatalkan'), 'count' => $stats['cancelled_bookings'], 'color' => 'danger'],
                    ];
                    $maxCount = max(array_column($summaryStatuses, 'count'));
                @endphp
                @foreach($summaryStatuses as $s)
                <div class="d-flex align-items-center mb-3">
                    <span class="badge rounded-pill bg-{{ $s['color'] }} me-2" style="width: 16px; height: 16px; border-radius: 4px;">&nbsp;</span>
                    <div class="flex-grow-1">{{ $s['label'] }}</div>
                    <div class="fw-bold ms-2">{{ $s['count'] }}</div>
                    <div class="ms-3" style="width: 120px;">
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-{{ $s['color'] }}" style="width: {{ $maxCount > 0 ? ($s['count'] / $maxCount) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>{{ __('Kode') }}</th>
                        <th>{{ __('Pelanggan') }}</th>
                        <th>{{ __('Mobil / Paket') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Driver') }}</th>
                        <th>{{ __('Aksi') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBookings as $booking)
                    <tr>
                        <td class="fw-bold">{{ $booking->booking_code }}</td>
                        <td>{{ $booking->customer->name ?? '-' }}</td>
                        <td>{{ $booking->car->name ?? $booking->tourPackage->name ?? '-' }}</td>
                        <td>
                            @php $b = match($booking->status) { 'pending' => 'secondary', 'waiting_payment' => 'warning', 'confirmed' => 'primary', 'in_progress' => 'info', 'completed' => 'success', 'cancelled' => 'danger', default => 'secondary' }; @endphp
                            <span class="badge rounded-pill bg-{{ $b }}">{{ __($booking->status) }}</span>
                        </td>
                        <td>{{ $booking->driver->name ?? '-' }}</td>
                        <td><a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-outline-success">{{ __('Detail') }}</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-3">{{ __('Belum ada pesanan') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    new Chart(document.getElementById('dailyChart'), {
        type: 'bar',
        data: {
            labels: @json($dailyLabels),
            datasets: [{
                label: '{{ __("Pesanan") }}',
                data: @json($dailyData),
                backgroundColor: '#198754',
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });

    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
                labels: @json($statusLabelsTranslated),
            datasets: [{
                data: @json($statusData),
                backgroundColor: @json($statusColors),
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom', labels: { padding: 12, boxWidth: 12 } }
            }
        }
    });
});
</script>
@endpush
