<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Tag;

class TagController extends Controller
{
    public function index(Tag $tag)
    {
        return view('pages.user.tag.index', [
            'tag' => $tag,
            'posts' => $tag->posts
        ]);
    }
}
