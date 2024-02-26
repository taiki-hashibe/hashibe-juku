<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Post;
use App\Models\PublishLevelEnum;
use App\Services\GenerateSlug;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $id = Post::max('id') + 1;
        $title = $id . '_' . fake()->sentence();
        $category = Category::inRandomOrder()->first();
        return [
            'title' => $title,
            'content' => '<h2>&nbsp;</h2><h2>記事のテスト</h2><p>テキスト</p><h3>見出し2</h3><p>テキスト</p><h4>見出し3</h4><p>テキスト</p><p><strong>太字</strong></p><p>斜体</p><p><a href="https://google.com">リンク</a></p><ul><li>リスト</li><li>リスト</li><li>リスト</li></ul><ol><li>リスト</li><li>リスト</li><li>リスト</li></ol><blockquote><p>引用</p></blockquote><figure class="table" style="width:21.96%;"><table class="ck-table-resized"><colgroup><col style="width:41.25%;"><col style="width:41.25%;"><col style="width:17.5%;"></colgroup><tbody><tr><td>テーブル</td><td>テーブル</td><td>テーブル</td></tr><tr><td>テーブル</td><td>テーブル</td><td>テーブル</td></tr></tbody></table></figure><p>左寄せ</p><p style="text-align:center;">中央寄せ</p><p style="text-align:right;">右寄せ</p>',
            'content_free' => '<h2>&nbsp;</h2><h2>一般公開記事のテスト</h2><p>テキスト</p><h3>見出し2</h3><p>テキスト</p><h4>見出し3</h4><p>テキスト</p><p><strong>太字</strong></p><p>斜体</p><p><a href="https://google.com">リンク</a></p><ul><li>リスト</li><li>リスト</li><li>リスト</li></ul><ol><li>リスト</li><li>リスト</li><li>リスト</li></ol><blockquote><p>引用</p></blockquote><figure class="table" style="width:21.96%;"><table class="ck-table-resized"><colgroup><col style="width:41.25%;"><col style="width:41.25%;"><col style="width:17.5%;"></colgroup><tbody><tr><td>テーブル</td><td>テーブル</td><td>テーブル</td></tr><tr><td>テーブル</td><td>テーブル</td><td>テーブル</td></tr></tbody></table></figure><p>左寄せ</p><p style="text-align:center;">中央寄せ</p><p style="text-align:right;">右寄せ</p>',
            'slug' => GenerateSlug::generate($title, Post::class),
            'status' => fake()->randomElement(['publish', 'draft']),
            'image' => null,
            'video' => 'http://127.0.0.1:8000/storage/videos/sample-video.mp4',
            'video_free' => 'http://127.0.0.1:8000/storage/videos/sample-video-free.mp4',
            'category_id' => 3 < random_int(0, 10) ? Category::factory() : (3 < random_int(0, 10) ? $category : null),
            'order' => fake()->numberBetween(1, 10),
            'publish_level' => PublishLevelEnum::$MEMBERSHIP
        ];
    }
}
