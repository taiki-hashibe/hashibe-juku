<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class BookmarkController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth('users')->user();
        return view('pages.user.bookmark.index', [
            'posts' => $user->bookmarks()->orderBy('created_at')
        ]);
    }
}
