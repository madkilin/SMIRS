<?php

namespace App\Exports;

use App\Models\ItemCheck;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportsExport implements FromCollection, WithHeadings
{
    protected $itemChecks;

    public function __construct($itemChecks)
    {
        $this->itemChecks = $itemChecks;
    }

    public function collection()
    {
        // Map the ItemCheck collection to an array with the desired attributes
        return $this->itemChecks->map(function ($itemCheck) {
            return [
                'Nama Barang' => $itemCheck->inventory->name,
                'Jenis Barang' => $itemCheck->inventory->category,
                'Kuantitas' => $itemCheck->quantity ?? 'N/A',  // Check if pivot data exists
                'Ruangan' => $itemCheck->location->name ?? '-', // Check if location exists
                'Kondisi' => ucfirst($itemCheck->status),
                'Keterangan' => $itemCheck->description,
                'Dicek Oleh' => $itemCheck->user->name,
                'Tanggal Pengecekan' => $itemCheck->created_at->format('d M Y H:i'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Barang',
            'Jenis Barang',
            'Kuantitas',
            'Ruangan',
            'Kondisi',
            'Keterangan',
            'Dicek Oleh',
            'Tanggal Pengecekan',
        ];
    }
}

