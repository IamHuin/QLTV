<?php

namespace Database\Seeders;

use App\Models\Role;
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

        $this->call([
            UserSeeder::class,
            ProfileSeeder::class,
            PostSeeder::class,
            GroupSeeder::class,
            UserGroupSeeder::class,
        ]);
//        Role::factory()->create([
//            'name' => 'user',
//        ]);
//        User::factory()->create([
//            'role_id' => 1,
//            'username' => 'admin',
//            'password' => bcrypt('admin'),
//            'email' => 'admin@gmail.com',
//        ]);
    }
}
