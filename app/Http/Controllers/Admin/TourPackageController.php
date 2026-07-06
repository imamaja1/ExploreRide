<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TourPackage;
use App\Models\TourDestination;
use Illuminate\Http\Request;

class TourPackageController extends Controller
{
    public function index()
    {
        $packages = TourPackage::withCount('destinations')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.tour-packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.tour-packages.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:tour_packages,slug',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'main_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'route' => 'nullable|json',
            'includes' => 'nullable|string',
            'excludes' => 'nullable|string',
        ]);

        if ($request->hasFile('main_photo')) {
            $data['main_photo'] = $request->file('main_photo')->store('packages', 'public');
        }

        $data['is_active'] = $request->boolean('is_active', true);

        TourPackage::create($data);

        return redirect()->route('admin.tour-packages.index')->with('success', 'Paket wisata berhasil ditambahkan');
    }

    public function edit(TourPackage $tourPackage)
    {
        $tourPackage->load('destinations');
        return view('admin.tour-packages.edit', compact('tourPackage'));
    }

    public function update(Request $request, TourPackage $tourPackage)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:tour_packages,slug,' . $tourPackage->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'main_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'route' => 'nullable|json',
            'includes' => 'nullable|string',
            'excludes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('main_photo')) {
            $data['main_photo'] = $request->file('main_photo')->store('packages', 'public');
        }

        $data['is_active'] = $request->boolean('is_active', true);

        $tourPackage->update($data);

        return redirect()->route('admin.tour-packages.index')->with('success', 'Paket wisata berhasil diupdate');
    }

    public function destroy(TourPackage $tourPackage)
    {
        $tourPackage->delete();
        return redirect()->route('admin.tour-packages.index')->with('success', 'Paket wisata berhasil dihapus');
    }
}
