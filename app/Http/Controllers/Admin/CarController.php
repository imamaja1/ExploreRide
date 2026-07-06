<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::orderBy('created_at', 'desc')->paginate(10);
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

        return redirect()->route('admin.cars.index')->with('success', 'Mobil berhasil ditambahkan');
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
            $data['main_photo'] = $request->file('main_photo')->store('cars', 'public');
        }

        $data['is_active'] = $request->boolean('is_active', true);
        $data['with_driver'] = $request->boolean('with_driver', false);

        $car->update($data);

        return redirect()->route('admin.cars.index')->with('success', 'Mobil berhasil diupdate');
    }

    public function destroy(Car $car)
    {
        $car->delete();
        return redirect()->route('admin.cars.index')->with('success', 'Mobil berhasil dihapus');
    }
}
