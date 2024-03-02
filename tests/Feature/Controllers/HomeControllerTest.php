<?php

namespace Tests\Feature\Controllers;

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
    /**
     * A basic feature test example.
     */
    public function testIndex(): void
    {
        /**
         * guest-layoutが使用される
         * パンくずリストが表示される
         * カテゴリーが無ければ見出しも表示されない
         * カリキュラムが無ければ見出しも表示されない
         */
        $response = $this->get(route('home'));
        $response->assertStatus(200);
        // アクセスログが記録されている
        $this->assertDatabaseHas('access_logs', [
            'url' => route('home'),
        ]);
        // ヘッダーのテスト
        $response->assertSee(route('home'));
        $response->assertSee('公式LINE');
        $response->assertSee(config('line.link'));
        $response->assertSee('ログイン');
        $response->assertSee(route('user.login'));

        // パンくずリストが表示される
        $response->assertSee('トップページ');
        // カテゴリーが無い場合
        $response->assertDontSee('カテゴリーから探す');
        // カリキュラムが無い場合
        $response->assertDontSee('カリキュラムから探す');
        // 投稿もカテゴリーもカリキュラムもない場合、公式LINEの追加ボタンが表示される
        $response->assertSee(asset('images/line-icon.png'));

        // 投稿が存在する場合
        $post = Post::factory()->create();
        $response = $this->get(route('home'));
        $response->assertSee($post->title);
        $response->assertSee($post->getDescription());
        $response->assertSee(route('post.post', [
            'post' => $post->slug,
        ]));
        // 投稿が存在するので、公式LINEの追加ボタンが表示されない
        $response->assertDontSee(asset('images/line-icon.png'));

        // カテゴリーが存在する場合
        $category = Category::factory()->create();
        $post->update(['category_id' => $category->id]);
        $response = $this->get(route('home'));
        // 投稿はカテゴリーに紐づいているので表示されなくなる
        $response->assertDontSee($post->title);
        // カテゴリーの見出しが表示される
        $response->assertSee("カテゴリーから探す");
        $response->assertSee($category->name);
        $response->assertSee(route('category.index', [
            'category' => $category->slug,
        ]));
        // カリキュラムの見出しは表示されない
        $response->assertDontSee('カリキュラムから探す');
        // 投稿が存在するので、公式LINEの追加ボタンが表示されない
        $response->assertDontSee(asset('images/line-icon.png'));

        // カテゴリーが存在するが紐づく投稿が無い場合
        $post->update(['category_id' => null]);
        $response = $this->get(route('home'));
        $response->assertSee($post->title);
        $response->assertSee($post->getDescription());
        $response->assertSee(route('post.post', [
            'post' => $post->slug,
        ]));
        // カテゴリーの見出しは表示されない
        $response->assertDontSee("カテゴリーから探す");
        // カリキュラムの見出しは表示されない
        $response->assertDontSee('カリキュラムから探す');
        // カテゴリーが存在するので、公式LINEの追加ボタンが表示されない
        $response->assertDontSee(asset('images/line-icon.png'));

        // カリキュラムが存在する場合
        $curriculum = Curriculum::factory()->create();
        $curriculumPost = CurriculumPost::factory()->create([
            'curriculum_id' => $curriculum->id,
            'post_id' => $post->id,
        ]);
        $response = $this->get(route('home'));
        $response->assertSee($post->title);
        $response->assertSee($post->getDescription());
        $response->assertSee(route('post.post', [
            'post' => $post->slug,
        ]));
        // カテゴリーの見出しは表示されない
        $response->assertDontSee("カテゴリーから探す");
        // カリキュラムの見出しが表示される
        $response->assertSee('カリキュラムから探す');
        $response->assertSee($curriculum->name);
        $response->assertSee($curriculum->description);
        $response->assertSee($curriculum->image);
        $response->assertSee(route('curriculum.index', [
            'curriculum' => $curriculum->slug,
        ]));
        // カリキュラムが存在するので、公式LINEの追加ボタンが表示されない
        $response->assertDontSee(asset('images/line-icon.png'));

        // カリキュラムが存在するが紐づく投稿が無い場合
        $curriculumPost->delete();
        $response = $this->get(route('home'));
        $response->assertSee($post->title);
        $response->assertSee(route('post.post', [
            'post' => $post->slug,
        ]));
        // カテゴリーの見出しは表示されない
        $response->assertDontSee("カテゴリーから探す");
        // カリキュラムの見出しは表示されない
        $response->assertDontSee('カリキュラムから探す');
        $response->assertDontSee($curriculum->name);
        // 投稿が存在するので、公式LINEの追加ボタンが表示されない
        $response->assertDontSee(asset('images/line-icon.png'));
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
        $response = $this->get(route('home'));
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
        $response = $this->get(route('home'));
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
        $response = $this->get(route('home'));
        $response->assertSeeInOrder([
            $curriculum0->name,
            $curriculum1->name,
            $curriculum2->name,
        ]);

        // ユーザー認証済みであればユーザーページにリダイレクトする
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'users')->get(route('home'));
        $response->assertRedirect(route('user.home'));
    }
}
