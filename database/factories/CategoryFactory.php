<?php

namespace Database\Factories;

use App\Models\Category;
use App\Services\GenerateSlug;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $id = Category::max('id') + 1;
        $name = $id . '_' . fake()->sentence();
        return [
            'name' => $name,
            'slug' => GenerateSlug::generate($name, Category::class),
            'description' => fake()->text(),
            'image' => fake()->imageUrl(),
            'order' => fake()->numberBetween(1, 10),
        ];
    }
}
