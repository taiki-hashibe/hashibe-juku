<?php

namespace Tests\Feature\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\StatusEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function testIndex(): void
    {
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'category_id' => $category->id,
            'status' => StatusEnum::$PUBLISH,
            'content' => 'content_' . Str::random(100),
            'content_free' => 'free_content_' . Str::random(100),
        ]);
        $response = $this->get(route('post.category', [
            'category' => $category->slug,
            'post' => $post->slug
        ]));

        $response->assertStatus(200);
        $response->assertSee($post->title);
        $response->assertDontSee($post->video);
        $response->assertSee($post->video_free);
        $response->assertSee("公式LINEを友達追加するとフルバージョンの動画が閲覧できます！");
        $response->assertDontSeeText($post->content);
        $response->assertSeeText($post->content_free);
        $response->assertSee("公式LINEを友達追加するとフルバージョンの記事が閲覧できます！");

        $post2 = Post::factory()->create([
            'category_id' => $category->id,
            'status' => StatusEnum::$PUBLISH,
            'content' => 'content_' . Str::random(100),
            'content_free' => 'free_content_' . Str::random(100),
        ]);
        $response = $this->get(route('post.category', [
            'category' => $category->slug,
            'post' => $post->slug
        ]));
        $response->assertStatus(200);
        $response->assertSee($post->title);
        $response->assertDontSee($post->video);
        $response->assertSee($post->video_free);
        $response->assertSee("公式LINEを友達追加するとフルバージョンの動画が閲覧できます！");
        $response->assertDontSeeText($post->content);
        $response->assertSeeText($post->content_free);
        $response->assertSee("公式LINEを友達追加するとフルバージョンの記事が閲覧できます！");
        $response->assertSee($post2->title);
        $response->assertSee($category->name);
    }

    public function testPost()
    {
        $post = Post::factory()->create([
            'status' => StatusEnum::$PUBLISH,
            'category_id' => null,
            'content' => 'content_' . Str::random(100),
            'content_free' => 'free_content_' . Str::random(100),
        ]);
        $response = $this->get(route('post.post', [
            'post' => $post->slug
        ]));

        $response->assertStatus(200);
        $response->assertSee($post->title);
        $response->assertDontSee($post->video);
        $response->assertSee($post->video_free);
        $response->assertSee("公式LINEを友達追加するとフルバージョンの動画が閲覧できます！");
        $response->assertDontSeeText($post->content);
        $response->assertSeeText($post->content_free);
        $response->assertSee("公式LINEを友達追加するとフルバージョンの記事が閲覧できます！");

        $post2 = Post::factory()->create([
            'status' => StatusEnum::$PUBLISH,
            'category_id' => null,
            'content' => 'content_' . Str::random(100),
            'content_free' => 'free_content_' . Str::random(100),
        ]);
        $response = $this->get(route('post.post', [
            'post' => $post->slug
        ]));
        $response->assertStatus(200);
        $response->assertSee($post->title);
        $response->assertDontSee($post->video);
        $response->assertSee($post->video_free);
        $response->assertSee("公式LINEを友達追加するとフルバージョンの動画が閲覧できます！");
        $response->assertDontSeeText($post->content);
        $response->assertSeeText($post->content_free);
        $response->assertSee("公式LINEを友達追加するとフルバージョンの記事が閲覧できます！");
        $response->assertSee($post2->title);
    }
}
