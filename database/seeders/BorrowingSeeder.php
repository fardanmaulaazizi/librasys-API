<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BorrowingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('borrowings')->insert([
            'user_id' => 3,
            'book_id' => 1,
            'quantity' => 1,
            'status' => 'returned',
            'loan_date' => '2022-01-01',
            'return_date' => '2022-02-02',
        ]);

        DB::table('borrowings')->insert([
            'user_id' => 2,
            'book_id' => 2,
            'quantity' => 3,
            'status' => 'loaned',
            'loan_date' => '2022-05-01',
            'return_date' => null,
        ]);
    }
}
