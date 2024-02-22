<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;
    public function testLogin()
    {
        $response = $this->get(route('admin.login'));
        $response->assertStatus(200);
        $response->assertSee('管理画面ログイン');
        $response->assertSee('メールアドレス');
        $response->assertSee('パスワード');
        $response->assertSee('ログイン');

        $response = $this->post(route('admin.login'), [
            'email' => 'test@test.com',
            'password' => 'password',
        ]);
        $response->assertRedirect(route('admin.login'));
        $response->assertSessionHasErrors(['any']);
        $admin = Admin::factory()->create([
            'password' => bcrypt('password'),
        ]);
        $response = $this->post(route('admin.login'), [
            'email' => $admin->email,
            'password' => 'password',
        ]);
        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHasNoErrors();
        $this->assertAuthenticatedAs($admin, 'admins');
    }

    public function testLogout()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admins');
        $response = $this->post(route('admin.logout'));
        $response->assertRedirect(route('admin.login'));
        $response->assertSessionHasNoErrors();
        $this->assertGuest('admins');
    }
}
