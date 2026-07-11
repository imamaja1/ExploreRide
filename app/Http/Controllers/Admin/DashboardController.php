<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Car;
use App\Models\User;
use App\Models\Destination;
use App\Models\TourPackage;

class DashboardController extends Controller
{
    public function index()
    {
        $statusCounts = Booking::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $stats = [
            'total_bookings'       => $statusCounts->sum(),
            'pending_bookings'     => $statusCounts->get('pending', 0),
            'waiting_payment'      => $statusCounts->get('waiting_payment', 0),
            'confirmed_bookings'   => $statusCounts->get('confirmed', 0),
            'in_progress_bookings' => $statusCounts->get('in_progress', 0),
            'completed_bookings'   => $statusCounts->get('completed', 0),
            'cancelled_bookings'   => $statusCounts->get('cancelled', 0),
            'active_bookings'      => $statusCounts->get('confirmed', 0) + $statusCounts->get('in_progress', 0),
            'total_cars'           => Car::active()->count(),
            'total_drivers'        => User::where('role', 'driver')->where('is_active', true)->count(),
            'total_destinations'   => Destination::active()->count(),
            'total_packages'       => TourPackage::active()->count(),
            'total_revenue'        => Booking::whereIn('status', ['completed', 'confirmed'])->sum('total_price'),
        ];

        $recentBookings = Booking::with(['customer', 'car', 'service', 'driver', 'tourPackage'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $statusLabels = Booking::STATUSES;
        $statusColors = ['#6c757d', '#ffc107', '#0d6efd', '#0dcaf0', '#198754', '#dc3545'];
        $statusLabelsTranslated = array_map(fn($l) => __($l), $statusLabels);
        $statusData = array_map(fn($s) => $statusCounts->get($s, 0), $statusLabels);

        $startDate = now()->subDays(6)->startOfDay();
        $dailyCounts = Booking::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('DATE(created_at)')
            ->pluck('count', 'date');

        $dailyLabels = [];
        $dailyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dailyLabels[] = now()->subDays($i)->format('d/m');
            $dailyData[] = $dailyCounts->get($date, 0);
        }

        return view('admin.dashboard', compact(
            'stats', 'recentBookings',
            'statusLabels', 'statusColors', 'statusData',
            'dailyLabels', 'dailyData', 'statusLabelsTranslated'
        ));
    }
}
