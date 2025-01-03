<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('locations')->insert([
            ['name' => 'RS-2 Server'],
            ['name' => 'RS-1 Poi Umum'],
            ['name' => 'RS-1 Poli Dalam'],
            ['name' => 'RS-1 Farmasi'],
            ['name' => 'K-1 Pendaftaran'],
        ]);
    }
}
