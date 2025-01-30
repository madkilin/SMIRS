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
                    $check->location_item_id,
                    $check->inventory->name, 
                    $check->inventory->category ,
                    ucfirst($check->status) ,
                    $check->description ,
                    $check->user->name ,
                    $check->created_at->format('d M Y H:i')
                ];
            });
    }

    public function headings(): array
    {
        return ['Kode Alokasi','Nama Barang','Kategori','Kondisi','Keterangan', 'Dicek Oleh', 'Tanggal Pengecekan
'];
    }
}
