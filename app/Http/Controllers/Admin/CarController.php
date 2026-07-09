<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $cars = Car::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $cars->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('plate_number', 'like', "%{$search}%");
            });
        }

        $cars = $cars->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        return view('admin.cars.index', compact('cars'));
    }

    public function create()
    {
        return view('admin.cars.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:2000|max:2030',
            'plate_number' => 'required|string|max:20',
            'color' => 'nullable|string|max:50',
            'fuel_type' => 'nullable|string|max:50',
            'transmission' => 'nullable|string|max:50',
            'seats' => 'required|integer|min:1',
            'price_per_day' => 'required|numeric|min:0',
            'main_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'with_driver' => 'boolean',
        ]);

        if ($request->hasFile('main_photo')) {
            $data['main_photo'] = $request->file('main_photo')->store('cars', 'public');
        }

        $data['is_active'] = $request->boolean('is_active', true);
        $data['with_driver'] = $request->boolean('with_driver', false);

        Car::create($data);

        return redirect()->back()->with('success', __('Mobil berhasil ditambahkan'));
    }

    public function edit(Car $car)
    {
        return view('admin.cars.edit', compact('car'));
    }

    public function update(Request $request, Car $car)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:2000|max:2030',
            'plate_number' => 'required|string|max:20',
            'color' => 'nullable|string|max:50',
            'fuel_type' => 'nullable|string|max:50',
            'transmission' => 'nullable|string|max:50',
            'seats' => 'required|integer|min:1',
            'price_per_day' => 'required|numeric|min:0',
            'main_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'with_driver' => 'boolean',
        ]);

        if ($request->hasFile('main_photo')) {
            if ($car->main_photo) {
                Storage::disk('public')->delete($car->main_photo);
            }
            $data['main_photo'] = $request->file('main_photo')->store('cars', 'public');
        }

        $data['is_active'] = $request->boolean('is_active', true);
        $data['with_driver'] = $request->boolean('with_driver', false);

        $car->update($data);

        return redirect()->back()->with('success', __('Mobil berhasil diupdate'));
    }

    public function destroy(Car $car)
    {
        if ($car->main_photo) {
            Storage::disk('public')->delete($car->main_photo);
        }
        $car->delete();
        return redirect()->route('admin.cars.index')->with('success', 'Mobil berhasil dihapus');
    }
}
