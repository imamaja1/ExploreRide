<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DestinationController extends Controller
{
    public function index()
    {
        $destinations = Destination::latest()->paginate(15);
        return view('admin.destinations.index', compact('destinations'));
    }

    public function create()
    {
        return view('admin.destinations.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:destinations,slug',
            'category' => 'required|in:pantai,gunung,air-terjun',
            'location' => 'required|string|max:255',
            'rating' => 'required|numeric|min:0|max:5',
            'description' => 'nullable|string',
            'main_photo' => 'nullable|image|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('main_photo')) {
            $data['main_photo'] = $request->file('main_photo')->store('destinations', 'public');
        }

        Destination::create($data);

        return redirect()->route('admin.destinations.index')
            ->with('success', __('Destinasi berhasil ditambahkan!'));
    }

    public function edit(Destination $destination)
    {
        return view('admin.destinations.edit', compact('destination'));
    }

    public function update(Request $request, Destination $destination)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:destinations,slug,' . $destination->id,
            'category' => 'required|in:pantai,gunung,air-terjun',
            'location' => 'required|string|max:255',
            'rating' => 'required|numeric|min:0|max:5',
            'description' => 'nullable|string',
            'main_photo' => 'nullable|image|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('main_photo')) {
            if ($destination->main_photo) {
                Storage::disk('public')->delete($destination->main_photo);
            }
            $data['main_photo'] = $request->file('main_photo')->store('destinations', 'public');
        }

        $destination->update($data);

        return redirect()->route('admin.destinations.index')
            ->with('success', __('Destinasi berhasil diupdate!'));
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
