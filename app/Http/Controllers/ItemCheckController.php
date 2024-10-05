<?php

namespace App\Http\Controllers;

use App\Models\ItemCheck;
use App\Models\Location;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ItemCheckExport;
use Maatwebsite\Excel\Facades\Excel;

class ItemCheckController extends Controller
{
    /**
     * Menampilkan form untuk pengecekan barang di suatu lokasi.
     */
    public function create(Location $location)
    {
        $user = auth()->user();
        $inventories = $location->inventories()->with('unit')->get();
        $divisionCategory = $user->division->category;
        if ($user->role_id == 1 || $user->role_id == 3) {
            $inventories = $location->inventories()->with('unit')->get();
        } else {
            $inventories = $location->inventories()->with('unit')->where('category', $divisionCategory)->get();
        }

        return view('item_check_form', compact('location', 'inventories'));
    }

    /**
     * Menyimpan pengecekan barang harian.
     */
    public function store(Request $request, Location $location)
    {
        // Validasi input
        $validated = $request->validate([
            'inventories.*.status' => 'required|in:bagus,hilang,rusak,butuh_perbaikan',
            'inventories.*.description' => 'nullable|string',
        ]);

        $today = now()->toDateString();

        foreach ($validated['inventories'] as $inventoryId => $data) {
            // Cek apakah pengguna sudah melakukan pengecekan untuk barang ini hari ini
            $alreadyChecked = ItemCheck::where('user_id', auth()->id())
                ->where('location_id', $location->id)
                ->where('inventory_id', $inventoryId)
                ->whereDate('created_at', $today)
                ->exists();

            if ($alreadyChecked) {
                return redirect()->back()->with('error', "Anda sudah melakukan pengecekan untuk barang ID {$inventoryId} hari ini.");
            }

            // Simpan pengecekan barang
            ItemCheck::create([
                'user_id' => auth()->id(),
                'inventory_id' => $inventoryId,
                'location_id' => $location->id,
                'status' => $data['status'],
                'description' => $data['description'] ?? '',
            ]);
        }

        return redirect()->back()->with('success', 'Pengecekan barang berhasil disimpan.');
    }



    /**
     * Menampilkan riwayat pengecekan barang di suatu lokasi.
     */
    public function history(Location $location)
    {
        // Ambil riwayat pengecekan barang
        $itemChecks = ItemCheck::where('location_id', $location->id)->with(['user', 'inventory'])->get();
        return view('item_check_history', compact('itemChecks', 'location'));
    }



    public function exportPdf(Location $location)
    {
        $itemChecks = ItemCheck::where('location_id', $location->id)->with(['user', 'inventory'])->get();
        $pdf = Pdf::loadView('exports.item_check_pdf', compact('itemChecks', 'location'));

        return $pdf->download('item_check_history.pdf');
    }
    public function exportExcel(Location $location)
    {
        return Excel::download(new ItemCheckExport($location), 'item_check_history.xlsx');
    }
}
