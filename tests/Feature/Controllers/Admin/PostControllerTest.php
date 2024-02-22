<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Exercise;
use App\Models\ExerciseChoice;
use App\Models\Post;
use App\Models\PublishLevelEnum;
use App\Models\StatusEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;
    public function testIndex()
    {
        $response = $this->get(route('admin.post.index'));
        $response->assertRedirect(route('admin.login'));
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.post.index'));
        $response->assertStatus(200);
        $response->assertSee('投稿');
        $post = Post::factory()->create([
            'status' => StatusEnum::$PUBLISH,
            'admin_id' => $admin->id,
        ]);
        $response = $this->actingAs($admin, 'admins')->get(route('admin.post.index'));
        $response->assertStatus(200);
        $response->assertSee($post->title);
        $response->assertSee($post->category->name);
        $response->assertSee($post->admin->name);
        $response->assertSee('カテゴリーの無い投稿の並べ替え');
    }

    public function testShow()
    {
        $response = $this->get(route('admin.post.show', ['post' => 1]));
        $response->assertRedirect(route('admin.login'));
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.post.show', ['post' => 1]));
        $response->assertStatus(404);
        $post = Post::factory()->create([
            'status' => StatusEnum::$PUBLISH,
            'content' => '<p>test content</p>',
        ]);
        $response = $this->actingAs($admin, 'admins')->get(route('admin.post.show', ['post' => $post->id]));
        $response->assertStatus(200);
        $response->assertSee($post->title);
        $response->assertSee($post->category->name);
        $response->assertSee($post->admin->name);
        $response->assertSee('test content');
        $response->assertSee('公開範囲');
        $response->assertDontSee('リビジョン');
        $response->assertSee('編集');
        $response->assertSee('削除');
        $response->assertSee('ページを確認する');
        $post->revision();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.post.show', ['post' => $post->getRevision()->first()->id]));
        $response->assertStatus(200);
        $response->assertSee('リビジョン');
        $response->assertSee('このリビジョンに戻す');
        $response->assertDontSee('編集');
        $response->assertDontSee('削除');
        $response->assertDontSee('ページを確認する');
        $post->admin->delete();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.post.show', ['post' => $post->id]));
        $response->assertStatus(200);
        $response->assertSee('削除された管理者');
        $post = Post::factory()->create([
            'status' => StatusEnum::$DRAFT,
            'content' => '<p>test content draft</p>',
        ]);
        $response = $this->actingAs($admin, 'admins')->get(route('admin.post.show', ['post' => $post->id]));
        $response->assertStatus(200);
        $response->assertSee($post->title);
        $response->assertSee($post->category->name);
        $response->assertSee($post->admin->name);
        $response->assertSee('test content draft');
        $response->assertSee('公開範囲');
        $response->assertSee('編集');
        $response->assertSee('削除');
        $response->assertDontSee('ページを確認する');
        // カテゴリー無し
        $post = Post::factory()->create([
            'status' => StatusEnum::$PUBLISH,
            'content' => '<p>test content no category</p>',
            'category_id' => null,
        ]);
        $response = $this->actingAs($admin, 'admins')->get(route('admin.post.show', ['post' => $post->id]));
        $response->assertStatus(200);
        $response->assertSee($post->title);
        $response->assertSee($post->admin->name);
        $response->assertSee('test content no category');
        $response->assertSee('公開範囲');
        $response->assertSee('編集');
        $response->assertSee('削除');
        $response->assertSee('ページを確認する');

        // 演習付き
        $post = Post::factory()->create([
            'status' => StatusEnum::$PUBLISH,
            'content' => '<p>test content</p>',
        ]);
        $exercise1 = Exercise::factory()->create([
            'post_id' => $post->id,
        ]);
        $exercise1choice1 = ExerciseChoice::factory()->create([
            'exercise_id' => $exercise1->id,
        ]);
        $exercise1choice2 = ExerciseChoice::factory()->create([
            'exercise_id' => $exercise1->id,
            'is_correct' => true,
        ]);
        $exercise2 = Exercise::factory()->create([
            'post_id' => $post->id,
        ]);
        $exercise2choice1 = ExerciseChoice::factory()->create([
            'exercise_id' => $exercise1->id,
        ]);
        $exercise2choice2 = ExerciseChoice::factory()->create([
            'exercise_id' => $exercise1->id,
            'is_correct' => true,
        ]);
        $response = $this->actingAs($admin, 'admins')->get(route('admin.post.show', ['post' => $post->id]));
        $response->assertStatus(200);
        $response->assertSee('公開範囲');
        $response->assertSee('演習');
        $response->assertSee($exercise1->question);
        $response->assertSee($exercise1choice1->choice);
        $response->assertSee($exercise1choice2->choice);
        $response->assertSee($exercise2->question);
        $response->assertSee($exercise2choice1->choice);
        $response->assertSee($exercise2choice2->choice);
    }

    public function testStore()
    {
        $response = $this->post(route('admin.post.store'), []);
        $response->assertRedirect(route('admin.login'));
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->post(route('admin.post.store'), []);
        $response->assertSessionHasErrors(['title', 'status', 'publish_level']);
        $response = $this->actingAs($admin, 'admins')->post(route('admin.post.store'), [
            'title' => 'タイトル',
            'status' => StatusEnum::$PUBLISH,
            'publish_level' => PublishLevelEnum::$MEMBERSHIP,
        ]);
        $post = Post::find(Post::max('id'));
        $response->assertRedirect(route('admin.post.show', [
            'post' => $post->id
        ]));
        $response->assertSessionHas('message', $post->title . 'を登録しました。');
        $this->assertEquals('タイトル', $post->title);
        $this->assertEquals(StatusEnum::$PUBLISH, $post->status);
        $this->assertEquals(PublishLevelEnum::$MEMBERSHIP, $post->publish_level);
        $this->assertEquals($admin->id, $post->admin_id);
        $response = $this->actingAs($admin, 'admins')->post(route('admin.post.store'), [
            'title' => 'タイトル',
            'status' => StatusEnum::$PUBLISH,
            'publish_level' => PublishLevelEnum::$TRIAL,
            'category_id' => 1,
        ]);
        $response->assertSessionHasErrors(['category_id']);
        $category = Category::factory()->create();
        Storage::fake('public');
        $file = UploadedFile::fake()->image('thumbnail.jpg');
        $response = $this->actingAs($admin, 'admins')->post(route('admin.post.store'), [
            'title' => 'タイトル',
            'status' => StatusEnum::$PUBLISH,
            'publish_level' => PublishLevelEnum::$TRIAL,
            'category_id' => $category->id,
            'image' => $file,
            'video' => 'video_path.mp4'
        ]);
        $post = Post::find(Post::max('id'));
        $response->assertRedirect(route('admin.post.show', [
            'post' => $post->id
        ]));
        $response->assertSessionHas('message', $post->title . 'を登録しました。');
        $this->assertDatabaseHas('posts', [
            'title' => 'タイトル',
            'status' => StatusEnum::$PUBLISH,
            'category_id' => $category->id,
            'publish_level' => PublishLevelEnum::$TRIAL,
            'image' =>  'post_thumbnails/' . $file->hashName(),
            'video' => 'video_path.mp4',
        ]);
        Storage::disk('public')->assertExists('post_thumbnails/' . $file->hashName());

        // 演習付き
        // 成功パターン
        $response = $this->actingAs($admin, 'admins')->post(route('admin.post.store'), [
            'title' => 'タイトル',
            'status' => StatusEnum::$PUBLISH,
            'category_id' => $category->id,
            'publish_level' => PublishLevelEnum::$TRIAL,
            'image' => $file,
            'video' => 'video_path.mp4',
            'exercises' => [
                [
                    'question' => '問題文1',
                    'choices' => [
                        [
                            'text' => '選択肢1',
                        ],
                        [
                            'text' => '選択肢2',
                            'is_correct' => true,
                        ],
                    ]
                ],
                [
                    'question' => '問題文2',
                    'choices' => [
                        [
                            'text' => '選択肢2-1',
                        ],
                        [
                            'text' => '選択肢2-2',
                            'is_correct' => true,
                        ],
                    ]
                ]
            ]
        ]);
        $post = Post::find(Post::max('id'));
        $response->assertRedirect(route('admin.post.show', [
            'post' => $post->id
        ]));
        $response->assertSessionHas('message', $post->title . 'を登録しました。');
        $this->assertDatabaseHas('posts', [
            'title' => 'タイトル',
            'status' => StatusEnum::$PUBLISH,
            'category_id' => $category->id,
            'publish_level' => PublishLevelEnum::$TRIAL,
            'image' =>  'post_thumbnails/' . $file->hashName(),
            'video' => 'video_path.mp4',
        ]);
        $exercises = $post->exercises;
        $this->assertCount(2, $exercises);
        $this->assertEquals('問題文1', $exercises[0]->question);
        $this->assertCount(2, $exercises[0]->choices);
        $this->assertEquals('選択肢1', $exercises[0]->choices[0]->text);
        $this->assertEquals('選択肢2', $exercises[0]->choices[1]->text);
        $this->assertTrue($exercises[0]->choices[1]->is_correct);
        $this->assertEquals('問題文2', $exercises[1]->question);
        $this->assertCount(2, $exercises[1]->choices);
        $this->assertEquals('選択肢2-1', $exercises[1]->choices[0]->text);
        $this->assertEquals('選択肢2-2', $exercises[1]->choices[1]->text);
        $this->assertTrue($exercises[1]->choices[1]->is_correct);

        // 失敗パターン、問題文が空
        $response = $this->actingAs($admin, 'admins')->post(route('admin.post.store'), [
            'title' => 'タイトル',
            'status' => StatusEnum::$PUBLISH,
            'category_id' => $category->id,
            'publish_level' => PublishLevelEnum::$TRIAL,
            'image' => $file,
            'video' => 'video_path.mp4',
            'exercises' => [
                [
                    'question' => null,
                    'choices' => [
                        [
                            'text' => '選択肢1',
                        ],
                        [
                            'text' => '選択肢2',
                            'is_correct' => true,
                        ],
                    ]
                ],
                [
                    'question' => '問題文2',
                    'choices' => [
                        [
                            'text' => '選択肢2-1',
                        ],
                        [
                            'text' => '選択肢2-2',
                            'is_correct' => true,
                        ],
                    ]
                ]
            ]
        ]);
        $response->assertSessionHasErrors([
            'exercises.0.question',
        ]);
        // 失敗パターン、選択肢が空
        $response = $this->actingAs($admin, 'admins')->post(route('admin.post.store'), [
            'title' => 'タイトル',
            'status' => StatusEnum::$PUBLISH,
            'publish_level' => PublishLevelEnum::$TRIAL,
            'category_id' => $category->id,
            'image' => $file,
            'video' => 'video_path.mp4',
            'exercises' => [
                [
                    'question' => '問題文1',
                    'choices' => []
                ],
            ]
        ]);
        $response->assertSessionHasErrors([
            'exercises.0.choices',
        ]);
        // 失敗パターン、選択肢のテキストが空
        $response = $this->actingAs($admin, 'admins')->post(route('admin.post.store'), [
            'title' => 'タイトル',
            'status' => StatusEnum::$PUBLISH,
            'category_id' => $category->id,
            'publish_level' => PublishLevelEnum::$TRIAL,
            'image' => $file,
            'video' => 'video_path.mp4',
            'exercises' => [
                [
                    'question' => '問題文1',
                    'choices' => [
                        [
                            'text' => null,
                            'is_correct' => true,
                        ],
                    ]
                ],
            ]
        ]);
        $response->assertSessionHasErrors([
            'exercises.0.choices.0.text',
        ]);
        // 失敗パターン、選択肢に正解がない
        $response = $this->actingAs($admin, 'admins')->post(route('admin.post.store'), [
            'title' => 'タイトル',
            'status' => StatusEnum::$PUBLISH,
            'category_id' => $category->id,
            'publish_level' => PublishLevelEnum::$TRIAL,
            'image' => $file,
            'video' => 'video_path.mp4',
            'exercises' => [
                [
                    'question' => '問題文1',
                    'choices' => [
                        [
                            'text' => '選択肢1',
                        ],
                    ]
                ],
            ]
        ]);
        $response->assertSessionHasErrors([
            'exercises.0.choices',
        ]);
    }

    public function testEdit()
    {
        $response = $this->get(route('admin.post.edit', ['post' => 1]));
        $response->assertRedirect(route('admin.login'));
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.post.edit', ['post' => 1]));
        $response->assertStatus(404);
        $post = Post::factory()->create([
            'status' => StatusEnum::$PUBLISH,
            'content' => '<p>post content</p>',
            'publish_level' => PublishLevelEnum::$TRIAL,
        ]);
        $response = $this->actingAs($admin, 'admins')->get(route('admin.post.edit', ['post' => $post->id]));
        $response->assertStatus(200);
        $response->assertSee($post->title);
        $response->assertSee($post->category->name);
        $response->assertSee('post content');
        $response->assertSee('公開範囲');
    }

    public function testUpdate()
    {
        $response = $this->put(route('admin.post.update', ['post' => 1]));
        $response->assertRedirect(route('admin.login'));
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->put(route('admin.post.update', ['post' => 1]));
        $response->assertStatus(404);
        $post = Post::factory()->create([
            'status' => StatusEnum::$PUBLISH,
            'publish_level' => PublishLevelEnum::$TRIAL,
            'content' => '<p>post content</p>'
        ]);
        $response = $this->actingAs($admin, 'admins')->put(route('admin.post.update', ['post' => $post->id]), [
            'title' => 'タイトル',
            'status' => StatusEnum::$PUBLISH,
            'publish_level' => PublishLevelEnum::$MEMBERSHIP,
            'content' => '<p>content</p>',
        ]);
        $post = Post::find($post->id);
        $response->assertRedirect(route('admin.post.show', [
            'post' => $post->id
        ]));
        $response->assertSessionHas('message', $post->title . 'を更新しました。');
        $this->assertEquals('タイトル', $post->title);
        $this->assertEquals(StatusEnum::$PUBLISH, $post->status);
        $this->assertEquals(PublishLevelEnum::$MEMBERSHIP, $post->publish_level);
        $this->assertEquals('<p>content</p>', $post->content);
        $response = $this->actingAs($admin, 'admins')->put(route('admin.post.update', ['post' => $post->id]), [
            'title' => 'タイトル',
            'status' => StatusEnum::$PUBLISH,
            'publish_level' => PublishLevelEnum::$MEMBERSHIP,
            'category_id' => 1,
        ]);
        $response->assertSessionHasErrors(['category_id']);
        $category = Category::factory()->create();
        Storage::fake('public');
        $file = UploadedFile::fake()->image('thumbnail.jpg');
        $response = $this->actingAs($admin, 'admins')->put(route('admin.post.update', ['post' => $post->id]), [
            'title' => 'タイトル',
            'status' => StatusEnum::$PUBLISH,
            'publish_level' => PublishLevelEnum::$MEMBERSHIP,
            'category_id' => $category->id,
            'image' => $file,
            'video' => 'video_path.mp4'
        ]);
        $post = Post::find($post->id);
        $response->assertRedirect(route('admin.post.show', [
            'post' => $post->id
        ]));
        $response->assertSessionHas('message', $post->title . 'を更新しました。');
        $this->assertDatabaseHas('posts', [
            'title' => 'タイトル',
            'status' => StatusEnum::$PUBLISH,
            'publish_level' => PublishLevelEnum::$MEMBERSHIP,
            'category_id' => $category->id,
            'image' =>  'post_thumbnails/' . $file->hashName(),
            'video' => 'video_path.mp4',
        ]);
        Storage::disk('public')->assertExists('post_thumbnails/' . $file->hashName());
        // 演習付き
        // 成功パターン
        $response = $this->actingAs($admin, 'admins')->put(route('admin.post.update', ['post' => $post->id]), [
            'title' => 'タイトル',
            'status' => StatusEnum::$PUBLISH,
            'category_id' => $category->id,
            'publish_level' => PublishLevelEnum::$MEMBERSHIP,
            'image' => $file,
            'video' => 'video_path.mp4',
            'exercises' => [
                [
                    'question' => '問題文1',
                    'choices' => [
                        [
                            'text' => '選択肢1',
                        ],
                        [
                            'text' => '選択肢2',
                            'is_correct' => true,
                        ],
                    ]
                ],
                [
                    'question' => '問題文2',
                    'choices' => [
                        [
                            'text' => '選択肢2-1',
                        ],
                        [
                            'text' => '選択肢2-2',
                            'is_correct' => true,
                        ],
                    ]
                ]
            ]
        ]);
        $post = Post::find($post->id);
        $response->assertRedirect(route('admin.post.show', [
            'post' => $post->id
        ]));
        $response->assertSessionHas('message', $post->title . 'を更新しました。');
        $this->assertDatabaseHas('posts', [
            'title' => 'タイトル',
            'status' => StatusEnum::$PUBLISH,
            'publish_level' => PublishLevelEnum::$MEMBERSHIP,
            'category_id' => $category->id,
            'image' =>  'post_thumbnails/' . $file->hashName(),
            'video' => 'video_path.mp4',
        ]);
        $exercises = $post->exercises;
        $this->assertCount(2, $exercises);
        $this->assertEquals('問題文1', $exercises[0]->question);
        $this->assertCount(2, $exercises[0]->choices);
        $this->assertEquals('選択肢1', $exercises[0]->choices[0]->text);
        $this->assertEquals('選択肢2', $exercises[0]->choices[1]->text);
        $this->assertTrue($exercises[0]->choices[1]->is_correct);
        $this->assertEquals('問題文2', $exercises[1]->question);
        $this->assertCount(2, $exercises[1]->choices);
        $this->assertEquals('選択肢2-1', $exercises[1]->choices[0]->text);
        $this->assertEquals('選択肢2-2', $exercises[1]->choices[1]->text);
        $this->assertTrue($exercises[1]->choices[1]->is_correct);
        // 失敗パターン、問題文が空
        $response = $this->actingAs($admin, 'admins')->put(route('admin.post.update', ['post' => $post->id]), [
            'title' => 'タイトル',
            'status' => StatusEnum::$PUBLISH,
            'publish_level' => PublishLevelEnum::$MEMBERSHIP,
            'category_id' => $category->id,
            'image' => $file,
            'video' => 'video_path.mp4',
            'exercises' => [
                [
                    'question' => null,
                    'choices' => [
                        [
                            'text' => '選択肢1',
                        ],
                        [
                            'text' => '選択肢2',
                            'is_correct' => true,
                        ],
                    ]
                ],
                [
                    'question' => '問題文2',
                    'choices' => [
                        [
                            'text' => '選択肢2-1',
                        ],
                        [
                            'text' => '選択肢2-2',
                            'is_correct' => true,
                        ],
                    ]
                ]
            ]
        ]);
        $response->assertSessionHasErrors([
            'exercises.0.question',
        ]);
        // 失敗パターン、選択肢が空
        $response = $this->actingAs($admin, 'admins')->put(route('admin.post.update', ['post' => $post->id]), [
            'title' => 'タイトル',
            'status' => StatusEnum::$PUBLISH,
            'publish_level' => PublishLevelEnum::$MEMBERSHIP,
            'category_id' => $category->id,
            'image' => $file,
            'video' => 'video_path.mp4',
            'exercises' => [
                [
                    'question' => '問題文1',
                    'choices' => []
                ],
            ]
        ]);
        $response->assertSessionHasErrors([
            'exercises.0.choices',
        ]);
        // 失敗パターン、選択肢のテキストが空
        $response = $this->actingAs($admin, 'admins')->put(route('admin.post.update', ['post' => $post->id]), [
            'title' => 'タイトル',
            'status' => StatusEnum::$PUBLISH,
            'publish_level' => PublishLevelEnum::$MEMBERSHIP,
            'category_id' => $category->id,
            'image' => $file,
            'video' => 'video_path.mp4',
            'exercises' => [
                [
                    'question' => '問題文1',
                    'choices' => [
                        [
                            'text' => null,
                            'is_correct' => true,
                        ],
                    ]
                ],
            ]
        ]);
        $response->assertSessionHasErrors([
            'exercises.0.choices.0.text',
        ]);
        // 失敗パターン、選択肢に正解がない
        $response = $this->actingAs($admin, 'admins')->put(route('admin.post.update', ['post' => $post->id]), [
            'title' => 'タイトル',
            'status' => StatusEnum::$PUBLISH,
            'publish_level' => PublishLevelEnum::$MEMBERSHIP,
            'category_id' => $category->id,
            'image' => $file,
            'video' => 'video_path.mp4',
            'exercises' => [
                [
                    'question' => '問題文1',
                    'choices' => [
                        [
                            'text' => '選択肢1',
                        ],
                    ]
                ],
            ]
        ]);
        $response->assertSessionHasErrors([
            'exercises.0.choices',
        ]);
    }

    public function testDestroy()
    {
        $response = $this->delete(route('admin.post.destroy', ['post' => 1]));
        $response->assertRedirect(route('admin.login'));
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->delete(route('admin.post.destroy', ['post' => 1]));
        $response->assertStatus(404);
        $post = Post::factory()->create([
            'status' => StatusEnum::$PUBLISH,
            'content' => '<p>post content</p>'
        ]);
        $response = $this->actingAs($admin, 'admins')->delete(route('admin.post.destroy', ['post' => $post->id]));
        $response->assertRedirect(route('admin.post.index'));
        $response->assertSessionHas('message', $post->title . 'を削除しました。');
        $this->assertNull(Post::find($post->id));
    }

    public function testSort()
    {
        $category = Category::factory()->create();
        $response = $this->get(route('admin.post.sort', [
            'category' => $category->id
        ]));
        $response->assertRedirect(route('admin.login'));
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.post.sort', [
            'category' => $category->id
        ]));
        $response->assertStatus(200);
        $response->assertSee($category->name);
        $response->assertSee('投稿の並び替え');
        $post1 = Post::factory()->create([
            'status' => StatusEnum::$PUBLISH,
            'content' => '<p>post content</p>',
            'category_id' => $category->id,
        ]);
        $post2 = Post::factory()->create([
            'status' => StatusEnum::$PUBLISH,
            'content' => '<p>post content2</p>',
            'category_id' => $category->id,
        ]);
        $response = $this->actingAs($admin, 'admins')->get(route('admin.post.sort', [
            'category' => $category->id
        ]));
        $response->assertStatus(200);
        $response->assertSee($post1->title);
        $response->assertSee($post2->title);
        $post1->revision();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.post.sort', [
            'category' => $category->id
        ]));
        $response->assertStatus(200);
        $response->assertDontSee('リビジョン');
        $post3 = Post::factory()->create([
            'status' => StatusEnum::$DRAFT,
            'content' => '<p>post content3</p>',
            'category_id' => $category->id,
        ]);
        $response = $this->actingAs($admin, 'admins')->get(route('admin.post.sort', [
            'category' => $category->id
        ]));
        $response->assertStatus(200);
        $response->assertSee($post3->title);

        // カテゴリーが無い場合
        $response = $this->actingAs($admin, 'admins')->get(route('admin.post.sort'));
        $response->assertStatus(200);
        $response->assertSee('投稿の並び替え');
        $post4 = Post::factory()->create([
            'status' => StatusEnum::$PUBLISH,
            'content' => '<p>post content4</p>',
            'category_id' => null,
        ]);
        $post5 = Post::factory()->create([
            'status' => StatusEnum::$PUBLISH,
            'content' => '<p>post content5</p>',
            'category_id' => null,
        ]);
        $response = $this->actingAs($admin, 'admins')->get(route('admin.post.sort'));
        $response->assertStatus(200);
        $response->assertSee($post4->title);
        $response->assertSee($post5->title);
        $post4->revision();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.post.sort'));
        $response->assertStatus(200);
        $response->assertDontSee('リビジョン');
        $post6 = Post::factory()->create([
            'status' => StatusEnum::$DRAFT,
            'content' => '<p>post content6</p>',
            'category_id' => null,
        ]);
        $response = $this->actingAs($admin, 'admins')->get(route('admin.post.sort'));
        $response->assertStatus(200);
        $response->assertSee($post6->title);

        // カテゴリー有り無し互いに影響しないこと
        $response->assertDontSee($post1->title);
        $response->assertDontSee($post2->title);
        $response->assertDontSee($post3->title);
        $response = $this->actingAs($admin, 'admins')->get(route('admin.post.sort', [
            'category' => $category->id
        ]));
        $response->assertStatus(200);
        $response->assertSee($post1->title);
        $response->assertSee($post2->title);
        $response->assertSee($post3->title);
        $response->assertDontSee($post4->title);
        $response->assertDontSee($post5->title);
        $response->assertDontSee($post6->title);


        // POST
        $response = $this->actingAs($admin, 'admins')->post(route('admin.post.sort', [
            'category' => $category->id
        ]), [
            'sort_item' => [
                ['id' => $post2->id],
                ['id' => $post1->id],
                ['id' => $post3->id],
            ]
        ]);
        $response->assertRedirect(route('admin.category.show', [
            'category' => $category->id
        ]));
        $response->assertSessionHas('message', '並べ替えが完了しました');
        $this->assertEquals(0, Post::find($post2->id)->order);
        $this->assertEquals(1, Post::find($post1->id)->order);
        $this->assertEquals(2, Post::find($post3->id)->order);

        // カテゴリー無し
        $response = $this->actingAs($admin, 'admins')->post(route('admin.post.sort'), [
            'sort_item' => [
                ['id' => $post5->id],
                ['id' => $post4->id],
                ['id' => $post6->id],
            ]
        ]);
        $response->assertRedirect(route('admin.post.index'));
        $response->assertSessionHas('message', '並べ替えが完了しました');
        $this->assertEquals(0, Post::find($post5->id)->order);
        $this->assertEquals(1, Post::find($post4->id)->order);
        $this->assertEquals(2, Post::find($post6->id)->order);
    }
}
