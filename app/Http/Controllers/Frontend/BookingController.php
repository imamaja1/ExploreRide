<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Car;
use App\Models\Service;
use App\Models\TourPackage;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function create()
    {
        $services = Service::where('is_active', true)->get();
        $cars = Car::where('is_active', true)->get();
        $packages = TourPackage::where('is_active', true)->get();
        return view('customer.booking.create', compact('services', 'cars', 'packages'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'service_id' => 'required|exists:services,id',
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'duration_days' => 'required|integer|min:1',
            'pickup_location' => 'nullable|string',
            'pickup_time' => 'nullable',
            'tour_package_id' => 'nullable|exists:tour_packages,id',
            'notes' => 'nullable|string',
        ]);

        $car = Car::findOrFail($data['car_id']);
        $endDate = date('Y-m-d', strtotime($data['start_date'] . ' + ' . ($data['duration_days'] - 1) . ' days'));

        $totalPrice = $car->price_per_day * $data['duration_days'];

        if (!empty($data['tour_package_id'])) {
            $package = TourPackage::findOrFail($data['tour_package_id']);
            $totalPrice = $package->price;
        }

        $booking = Booking::create([
            'booking_code' => 'EXP-' . strtoupper(Str::random(8)),
            'customer_id' => Auth::guard('customer')->id(),
            'car_id' => $data['car_id'],
            'service_id' => $data['service_id'],
            'tour_package_id' => $data['tour_package_id'] ?? null,
            'start_date' => $data['start_date'],
            'end_date' => $endDate,
            'duration_days' => $data['duration_days'],
            'pickup_location' => $data['pickup_location'] ?? null,
            'pickup_time' => $data['pickup_time'] ?? null,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'notes' => $data['notes'] ?? null,
        ]);

        return redirect()->route('booking.payment', $booking->id);
    }

    public function payment($id)
    {
        $booking = Booking::with(['car', 'service', 'tourPackage'])->findOrFail($id);
        $banks = Bank::where('is_active', true)->get();

        if ($booking->customer_id !== Auth::guard('customer')->id()) {
            abort(403);
        }

        return view('customer.booking.payment', compact('booking', 'banks'));
    }

    public function uploadPayment(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->customer_id !== Auth::guard('customer')->id()) {
            abort(403);
        }

        $data = $request->validate([
            'bank_id' => 'required|exists:banks,id',
            'account_name' => 'required|string',
            'proof_photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $bank = Bank::findOrFail($data['bank_id']);

        if ($request->hasFile('proof_photo')) {
            $path = $request->file('proof_photo')->store('payments', 'public');
        }

        $booking->payment()->create([
            'amount' => $booking->total_price,
            'method' => 'transfer',
            'bank_id' => $bank->id,
            'bank_name' => $bank->name,
            'account_number' => $bank->account_number,
            'account_name' => $data['account_name'],
            'proof_photo' => $path ?? null,
            'status' => 'pending',
        ]);

        $booking->update(['status' => 'waiting_payment']);

        return redirect()->route('booking.detail', $booking->id)->with('success', 'Bukti transfer berhasil diupload!');
    }

    public function detail($id)
    {
        $booking = Booking::with(['car', 'service', 'tourPackage', 'driver', 'payment.bank'])->findOrFail($id);

        if ($booking->customer_id !== Auth::guard('customer')->id()) {
            abort(403);
        }

        return view('customer.booking.detail', compact('booking'));
    }

    public function myBookings()
    {
        $bookings = Booking::with(['car', 'service'])
            ->where('customer_id', Auth::guard('customer')->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.booking.index', compact('bookings'));
    }
}
