<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'phone' => '1234567890',
                'address' => '123 Admin St, Hanoi',
                'avatar' => 'admin_avatar.jpg',
                'birth' => '1990-01-01',
                'gender' => 'nam',
                'password' => Hash::make('12345'),
                'status' => 1,
                'role_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'User',
                'email' => 'user@example.com',
                'phone' => '0987654321',
                'address' => '456 Guide St, Ho Chi Minh City',
                'avatar' => 'user_avatar.jpg',
                'birth' => '1992-02-02',
                'gender' => 'nu',
                'password' => Hash::make('12345'),
                'status' => 1,
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
