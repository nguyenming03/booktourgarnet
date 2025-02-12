<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'view_dashboard', 'description' => 'Xem dashboard'],
            ['name' => 'edit_users', 'description' => 'Chỉnh sửa người dùng'],
            ['name' => 'delete_posts', 'description' => 'Xóa bài viết'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
