<?php

namespace App\Http\Controllers\Line;

use App\Foundation\LineSignup;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use LineSignup;

    public function __construct()
    {
        $this->configKeys = [
            'client_id' => config('line.line_login.channel_id'),
            'callback_url' => config('line.line_login.callback_url'),
            'client_secret' => config('line.line_login.channel_secret'),
        ];
        dump($this->configKeys);
    }

    public function login()
    {
        return view('pages.line.auth.index');
    }

    public function logout()
    {
        Auth::guard($this->guard)->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect()->route('line.login')->with('message', 'ログアウトしました！');
    }

    public function createAccount(mixed $profile): mixed
    {
        $user = User::create([
            'name' => $profile->displayName,
            'line_id' => $profile->userId,
            'status_message' => property_exists($profile, 'statusMessage') ? $profile->statusMessage : null,
            'picture_url' =>  property_exists($profile, 'pictureUrl') ? $profile->pictureUrl : null,
        ]);
        return $user;
    }
}
