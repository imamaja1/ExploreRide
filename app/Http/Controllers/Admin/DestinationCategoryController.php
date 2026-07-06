<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DestinationCategory;
use Illuminate\Http\Request;

class DestinationCategoryController extends Controller
{
    public function index()
    {
        $categories = DestinationCategory::all();
        return view('admin.destination-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.destination-categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'slug' => 'required|string|max:255|unique:destination_categories,slug',
            'name' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        DestinationCategory::create($data);

        return redirect()->route('admin.destination-categories.index')
            ->with('success', __('Kategori berhasil ditambahkan!'));
    }

    public function edit(DestinationCategory $category)
    {
        return view('admin.destination-categories.edit', compact('category'));
    }

    public function update(Request $request, DestinationCategory $category)
    {
        $data = $request->validate([
            'slug' => 'required|string|max:255|unique:destination_categories,slug,' . $category->id,
            'name' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $category->update($data);

        return redirect()->route('admin.destination-categories.index')
            ->with('success', __('Kategori berhasil diupdate!'));
    }

    public function destroy(DestinationCategory $category)
    {
        $category->delete();

        return redirect()->route('admin.destination-categories.index')
            ->with('success', __('Kategori berhasil dihapus!'));
    }

    public function toggle(DestinationCategory $category)
    {
        $category->update(['is_active' => !$category->is_active]);

        $status = $category->is_active ? __('diaktifkan') : __('dinonaktifkan');
        return redirect()->route('admin.destination-categories.index')
            ->with('success', __('Kategori :name berhasil :status.', ['name' => $category->name, 'status' => $status]));
    }
}
