<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        $banks = Bank::orderBy('created_at', 'desc')->paginate(10);
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

        return redirect()->route('admin.banks.index')->with('success', 'Bank berhasil ditambahkan');
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
            $data['logo'] = $request->file('logo')->store('banks', 'public');
        }

        $data['is_active'] = $request->boolean('is_active', true);

        $bank->update($data);

        return redirect()->route('admin.banks.index')->with('success', 'Bank berhasil diupdate');
    }

    public function destroy(Bank $bank)
    {
        $bank->delete();
        return redirect()->route('admin.banks.index')->with('success', 'Bank berhasil dihapus');
    }
}
