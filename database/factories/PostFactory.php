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
        return [
            'title' => $title,
            'content' => fake()->paragraphs(3, true),
            'slug' => GenerateSlug::generate($title, Post::class),
            'status' => fake()->randomElement(['publish', 'draft']),
            'image' => null,
            'category_id' => Category::factory(),
            'admin_id' => Admin::factory(),
            'order' => fake()->numberBetween(1, 10),
            'publish_level' => PublishLevelEnum::$MEMBERSHIP
        ];
    }
}
