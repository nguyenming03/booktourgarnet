<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tours')->insert([
            [
                'name' => 'Amazing Thailand Tour',
                'journeys' => 'Bangkok, Chiang Mai, Phuket',
                'schedule' => '5 days and 4 nights',
                'move_method' => 'Airplane and bus',
                'starting_gate' => 'Hanoi',
                'start_date' => Carbon::parse('2024-12-01 08:00:00'),
                'end_date' => Carbon::parse('2024-12-06 20:00:00'),
                'number_guests' => 20,
                'price_old' => 10000000,
                'price_children' => 5000000,
                'sale' => 10,
                'view' => 120,
                'description' => 'A wonderful journey through Thailand’s cultural heritage and stunning landscapes.',
                'content' => 'Experience the beauty of Thailand with guided tours, authentic cuisine, and more.',
                'image' => 'thailand_tour.jpg',
                'location_id' => 1,
                'user_id' => 1,
                'category_tour_id' => 1,
                'number_registered' => 15,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Discover Japan',
                'journeys' => 'Tokyo, Kyoto, Osaka',
                'schedule' => '7 days and 6 nights',
                'move_method' => 'Shinkansen and bus',
                'starting_gate' => 'Ho Chi Minh City',
                'start_date' => Carbon::parse('2025-01-10 09:00:00'),
                'end_date' => Carbon::parse('2025-01-17 21:00:00'),
                'number_guests' => 25,
                'price_old' => 15000000,
                'price_children' => 7000000,
                'sale' => 15,
                'view' => 200,
                'description' => 'Experience Japan’s vibrant cities, historic temples, and cherry blossoms.',
                'content' => 'Enjoy a guided tour through Japan’s beautiful cities and traditional culture.',
                'image' => 'japan_tour.jpg',
                'location_id' => 2,
                'user_id' => 1,
                'category_tour_id' => 2,
                'number_registered' => 20,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'European Grand Tour',
                'journeys' => 'Paris, Rome, Berlin',
                'schedule' => '10 days and 9 nights',
                'move_method' => 'Plane, train, and bus',
                'starting_gate' => 'Da Nang',
                'start_date' => Carbon::parse('2025-03-15 07:00:00'),
                'end_date' => Carbon::parse('2025-03-25 22:00:00'),
                'number_guests' => 30,
                'price_old' => 20000000,
                'price_children' => 10000000,
                'sale' => 20,
                'view' => 250,
                'description' => 'Travel across Europe’s iconic cities and historic landmarks.',
                'content' => 'Discover the art, architecture, and culture of Europe’s most famous cities.',
                'image' => 'europe_tour.jpg',
                'location_id' => 3,
                'user_id' => 1,
                'category_tour_id' => 3,
                'number_registered' => 28,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
