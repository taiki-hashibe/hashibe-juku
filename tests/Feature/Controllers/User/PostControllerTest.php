<?php

namespace Tests\Feature\Controllers\User;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Models\UserTrialViewingPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex(): void
    {
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'category_id' => $category->id,
            'content' => 'main_content',
            'content_free' => 'free_content'
        ]);
        $response = $this->get(route('user.post.category', [
            'category' => $category->slug,
            'post' => $post->slug
        ]));
        $response->assertRedirect(route('user.login'));

        /**
         * auth-layoutが使用される
         * パンくずリストが表示される
         */

        /**
         * サブスクリプション未加入ユーザー
         * 一般向け動画が表示される
         * 一般向け記事が表示される
         * トライアルチケットの利用を促す
         * 動画が無ければ動画に関してはトライアルチケットの利用を促さない
         * 記事が無ければ記事に関してはトライアルチケットの利用を促さない
         */
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'users')->get(route('user.post.category', [
            'category' => $category->slug,
            'post' => $post->slug
        ]));
        $response->assertStatus(200);
        $response->assertSeeInOrder([
            'マイページ',
            $category->name,
            $post->title
        ]);
        $response->assertSee($post->title);
        $response->assertSee($post->video_free);
        $response->assertDontSee($post->video);
        $response->assertSee($post->content_free);
        $response->assertDontSee($post->content);
        $response->assertSee('トライアルチケットを使ってフルバージョンの動画を見ることができます！');
        $response->assertSee('トライアルチケットを使ってフルバージョンの記事を見ることができます！');
        $response->assertSee(route('user.post.trial-viewing'));
        // 動画が無い場合
        $post->update(['video' => null, 'video_free' => null]);
        $response = $this->actingAs($user, 'users')->get(route('user.post.category', [
            'category' => $category->slug,
            'post' => $post->slug
        ]));
        $response->assertStatus(200);
        $response->assertDontSee($post->video);
        $response->assertDontSee($post->video_free);
        $response->assertDontSee('トライアルチケットを使ってフルバージョンの動画を見ることができます！');
        // 記事が無い場合
        $post->update(['content' => null, 'content_free' => null]);
        $response = $this->actingAs($user, 'users')->get(route('user.post.category', [
            'category' => $category->slug,
            'post' => $post->slug
        ]));
        $response->assertStatus(200);
        $response->assertDontSee($post->content);
        $response->assertDontSee($post->content_free);
        $response->assertDontSee('トライアルチケットを使ってフルバージョンの記事を見ることができます!');

        $post->update(['video' => 'video.mp4', 'content' => 'main_content', 'content_free' => 'free_content']);

        /**
         * サブスクリプション未加入ユーザー + トライアルチケットを利用済み
         * 会員向け動画が表示される
         * 会員向け記事が表示される
         */
        UserTrialViewingPost::create([
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);
        $response = $this->actingAs($user, 'users')->get(route('user.post.category', [
            'category' => $category->slug,
            'post' => $post->slug
        ]));
        $response->assertStatus(200);
        $response->assertSeeInOrder([
            'マイページ',
            $category->name,
            $post->title
        ]);
        $response->assertSee($post->title);
        $response->assertSee($post->video);
        $response->assertDontSee($post->video_free);
        $response->assertSee($post->content);
        $response->assertDontSee($post->content_free);
        $response->assertDontSee('トライアルチケットを使ってフルバージョンの動画を見ることができます！');
        $response->assertDontSee('トライアルチケットを使ってフルバージョンの記事を見ることができます！');
        $response->assertDontSee(route('user.post.trial-viewing'));

        /**
         * サブスクリプション加入済みユーザー
         * 会員向け動画が表示される
         * 会員向け記事が表示される
         * 一般公開日前でも表示される
         */
        $response = $this->actingAs($this->subscribedUser, 'users')->get(route('user.post.category', [
            'category' => $category->slug,
            'post' => $post->slug
        ]));
        $response->assertStatus(200);
        $response->assertSeeInOrder([
            'マイページ',
            $category->name,
            $post->title
        ]);
        $response->assertSee($post->title);
        $response->assertSee($post->video);
        $response->assertDontSee($post->video_free);
        $response->assertSee($post->content);
        $response->assertDontSee($post->content_free);
        $response->assertDontSee('トライアルチケットを使ってフルバージョンの動画を見ることができます！');
        $response->assertDontSee('トライアルチケットを使ってフルバージョンの記事を見ることができます！');
        // 動画が無い場合
        $post->update(['video' => null]);
        $response = $this->actingAs($this->subscribedUser, 'users')->get(route('user.post.category', [
            'category' => $category->slug,
            'post' => $post->slug
        ]));
        $response->assertStatus(200);
        $response->assertDontSee($post->video);
        $response->assertDontSee($post->video_free);
        // 記事が無い場合
        $post->update(['content' => null]);
        $response = $this->actingAs($this->subscribedUser, 'users')->get(route('user.post.category', [
            'category' => $category->slug,
            'post' => $post->slug
        ]));
        $response->assertStatus(200);
        $response->assertDontSee($post->content);
        $response->assertDontSee($post->content_free);

        $post->update(['video' => 'video.mp4', 'content' => 'main_content', 'content_free' => 'free_content']);
        // 一般公開日前の場合でも閲覧できる
        $post->update(['published_at' => now()->addDay()]);
        $response = $this->actingAs($this->subscribedUser, 'users')->get(route('user.post.category', [
            'category' => $category->slug,
            'post' => $post->slug
        ]));
        $response->assertStatus(200);
        $response->assertSee($post->title);
        $response->assertSee($post->video);
        $response->assertDontSee($post->video_free);
        $response->assertSee($post->content);
        $response->assertDontSee($post->content_free);
        // 同じ階層の記事が表示される
        $post2 = Post::factory()->create([
            'category_id' => $category->id,
            'order' => 2
        ]);
        $post1 = Post::factory()->create([
            'category_id' => $category->id,
            'order' => 1
        ]);
        $post0 = Post::factory()->create([
            'category_id' => $category->id,
            'order' => 0
        ]);
        $response = $this->actingAs($this->subscribedUser, 'users')->get(route('user.post.category', [
            'category' => $category->slug,
            'post' => $post->slug
        ]));
        $response->assertStatus(200);
        $response->assertSeeInOrder([
            $post0->title,
            $post1->title,
            $post2->title
        ]);
    }

    public function testPost(): void
    {
        $post = Post::factory()->create([
            'content' => 'main_content',
            'content_free' => 'free_content'
        ]);
        $response = $this->get(route('user.post.post', [
            'post' => $post->slug
        ]));
        $response->assertRedirect(route('user.login'));

        /**
         * auth-layoutが使用される
         * パンくずリストが表示される
         */

        /**
         * サブスクリプション未加入ユーザー
         * 一般向け動画が表示される
         * 一般向け記事が表示される
         * トライアルチケットの利用を促す
         * 動画が無ければ動画に関してはトライアルチケットの利用を促さない
         * 記事が無ければ記事に関してはトライアルチケットの利用を促さない
         */
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'users')->get(route('user.post.post', [
            'post' => $post->slug
        ]));
        $response->assertStatus(200);
        $response->assertSeeInOrder([
            'マイページ',
            $post->title
        ]);
        $response->assertSee($post->title);
        $response->assertSee($post->video_free);
        $response->assertDontSee($post->video);
        $response->assertSee($post->content_free);
        $response->assertDontSee($post->content);
        $response->assertSee('トライアルチケットを使ってフルバージョンの動画を見ることができます！');
        $response->assertSee('トライアルチケットを使ってフルバージョンの記事を見ることができます！');
        $response->assertSee(route('user.post.trial-viewing'));
        // 動画が無い場合
        $post->update(['video' => null, 'video_free' => null]);
        $response = $this->actingAs($user, 'users')->get(route('user.post.post', [
            'post' => $post->slug
        ]));
        $response->assertStatus(200);
        $response->assertDontSee($post->video);
        $response->assertDontSee($post->video_free);
        $response->assertDontSee('トライアルチケットを使ってフルバージョンの動画を見ることができます！');
        // 記事が無い場合
        $post->update(['content' => null, 'content_free' => null]);
        $response = $this->actingAs($user, 'users')->get(route('user.post.post', [
            'post' => $post->slug
        ]));
        $response->assertStatus(200);
        $response->assertDontSee($post->content);
        $response->assertDontSee($post->content_free);
        $response->assertDontSee('トライアルチケットを使ってフルバージョンの記事を見ることができます!');

        $post->update(['video' => 'video.mp4', 'content' => 'main_content', 'content_free' => 'free_content']);

        /**
         * サブスクリプション未加入ユーザー + トライアルチケットを利用済み
         * 会員向け動画が表示される
         * 会員向け記事が表示される
         */
        UserTrialViewingPost::create([
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);
        $response = $this->actingAs($user, 'users')->get(route('user.post.post', [
            'post' => $post->slug
        ]));
        $response->assertStatus(200);
        $response->assertSeeInOrder([
            'マイページ',
            $post->title
        ]);
        $response->assertSee($post->title);
        $response->assertSee($post->video);
        $response->assertDontSee($post->video_free);
        $response->assertSee($post->content);
        $response->assertDontSee($post->content_free);
        $response->assertDontSee('トライアルチケットを使ってフルバージョンの動画を見ることができます！');
        $response->assertDontSee('トライアルチケットを使ってフルバージョンの記事を見ることができます！');
        $response->assertDontSee(route('user.post.trial-viewing'));

        /**
         * サブスクリプション加入済みユーザー
         * 会員向け動画が表示される
         * 会員向け記事が表示される
         * 一般公開日前でも表示される
         */
        $response = $this->actingAs($this->subscribedUser, 'users')->get(route('user.post.post', [
            'post' => $post->slug
        ]));
        $response->assertStatus(200);
        $response->assertSeeInOrder([
            'マイページ',
            $post->title
        ]);
        $response->assertSee($post->title);
        $response->assertSee($post->video);
        $response->assertDontSee($post->video_free);
        $response->assertSee($post->content);
        $response->assertDontSee($post->content_free);
        $response->assertDontSee('トライアルチケットを使ってフルバージョンの動画を見ることができます！');
        $response->assertDontSee('トライアルチケットを使ってフルバージョンの記事を見ることができます！');
        // 動画が無い場合
        $post->update(['video' => null]);
        $response = $this->actingAs($this->subscribedUser, 'users')->get(route('user.post.post', [
            'post' => $post->slug
        ]));
        $response->assertStatus(200);
        $response->assertDontSee($post->video);
        $response->assertDontSee($post->video_free);
        // 記事が無い場合
        $post->update(['content' => null]);
        $response = $this->actingAs($this->subscribedUser, 'users')->get(route('user.post.post', [
            'post' => $post->slug
        ]));
        $response->assertStatus(200);
        $response->assertDontSee($post->content);
        $response->assertDontSee($post->content_free);

        $post->update(['video' => 'video.mp4', 'content' => 'main_content', 'content_free' => 'free_content']);
        // 一般公開日前の場合でも閲覧できる
        $post->update(['published_at' => now()->addDay()]);
        $response = $this->actingAs($this->subscribedUser, 'users')->get(route('user.post.post', [
            'post' => $post->slug
        ]));
        $response->assertStatus(200);
        $response->assertSee($post->title);
        $response->assertSee($post->video);
        $response->assertDontSee($post->video_free);
        $response->assertSee($post->content);
        $response->assertDontSee($post->content_free);
        // 同じ階層の記事が表示される
        $post2 = Post::factory()->create([
            'order' => 2
        ]);
        $post1 = Post::factory()->create([
            'order' => 1
        ]);
        $post0 = Post::factory()->create([
            'order' => 0
        ]);
        $response = $this->actingAs($this->subscribedUser, 'users')->get(route('user.post.post', [
            'post' => $post->slug
        ]));
        $response->assertStatus(200);
        $response->assertSeeInOrder([
            $post0->title,
            $post1->title,
            $post2->title
        ]);
    }

    public function testTrialViewing()
    {
        $post = Post::factory()->create();
        $response = $this->post(route('user.post.trial-viewing', [
            'post_id' => $post->id
        ]));
        $response->assertRedirect(route('user.login'));

        $user = User::factory()->create();
        $response = $this->actingAs($user, 'users')->post(route('user.post.trial-viewing', [
            'post_id' => $post->id
        ]));
        $response->assertRedirect(route('user.post.post', ['post' => $post->slug]));
        $response->assertSessionHas('message', 'トライアルチケットを使用しました！');
        $this->assertDatabaseHas('user_trial_viewing_posts', [
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);
        // トライアルチケットの利用は5回まで
        for ($i = 0; $i < 3; $i++) {
            UserTrialViewingPost::create([
                'user_id' => $user->id,
                'post_id' => Post::factory()->create()->id
            ]);
        }
        $this->assertEquals(4, UserTrialViewingPost::where('user_id', $user->id)->count());
        $post = Post::factory()->create();
        // 5回目の利用
        $response = $this->actingAs($user, 'users')->post(route('user.post.trial-viewing', [
            'post_id' => $post->id
        ]));
        $response->assertRedirect(route('user.post.post', ['post' => $post->slug]));
        $response->assertSessionHas('message', 'トライアルチケットを使用しました！');
        $this->assertDatabaseHas('user_trial_viewing_posts', [
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);
        // 6回目の利用
        $post = Post::factory()->create();
        $response = $this->actingAs($user, 'users')->post(route('user.post.trial-viewing', [
            'post_id' => $post->id
        ]));
        $response->assertSessionHas('message', 'トライアルチケットを使い切りました');
        $this->assertNull(UserTrialViewingPost::where('user_id', $user->id)->where('post_id', $post->id)->first());
        $response->assertRedirect(route('user.register.guidance'));

        // 同じ投稿に対しての重複登録はできない
        UserTrialViewingPost::all()->each->delete();
        UserTrialViewingPost::create([
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);
        $response = $this->actingAs($user, 'users')->post(route('user.post.trial-viewing', [
            'post_id' => $post->id
        ]));
        $response->assertSessionHas('message', '既にチケットを使用済みです');
        $response->assertRedirect(route('user.post.post', ['post' => $post->slug]));
        $this->assertCount(1, UserTrialViewingPost::where('user_id', $user->id)->where('post_id', $post->id)->get());
    }
}
