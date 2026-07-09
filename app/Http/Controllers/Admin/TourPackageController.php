<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TourPackage;
use App\Models\TourDestination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TourPackageController extends Controller
{
    public function index(Request $request)
    {
        $packages = TourPackage::withCount('destinations');

        if ($request->filled('search')) {
            $search = $request->search;
            $packages->where('name', 'like', "%{$search}%");
        }

        $packages = $packages->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        return view('admin.tour-packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.tour-packages.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:tour_packages,name',
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
        $data['slug'] = $this->generateUniqueSlug($request->name);

        TourPackage::create($data);

        return redirect()->back()->with('success', __('Paket wisata berhasil ditambahkan'));
    }

    public function edit(TourPackage $tourPackage)
    {
        $tourPackage->load('destinations');
        return view('admin.tour-packages.edit', compact('tourPackage'));
    }

    public function update(Request $request, TourPackage $tourPackage)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:tour_packages,name,' . $tourPackage->id,
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
            if ($tourPackage->main_photo) {
                Storage::disk('public')->delete($tourPackage->main_photo);
            }
            $data['main_photo'] = $request->file('main_photo')->store('packages', 'public');
        }

        $data['is_active'] = $request->boolean('is_active', true);
        $data['slug'] = $this->generateUniqueSlug($request->name, $tourPackage->id);

        $tourPackage->update($data);

        return redirect()->back()->with('success', __('Paket wisata berhasil diupdate'));
    }

    public function destroy(TourPackage $tourPackage)
    {
        if ($tourPackage->main_photo) {
            Storage::disk('public')->delete($tourPackage->main_photo);
        }
        $tourPackage->delete();
        return redirect()->route('admin.tour-packages.index')->with('success', 'Paket wisata berhasil dihapus');
    }

    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name);
        $base = $slug;
        $counter = 1;
        $query = TourPackage::where('slug', $slug);
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }
        while ($query->exists()) {
            $slug = $base . '-' . $counter++;
            $query = TourPackage::where('slug', $slug);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }
        }
        return $slug;
    }
}
