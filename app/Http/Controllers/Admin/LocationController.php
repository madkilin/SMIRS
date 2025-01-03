<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\ItemCheck;
use App\Models\Location;
use App\Models\LocationItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::all();
        return view('admin.location.index', compact('locations'));
    }

    public function create()
    {
        return view('admin.location.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama lokasi harus diisi.',
            'name.string' => 'Nama lokasi harus berupa string.',
            'name.max' => 'Nama lokasi tidak boleh lebih dari 255 karakter.',
        ]);

        Location::create($request->all());

        return redirect()->route('admin.locations.index')->with('success', 'Lokasi berhasil dibuat.');
    }


    public function edit(Location $location)
    {
        return view('admin.location.edit', compact('location'));
    }

    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama lokasi harus diisi.',
            'name.string' => 'Nama lokasi harus berupa string.',
            'name.max' => 'Nama lokasi tidak boleh lebih dari 255 karakter.',
        ]);

        $location->update($request->all());

        return redirect()->route('admin.locations.index')->with('success', 'Lokasi berhasil diperbarui.');
    }

    public function destroy(Location $location)
    {
        $location->delete();

        return redirect()->route('admin.locations.index')->with('success', 'Lokasi berhasil dihapus.');
    }

    public function addinventories(Location $location)
    {
        $user = auth()->user();
        $divisionCategory = $user->division->category;
        if ($user->role_id == 1 || $user->role_id == 3) {
            $inventories = Inventory::all();
        } else {
            $inventories = Inventory::where('category', $divisionCategory)->get();
        }
        $items = LocationItem::where('location_id', $location->id)->with('inventory')->get();
        return view('admin.allocation.add-inventories', compact('location', 'inventories', 'items'));
    }

    public function addaction(Request $request, Location $location)
    {
        // Validasi data inventori
        $request->validate([
            'inventories' => 'required|array',
            'inventories.*.inventory_id' => 'required|exists:inventories,id',
            'inventories.*.quantity' => 'required|integer|min:1',
        ], [
            'inventories.required' => 'Data inventori harus disertakan.',
            'inventories.*.inventory_id.required' => 'ID inventori harus diisi.',
            'inventories.*.inventory_id.exists' => 'ID inventori tidak valid.',
            'inventories.*.quantity.required' => 'Jumlah harus diisi.',
            'inventories.*.quantity.integer' => 'Jumlah harus berupa angka.',
            'inventories.*.quantity.min' => 'Jumlah harus minimal 1.',
        ]);

        // Loop melalui inventori untuk memperbarui atau membuat catatan location_inventory
        foreach ($request->inventories as $inventoryData) {
            $inventory = Inventory::findOrFail($inventoryData['inventory_id']);

            // Cek apakah ada cukup jumlah di inventori
            if ($inventory->quantity >= $inventoryData['quantity']) {
                // Kurangi jumlah dari inventori
                $inventory->quantity -= $inventoryData['quantity'];
                $inventory->save(); // Simpan inventori yang diperbarui

                // Buat entri di tabel location_inventory sebanyak jumlah yang diminta
                for ($i = 0; $i < $inventoryData['quantity']; $i++) {
                    LocationItem::create([
                        'location_id' => $location->id,
                        'inventory_id' => $inventory->id,
                    ]);
                }
            } else {
                // Jika tidak ada cukup jumlah, redirect kembali dengan error
                return redirect()->back()->withErrors([
                    'message' => 'Jumlah tidak cukup tersedia untuk ' . $inventory->name,
                ]);
            }
        }

        // Redirect kembali ke daftar lokasi dengan pesan sukses
        return redirect()->route('admin.alokasi.index')->with('success', 'Inventori untuk lokasi berhasil diperbarui.');
    }


    public function indexadd()
    {
        $locations = Location::all();
        return view('admin.allocation.index-add', compact('locations'));
    }
    public function toWarehouse(Location $location)
    {
        $user = auth()->user();
        $divisionCategory = $user->division->category;

        // Ambil semua inventory berdasarkan lokasi
        $locationItems = LocationItem::where('location_id', $location->id)
            ->with('inventory') // Mengambil data inventory terkait
            ->get();

        // Filter jika user bukan admin
        if ($user->role_id != 1 && $user->role_id != 3) {
            $locationItems = $locationItems->filter(function ($locationItem) use ($divisionCategory) {
                return $locationItem->inventory->category == $divisionCategory;
            });
        }

        return view('admin.allocation.add-inventoriesToWH', compact('location', 'locationItems'));
    }
    public function returnToWarehouse(Request $request, Location $location)
    {
        $request->validate([
            'return_items' => 'required|array',
            'return_items.*' => 'exists:location_inventory,id',
        ]);

        foreach ($request->return_items as $locationItemId) {
            $locationItem = LocationItem::findOrFail($locationItemId);
            $inventory = $locationItem->inventory;

            // Kembalikan stok ke inventaris
            $inventory->quantity += 1;
            $inventory->save();

            // Hapus relasi pada ItemCheck
            ItemCheck::where('location_item_id', $locationItem->id)
                ->update(['location_item_id' => null]);

            // Hapus LocationItem secara permanen
            $locationItem->delete();
        }

        return redirect()->route('admin.location.inventories', $location->id)
            ->with('success', 'Stok telah berhasil dikembalikan ke inventaris.');
    }
    public function exportPdf(Location $location)
    {
        // Get all inventories for this location, with quantity from the pivot table
        $inventories = $location->inventories->map(function ($inventory) {
            return [
                'Nama Barang' => $inventory->name,
                'Quantity' => $inventory->pivot->quantity,
            ];
        });

        // Generate PDF with the data
        $pdf = Pdf::loadView('exports.kartu_inventaris_medina_pdf', compact('inventories', 'location'));

        return $pdf->download('kartu_inventaris_medina.pdf');
    }
}
