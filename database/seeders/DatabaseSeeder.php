<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        if (! User::where('email', 'admin@bkdesu.com')->exists()) {
            User::factory()->create([
                'name' => 'BKhanggDesu',
                'email' => 'admin@bkdesu.com',
            ]);
        }

        // Refresh categories with Vietnamese clothing data
        \App\Models\Category::query()->delete();
        \App\Models\Category::factory(25)->create();
    }
}
