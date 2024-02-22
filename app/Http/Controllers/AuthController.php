<?php

namespace App\Http\Controllers;

use App\Foundation\LineSignup;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use LineSignup;

    public function login()
    {
        return view('pages.auth.index');
    }

    public function logout()
    {
        Auth::guard($this->guard)->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect()->route('login')->with('message', 'ログアウトしました！');
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
