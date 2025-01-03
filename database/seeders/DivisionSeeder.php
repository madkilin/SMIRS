<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Division;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Division::create([
            'name' => 'IT',
            'category' => 'perangkat', // Adjusted category to match enum value
        ]);

        Division::create([
            'name' => 'Teknisi',
            'category' => 'elektronik', // Adjusted category to match enum value
        ]);

        Division::create([
            'name' => 'Kesehatan',
            'category' => 'kesehatan', // Adjusted category to match enum value

        ]);

        Division::create([
            'name' => 'Logistik',
            'category' => 'perlengkapan', // Adjusted category to match enum value
        ]);

        Division::create([
            'name' => 'Gudang',
            'category' => 'lainnya', // Adjusted category to match enum value
        ]);
    }
}
