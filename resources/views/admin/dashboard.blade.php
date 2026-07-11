@extends('layouts.admin')
@section('title', __('Dashboard'))
@section('content')
<div class="page-header">
    <h4>{{ __('Dashboard') }}</h4>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">{{ __('Total Pesanan') }}</div>
                <div class="stat-number">{{ $stats['total_bookings'] }}</div>
            </div>
            <div class="stat-icon" style="background: #dbeafe; color: #2563eb;">
                <i class="bi bi-receipt"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">{{ __('Menunggu') }}</div>
                <div class="stat-number">{{ $stats['pending_bookings'] + $stats['waiting_payment'] }}</div>
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
                <div class="stat-number">{{ $stats['active_bookings'] }}</div>
            </div>
            <div class="stat-icon" style="background: #e0e7ff; color: #4f46e5;">
                <i class="bi bi-play-circle"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">{{ __('Pendapatan') }}</div>
                <div class="stat-number">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
            </div>
            <div class="stat-icon" style="background: #d1fae5; color: #059669;">
                <i class="bi bi-cash-stack"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-8">
        <div class="card h-100">
            <div class="card-header"><i class="bi bi-graph-up me-2"></i>{{ __('Pesanan 7 Hari Terakhir') }}</div>
            <div class="card-body"><canvas id="dailyChart" height="200"></canvas></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header"><i class="bi bi-pie-chart me-2"></i>{{ __('Status Pesanan') }}</div>
            <div class="card-body"><canvas id="statusChart" height="240"></canvas></div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header"><i class="bi bi-box me-2"></i>{{ __('Sumber Daya') }}</div>
            <div class="card-body">
                <div class="row text-center g-3">
                    <div class="col-4">
                        <div class="p-3 rounded" style="background: var(--gray-50);">
                            <div class="fs-2 fw-bold" style="color: var(--primary);">{{ $stats['total_cars'] }}</div>
                            <small class="text-muted">{{ __('Mobil Aktif') }}</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 rounded" style="background: var(--gray-50);">
                            <div class="fs-2 fw-bold" style="color: #8b5cf6;">{{ $stats['total_drivers'] }}</div>
                            <small class="text-muted">{{ __('Driver Aktif') }}</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 rounded" style="background: var(--gray-50);">
                            <div class="fs-2 fw-bold" style="color: #f59e0b;">{{ $stats['total_destinations'] }}</div>
                            <small class="text-muted">{{ __('Destinasi') }}</small>
                        </div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-6">
                        <div class="p-3 rounded" style="background: var(--gray-50);">
                            <div class="fs-2 fw-bold" style="color: #10b981;">{{ $stats['total_packages'] }}</div>
                            <small class="text-muted">{{ __('Paket Wisata') }}</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded" style="background: var(--gray-50);">
                            <div class="fs-2 fw-bold" style="color: var(--gray-500);">{{ $stats['completed_bookings'] }}</div>
                            <small class="text-muted">{{ __('Selesai') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header"><i class="bi bi-list-check me-2"></i>{{ __('Ringkasan Status') }}</div>
            <div class="card-body">
                @php
                    $summaryStatuses = [
                        ['label' => __('Pending'), 'count' => $stats['pending_bookings'], 'color' => '#6b7280'],
                        ['label' => __('Menunggu Pembayaran'), 'count' => $stats['waiting_payment'], 'color' => '#f59e0b'],
                        ['label' => __('Dikonfirmasi'), 'count' => $stats['confirmed_bookings'], 'color' => '#2563eb'],
                        ['label' => __('Berjalan'), 'count' => $stats['in_progress_bookings'], 'color' => '#8b5cf6'],
                        ['label' => __('Selesai'), 'count' => $stats['completed_bookings'], 'color' => '#10b981'],
                        ['label' => __('Dibatalkan'), 'count' => $stats['cancelled_bookings'], 'color' => '#ef4444'],
                    ];
                    $maxCount = max(array_column($summaryStatuses, 'count'));
                @endphp
                @foreach($summaryStatuses as $s)
                <div class="d-flex align-items-center mb-3">
                    <span style="width: 10px; height: 10px; border-radius: 3px; background: {{ $s['color'] }}; flex-shrink: 0;"></span>
                    <div class="flex-grow-1 ms-2" style="font-size: 0.85rem;">{{ $s['label'] }}</div>
                    <div class="fw-semibold ms-2" style="font-size: 0.85rem;">{{ $s['count'] }}</div>
                    <div class="ms-3" style="width: 100px;">
                        <div style="height: 6px; background: var(--gray-100); border-radius: 3px;">
                            <div style="height: 100%; width: {{ $maxCount > 0 ? ($s['count'] / $maxCount) * 100 : 0 }}%; background: {{ $s['color'] }}; border-radius: 3px;"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header"><i class="bi bi-clock-history me-2"></i>{{ __('Pesanan Terbaru') }}</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table">
                <thead>
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
                        <td class="fw-semibold">{{ $booking->booking_code }}</td>
                        <td>{{ $booking->customer?->name ?? '-' }}</td>
                        <td>{{ $booking->car?->name ?? $booking->tourPackage?->name ?? '-' }}</td>
                        <td>
                            @php $bs = $booking->getStatusBadgeStyle(); @endphp
                            <span class="badge" style="background:{{ $bs['bg'] }};color:{{ $bs['color'] }};">{{ __($booking->status) }}</span>
                        </td>
                        <td>{{ $booking->driver?->name ?? '-' }}</td>
                        <td><a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-outline-gray">{{ __('Detail') }}</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">{{ __('Belum ada pesanan') }}</td></tr>
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
                backgroundColor: '#0ea5e9',
                borderRadius: 6,
                barThickness: 28,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f3f4f6' } },
                x: { grid: { display: false } }
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
                spacing: 2,
            }]
        },
        options: {
            responsive: true,
            cutout: '65%',
            plugins: {
                legend: { position: 'bottom', labels: { padding: 12, boxWidth: 10, font: { size: 11 } } }
            }
        }
    });
});
</script>
@endpush
