<?php

namespace Tests\Feature\Controllers\User;

use App\Models\Category;
use App\Models\Curriculum;
use App\Models\CurriculumPost;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;
    public function testIndex(): void
    {
        $response = $this->get(route('user.home'));
        $response->assertRedirect(route('user.login'));
        /**
         * auth-layoutが使用される
         * パンくずリストが表示される
         * カテゴリーが無ければ見出しも表示されない
         * カリキュラムが無ければ見出しも表示されない
         */
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'users')->get(route('user.home'));
        $response->assertStatus(200);
        // ヘッダーのテスト
        $response->assertSee(route('user.home'));
        $response->assertSee($user->name);
        $response->assertSeeInOrder([
            route('user.bookmark'),
            route('user.complete'),
            route('user.logout'),
        ]);

        // パンくずリストが表示される
        $response->assertSee('トップページ');
        // カテゴリーが無い場合
        $response->assertDontSee('カテゴリーから探す');
        // カリキュラムが無い場合
        $response->assertDontSee('カリキュラムから探す');
        // 投稿もカテゴリーもカリキュラムも無くても公式LINEの追加ボタンは表示されない
        $response->assertDontSee(asset('images/line-icon.png'));

        // 投稿が存在する場合
        $post = Post::factory()->create();
        $response = $this->actingAs($user, 'users')->get(route('user.home'));
        $response->assertSee($post->title);
        $response->assertSee($post->getDescription());
        $response->assertSee(route('user.post.post', [
            'post' => $post->slug,
        ]));
        // ユーザー用のリンクである必要がある
        $response->assertDontSee(route('post.post', [
            'post' => $post->slug,
        ]));

        // カテゴリーが存在する場合
        $category = Category::factory()->create();
        $post->update(['category_id' => $category->id]);
        $response = $this->actingAs($user, 'users')->get(route('user.home'));
        // 投稿はカテゴリーに紐づいているので表示されなくなる
        $response->assertDontSee($post->title);
        // カテゴリーの見出しが表示される
        $response->assertSee("カテゴリーから探す");
        $response->assertSee($category->name);
        $response->assertSee(route('user.category.index', [
            'category' => $category->slug,
        ]));
        // ユーザー用のリンクである必要がある
        $response->assertDontSee(route('category.index', [
            'category' => $category->slug,
        ]));

        // カリキュラムの見出しは表示されない
        $response->assertDontSee('カリキュラムから探す');

        // カテゴリーが存在するが紐づく投稿が無い場合
        $post->update(['category_id' => null]);
        $response = $this->actingAs($user, 'users')->get(route('user.home'));
        $response->assertSee($post->title);
        $response->assertSee($post->getDescription());
        $response->assertSee(route('user.post.post', [
            'post' => $post->slug,
        ]));
        // ユーザー用のリンクである必要がある
        $response->assertDontSee(route('post.post', [
            'post' => $post->slug,
        ]));

        // カテゴリーの見出しは表示されない
        $response->assertDontSee("カテゴリーから探す");
        // カリキュラムの見出しは表示されない
        $response->assertDontSee('カリキュラムから探す');

        // カリキュラムが存在する場合
        $curriculum = Curriculum::factory()->create();
        $curriculumPost = CurriculumPost::factory()->create([
            'curriculum_id' => $curriculum->id,
            'post_id' => $post->id,
        ]);
        $response = $this->actingAs($user, 'users')->get(route('user.home'));
        $response->assertSee($post->title);
        $response->assertSee($post->getDescription());
        $response->assertSee(route('user.post.post', [
            'post' => $post->slug,
        ]));
        // ユーザー用のリンクである必要がある
        $response->assertDontSee(route('post.post', [
            'post' => $post->slug,
        ]));
        // カテゴリーの見出しは表示されない
        $response->assertDontSee("カテゴリーから探す");
        // カリキュラムの見出しが表示される
        $response->assertSee('カリキュラムから探す');
        $response->assertSee($curriculum->name);
        $response->assertSee($curriculum->description);
        $response->assertSee($curriculum->image);
        $response->assertSee(route('user.curriculum.index', [
            'curriculum' => $curriculum->slug,
        ]));
        // ユーザー用のリンクである必要がある
        $response->assertDontSee(route('curriculum.index', [
            'curriculum' => $curriculum->slug,
        ]));

        // カリキュラムが存在するが紐づく投稿が無い場合
        $curriculumPost->delete();
        $response = $this->actingAs($user, 'users')->get(route('user.home'));
        $response->assertSee($post->title);
        $response->assertSee(route('user.post.post', [
            'post' => $post->slug,
        ]));
        // ユーザー用のリンクである必要がある
        $response->assertDontSee(route('post.post', [
            'post' => $post->slug,
        ]));
        // カテゴリーの見出しは表示されない
        $response->assertDontSee("カテゴリーから探す");
        // カリキュラムの見出しは表示されない
        $response->assertDontSee('カリキュラムから探す');
        $response->assertDontSee($curriculum->name);
        $post->delete();

        // 投稿は並び順通りになっている
        $post2 = Post::factory()->create([
            'order' => 2
        ]);
        $post1 = Post::factory()->create([
            'order' => 1
        ]);
        $post0 = Post::factory()->create([
            'order' => 0
        ]);
        $response = $this->actingAs($user, 'users')->get(route('user.home'));
        $response->assertSeeInOrder([
            $post0->title,
            $post1->title,
            $post2->title,
        ]);
        // カテゴリーは並び順通りになっている
        $category2 = Category::factory()->create([
            'order' => 2
        ]);
        $category1 = Category::factory()->create([
            'order' => 1
        ]);
        $category0 = Category::factory()->create([
            'order' => 0
        ]);
        $post0->update(['category_id' => $category0->id]);
        $post1->update(['category_id' => $category1->id]);
        $post2->update(['category_id' => $category2->id]);
        $response = $this->actingAs($user, 'users')->get(route('user.home'));
        $response->assertSeeInOrder([
            $category0->name,
            $category1->name,
            $category2->name,
        ]);
        // カリキュラムは並び順通りになっている
        $curriculum2 = Curriculum::factory()->create([
            'order' => 2
        ]);
        $curriculum1 = Curriculum::factory()->create([
            'order' => 1
        ]);
        $curriculum0 = Curriculum::factory()->create([
            'order' => 0
        ]);
        $curriculumPost = CurriculumPost::factory()->create([
            'curriculum_id' => $curriculum0->id,
            'post_id' => $post0->id,
        ]);
        $curriculumPost = CurriculumPost::factory()->create([
            'curriculum_id' => $curriculum1->id,
            'post_id' => $post1->id,
        ]);
        $curriculumPost = CurriculumPost::factory()->create([
            'curriculum_id' => $curriculum2->id,
            'post_id' => $post2->id,
        ]);
        $response = $this->actingAs($user, 'users')->get(route('user.home'));
        $response->assertSeeInOrder([
            $curriculum0->name,
            $curriculum1->name,
            $curriculum2->name,
        ]);
    }
}
