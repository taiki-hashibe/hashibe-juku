<?php

namespace Tests\Feature\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function testIndex(): void
    {
        $tag = Tag::factory()->create();
        $post1 = Post::factory()->create();
        $post2 = Post::factory()->create();
        $tag->posts()->attach($post1);
        $tag->posts()->attach($post2);
        $response = $this->get(route('tag.index', [
            'tag' => $tag->slug
        ]));
        $response->assertStatus(200);
        $response->assertSee('ログイン');
        $response->assertSee('タグから探す');
        $response->assertSee($tag->name);
        $response->assertSee($post1->title);
        $response->assertSee($post2->title);
        // アクセスログが記録されている
        $this->assertDatabaseHas('access_logs', [
            'url' => route('tag.index', [
                'tag' => $tag->slug
            ]),
        ]);
    }
}
