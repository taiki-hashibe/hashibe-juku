<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get(route('admin.user.index'));
        $response->assertRedirect(route('admin.login'));
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.user.index'));
        $response->assertStatus(200);
        $response->assertSee('ユーザー');
        $user = User::factory()->create();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.user.index'));
        $response->assertSee($user->id);
        $response->assertSee($user->name);
    }

    public function testShow()
    {
        $user = User::factory()->create();
        $response = $this->get(route('admin.user.show', ['user' => $user->id]));
        $response->assertRedirect(route('admin.login'));
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.user.show', ['user' => $user->id]));
        $response->assertStatus(200);
        $response->assertSee('ユーザー');
        $response->assertSee($user->id);
        $response->assertSee($user->name);
    }
}
