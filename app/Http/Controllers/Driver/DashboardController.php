<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['customer', 'car'])
            ->where('driver_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total' => $bookings->count(),
            'confirmed' => $bookings->where('status', 'confirmed')->count(),
            'in_progress' => $bookings->where('status', 'in_progress')->count(),
            'completed' => $bookings->where('status', 'completed')->count(),
        ];

        return view('driver.dashboard', compact('bookings', 'stats'));
    }

    public function bookings()
    {
        $bookings = Booking::with(['customer', 'car', 'service'])
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

        $booking = Booking::where('driver_id', auth()->id())->findOrFail($id);

        $validTransitions = [
            'confirmed' => ['in_progress'],
            'in_progress' => ['completed'],
        ];

        $allowed = $validTransitions[$booking->status] ?? [];

        if (!in_array($data['status'], $allowed)) {
            return back()->withErrors(['status' => __('Transisi status tidak valid.')]);
        }

        $booking->update(['status' => $data['status']]);

        return redirect()->back()->with('success', 'Status berhasil diupdate');
    }
}
