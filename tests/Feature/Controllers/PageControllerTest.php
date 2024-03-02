<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PageControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function testIndex(): void
    {
        $page = \App\Models\Page::factory()->create();
        $response = $this->get(route('page', [
            'page' => $page->slug
        ]));
        $response->assertStatus(200);
        $response->assertSee($page->title);
        $response->assertSee($page->content);
        // アクセスログが記録されている
        $this->assertDatabaseHas('access_logs', [
            'url' => route('page', [
                'page' => $page->slug
            ]),
        ]);

        /**
         * ヘッダーのテスト
         * ユーザーが認証されていなければguest-layout
         * ユーザーが認証されていればauth-layout
         */
        $response->assertSee('ログイン');
        $response->assertSee('公式LINE');
        $response->assertSee(config('line.link'));
        $response->assertSee(route('user.login'));
        $user = \App\Models\User::factory()->create();
        $response = $this->actingAs($user, 'users')->get(route('page', [
            'page' => $page->slug
        ]));
        $response->assertSee('ログアウト');
    }
}
