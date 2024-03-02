<?php

namespace Tests\Feature\Controllers\Line;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StepMessageControllerTest extends TestCase
{
    use RefreshDatabase;

    // TODO: 正常にアクセスできるかのテストのみ
    // TODO: 体験レッスン申し込み関連のテストはしていない
    /**
     * A basic feature test example.
     */
    public function testStep1()
    {
        $response = $this->get(route('line.step.step-1'));
        $response->assertRedirect(route('line.login'));
        $user = \App\Models\User::factory()->create();
        $response = $this->actingAs($user, 'users')->get(route('line.step.step-1'));
        $response->assertStatus(200);
    }

    public function testStep2()
    {
        $response = $this->get(route('line.step.step-2'));
        $response->assertRedirect(route('line.login'));
        $user = \App\Models\User::factory()->create();
        $response = $this->actingAs($user, 'users')->get(route('line.step.step-2'));
        $response->assertStatus(200);
    }

    public function testQuestionnaireSuccess()
    {
        $response = $this->get(route('line.step.questionnaire_success'));
        $response->assertRedirect(route('line.login'));
        $user = \App\Models\User::factory()->create();
        $response = $this->actingAs($user, 'users')->get(route('line.step.questionnaire_success'));
        $response->assertStatus(200);
    }
}
