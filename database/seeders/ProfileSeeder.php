<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $list_user = User::all();
        foreach ($list_user as $item) {
            $exists = Profile::where('user_id', $item->id)->exists();
            if (!$exists) {
                Profile::factory()->create(['user_id' => $item->id]);
            }
        }
    }
}
