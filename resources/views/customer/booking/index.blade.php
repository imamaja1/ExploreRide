@extends('layouts.app')
@section('title', __('Pesanan Saya'))
@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">{{ __('Pesanan Saya') }}</h2>

    @if($bookings->count() > 0)
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>{{ __('Kode') }}</th>
                    <th>{{ __('Mobil') }}</th>
                    <th>{{ __('Tanggal') }}</th>
                    <th>{{ __('Total') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Aksi') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                <tr>
                    <td class="fw-bold">{{ $booking->booking_code }}</td>
                    <td>{{ $booking->car?->brand }} {{ $booking->car?->name }}</td>
                    <td>{{ $booking->start_date }} ({{ $booking->duration_days }} {{ __('hari') }})</td>
                    <td>{{ __('Rp') }} {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                    <td>
                        @php
                            $badge = match($booking->status) {
                                'pending' => 'warning',
                                'waiting_payment' => 'info',
                                'confirmed' => 'success',
                                'in_progress' => 'primary',
                                'completed' => 'secondary',
                                'cancelled' => 'danger',
                                default => 'secondary',
                            };
                        @endphp
                        <span class="badge bg-{{ $badge }}">{{ __($booking->status) }}</span>
                    </td>
                    <td>
                        <a href="{{ route('booking.detail', $booking->id) }}" class="btn btn-sm btn-success">
                            {{ __('Detail') }}
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">{{ $bookings->links() }}</div>
    @else
    <div class="text-center py-5">
        <i class="bi bi-calendar-x text-muted" style="font-size: 4rem;"></i>
        <h4 class="mt-3">{{ __('Belum ada pesanan') }}</h4>
        <a href="{{ route('cars') }}" class="btn btn-success mt-2">{{ __('Pesan Sekarang') }}</a>
    </div>
    @endif
</div>
@endsection
