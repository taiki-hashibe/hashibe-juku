<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(): View|RedirectResponse
    {
        if (request()->method() === 'POST') {
            $credentials = request()->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (Auth::guard('admins')->attempt($credentials, true)) {
                request()->session()->regenerate();
                return redirect()->intended('admin');
            }

            return back()->withErrors([
                'any' => 'The provided credentials do not match our records.',
            ]);
        }
        return view('admin.pages.auth.login');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admins')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
