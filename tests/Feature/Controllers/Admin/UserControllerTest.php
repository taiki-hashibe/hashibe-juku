<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\Admin;
use App\Models\Company;
use App\Models\PublishLevelEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get(route('admin.user.index'));
        $response->assertRedirect(route('admin.login'));
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.user.index'));
        $response->assertStatus(200);
        $response->assertSee('ユーザー');
        $user = User::factory()->create([
            'name' => null,
            'status' => PublishLevelEnum::$TRIAL,
        ]);
        $response = $this->actingAs($admin, 'admins')->get(route('admin.user.index'));
        $response->assertSee($user->id);
        $response->assertSee($user->user_id);
        $response->assertSee('トライアル');
        $user = User::factory()->create();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.user.index'));
        $response->assertSee($user->id);
        $response->assertSee($user->name);
        $response->assertSee($user->user_id);
        $user->update([
            'company_id' => Company::factory()->create()->id,
        ]);
        $response = $this->actingAs($admin, 'admins')->get(route('admin.user.index'));
        $response->assertSee($user->company->name);
    }

    public function testShow()
    {
        $user = User::factory()->create([
            'name' => null,
            'default_password' => 'password',
        ]);
        $response = $this->get(route('admin.user.show', ['user' => $user->id]));
        $response->assertRedirect(route('admin.login'));
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.user.show', ['user' => $user->id]));
        $response->assertStatus(200);
        $response->assertSee('ユーザー');
        $response->assertSee($user->id);
        $response->assertSee($user->user_id);
        $response->assertSee($user->email);
        $response->assertSee('初期パスワード');
        $response->assertSee($user->default_password);
        $user->update([
            'password' => bcrypt('password1'),
        ]);
        $response = $this->actingAs($admin, 'admins')->get(route('admin.user.show', ['user' => $user->id]));
        $response->assertDontSee('初期パスワード');
        $response->assertDontSee($user->default_password);
        $user->update([
            'company_id' => Company::factory()->create()->id,
        ]);
        $response = $this->actingAs($admin, 'admins')->get(route('admin.user.show', ['user' => $user->id]));
        $response->assertSee($user->company->name);
    }

    public function testCreate()
    {
        $response = $this->get(route('admin.user.create'));
        $response->assertRedirect(route('admin.login'));
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.user.create'));
        $response->assertStatus(200);
        $response->assertSee('ユーザー');
        $response->assertSee('新規作成');
        $response->assertSee('名前');
        $response->assertSee('メールアドレス');
        $response->assertSee('契約先会社名');
        $response->assertSee('ステータス');
        $response->assertSee('閲覧可');
        $response->assertSee('保存');
        $company = Company::factory()->create();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.user.create'));
        $response->assertSee($company->name);
    }

    public function testStore()
    {
        User::all()->each->forceDelete();
        $response = $this->post(route('admin.user.store'));
        $response->assertRedirect(route('admin.login'));
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->post(route('admin.user.store'));
        $response->assertSessionHasErrors(['status']);
        $response = $this->actingAs($admin, 'admins')->post(route('admin.user.store'), [
            'status' => PublishLevelEnum::$TRIAL,
            'site' => 'programming',
        ]);
        $response->assertSessionHasNoErrors();
        $user = User::withOutGlobalScope('siteFiltering')->first();
        $response->assertRedirect(route('admin.user.show', ['user' => $user->id]));
        $response->assertSessionHas('message', $user->user_id . 'を作成しました。');
        $this->assertEquals($user->status, PublishLevelEnum::$TRIAL);
        User::withOutGlobalScope('siteFiltering')->get()->each->forceDelete();
        $response = $this->actingAs($admin, 'admins')->post(route('admin.user.store'), [
            'name' => 'test',
            'email' => 'test@test.com',
            'status' => PublishLevelEnum::$TRIAL,
            'company_id' => Company::factory()->create()->id,
            'site' => 'programming',
        ]);
        $response->assertSessionHasNoErrors();
        $user = User::withOutGlobalScope('siteFiltering')->first();
        $response->assertRedirect(route('admin.user.show', ['user' => $user->id]));
        $response->assertSessionHas('message', $user->name . 'を作成しました。');
        $this->assertEquals('test', $user->name);
        $this->assertEquals('test@test.com', $user->email);
        $this->assertEquals($user->status, PublishLevelEnum::$TRIAL);
        $this->assertNotNull($user->default_password);
        $this->assertEquals('programming', $user->site);
    }

    public function testEdit()
    {
        $user = User::factory()->create();
        $response = $this->get(route('admin.user.edit', ['user' => $user->id]));
        $response->assertRedirect(route('admin.login'));
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->get(route('admin.user.edit', ['user' => $user->id]));
        $response->assertStatus(200);
        $response->assertSee('ユーザー');
        $response->assertSee($user->name);
        $response->assertSee('編集');
        $response->assertSee('ステータス');
        $response->assertDontSee('名前');
        $response->assertDontSee('メールアドレス');
        $response->assertSee('契約先会社名');
        $response->assertSee('閲覧可');
    }

    public function testUpdate()
    {
        $user = User::factory()->create([
            'status' => PublishLevelEnum::$TRIAL,
        ]);
        $company = Company::factory()->create();
        $response = $this->put(route('admin.user.update', ['user' => $user->id, 'company_id' => $company->id, 'status' => PublishLevelEnum::$MEMBERSHIP, 'site' => 'programming']));
        $response->assertRedirect(route('admin.login'));
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->put(route('admin.user.update', ['user' => $user->id, 'company_id' => $company->id, 'status' => PublishLevelEnum::$MEMBERSHIP, 'site' => 'programming']));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('admin.user.show', ['user' => $user->id]));
        $response->assertSessionHas('message', $user->user_id . 'を更新しました。');
        $user->refresh();
        $this->assertEquals($company->id, $user->company_id);
        $this->assertEquals(PublishLevelEnum::$MEMBERSHIP, $user->status);
        $this->assertEquals('programming', $user->site);
    }

    public function testDestroy()
    {
        $user = User::factory()->create();
        $response = $this->delete(route('admin.user.destroy', ['user' => $user->id]));
        $response->assertRedirect(route('admin.login'));
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->delete(route('admin.user.destroy', ['user' => $user->id]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('admin.user.index'));
        $response->assertSessionHas('message', $user->user_id . 'を削除しました。');
        $this->assertNull(User::withOutGlobalScope('siteFiltering')->find($user->id));
        $this->assertNotNull(User::withOutGlobalScope('siteFiltering')->withTrashed()->find($user->id));
    }

    public function testForceDelete()
    {
        $user = User::factory()->create();
        $response = $this->post(route('admin.user.force-delete', ['user' => $user->id]));
        $response->assertRedirect(route('admin.login'));
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->post(route('admin.user.force-delete', ['user' => $user->id]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('admin.user.show', ['user' => $user->id]));
        $response->assertSessionHas('message', $user->user_id . 'は削除されていません。');
        $this->assertNotNull(User::withOutGlobalScope('siteFiltering')->find($user->id));
        $this->assertNotNull(User::withOutGlobalScope('siteFiltering')->withTrashed()->find($user->id));
        $user->delete();
        $response = $this->actingAs($admin, 'admins')->post(route('admin.user.force-delete', ['user' => $user->id]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('admin.user.index'));
        $response->assertSessionHas('message', $user->user_id . 'を完全に削除しました。');
        $this->assertNull(User::withOutGlobalScope('siteFiltering')->find($user->id));
        $this->assertNull(User::withOutGlobalScope('siteFiltering')->withTrashed()->find($user->id));
    }

    public function testRestore()
    {
        $user = User::factory()->create();
        $response = $this->post(route('admin.user.restore', ['user' => $user->id]));
        $response->assertRedirect(route('admin.login'));
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admins')->post(route('admin.user.restore', ['user' => $user->id]));
        $response->assertRedirect(route('admin.user.show', ['user' => $user->id]));
        $response->assertSessionHas('message', $user->user_id . 'は削除されていません。');

        $user->delete();
        $response = $this->actingAs($admin, 'admins')->post(route('admin.user.restore', ['user' => $user->id]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('admin.user.show', ['user' => $user->id]));
        $response->assertSessionHas('message', $user->user_id . 'を復元しました。');
        $this->assertNotNull(User::withOutGlobalScope('siteFiltering')->find($user->id));
    }
}
