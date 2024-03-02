<?php

namespace Tests\Feature\Controllers\Line;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;
    // TODO: 正常にアクセスできるかのテストのみ
    public function testLogin()
    {
        $response = $this->get(route('line.login'));
        $response->assertStatus(200);
    }

    public function testLogout()
    {
        $user = \App\Models\User::factory()->create();
        $response = $this->actingAs($user, 'line')->get(route('line.logout'));
        $response->assertStatus(302);
    }
}
