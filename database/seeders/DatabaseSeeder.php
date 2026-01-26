<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $list_role = ['admin', 'user'];
        foreach ($list_role as $role) {
            Role::factory()->create([
                'name' => $role,
            ]);
        }
        User::factory()->create([
            'role_id' => 1,
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'email' => 'admin@gmail.com',
        ]);
        $list_permission = ['manageUser', 'managePost', 'manageGroup'];
        foreach ($list_permission as $permission) {
            Permission::factory()->create([
                'name' => $permission,
            ]);
        }
        $roles = [1, 2];
        $permissions = [1, 2, 3];
        foreach ($roles as $role_id) {
            foreach ($permissions as $permission) {
                RolePermission::factory()->create([
                    'role_id' => $role_id,
                    'permission_id' => $permission,
                ]);
            }
        }
        $this->call([
            UserSeeder::class,
            ProfileSeeder::class,
            PostSeeder::class,
            GroupSeeder::class,
            UserGroupSeeder::class,
        ]);
    }
}
