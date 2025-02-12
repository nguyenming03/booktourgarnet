<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('locations')->insert([
            [
                'id' => 1,
                'name' => 'Hanoi',
                'slug' => 'hanoi',
                'image' => 'hanoi.jpg',
                'description' => 'The capital of Vietnam with rich history.',
                'content' => 'Explore the old quarters, temples, and cuisine.',
                'status' => 1,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Ho Chi Minh City',
                'slug' => 'ho-chi-minh-city',
                'image' => 'hcmc.jpg',
                'description' => 'The largest city in Vietnam, known for its vibrant life.',
                'content' => 'A bustling city with a mix of the old and new.',
                'status' => 1,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Da Nang',
                'slug' => 'da-nang',
                'image' => 'danang.jpg',
                'description' => 'A coastal city with beautiful beaches.',
                'content' => 'Known for My Khe Beach and the Marble Mountains.',
                'status' => 1,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
