<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Artesaos\SEOTools\Facades\SEOMeta;

class CategoryController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View
    {
        $posts = Post::publish()->where('category_id', null)->get();
        $categories = Category::onlyHasPost();
        if (!$categories) abort(404);
        return view('pages.category.index', [
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }

    public function detail(): \Illuminate\Contracts\View\View
    {
        $category = Category::onlyHasPost()->where('slug', request()->category)->first();
        if (!$category) abort(404);
        SEOMeta::setTitle($category->name);
        if ($category->description) {
            SEOMeta::setDescription($category->description);
        }
        return view('pages.category.detail', [
            'category' => $category,
        ]);
    }
}
