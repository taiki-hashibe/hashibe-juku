<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Curriculum;
use App\Models\Post;
use Artesaos\SEOTools\Facades\SEOMeta;

class HomeController extends Controller
{
    public function home(): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        if (auth('users')->check()) {
            return redirect()->route('user.' . request()->route()->getName(), [
                'category' => request()->category
            ]);
        }
        $posts = Post::publish()->where('category_id', null)->sortOrder()->get();
        $categories = Category::onlyHasPost()->sortOrder();
        $curriculums = Curriculum::onlyHasPost()->sortOrder();
        return view('pages.home.index', [
            'posts' => $posts,
            'categories' => $categories,
            'curriculums' => $curriculums
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
