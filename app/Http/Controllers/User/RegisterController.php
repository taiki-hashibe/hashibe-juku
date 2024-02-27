<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function guidance()
    {
        $user = auth('users')->user();
        return view('pages.user.register.guidance', [
            'user' => $user,
        ]);
    }
}
