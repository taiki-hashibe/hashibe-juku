<?php

namespace App\Http\Controllers;

use App\Models\Tag;

class TagController extends Controller
{
    public function index(Tag $tag)
    {
        return view('pages.tag.index', [
            'tag' => $tag,
            'posts' => $tag->posts
        ]);
    }
}
