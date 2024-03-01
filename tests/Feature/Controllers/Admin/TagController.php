<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagController extends TestCase
{
    use RefreshDatabase;
    public function testIndex(): void
    {
        $tag = \App\Models\Tag::factory()->create();
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.tag.index'));

        $response->assertStatus(200);
        $response->assertSee($tag->name);
    }

    public function testShow(): void
    {
        $tag = \App\Models\Tag::factory()->create();
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.tag.show', [
            'tag' => $tag->id,
        ]));

        $response->assertStatus(200);
        $response->assertSee($tag->name);
    }

    public function testCreate(): void
    {
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.tag.create'));

        $response->assertStatus(200);
    }

    public function testStore(): void
    {
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->post(route('admin.tag.store'), [
            'name' => 'test',
        ]);

        $response->assertRedirect(route('admin.tag.show', [
            'tag' => \App\Models\Tag::latest()->first(),
        ]));
        $response->assertSessionHas('message', 'testを登録しました');

        $response = $this->actingAs($admin, 'admins')->post(route('admin.tag.store'));
        $response->assertSessionHasErrors(['name']);
    }

    public function testEdit(): void
    {
        $tag = \App\Models\Tag::factory()->create();
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.tag.edit', [
            'tag' => $tag,
        ]));

        $response->assertStatus(200);
        $response->assertSee($tag->name);
    }

    public function testUpdate(): void
    {
        $tag = \App\Models\Tag::factory()->create();
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->patch(route('admin.tag.update', [
            'tag' => $tag->id,
        ]), [
            'name' => 'test',
        ]);

        $response->assertRedirect(route('admin.tag.show', [
            'tag' => $tag->id,
        ]));
        $tag->refresh();
        $response->assertSessionHas('message', $tag->name . 'を更新しました');
        $this->assertDatabaseHas('tags', [
            'name' => 'test',
        ]);

        $response = $this->actingAs($admin, 'admins')->patch(route('admin.tag.update', [
            'tag' => $tag,
        ]));
        $response->assertSessionHasErrors(['name']);
    }

    public function testDestroy(): void
    {
        $tag = \App\Models\Tag::factory()->create();
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->delete(route('admin.tag.destroy', [
            'tag' => $tag->id,
        ]));

        $response->assertRedirect(route('admin.tag.index'));
        $response->assertSessionHas('message', $tag->name . 'を削除しました');
        $this->assertNull(\App\Models\Tag::find($tag->id));
    }
}
