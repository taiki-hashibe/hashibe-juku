<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class CompleteController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth('users')->user();
        return view('pages.user.complete.index', [
            'posts' => $user->completes()->orderBy('created_at')
        ]);
    }
}
