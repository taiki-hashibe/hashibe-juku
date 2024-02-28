<?php

namespace Tests\Feature\Livewire\Admin;

use App\Livewire\Admin\CurriculumPostEditor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CurriculumPostEditorTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(CurriculumPostEditor::class)
            ->assertStatus(200);
    }
}
