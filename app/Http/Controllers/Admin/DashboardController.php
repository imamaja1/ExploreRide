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
        $stats = [
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'waiting_payment' => Booking::where('status', 'waiting_payment')->count(),
            'active_bookings' => Booking::whereIn('status', ['confirmed', 'in_progress'])->count(),
            'completed_bookings' => Booking::where('status', 'completed')->count(),
            'cancelled_bookings' => Booking::where('status', 'cancelled')->count(),
            'total_cars' => Car::where('is_active', true)->count(),
            'total_drivers' => User::where('role', 'driver')->where('is_active', true)->count(),
            'total_destinations' => Destination::where('is_active', true)->count(),
            'total_packages' => TourPackage::where('is_active', true)->count(),
            'total_revenue' => Booking::whereIn('status', ['completed', 'confirmed'])->sum('total_price'),
            'confirmed_bookings' => Booking::where('status', 'confirmed')->count(),
            'in_progress_bookings' => Booking::where('status', 'in_progress')->count(),
        ];

        $recentBookings = Booking::with(['customer', 'car', 'service', 'driver'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $statusLabels = ['pending', 'waiting_payment', 'confirmed', 'in_progress', 'completed', 'cancelled'];
        $statusColors = ['#6c757d', '#ffc107', '#0d6efd', '#0dcaf0', '#198754', '#dc3545'];
        $statusLabelsTranslated = array_map(function($l) { return __($l); }, $statusLabels);
        $statusData = [];
        foreach ($statusLabels as $s) {
            $statusData[] = Booking::where('status', $s)->count();
        }

        $dailyLabels = [];
        $dailyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dailyLabels[] = now()->subDays($i)->format('d/m');
            $dailyData[] = Booking::whereDate('created_at', $date)->count();
        }

        return view('admin.dashboard', compact(
            'stats', 'recentBookings',
            'statusLabels', 'statusColors', 'statusData',
            'dailyLabels', 'dailyData', 'statusLabelsTranslated'
        ));
    }
}
