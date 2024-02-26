<?php

namespace Tests\Feature\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function testIndex(): void
    {
        $post = Post::factory()->create([
            'category_id' => null
        ]);
        $category = Category::factory()->create([
            'parent_id' => null,
        ]);
        $dontSeePost = Post::factory()->create([
            'category_id' => $category->id
        ]);
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee($post->title);
        $response->assertSee($category->name);
        $response->assertDontSee($dontSeePost->title);
    }

    public function testLegal()
    {
        $response = $this->get(route('legal'));
        $response->assertStatus(200);
    }

    public function testPrivacy()
    {
        $response = $this->get(route('privacy'));
        $response->assertStatus(200);
    }

    public function testTerm()
    {
        $response = $this->get(route('term'));
        $response->assertStatus(200);
    }
}
