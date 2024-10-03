<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Location;
use App\Models\Unit;
use App\Models\Supplier;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $divisionCategory = $user->division->category;
        if($user->role_id == 1 || $user->role_id == 3) {
            $inventories = Inventory::all();
        }else{
            $inventories = Inventory::where('category', $divisionCategory)->get();
        }

        return view('admin.inventory.index', compact('inventories'));
    }

    public function create()
    {
        $locations = Location::all();
        $units = Unit::all();
        $suppliers = Supplier::all();
        return view('admin.inventory.create', compact('locations', 'units', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'quantity' => 'required|numeric',
            'unit_id' => 'required|exists:units,id',
            'added_date' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'image' => 'nullable|image|max:1024',
        ], [
            'name.required' => 'Nama inventori harus diisi.',
            'category.required' => 'Kategori inventori harus diisi.',
            'quantity.required' => 'Jumlah harus diisi.',
            'unit_id.required' => 'Unit harus dipilih.',
            'added_date.required' => 'Tanggal harus diisi.',
            'supplier_id.required' => 'Pemasok harus dipilih.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 1MB.',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('inventories', 'public');
        }

        Inventory::create($validated);

        return redirect()->route('admin.inventory.index')->with('success', 'Inventori berhasil dibuat.');
    }

    public function edit(Inventory $inventory)
    {
        $locations = Location::all();
        $units = Unit::all();
        $suppliers = Supplier::all();
        return view('admin.inventory.edit', compact('inventory', 'locations', 'units', 'suppliers'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'quantity' => 'required|numeric',
            'unit_id' => 'required|exists:units,id',
            'added_date' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'image' => 'nullable|image|max:1024',
        ], [
            'name.required' => 'Nama inventori harus diisi.',
            'category.required' => 'Kategori inventori harus diisi.',
            'quantity.required' => 'Jumlah harus diisi.',
            'unit_id.required' => 'Unit harus dipilih.',
            'added_date.required' => 'Tanggal harus diisi.',
            'supplier_id.required' => 'Pemasok harus dipilih.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 1MB.',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('inventories', 'public');
        }

        $inventory->update($validated);

        return redirect()->route('admin.inventory.index')->with('success', 'Inventori berhasil diperbarui.');
    }

    public function destroy(Inventory $inventory)
    {
        try {
            $inventory->delete();
            return redirect()->route('admin.inventory.index')->with('success', 'Inventori berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.inventory.index')->with('error', 'Gagal menghapus inventori. Silakan coba lagi.');
        }
    }
}
