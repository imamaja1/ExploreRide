<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string|min:10',
        ]);

        $data['is_active'] = false;

        if (Auth::guard('customer')->check()) {
            $customer = Auth::guard('customer')->user();
            $data['customer_id'] = $customer->id;
            $data['name'] = $customer->name;
        }

        Testimonial::create($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => __('Terima kasih! Testimoni Anda akan ditinjau admin.'),
            ]);
        }

        return back()->with('success', __('Terima kasih! Testimoni Anda akan ditinjau admin.'));
    }
}
