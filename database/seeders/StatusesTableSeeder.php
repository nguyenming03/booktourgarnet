<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('statuses')->insert([
            ['name' => 'Chờ xác nhận'],
            ['name' => 'Đã xác nhận'],
            ['name' => 'Chờ thanh toán'],
            ['name' => 'Đã thanh toán'],
            ['name' => 'Chưa hoàn thành'],
            ['name' => 'Đã hoàn thành'],
            ['name' => 'Đã hủy'],
        ]);
    }
}
