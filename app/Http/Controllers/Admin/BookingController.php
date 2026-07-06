<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Notifications\BookingConfirmed;
use App\Notifications\DriverAssigned;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['customer', 'car', 'service', 'driver'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $statuses = ['pending', 'waiting_payment', 'confirmed', 'in_progress', 'completed', 'cancelled'];

        return view('admin.bookings.index', compact('bookings', 'statuses'));
    }

    public function show($id)
    {
        $booking = Booking::with(['customer', 'car', 'service', 'tourPackage', 'driver', 'payment.bank'])->findOrFail($id);
        $drivers = User::where('role', 'driver')->where('is_active', true)->get();
        return view('admin.bookings.show', compact('booking', 'drivers'));
    }

    public function confirmPayment(Request $request, $id)
    {
        $booking = Booking::with('car')->findOrFail($id);

        if ($booking->payment) {
            $booking->payment->update([
                'status' => 'verified',
                'verified_by' => auth()->id(),
                'verified_at' => now(),
            ]);
        }

        $booking->update(['status' => 'confirmed']);

        $booking->customer->notify(new BookingConfirmed($booking));

        return redirect()->back()->with('success', 'Pembayaran dikonfirmasi! Notifikasi terkirim ke pelanggan.');
    }

    public function assignDriver(Request $request, $id)
    {
        $data = $request->validate([
            'driver_id' => 'required|exists:users,id',
        ]);

        $booking = Booking::with(['car', 'customer'])->findOrFail($id);
        $booking->update([
            'driver_id' => $data['driver_id'],
            'status' => 'confirmed',
        ]);

        $driver = User::find($data['driver_id']);
        $driver->notify(new DriverAssigned($booking));

        return redirect()->back()->with('success', 'Sopir berhasil ditugaskan! Notifikasi terkirim ke driver.');
    }

    public function cancel(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Pesanan dibatalkan');
    }
}
