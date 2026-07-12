<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DriverController extends Controller
{
    public function index(Request $request)
    {
        $drivers = User::where('role', 'driver');

        if ($request->filled('search')) {
            $search = addcslashes($request->search, '%_');
            $drivers->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('plate_number', 'like', "%{$search}%");
            });
        }

        $drivers = $drivers->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        return view('admin.drivers.index', compact('drivers'));
    }

    public function create()
    {
        return view('admin.drivers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'plate_number' => 'required|string|max:20',
            'password' => 'required|string|min:8',
            'sim_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('sim_photo')) {
            $data['sim_photo'] = $request->file('sim_photo')->store('sim', 'public');
        }

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);
        $user->forceFill([
            'role' => 'driver',
            'is_active' => $request->boolean('is_active', true),
        ])->save();

        return redirect()->back()->with('success', __('Driver berhasil ditambahkan'));
    }

    public function edit(User $driver)
    {
        return view('admin.drivers.edit', compact('driver'));
    }

    public function update(Request $request, User $driver)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $driver->id,
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'plate_number' => 'required|string|max:20',
            'password' => 'nullable|string|min:8',
            'sim_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('sim_photo')) {
            if ($driver->sim_photo) {
                Storage::disk('public')->delete($driver->sim_photo);
            }
            $data['sim_photo'] = $request->file('sim_photo')->store('sim', 'public');
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $driver->update($data);
        $driver->forceFill([
            'is_active' => $request->boolean('is_active', true),
        ])->save();

        return redirect()->back()->with('success', __('Driver berhasil diupdate'));
    }

    public function destroy(User $driver)
    {
        if ($driver->sim_photo) {
            Storage::disk('public')->delete($driver->sim_photo);
        }
        $driver->delete();
        return redirect()->route('admin.drivers.index')->with('success', 'Driver berhasil dihapus');
    }
}
