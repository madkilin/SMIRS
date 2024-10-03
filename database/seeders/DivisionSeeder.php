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
            'category' => 'elektronik', // Adjusted category to match enum value
        ]);

        Division::create([
            'name' => 'Health',
            'category' => 'kesehatan', // Adjusted category to match enum value

        ]);

        Division::create([
            'name' => 'Other',
            'category' => 'perlengkapan', // Adjusted category to match enum value
        ]);
    }
}
