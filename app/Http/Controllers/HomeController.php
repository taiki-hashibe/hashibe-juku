<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Artesaos\SEOTools\Facades\SEOMeta;

class HomeController extends Controller
{
    public function home()
    {
        $posts = Post::publish()->where('category_id', null)->get();
        $categories = Category::onlyHasPost();
        if (!$categories) abort(404);
        return view('pages.home.index', [
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }

    public function legal()
    {
        SEOMeta::setTitle('特定商取引法に基づく表記');
        return view('pages.home.legal');
    }

    public function privacy()
    {
        SEOMeta::setTitle('プライバシーポリシー');
        return view('pages.home.privacy');
    }

    public function term()
    {
        SEOMeta::setTitle('利用規約');
        return view('pages.home.term');
    }
}
