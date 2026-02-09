<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Role::all()->pluck('name')->toArray();
        $permissions = Permission::all()->pluck('name')->toArray();
        foreach ($roles as $itemRole) {
            foreach ($permissions as $itemPermission) {
                if ($itemRole === 'admin' || $itemRole === 'pm') {
                    $role_id = Role::firstWhere('name', $itemRole)->id;
                    $permission_id = Permission::firstWhere('name', $itemPermission)->id;
                    RolePermission::factory()->create([
                        'role_id' => $role_id,
                        'permission_id' => $permission_id,
                    ]);
                }
                if ($itemRole === 'user' && $itemPermission !== 'manageURD') {
                    $role_id = Role::firstWhere('name', $itemRole)->id;
                    $permission_id = Permission::firstWhere('name', $itemPermission)->id;
                    RolePermission::factory()->create([
                        'role_id' => $role_id,
                        'permission_id' => $permission_id,
                    ]);
                }
            }
        }
    }
}
