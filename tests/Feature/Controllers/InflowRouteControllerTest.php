<?php

namespace Tests\Feature\Controllers;

use App\Models\InflowRoute;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InflowRouteControllerTest extends TestCase
{
    use RefreshDatabase;
    public function testIndex(): void
    {
        $response = $this->get(route('inflow-route', ['key' => 'test-key']));
        $response->assertRedirect(route('home'));
        $post = Post::factory()->create();
        $inflowRoute = InflowRoute::factory()->create([
            'key' => 'test-key',
            'redirect_url' => route('post.post', [
                'post' => $post->id,
            ]),
        ]);
        $response = $this->get(route('inflow-route', ['key' => 'test-key']));
        $response->assertRedirect(route('post.post', [
            'post' => $post->id,
        ]));
        $this->assertDatabaseHas('inflow_route_logs', [
            'inflow_route_id' => $inflowRoute->id,
        ]);

        $response = $this->get(route('inflow-route', ['key' => 'test-key']) . '?test=1');
        $response->assertRedirect(route('post.post', [
            'post' => $post->id,
        ]));
        $this->assertDatabaseCount('inflow_route_logs', 1);
    }
}
