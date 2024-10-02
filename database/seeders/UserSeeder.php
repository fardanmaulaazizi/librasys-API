<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Fardan',
            'email' => 'fardan@gmail.com',
            'password' => Hash::make('librasys123'),
            'role_id' => 1,
        ]);
        DB::table('users')->insert([
            'name' => 'Abdul',
            'email' => 'abdul@gmail.com',
            'password' => Hash::make('librasys123'),
            'role_id' => 2,
        ]);
        DB::table('users')->insert([
            'name' => 'Udin',
            'email' => 'udin@gmail.com',
            'password' => Hash::make('librasys123'),
            'role_id' => 3,
        ]);
    }
}
