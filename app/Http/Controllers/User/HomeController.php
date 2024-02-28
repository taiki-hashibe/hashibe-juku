<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Curriculum;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::publish()->where('category_id', null)->sortOrder()->get();
        $categories = Category::onlyHasPost()->sortOrder();
        $curriculums = Curriculum::onlyHasPost()->sortOrder();
        return view('pages.user.home.index', [
            'posts' => $posts,
            'categories' => $categories,
            'curriculums' => $curriculums
        ]);
    }
}
