<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Notifications\BookingConfirmed;
use App\Notifications\DriverAssigned;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $bookings = Booking::with(['customer', 'car', 'service', 'driver', 'tourPackage']);

        if ($request->filled('search')) {
            $search = addcslashes($request->search, '%_');
            $bookings->where(function($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $bookings->where('status', $request->status);
        }

        $bookings = $bookings->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

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
        $booking = Booking::with(['car', 'customer'])->findOrFail($id);

        if ($booking->status !== 'waiting_payment') {
            return back()->withErrors(['status' => __('Hanya pesanan dengan status menunggu pembayaran yang bisa dikonfirmasi.')]);
        }

        if (!$booking->payment) {
            return back()->withErrors(['payment' => __('Bukti pembayaran belum diupload.')]);
        }

        DB::transaction(function () use ($booking) {
            $booking->payment->forceFill([
                'status' => 'verified',
                'verified_by' => auth()->id(),
                'verified_at' => now(),
            ])->save();

            $booking->forceFill(['status' => 'confirmed'])->save();

            if ($booking->customer) {
                $booking->customer->notify(new BookingConfirmed($booking));
            }
        });

        return redirect()->back()->with('success', 'Pembayaran dikonfirmasi! Notifikasi terkirim ke pelanggan.');
    }

    public function assignDriver(Request $request, $id)
    {
        $data = $request->validate([
            'driver_id' => 'required|exists:users,id',
        ]);

        $driver = User::where('id', $data['driver_id'])->where('role', 'driver')->where('is_active', true)->first();
        if (!$driver) {
            return back()->withErrors(['driver_id' => __('Driver tidak valid atau tidak aktif.')]);
        }

        $booking = Booking::with(['car', 'customer'])->findOrFail($id);

        if (!in_array($booking->status, ['confirmed', 'pending'])) {
            return back()->withErrors(['status' => __('Hanya pesanan yang sudah dikonfirmasi atau pending yang bisa ditugaskan driver.')]);
        }

        DB::transaction(function () use ($booking, $data) {
            $booking->forceFill([
                'driver_id' => $data['driver_id'],
                'status' => 'confirmed',
            ])->save();

            $driver = User::find($data['driver_id']);
            if ($driver) {
                $driver->notify(new DriverAssigned($booking));
            }
        });

        return redirect()->back()->with('success', 'Sopir berhasil ditugaskan! Notifikasi terkirim ke driver.');
    }

    public function cancel(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        if (in_array($booking->status, ['completed', 'cancelled'])) {
            return back()->withErrors(['status' => __('Pesanan yang sudah selesai atau dibatalkan tidak bisa diubah.')]);
        }

        $booking->forceFill(['status' => 'cancelled'])->save();

        return redirect()->back()->with('success', 'Pesanan dibatalkan');
    }
}
