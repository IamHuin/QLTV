<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRoleDepartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class UserRoleDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_id = Role::all()->pluck('id', 'name')->toArray();
        $department_id = Department::all()->pluck('id')->toArray();
        $user_id = User::all()->pluck('id')->toArray();
        UserRoleDepartment::factory()->create([
            'role_id' => $role_id['admin'],
            'department_id' => null,
            'user_id' => $user_id[0],
        ]);
        UserRoleDepartment::factory()->create([
            'role_id' => $role_id['pm'],
            'department_id' => $department_id[0],
            'user_id' => $user_id[1],
        ]);
        for ($i = 2; $i <= 10; $i++) {
            UserRoleDepartment::factory()->create([
                'role_id' => $role_id['user'],
                'department_id' => $department_id[0],
                'user_id' => $user_id[$i],
            ]);
        }

        UserRoleDepartment::factory()->create([
            'role_id' => $role_id['pm'],
            'department_id' => $department_id[1],
            'user_id' => $user_id[11],
        ]);
        for ($i = 12; $i <= 20; $i++) {
            UserRoleDepartment::factory()->create([
                'role_id' => $role_id['user'],
                'department_id' => $department_id[1],
                'user_id' => $user_id[$i],
            ]);
        }

    }
}
