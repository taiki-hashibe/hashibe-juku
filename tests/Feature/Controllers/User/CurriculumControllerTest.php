<?php

namespace Tests\Feature\Controllers\User;

use App\Models\Curriculum;
use App\Models\CurriculumPost;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CurriculumControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function testIndex(): void
    {
        $post = Post::factory()->create();
        $curriculum = Curriculum::factory()->create();
        $curriculumPost = CurriculumPost::factory()->create([
            'curriculum_id' => $curriculum->id,
            'post_id' => $post->id,
        ]);
        $response = $this->get(route('user.curriculum.index', ['curriculum' => $curriculum->id]));
        $response->assertRedirect(route('user.login'));

        /**
         * auth-layoutが使用される
         * パンくずリストが表示される
         * サブスクリプション加入ユーザーのみアクセスできる
         * カリキュラムが存在しても投稿が無い場合は404を返す
         */

        $response = $this->actingAs($this->subscribedUser, 'users')->get(route('user.curriculum.index', ['curriculum' => $curriculum->slug]));
        $response->assertStatus(200);
        $response->assertSeeInOrder([
            'マイページ',
            $curriculum->name
        ]);
        $response->assertSee($curriculum->description);
        $response->assertSee($post->title);
        $response->assertSee($post->getDescription());
        $response->assertSee(route('user.curriculum.post', ['curriculum' => $curriculum->slug, 'post' => $post->slug]));
        $post2 = Post::factory()->create();
        $post1 = Post::factory()->create();
        $post0 = Post::factory()->create();
        CurriculumPost::factory()->create([
            'curriculum_id' => $curriculum->id,
            'post_id' => $post2->id,
            'order' => 2
        ]);
        CurriculumPost::factory()->create([
            'curriculum_id' => $curriculum->id,
            'post_id' => $post1->id,
            'order' => 1
        ]);
        CurriculumPost::factory()->create([
            'curriculum_id' => $curriculum->id,
            'post_id' => $post0->id,
            'order' => 0
        ]);
        // 投稿は並び順通りになっている
        $response = $this->actingAs($this->subscribedUser, 'users')->get(route('user.curriculum.index', ['curriculum' => $curriculum->slug]));
        $response->assertSeeInOrder([
            $post0->title,
            $post1->title,
            $post2->title,
        ]);

        // サブスクリプションに加入していないユーザーは閲覧できない
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'users')->get(route('user.curriculum.index', ['curriculum' => $curriculum->slug]));
        $response->assertRedirect(route('user.register.guidance'));
    }

    public function testPost()
    {
        $post = Post::factory()->create([
            'content' => 'main_content',
            'content_free' => 'free_content',
        ]);
        $curriculum = Curriculum::factory()->create();
        $curriculumPost = CurriculumPost::factory()->create([
            'curriculum_id' => $curriculum->id,
            'post_id' => $post->id,
        ]);
        $response = $this->get(route('user.curriculum.post', ['curriculum' => $curriculum->id, 'post' => $post->id]));
        $response->assertRedirect(route('user.login'));

        $response = $this->actingAs($this->subscribedUser, 'users')->get(route('user.curriculum.post', ['curriculum' => $curriculum->slug, 'post' => $post->slug]));
        $response->assertStatus(200);
        $response->assertSeeInOrder([
            'マイページ',
            $curriculum->name,
            $post->title
        ]);
        $response->assertSee($post->title);
        $response->assertSee($post->video);
        $response->assertDontSee($post->content_free);
        $response->assertSee($post->content);
        $response->assertDontSee($post->content_free);

        // 同じ階層に記事があれば表示される
        $post2 = Post::factory()->create();
        $post1 = Post::factory()->create();
        $post0 = Post::factory()->create();
        CurriculumPost::factory()->create([
            'curriculum_id' => $curriculum->id,
            'post_id' => $post2->id,
            'order' => 2
        ]);
        CurriculumPost::factory()->create([
            'curriculum_id' => $curriculum->id,
            'post_id' => $post1->id,
            'order' => 1
        ]);
        CurriculumPost::factory()->create([
            'curriculum_id' => $curriculum->id,
            'post_id' => $post0->id,
            'order' => 0
        ]);
        $response = $this->actingAs($this->subscribedUser, 'users')->get(route('user.curriculum.post', ['curriculum' => $curriculum->slug, 'post' => $post->slug]));
        $response->assertStatus(200);
        // 投稿は並び順通りになっている
        $response->assertSeeInOrder([
            $post0->title,
            $post1->title,
            $post2->title,
        ]);

        // サブスクリプションに加入していないユーザーは閲覧できない
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'users')->get(route('user.curriculum.post', ['curriculum' => $curriculum->slug, 'post' => $post->slug]));
        $response->assertRedirect(route('user.register.guidance'));
    }
}
