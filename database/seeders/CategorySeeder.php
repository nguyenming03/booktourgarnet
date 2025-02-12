<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['id' => 1, 'name' => 'Tour', 'parent_id' => null, 'slug' => 'abc', 'img_thumb' => 'abc.jpg', 'description' => 'abc', 'hot' => 0, 'status' => 1, 'user_id'=> '1', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Miền Bắc', 'parent_id' => 1, 'slug' => 'abc', 'img_thumb' => 'abc.jpg', 'description' => 'abc', 'hot' => 0, 'status' => 1, 'user_id'=> '1', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Du lịch Hà Nội', 'parent_id' => 2, 'slug' => 'abc', 'img_thumb' => 'abc.jpg', 'description' => 'abc', 'hot' => 0, 'status' => 1, 'user_id'=> '1', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Du lịch Hạ Long', 'parent_id' => 2, 'slug' => 'abc', 'img_thumb' => 'abc.jpg', 'description' => 'abc', 'hot' => 0, 'status' => 1, 'user_id'=> '1', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Miền Trung', 'parent_id' => 1, 'slug' => 'abc', 'img_thumb' => 'abc.jpg', 'description' => 'abc', 'hot' => 0, 'status' => 1, 'user_id'=> '1', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Du lịch Đà Nẵng', 'parent_id' => 5, 'slug' => 'abc', 'img_thumb' => 'abc.jpg', 'description' => 'abc', 'hot' => 0, 'status' => 1, 'user_id'=> '1', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'name' => 'Miền Nam', 'parent_id' => 1, 'slug' => 'abc', 'img_thumb' => 'abc.jpg', 'description' => 'abc', 'hot' => 0, 'status' => 1, 'user_id'=> '1', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'name' => 'Du lịch Phú Quốc', 'parent_id' => 7, 'slug' => 'abc', 'img_thumb' => 'abc.jpg', 'description' => 'abc', 'hot' => 0, 'status' => 1, 'user_id'=> '1', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
