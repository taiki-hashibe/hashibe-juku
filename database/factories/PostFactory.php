<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Post;
use App\Models\PublishLevelEnum;
use App\Services\GenerateSlug;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $id = Post::max('id') + 1;
        $title = $id . '_' . Str::random(10);
        $category = Category::inRandomOrder()->first();
        return [
            'title' => $title,
            'content' => '<h2>テストの投稿</h2><p>テスト</p><p><abbr title="publish-level:membership">-</abbr></p><p>有料会員のみ</p>',
            'slug' => GenerateSlug::generate($title, Post::class),
            'status' => fake()->randomElement(['publish', 'draft']),
            'image' => null,
            'video' => 'http://127.0.0.1:8000/storage/video/1gaweyjgegei.mp4',
            'category_id' => 3 < random_int(0, 10) ? Category::factory() : (3 < random_int(0, 10) ? $category : null),
            'order' => fake()->numberBetween(1, 10),
            'publish_level' => PublishLevelEnum::$MEMBERSHIP
        ];
    }
}
