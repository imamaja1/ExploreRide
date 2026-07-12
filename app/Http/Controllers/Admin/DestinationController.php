<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\DestinationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DestinationController extends Controller
{
    public function index(Request $request)
    {
        $destinations = Destination::query();

        if ($request->filled('search')) {
            $search = addcslashes($request->search, '%_');
            $destinations->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $destinations = $destinations->latest()->paginate(10)->withQueryString();
        $categories = DestinationCategory::active()->get();
        return view('admin.destinations.index', compact('destinations', 'categories'));
    }

    public function create()
    {
        $categories = DestinationCategory::active()->get();
        return view('admin.destinations.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $categorySlugs = DestinationCategory::active()->pluck('slug')->toArray();

        $data = $request->validate([
            'name' => 'required|string|max:255|unique:destinations,name',
            'category' => 'required|in:' . implode(',', $categorySlugs),
            'location' => 'required|string|max:255',
            'rating' => 'required|numeric|min:0|max:5',
            'description' => 'nullable|string',
            'main_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['slug'] = $this->generateUniqueSlug($request->name);

        if ($request->hasFile('main_photo')) {
            $data['main_photo'] = $request->file('main_photo')->store('destinations', 'public');
        }

        Destination::create($data);

        return redirect()->back()->with('success', __('Destinasi berhasil ditambahkan'));
    }

    public function edit(Destination $destination)
    {
        $categories = DestinationCategory::active()->get();
        return view('admin.destinations.edit', compact('destination', 'categories'));
    }

    public function update(Request $request, Destination $destination)
    {
        $categorySlugs = DestinationCategory::active()->pluck('slug')->toArray();

        $data = $request->validate([
            'name' => 'required|string|max:255|unique:destinations,name,' . $destination->id,
            'category' => 'required|in:' . implode(',', $categorySlugs),
            'location' => 'required|string|max:255',
            'rating' => 'required|numeric|min:0|max:5',
            'description' => 'nullable|string',
            'main_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['slug'] = $this->generateUniqueSlug($request->name, $destination->id);

        if ($request->hasFile('main_photo')) {
            if ($destination->main_photo) {
                Storage::disk('public')->delete($destination->main_photo);
            }
            $data['main_photo'] = $request->file('main_photo')->store('destinations', 'public');
        }

        $destination->update($data);

        return redirect()->back()->with('success', __('Destinasi berhasil diupdate'));
    }

    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name);
        $base = $slug;
        $counter = 1;
        $query = Destination::where('slug', $slug);
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }
        while ($query->exists()) {
            $slug = $base . '-' . $counter++;
            $query = Destination::where('slug', $slug);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }
        }
        return $slug;
    }

    public function destroy(Destination $destination)
    {
        if ($destination->main_photo) {
            Storage::disk('public')->delete($destination->main_photo);
        }
        $destination->delete();

        return redirect()->route('admin.destinations.index')
            ->with('success', __('Destinasi berhasil dihapus!'));
    }
}
