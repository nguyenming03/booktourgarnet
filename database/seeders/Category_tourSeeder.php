<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Category_tourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('category_tour')->insert([
            ['id' => 1, 'category_tour' => 'Miền Bắc', 'description' => 'Miền Bắc','status' => 1, 'responsibility' => 1 , 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'category_tour' => 'Miền Trung', 'description' => 'Miền Trung','status' => 1, 'responsibility' => 1 , 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'category_tour' => 'Miền Nam', 'description' => 'Miền Nam','status' => 1, 'responsibility' => 1 , 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
