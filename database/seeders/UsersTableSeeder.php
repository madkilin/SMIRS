<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@medina.com',
                'password' => Hash::make('password'), // Ubah sesuai keperluan
                'role_id' => 1, // Admin
                'division_id' => 1,
                'phone' => '081234567890',

            ],
            [
                'name' => 'Regular User',
                'email' => 'user@medina.com',
                'password' => Hash::make('password'), // Ubah sesuai keperluan
                'role_id' => 2, // User
                'division_id' => 2,
                'phone' => '081234567890',
            ],
            [
                'name' => 'Gudang',
                'email' => 'gudang@medina.com',
                'password' => Hash::make('password'), // Ubah sesuai keperluan
                'role_id' => 3, // User
                'division_id' => 2,
                'phone' => '081234567890',
            ]
        ]);
    }
}
