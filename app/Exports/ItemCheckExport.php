<?php

namespace App\Exports;

use App\Models\ItemCheck;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ItemCheckExport implements FromCollection, WithHeadings
{
    protected $location;

    public function __construct($location)
    {
        $this->location = $location;
    }

    public function collection()
    {
        return ItemCheck::where('location_id', $this->location->id)
            ->with(['user', 'inventory'])
            ->get()
            ->map(function($check) {
                return [
                    $check->inventory->name,
                    ucfirst($check->status), // Capitalizing the first letter of the status
                    $check->description,
                    $check->user->name,
                    $check->created_at->format('d M Y H:i'),
                ];
            });
    }

    public function headings(): array
    {
        return ['Nama Barang','Status','Keterangan', 'DiCek Oleh', 'Tanggal Pengecekan
'];
    }
}
