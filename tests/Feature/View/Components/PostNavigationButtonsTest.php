<?php

namespace Tests\Feature\View\Components;

use App\Models\Post;
use App\View\Components\PostNavigationButtons;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostNavigationButtonsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function testRender(): void
    {
        // カテゴリー無し
        $post2 = Post::factory()->create([
            'title' => 'post2',
            'order' => 2
        ]);
        $post1 = Post::factory()->create([
            'title' => 'post1',
            'order' => 1
        ]);
        $post0 = Post::factory()->create([
            'title' => 'post0',
            'order' => 0
        ]);
        $view = $this->component(PostNavigationButtons::class, ['post' => $post0]);
        $view->assertDontSee("前のレッスン");
        $view->assertSee("次のレッスン");
        $view->assertDontSee($post0->title);
        $view->assertSee($post1->title);
        $view->assertDontSee($post2->title);

        $view = $this->component(PostNavigationButtons::class, ['post' => $post1]);
        $view->assertSee("前のレッスン");
        $view->assertSee("次のレッスン");
        $view->assertSeeInOrder([
            $post0->title,
            $post2->title
        ]);
        $view->assertDontSee($post1->title);

        $view = $this->component(PostNavigationButtons::class, ['post' => $post2]);
        $view->assertSee("前のレッスン");
        $view->assertDontSee("次のレッスン");
        $view->assertSee($post1->title);
        $view->assertDontSee($post0->title);
        $view->assertDontSee($post2->title);
    }
}
