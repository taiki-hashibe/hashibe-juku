<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testGetRouteCategoryOrPost()
    {
        // カテゴリーが存在しない場合
        $post = Post::factory()->create();
        $this->assertEquals($post->getRouteCategoryOrPost(), route('post.post', [
            'post' => $post->slug,
        ]));
        // カテゴリーが存在しない＋authを指定
        $this->assertEquals($post->getRouteCategoryOrPost(true), route('user.post.post', [
            'post' => $post->slug,
        ]));
        // カテゴリーが存在しない＋auth=falseを指定
        $this->assertEquals($post->getRouteCategoryOrPost(false), route('post.post', [
            'post' => $post->slug,
        ]));
        // カテゴリーが存在する場合
        $post->update([
            'category_id' => Category::factory()->create()->id,
        ]);
        $post->refresh();
        $this->assertEquals($post->getRouteCategoryOrPost(), route('post.category', [
            'category' => $post->category->slug,
            'post' => $post->slug,
        ]));
        // カテゴリーが存在する＋authを指定
        $this->assertEquals($post->getRouteCategoryOrPost(true), route('user.post.category', [
            'category' => $post->category->slug,
            'post' => $post->slug,
        ]));
        // カテゴリーが存在する＋auth=falseを指定
        $this->assertEquals($post->getRouteCategoryOrPost(false), route('post.category', [
            'category' => $post->category->slug,
            'post' => $post->slug,
        ]));

        // 認証されている場合
        $this->actingAs(User::factory()->create(), 'users');
        // カテゴリーが存在しない場合
        $post = Post::factory()->create();
        $this->assertEquals($post->getRouteCategoryOrPost(), route('user.post.post', [
            'post' => $post->slug,
        ]));
        // カテゴリーが存在しない＋authを指定
        $this->assertEquals($post->getRouteCategoryOrPost(true), route('user.post.post', [
            'post' => $post->slug,
        ]));
        // カテゴリーが存在しない＋auth=falseを指定
        $this->assertEquals($post->getRouteCategoryOrPost(false), route('post.post', [
            'post' => $post->slug,
        ]));
        // カテゴリーが存在する場合
        $post->update([
            'category_id' => Category::factory()->create()->id,
        ]);
        $post->refresh();
        $this->assertEquals($post->getRouteCategoryOrPost(), route('user.post.category', [
            'category' => $post->category->slug,
            'post' => $post->slug,
        ]));
        // カテゴリーが存在する＋authを指定
        $this->assertEquals($post->getRouteCategoryOrPost(true), route('user.post.category', [
            'category' => $post->category->slug,
            'post' => $post->slug,
        ]));
        // カテゴリーが存在する＋auth=falseを指定
        $this->assertEquals($post->getRouteCategoryOrPost(false), route('post.category', [
            'category' => $post->category->slug,
            'post' => $post->slug,
        ]));
    }
}
