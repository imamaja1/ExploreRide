<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DestinationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DestinationCategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = DestinationCategory::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $categories->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $categories = $categories->latest()->paginate(10)->withQueryString();

        return view('admin.destination-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.destination-categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:destination_categories,name',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['slug'] = $this->generateUniqueSlug($request->name);

        DestinationCategory::create($data);

        return redirect()->back()->with('success', __('Kategori berhasil ditambahkan'));
    }

    public function edit(DestinationCategory $destination_category)
    {
        $category = $destination_category;
        return view('admin.destination-categories.edit', compact('category'));
    }

    public function update(Request $request, DestinationCategory $destination_category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:destination_categories,name,' . $destination_category->id,
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['slug'] = $this->generateUniqueSlug($request->name, $destination_category->id);

        $destination_category->update($data);

        return redirect()->back()->with('success', __('Kategori berhasil diupdate'));
    }

    public function destroy(DestinationCategory $destination_category)
    {
        $destination_category->delete();

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

    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name);
        $base = $slug;
        $counter = 1;
        $query = DestinationCategory::where('slug', $slug);
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }
        while ($query->exists()) {
            $slug = $base . '-' . $counter++;
            $query = DestinationCategory::where('slug', $slug);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }
        }
        return $slug;
    }
}
