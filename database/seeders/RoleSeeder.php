<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            'name' => 'Head of library',
        ]);
        DB::table('roles')->insert([
            'name' => 'Librarian',
        ]);
        DB::table('roles')->insert([
            'name' => 'Member',
        ]);
    }
}
