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
        for ($i = 0; $i < 50; $i++) {
            $publicReleaseAt = null;
            if (random_int(0, 10) > 3) {
                $publicReleaseAt = now()->addDays(random_int(10, 30));
            }
            $category = Category::inRandomOrder()->first();
            \App\Models\Post::factory()->create([
                'category_id' => 8 < random_int(0, 10) ? Category::factory()->create()->id : (3 < random_int(0, 10) ? $category : null),
                'public_release_at' => $publicReleaseAt,
            ]);
        }
        for ($c = 0; $c < 5; $c++) {
            $curriculum = \App\Models\Curriculum::factory()->create();
            for ($i = 0; $i < 5; $i++) {
                $post = \App\Models\Post::whereNotIn('id', $curriculum->posts->pluck('id'))->inRandomOrder()->first();
                \App\Models\CurriculumPost::create([
                    'curriculum_id' => $curriculum->id,
                    'post_id' => $post->id,
                    'order' => $i,
                ]);
            }
        }
    }
}
