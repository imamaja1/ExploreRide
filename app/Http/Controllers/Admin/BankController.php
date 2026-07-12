<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BankController extends Controller
{
    public function index(Request $request)
    {
        $banks = Bank::query();

        if ($request->filled('search')) {
            $search = addcslashes($request->search, '%_');
            $banks->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('account_number', 'like', "%{$search}%")
                  ->orWhere('account_name', 'like', "%{$search}%");
            });
        }

        $banks = $banks->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        return view('admin.banks.index', compact('banks'));
    }

    public function create()
    {
        return view('admin.banks.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'account_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('banks', 'public');
        }

        $data['is_active'] = $request->boolean('is_active', true);

        Bank::create($data);

        return redirect()->back()->with('success', __('Bank berhasil ditambahkan'));
    }

    public function edit(Bank $bank)
    {
        return view('admin.banks.edit', compact('bank'));
    }

    public function update(Request $request, Bank $bank)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'account_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('logo')) {
            if ($bank->logo) {
                Storage::disk('public')->delete($bank->logo);
            }
            $data['logo'] = $request->file('logo')->store('banks', 'public');
        }

        $data['is_active'] = $request->boolean('is_active', true);

        $bank->update($data);

        return redirect()->back()->with('success', __('Bank berhasil diupdate'));
    }

    public function destroy(Bank $bank)
    {
        if ($bank->logo) {
            Storage::disk('public')->delete($bank->logo);
        }
        $bank->delete();
        return redirect()->route('admin.banks.index')->with('success', 'Bank berhasil dihapus');
    }
}
