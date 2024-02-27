<?php

namespace Tests\Feature\Models;

use App\Models\Curriculum;
use App\Models\CurriculumPost;
use App\Models\Post;
use App\Models\StatusEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CurriculumTest extends TestCase
{
    use RefreshDatabase;
    public function testOnlyHasPost()
    {
        // カリキュラムが投稿を持っている場合
        $post = Post::factory()->create();
        $curriculum = Curriculum::factory()->create();
        CurriculumPost::factory()->create([
            'curriculum_id' => $curriculum->id,
            'post_id' => $post->id,
        ]);
        $this->assertTrue(Curriculum::onlyHasPost()->get()->contains($curriculum));

        // 投稿が非公開なら取得しない
        $post->update([
            'status' => StatusEnum::$DRAFT,
        ]);
        $this->assertFalse(Curriculum::onlyHasPost()->get()->contains($curriculum));

        // カリキュラムが投稿を持っていない場合
        $curriculum = Curriculum::factory()->create();
        $this->assertFalse(Curriculum::onlyHasPost()->get()->contains($curriculum));
    }
}
