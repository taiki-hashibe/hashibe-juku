<?php

namespace Tests\Feature\Controllers\User;

use App\Models\Category;
use App\Models\Post;
use App\Models\StatusEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;
    public function testIndex()
    {
        $category = Category::factory()->create();
        $response = $this->get(route('user.category.index', [
            'category' => $category->slug,
        ]));
        $response->assertRedirect(route('user.login'));
        /**
         * auth-layoutが使用される
         * パンくずリストが表示される
         * カテゴリーが存在しても投稿が無い場合は404を返す
         */
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $response = $this->actingAs($user, 'users')->get(route('user.category.index', [
            'category' => $category->slug,
        ]));
        // カテゴリーが存在しても投稿が無い場合は404を返す
        $response->assertStatus(404);

        $post->update(['category_id' => $category->id]);
        $response = $this->actingAs($user, 'users')->get(route('user.category.index', [
            'category' => $category->slug,
        ]));
        $response->assertStatus(200);
        // パンくずリストが表示される
        $response->assertSeeInOrder([
            'マイページ',
            $category->name,
        ]);
        $response->assertSee($category->name);
        $response->assertSee($category->description);
        $response->assertSee($post->title);
        $response->assertSee($post->getDescription());
        $response->assertSee(route('user.post.category', [
            'post' => $post->slug,
            'category' => $category->slug,
        ]));
        // ユーザー用のリンクである必要がある
        $response->assertDontSee(route('post.category', [
            'post' => $post->slug,
            'category' => $category->slug,
        ]));

        // 子カテゴリーが存在するが投稿が無い場合は表示されない
        $childCategory = Category::factory()->create([
            'parent_id' => $category->id,
        ]);
        $response = $this->actingAs($user, 'users')->get(route('user.category.index', [
            'category' => $category->slug,
        ]));
        $response->assertDontSee($childCategory->name);

        // 子カテゴリーが存在し投稿がある場合は表示される
        $childPost = Post::factory()->create([
            'category_id' => $childCategory->id
        ]);
        $response = $this->actingAs($user, 'users')->get(route('user.category.index', [
            'category' => $category->slug,
        ]));
        $response->assertSee($childCategory->name);
        $response->assertDontSee($childPost->title);
        $response->assertSee(route('user.category.index', [
            'category' => $childCategory->slug,
        ]));
        // ユーザー用のリンクである必要がある
        $response->assertDontSee(route('category.index', [
            'category' => $childCategory->slug,
        ]));
        // 子カテゴリーが存在し投稿がある場合でも投稿が非公開の場合は子カテゴリーは表示されない
        $childPost->update(['status' => StatusEnum::$DRAFT]);
        $response = $this->actingAs($user, 'users')->get(route('user.category.index', [
            'category' => $category->slug,
        ]));
        $response->assertDontSee($childCategory->name);
        $response->assertDontSee($childPost->title);
        $childCategory->delete();

        // 子カテゴリーは並び順通りに表示される
        $childCategory2 = Category::factory()->create([
            'parent_id' => $category->id,
            'order' => 2,
        ]);
        $childCategory1 = Category::factory()->create([
            'parent_id' => $category->id,
            'order' => 1,
        ]);
        $childCategory0 = Category::factory()->create([
            'parent_id' => $category->id,
            'order' => 0,
        ]);
        Post::factory()->create([
            'category_id' => $childCategory2
        ]);
        Post::factory()->create([
            'category_id' => $childCategory1
        ]);
        Post::factory()->create([
            'category_id' => $childCategory0
        ]);
        $response = $this->actingAs($user, 'users')->get(route('user.category.index', [
            'category' => $category->slug,
        ]));
        $response->assertSeeInOrder([
            $childCategory0->name,
            $childCategory1->name,
            $childCategory2->name,
        ]);
    }
}
