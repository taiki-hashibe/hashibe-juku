<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\Admin;
use App\Models\InflowRoute;
use App\Models\InflowRouteLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InflowRouteControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function testIndex(): void
    {
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.inflow-route.index'));
        $response->assertStatus(200);

        $ir = InflowRoute::factory()->create();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.inflow-route.index'));
        $response->assertSee($ir->route);
        $response->assertSee($ir->source);
        $response->assertSee($ir->url());
        InflowRouteLog::factory(10)->create([
            'inflow_route_id' => $ir->id,
        ]);
        $response = $this->actingAs($admin, 'admins')->get(route('admin.inflow-route.index'));
        $response->assertSee($ir->logs->count());
    }

    public function testShow()
    {
        $admin = Admin::factory()->create();
        $ir = InflowRoute::factory()->create();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.inflow-route.show', ['inflow_route' => $ir->id]));
        $response->assertStatus(200);
        $response->assertSee($ir->route);
        $response->assertSee($ir->source);
        $response->assertSee($ir->url());
        $response->assertSee($ir->url() . "?test=1");
        $response->assertSee($ir->redirect_url);
        $ir2 = InflowRoute::factory()->create();
        InflowRouteLog::factory(10)->create([
            'inflow_route_id' => $ir->id,
        ]);
        InflowRouteLog::factory(23)->create([
            'inflow_route_id' => $ir2->id,
        ]);
        $response = $this->actingAs($admin, 'admins')->get(route('admin.inflow-route.show', ['inflow_route' => $ir->id]));
        $response->assertSee($ir->logs->count());
    }

    public function testCreate()
    {
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.inflow-route.create'));
        $response->assertStatus(200);
    }

    public function testStore()
    {
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->post(route('admin.inflow-route.store'), [
            'route' => 'test-route',
            'source' => 'test-source',
            'redirect_url' => 'https://example.com',
        ]);
        $id = InflowRoute::max('id');
        $response->assertRedirect(route('admin.inflow-route.show', ['inflow_route' => $id]));
        $response->assertSessionHas('message');
        $this->assertDatabaseHas('inflow_routes', [
            'route' => 'test-route',
            'source' => 'test-source',
            'redirect_url' => 'https://example.com',
        ]);
    }

    public function testEdit()
    {
        $admin = Admin::factory()->create();
        $ir = InflowRoute::factory()->create();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.inflow-route.edit', ['inflow_route' => $ir->id]));
        $response->assertStatus(200);
        $response->assertSee($ir->route);
        $response->assertSee($ir->source);
        $response->assertSee($ir->redirect_url);
    }

    public function testUpdate()
    {
        $admin = Admin::factory()->create();
        $ir = InflowRoute::factory()->create();
        $response = $this->actingAs($admin, 'admins')->put(route('admin.inflow-route.update', ['inflow_route' => $ir->id]), [
            'route' => 'test-route',
            'source' => 'test-source',
            'redirect_url' => 'https://example.com',
        ]);
        $response->assertRedirect(route('admin.inflow-route.show', ['inflow_route' => $ir->id]));
        $response->assertSessionHas('message');
        $this->assertDatabaseHas('inflow_routes', [
            'route' => 'test-route',
            'source' => 'test-source',
            'redirect_url' => 'https://example.com',
        ]);
    }

    public function testDestroy()
    {
        $admin = Admin::factory()->create();
        $ir = InflowRoute::factory()->create();
        $response = $this->actingAs($admin, 'admins')->delete(route('admin.inflow-route.destroy', ['inflow_route' => $ir->id]));
        $response->assertRedirect(route('admin.inflow-route.index'));
        $response->assertSessionHas('message');
        $this->assertDatabaseMissing('inflow_routes', [
            'id' => $ir->id,
        ]);
    }
}
