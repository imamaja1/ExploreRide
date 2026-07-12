<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Notifications\TripCompleted;
use App\Notifications\TripStarted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        $baseQuery = Booking::where('driver_id', auth()->id());

        $stats = [
            'total' => (clone $baseQuery)->count(),
            'confirmed' => (clone $baseQuery)->where('status', 'confirmed')->count(),
            'in_progress' => (clone $baseQuery)->where('status', 'in_progress')->count(),
            'completed' => $baseQuery->where('status', 'completed')->count(),
        ];

        $bookings = Booking::with(['customer', 'car'])
            ->where('driver_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('driver.dashboard', compact('bookings', 'stats'));
    }

    public function bookings()
    {
        $bookings = Booking::with(['customer', 'car'])
            ->where('driver_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('driver.bookings', compact('bookings'));
    }

    public function updateStatus(Request $request, $id)
    {
        $data = $request->validate([
            'status' => 'required|in:in_progress,completed',
        ]);

        $booking = Booking::with('customer')->where('driver_id', auth()->id())->findOrFail($id);

        $validTransitions = [
            'confirmed' => ['in_progress'],
            'in_progress' => ['completed'],
        ];

        $allowed = $validTransitions[$booking->status] ?? [];

        if (! in_array($data['status'], $allowed)) {
            return back()->withErrors(['status' => __('Transisi status tidak valid.')]);
        }

        $booking->forceFill(['status' => $data['status']])->save();

        try {
            $admins = User::where('role', 'admin')->get();
            $notification = match ($data['status']) {
                'in_progress' => new TripStarted($booking),
                'completed' => new TripCompleted($booking),
                default => null,
            };

            if ($notification) {
                foreach ($admins as $admin) {
                    $admin->notify($notification);
                }

                if ($booking->customer) {
                    $booking->customer->notify($notification);
                }
            }
        } catch (\Exception $e) {
            Log::error('WA notification failed on driver status update: '.$e->getMessage());
        }

        return redirect()->back()->with('success', __('Status berhasil diupdate'));
    }
}
