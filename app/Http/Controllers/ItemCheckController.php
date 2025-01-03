<?php

namespace App\Http\Controllers;

use App\Models\ItemCheck;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\LocationItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ItemCheckExport;

class ItemCheckController extends Controller
{
    public function create(Location $location)
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

        return view('item_check_form', compact('location', 'locationItems'));
    }

    public function store(Request $request, Location $location)
    {
        // Validasi input
        $validated = $request->validate([
            'location_items.*.status' => 'required|in:bagus,hilang,rusak,perbaikan',
            'location_items.*.description' => 'nullable|string',
        ]);

        $today = now()->toDateString();

        foreach ($validated['location_items'] as $locationItemId => $data) {
            // Cek jika sudah pernah di-check hari ini
            $alreadyChecked = ItemCheck::where('user_id', auth()->id())
                ->where('location_item_id', $locationItemId)
                ->whereDate('created_at', $today)
                ->exists();

            if ($alreadyChecked) {
                continue;
            }

            // Simpan ItemCheck
            ItemCheck::create([
                'user_id' => auth()->id(),
                'inventory_id' => LocationItem::find($locationItemId)->inventory_id,
                'location_id' => $location->id,
                'location_item_id' => $locationItemId,
                'status' => $data['status'],
                'description' => $data['description'] ?? '',
            ]);
        }

        return redirect()->route('item_checks.history', $location)->with('success', 'Pengecekan barang berhasil disimpan.');
    }



    public function history(Location $location)
    {
        $itemChecks = ItemCheck::with(['user', 'inventory'])->where('location_id', $location->id)->latest()->paginate(10);
        return view('item_check_history', compact('itemChecks', 'location'));
    }

    public function exportPdf(Location $location)
    {
        $itemChecks = ItemCheck::with(['user', 'inventory'])->where('location_id', $location->id)->get();
        $pdf = Pdf::loadView('exports.item_check_pdf', compact('itemChecks', 'location'));
        return $pdf->download('item_check_history.pdf');
    }

    public function exportExcel(Location $location)
    {
        return Excel::download(new ItemCheckExport($location), 'item_check_history.xlsx');
    }
}
