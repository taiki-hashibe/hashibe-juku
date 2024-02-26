<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Post;
use App\Models\StatusEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;
    public function testIndex()
    {
        $response = $this->get(route('admin.category.index'));
        $response->assertRedirect(route('admin.login'));
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.category.index'));
        $response->assertStatus(200);
        $response->assertSee('投稿カテゴリー');
        $response->assertSee('新規作成');
        $response->assertSee('並べ替え');
        $category = Category::factory()->create();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.category.index'));
        $response->assertSee($category->id);
        $response->assertSee($category->name);
        $response->assertSee($category->posts->count());
        $category->update([
            'parent_id' => Category::factory()->create()->id,
        ]);
        $response = $this->actingAs($admin, 'admins')->get(route('admin.category.index'));
        $response->assertSee($category->parent->name);
        $publishPost = Post::factory()->create([
            'category_id' => $category->id,
            'status' => StatusEnum::$PUBLISH,
        ]);
        $response = $this->actingAs($admin, 'admins')->get(route('admin.category.index'));
        $response->assertSee($category->posts->count());
        Post::factory()->create([
            'category_id' => $category->id,
            'status' => StatusEnum::$DRAFT,
        ]);
        $response = $this->actingAs($admin, 'admins')->get(route('admin.category.index'));
        $response->assertSee(1);
        $publishPost->revision();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.category.index'));
        $response->assertSee(1);
    }

    public function testShow()
    {
        Category::all()->each->delete();
        $response = $this->get(route('admin.category.show', ['category' => 1]));
        $response->assertRedirect(route('admin.login'));
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.category.show', ['category' => 1]));
        $response->assertStatus(404);
        $category = Category::factory([
            'parent_id' => null
        ])->create();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.category.show', ['category' => $category->id]));
        $response->assertStatus(200);
        $response->assertSee($category->name);
        $response->assertSee($category->description);
        $response->assertDontSee('親カテゴリー');
        $response->assertDontSee('子カテゴリー');
        $category->update([
            'parent_id' => Category::factory([
                'parent_id' => null
            ])->create()->id,
        ]);
        $response = $this->actingAs($admin, 'admins')->get(route('admin.category.show', ['category' => $category->id]));
        $response->assertSee('親カテゴリー');
        $response->assertSee($category->parent->name);
        $response->assertDontSee('子カテゴリー');
        $child = Category::factory()->create([
            'parent_id' => $category->id,
        ]);
        $response = $this->actingAs($admin, 'admins')->get(route('admin.category.show', ['category' => $category->id]));
        $response->assertSee('子カテゴリー');
        $response->assertSee($child->name);
        $post = Post::factory()->create([
            'category_id' => $category->id,
            'status' => StatusEnum::$PUBLISH,
        ]);
        $response = $this->actingAs($admin, 'admins')->get(route('admin.category.show', ['category' => $category->id]));
        $response->assertSee('親カテゴリー');
        $response->assertSee($category->parent->name);
        $response->assertSee('子カテゴリー');
        $response->assertSee($child->name);
        $response->assertSee($post->title);
        $post->revision();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.category.show', ['category' => $category->id]));
        $response->assertDontSee('リビジョン');
        $post = Post::factory()->create([
            'category_id' => $category->id,
            'status' => StatusEnum::$DRAFT,
        ]);
        $response = $this->actingAs($admin, 'admins')->get(route('admin.category.show', ['category' => $category->id]));
        $response->assertSee($post->title);
    }

    public function testCreate()
    {
        $response = $this->get(route('admin.category.create'));
        $response->assertRedirect(route('admin.login'));
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.category.create'));
        $response->assertStatus(200);
        $response->assertSee('新規作成');
        $response->assertSee('投稿カテゴリー');
        $response->assertSee('親カテゴリー');
        $response->assertSee('詳細');
        $response->assertSee('サムネイル画像');
        $response->assertSee('保存');
    }

    public function testStore()
    {
        Storage::fake('public');
        $parentCategory = Category::factory()->create();
        $file = UploadedFile::fake()->image('thumbnail.jpg');
        $response = $this->post(route('admin.category.store'), [
            'name' => 'テスト',
            'description' => 'テスト',
            'parent_id' => $parentCategory->id,
            'image' => $file,
        ]);
        $response->assertRedirect(route('admin.login'));
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->post(route('admin.category.store'), [
            'name' => 'テスト',
            'description' => 'テスト',
            'parent_id' => $parentCategory->id,
            'image' => $file,
        ]);
        $category = Category::find(Category::max('id'));
        $response->assertRedirect(route('admin.category.show', [
            'category' => $category->id,
        ]));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('categories', [
            'name' => 'テスト',
            'description' => 'テスト',
            'parent_id' => $parentCategory->id,
            'image' => 'category_images/' . $file->hashName(),
        ]);
        Storage::disk('public')->assertExists('category_images/' . $file->hashName());
        $response->assertSessionHas('message', $category->name . 'を登録しました。');
    }

    public function testEdit()
    {
        Category::all()->each->delete();
        $response = $this->get(route('admin.category.edit', ['category' => 1]));
        $response->assertRedirect(route('admin.login'));
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.category.edit', ['category' => 1]));
        $response->assertStatus(404);
        $parentCategory = Category::factory()->create();
        $category = Category::factory()->create([
            'parent_id' => $parentCategory->id,
        ]);
        $response = $this->actingAs($admin, 'admins')->get(route('admin.category.edit', ['category' => $category->id]));
        $response->assertStatus(200);
        $response->assertSee('名前');
        $response->assertSee($category->name);
        $response->assertSee('詳細');
        $response->assertSee($category->description);
        $response->assertSee('親カテゴリー');
        $response->assertSee($category->parent->name);
        $response->assertSee('サムネイル画像');
        $response->assertSee('保存');
    }

    public function testUpdate()
    {
        Storage::fake('public');
        $parentCategory = Category::factory()->create();
        $category = Category::factory()->create([
            'parent_id' => $parentCategory->id,
        ]);
        $file = UploadedFile::fake()->image('thumbnail.jpg');
        $response = $this->patch(route('admin.category.update', ['category' => $category->id]), [
            'name' => 'テスト',
            'description' => 'テスト',
            'parent_id' => $parentCategory->id,
            'image' => $file,
        ]);
        $response->assertRedirect(route('admin.login'));
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->patch(route('admin.category.update', ['category' => $category->id]), [
            'name' => 'テスト',
            'description' => 'テスト',
            'parent_id' => $parentCategory->id,
            'image' => $file,
        ]);
        $response->assertRedirect(route('admin.category.show', [
            'category' => $category->id,
        ]));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('categories', [
            'name' => 'テスト',
            'description' => 'テスト',
            'parent_id' => $parentCategory->id,
            'image' => 'category_images/' . $file->hashName(),
        ]);
        Storage::disk('public')->assertExists('category_images/' . $file->hashName());
        $category->refresh();
        $response->assertSessionHas('message', $category->name . 'を更新しました。');
    }

    public function testDestroy()
    {
        $category = Category::factory()->create();
        $response = $this->delete(route('admin.category.destroy', ['category' => $category->id]));
        $response->assertRedirect(route('admin.login'));
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->delete(route('admin.category.destroy', ['category' => $category->id]));
        $response->assertRedirect(route('admin.category.index'));
        $response->assertSessionHasNoErrors();
        $this->assertNull(Category::find($category->id));
        $response->assertSessionHas('message', $category->name . 'を削除しました。');
    }

    public function testSortEdit()
    {
        $parent = Category::factory()->create();
        $category1 = Category::factory()->create([
            'parent_id' => $parent->id,
        ]);
        $category2 = Category::factory()->create([
            'parent_id' => $parent->id,
        ]);
        $category3 = Category::factory()->create([
            'parent_id' => $parent->id,
        ]);
        $response = $this->get(route('admin.category.sort', [
            'category' => $parent->id,
        ]));
        $response->assertRedirect(route('admin.login'));
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.category.sort', [
            'category' => $parent->id,
        ]));
        $response->assertStatus(200);
        $response->assertSee('投稿カテゴリー');
        $response->assertSee('並べ替え');
        $response->assertSee($parent->name);
        $response->assertSee($category1->name);
        $response->assertSee($category2->name);
        $response->assertSee($category3->name);
        $response->assertSee('保存');
    }

    public function testSortUpdate()
    {
        $parent = Category::factory()->create();
        $category1 = Category::factory()->create([
            'parent_id' => $parent->id,
        ]);
        $category2 = Category::factory()->create([
            'parent_id' => $parent->id,
        ]);
        $category3 = Category::factory()->create([
            'parent_id' => $parent->id,
        ]);
        $response = $this->post(route('admin.category.sort', [
            'category' => $parent->id,
            'sort_item' => [
                ['id' => $category1->id],
                ['id' => $category2->id],
                ['id' => $category3->id],
            ],
        ]));
        $response->assertRedirect(route('admin.login'));
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->post(route('admin.category.sort', [
            'category' => $parent->id,
        ]), [
            'sort_item' => [
                ['id' => $category1->id],
                ['id' => $category2->id],
                ['id' => $category3->id],
            ],
        ]);
        $response->assertRedirect(route('admin.category.show', [
            'category' => $parent->id,
        ]));
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('message', '並べ替えが完了しました');
        $response->assertSessionHasNoErrors();
        $category1->refresh();
        $category2->refresh();
        $category3->refresh();
        $this->assertEquals(0, $category1->order);
        $this->assertEquals(1, $category2->order);
        $this->assertEquals(2, $category3->order);
        $response = $this->actingAs($admin, 'admins')->post(route('admin.category.sort', [
            'category' => $parent->id,
            'sort_item' => [
                ['id' => $category3->id],
                ['id' => $category2->id],
                ['id' => $category1->id],
            ],
        ]));
        $category1->refresh();
        $category2->refresh();
        $category3->refresh();
        $this->assertEquals(2, $category1->order);
        $this->assertEquals(1, $category2->order);
        $this->assertEquals(0, $category3->order);
    }
}
