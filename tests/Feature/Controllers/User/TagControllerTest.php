<?php

namespace Tests\Feature\Controllers\User;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
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
        $user = User::factory()->create();
        $tag = Tag::factory()->create();
        $post1 = Post::factory()->create();
        $post2 = Post::factory()->create();
        $tag->posts()->attach($post1);
        $tag->posts()->attach($post2);
        $response = $this->get(route('user.tag', [
            'tag' => $tag->slug
        ]));
        $response->assertRedirect(route('user.login'));
        $response = $this->actingAs($user, 'users')->get(route('user.tag', [
            'tag' => $tag->slug
        ]));
        $response->assertStatus(200);
        $response->assertSee($user->name);
        $response->assertSee('タグから探す');
        $response->assertSee($tag->name);
        $response->assertSee($post1->title);
        $response->assertSee($post2->title);
    }
}
