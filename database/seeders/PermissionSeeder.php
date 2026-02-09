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
        $list_permission = ['manageUser', 'managePost', 'manageGroup', 'manageURD'];
        foreach ($list_permission as $permission) {
            Permission::factory()->create([
                'name' => $permission,
            ]);
        }
    }
}
