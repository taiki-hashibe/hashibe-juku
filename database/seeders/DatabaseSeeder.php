<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        for ($i = 00; $i < 50; $i++) {
            $category = Category::inRandomOrder()->first();
            \App\Models\Post::factory()->create([
                'category_id' => 3 < random_int(0, 10) ? Category::factory()->create()->id : (3 < random_int(0, 10) ? $category : null),
            ]);
        }
    }
}
