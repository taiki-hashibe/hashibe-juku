<?php

namespace Tests\Feature\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\StatusEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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
            'title' => 'title',
            'category_id' => $category->id,
            'content' => 'main_content',
            'content_free' => 'free_content',
        ]);
        $response = $this->get(route('post.category', [
            'category' => $category->slug,
            'post' => $post->slug,
        ]));
        $response->assertStatus(200);
        // パンくずリストが表示される
        $response->assertSeeInOrder([
            'トップページ',
            $category->name,
            $post->title,
        ]);
        // 一般公開用動画が表示される
        $response->assertDontSee($post->video);
        $response->assertSee($post->video_free);
        // 一般公開用コンテンツが表示される
        $response->assertDontSee($post->content);
        $response->assertSee($post->content_free);
        // 動画下に公式LINEへの誘導が表示される
        $response->assertSee("公式LINEを友達追加するとフルバージョンの動画が閲覧できます！");
        $response->assertSee(config('line.link'));
        // 記事下に公式LINEへの誘導が表示される
        $response->assertSee("公式LINEを友達追加するとフルバージョンの記事が閲覧できます！");

        // 公式LINE追加用URLが設定されていればそちらを表示する
        $post->update([
            'line_link' => 'https://example.com',
        ]);
        $post->refresh();
        $response = $this->get(route('post.category', [
            'category' => $category->slug,
            'post' => $post->slug,
        ]));
        $response->assertStatus(200);
        $response->assertSee("https://example.com");

        // 一般公開用動画が無い場合
        $post->update([
            'video_free' => null,
        ]);
        $post->refresh();
        $response = $this->get(route('post.category', [
            'category' => $category->slug,
            'post' => $post->slug,
        ]));
        $response->assertStatus(200);
        // 会員用動画が表示される
        $response->assertSee($post->video);
        // 動画下の公式LINEへの誘導は表示されない
        $response->assertDontSee("公式LINEを友達追加するとフルバージョンの動画が閲覧できます！");
        $response->assertDontSee(config('https://example.com'));
        // 記事は通常の表示
        // 一般公開用コンテンツが表示される
        $response->assertDontSee($post->content);
        $response->assertSee($post->content_free);
        // 記事下に公式LINEへの誘導が表示される
        $response->assertSee("公式LINEを友達追加するとフルバージョンの記事が閲覧できます！");

        // 一般公開用コンテンツが無い場合
        $post->update([
            'content_free' => null,
        ]);
        $post->refresh();
        $response = $this->get(route('post.category', [
            'category' => $category->slug,
            'post' => $post->slug,
        ]));
        $response->assertStatus(200);
        // 会員用動画が表示される
        $response->assertSee($post->video);
        // 動画下の公式LINEへの誘導は表示されない
        $response->assertDontSee("公式LINEを友達追加するとフルバージョンの動画が閲覧できます！");
        $response->assertDontSee(config('https://example.com'));
        // 会員用コンテンツが表示される
        $response->assertSee($post->content);
        $response->assertDontSee($post->content_free);
        // 記事下の公式LINEへの誘導は表示されない
        $response->assertDontSee("公式LINEを友達追加するとフルバージョンの記事が閲覧できます！");

        // 動画が無い場合
        $post->update([
            'video' => null,
        ]);
        $post->refresh();
        $response = $this->get(route('post.category', [
            'category' => $category->slug,
            'post' => $post->slug,
        ]));
        $response->assertStatus(200);
        // 会員用動画が表示されない
        $response->assertDontSee($post->video);
        // 動画下に公式LINEへの誘導が表示されない
        $response->assertDontSee("公式LINEを友達追加するとフルバージョンの動画が閲覧できます！");
        // 会員用コンテンツが表示される
        $response->assertSee($post->content);
        $response->assertDontSee($post->content_free);
        // 記事下の公式LINEへの誘導は表示されない
        $response->assertDontSee("公式LINEを友達追加するとフルバージョンの記事が閲覧できます！");

        // コンテンツが無い場合
        $post->update([
            'content' => null,
        ]);
        $post->refresh();
        $response = $this->get(route('post.category', [
            'category' => $category->slug,
            'post' => $post->slug,
        ]));
        $response->assertStatus(200);
        // 会員用動画が表示されない
        $response->assertDontSee($post->video);
        $response->assertDontSee($post->video_free);
        // 動画下に公式LINEへの誘導が表示されない
        $response->assertDontSee("公式LINEを友達追加するとフルバージョンの動画が閲覧できます！");
        // 会員用コンテンツが表示されない
        $response->assertDontSee($post->content);
        $response->assertDontSee($post->content_free);
        // 記事下の公式LINEへの誘導は表示されない
        $response->assertDontSee("公式LINEを友達追加するとフルバージョンの記事が閲覧できます！");
        // meta=descriptionはデフォルトになる
        $response->assertSee(config('seotools.meta.defaults.description'));

        // 同じ階層に記事があれば表示される
        $post2 = Post::factory()->create([
            'category_id' => $category->id,
            'order' => 2,
        ]);
        $post1 = Post::factory()->create([
            'category_id' => $category->id,
            'order' => 1,
        ]);
        $post0 = Post::factory()->create([
            'category_id' => $category->id,
            'order' => 0,
        ]);
        $response = $this->get(route('post.category', [
            'category' => $category->slug,
            'post' => $post->slug,
        ]));
        $response->assertStatus(200);
        $response->assertSeeInOrder([
            $post0->title,
            $post1->title,
            $post2->title,
        ]);

        // 一般公開前の場合
        $post->update([
            'public_release_at' => now()->addDay(),
        ]);
        $post->refresh();
        $response = $this->get(route('post.category', [
            'category' => $category->slug,
            'post' => $post->slug,
        ]));
        $response->assertStatus(200);
        $response->assertSeeText('このレッスンは' . $post->public_release_at->format('Y年m月d日 H時i分') . 'に公開予定です。');
        $response->assertSeeInOrder([
            '公式LINEを友達追加して先取り視聴しよう！',
            'https://example.com',
            route('user.post.category', [
                'category' => $category->slug,
                'post' => $post->slug,
            ]),
        ]);

        // 認証済みの場合はリダイレクトされる
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'users')->get(route('post.category', [
            'category' => $category->slug,
            'post' => $post->slug,
        ]));
        $response->assertRedirect(route('user.post.category', [
            'category' => $category->slug,
            'post' => $post->slug,
        ]));
        // アクセスログが記録されている
        $this->assertDatabaseHas('access_logs', [
            'url' => route('post.category', [
                'category' => $category->slug,
                'post' => $post->slug,
            ]),
        ]);
    }

    public function testPost()
    {
        $post = Post::factory()->create([
            'title' => 'title',
            'content' => 'main_content',
            'content_free' => 'free_content',
        ]);
        $response = $this->get(route('post.post', [
            'post' => $post->slug,
        ]));
        $response->assertStatus(200);
        // パンくずリストが表示される
        $response->assertSeeInOrder([
            'トップページ',
            $post->title,
        ]);
        // 一般公開用動画が表示される
        $response->assertDontSee($post->video);
        $response->assertSee($post->video_free);
        // 一般公開用コンテンツが表示される
        $response->assertDontSee($post->content);
        $response->assertSee($post->content_free);
        // 動画下に公式LINEへの誘導が表示される
        $response->assertSee("公式LINEを友達追加するとフルバージョンの動画が閲覧できます！");
        $response->assertSee(config('line.link'));
        // 記事下に公式LINEへの誘導が表示される
        $response->assertSee("公式LINEを友達追加するとフルバージョンの記事が閲覧できます！");

        // 公式LINE追加用URLが設定されていればそちらを表示する
        $post->update([
            'line_link' => 'https://example.com',
        ]);
        $post->refresh();
        $response = $this->get(route('post.post', [
            'post' => $post->slug,
        ]));
        $response->assertStatus(200);
        $response->assertSee("https://example.com");

        // 一般公開用動画が無い場合
        $post->update([
            'video_free' => null,
        ]);
        $post->refresh();
        $response = $this->get(route('post.post', [
            'post' => $post->slug,
        ]));
        $response->assertStatus(200);
        // 会員用動画が表示される
        $response->assertSee($post->video);
        // 動画下の公式LINEへの誘導は表示されない
        $response->assertDontSee("公式LINEを友達追加するとフルバージョンの動画が閲覧できます！");
        // 記事は通常の表示
        // 一般公開用コンテンツが表示される
        $response->assertDontSee($post->content);
        $response->assertSee($post->content_free);
        // 記事下に公式LINEへの誘導が表示される
        $response->assertSee("公式LINEを友達追加するとフルバージョンの記事が閲覧できます！");

        // 一般公開用コンテンツが無い場合
        $post->update([
            'content_free' => null,
        ]);
        $post->refresh();
        $response = $this->get(route('post.post', [
            'post' => $post->slug,
        ]));
        $response->assertStatus(200);
        // 会員用動画が表示される
        $response->assertSee($post->video);
        // 動画下の公式LINEへの誘導は表示されない
        $response->assertDontSee("公式LINEを友達追加するとフルバージョンの動画が閲覧できます！");
        $response->assertDontSee(config('https://example.com'));
        // 会員用コンテンツが表示される
        $response->assertSee($post->content);
        $response->assertDontSee($post->content_free);
        // 記事下の公式LINEへの誘導は表示されない
        $response->assertDontSee("公式LINEを友達追加するとフルバージョンの記事が閲覧できます！");

        // 動画が無い場合
        $post->update([
            'video' => null,
        ]);
        $post->refresh();
        $response = $this->get(route('post.post', [
            'post' => $post->slug,
        ]));
        $response->assertStatus(200);
        // 会員用動画が表示されない
        $response->assertDontSee($post->video);
        // 動画下に公式LINEへの誘導が表示されない
        $response->assertDontSee("公式LINEを友達追加するとフルバージョンの動画が閲覧できます！");
        // 会員用コンテンツが表示される
        $response->assertSee($post->content);
        $response->assertDontSee($post->content_free);
        // 記事下の公式LINEへの誘導は表示されない
        $response->assertDontSee("公式LINEを友達追加するとフルバージョンの記事が閲覧できます！");

        // コンテンツが無い場合
        $post->update([
            'content' => null,
        ]);
        $post->refresh();
        $response = $this->get(route('post.post', [
            'post' => $post->slug,
        ]));
        $response->assertStatus(200);
        // 会員用動画が表示されない
        $response->assertDontSee($post->video);
        $response->assertDontSee($post->video_free);
        // 動画下に公式LINEへの誘導が表示されない
        $response->assertDontSee("公式LINEを友達追加するとフルバージョンの動画が閲覧できます！");
        // 会員用コンテンツが表示されない
        $response->assertDontSee($post->content);
        $response->assertDontSee($post->content_free);
        // 記事下に公式LINEへの誘導が表示されない
        $response->assertDontSee("公式LINEを友達追加するとフルバージョンの記事が閲覧できます！");
        // meta=descriptionはデフォルトになる
        $response->assertSee(config('seotools.meta.defaults.description'));

        // 同じ階層に記事があれば表示される
        $post2 = Post::factory()->create([
            'order' => 2,
        ]);
        $post1 = Post::factory()->create([
            'order' => 1,
        ]);
        $post0 = Post::factory()->create([
            'order' => 0,
        ]);
        $response = $this->get(route('post.post', [
            'post' => $post->slug,
        ]));
        $response->assertStatus(200);
        $response->assertSeeInOrder([
            $post0->title,
            $post1->title,
            $post2->title,
        ]);

        // 一般公開前の場合
        $post->update([
            'public_release_at' => now()->addDay(),
        ]);
        $post->refresh();
        $response = $this->get(route('post.post', [
            'post' => $post->slug,
        ]));
        $response->assertStatus(200);
        $response->assertSeeText('このレッスンは' . $post->public_release_at->format('Y年m月d日 H時i分') . 'に公開予定です。');
        $response->assertSeeInOrder([
            '公式LINEを友達追加して先取り視聴しよう！',
            'https://example.com',
            route('user.post.post', [
                'post' => $post->slug,
            ]),
        ]);

        // 認証済みの場合はリダイレクトされる
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'users')->get(route('post.post', [
            'post' => $post->slug,
        ]));
        $response->assertRedirect(route('user.post.post', [
            'post' => $post->slug,
        ]));
        // アクセスログが記録されている
        $this->assertDatabaseHas('access_logs', [
            'url' => route('post.post', [
                'post' => $post->slug,
            ]),
        ]);
    }
}
