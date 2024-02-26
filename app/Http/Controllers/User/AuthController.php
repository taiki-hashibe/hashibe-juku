<?php

namespace App\Http\Controllers\User;

use App\Foundation\LineSignup;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use LineSignup;

    public function login()
    {
        return view('pages.user.auth.index');
    }

    public function logout()
    {
        Auth::guard($this->guard)->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect()->route('user.login')->with('message', 'ログアウトしました！');
    }

    public function callback(Request $request): RedirectResponse
    {
        $accessToken = $this->getAccessToken($request);
        $profile = $this->getProfile($accessToken);
        $model = app()->make($this->modelClass);
        $user = $model->where($this->lineIdColumnName, $profile->userId)->first();
        if ($user) {
            Auth::guard($this->guard)->login($user, true);
        } else {
            return redirect()->route('user.login')->with('message', 'アカウントが見つかりませんでした。公式LINEを友達追加でアカウントを作成できます。');
        }

        return redirect()->intended(route($this->redirectRouteName));
    }
}
