<?php

namespace App\Exports;

use App\Models\Location;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class cetakKartuExport implements FromCollection, WithHeadings
{
    protected $location;

    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    public function collection()
    {
        // Use the inventories relationship to get items with quantity for this location
        return $this->location->inventories->map(function ($inventory, $index) {
            return [
                'No.' => $index + 1,
                'Nama Barang' => $inventory->name,
                'Kuantitas' => $inventory->pivot->quantity,
                'Pengecekan' => '', // Placeholder for monthly check columns
            ];
        });
    }

    public function headings(): array
    {
        return [
            ['No.', 'Nama Barang', 'Kuantitas', 'Pengecekan', '', '', '', '', '', '', '', '', '', ''],
            ['', '', '', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
        ];
    }
}
