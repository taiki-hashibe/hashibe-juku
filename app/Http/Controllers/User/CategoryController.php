<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Artesaos\SEOTools\Facades\SEOMeta;

class CategoryController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View
    {
        $category = Category::onlyHasPost()->where('slug', request()->category)->first();
        if (!$category) abort(404);
        SEOMeta::setTitle($category->name);
        if ($category->description) {
            SEOMeta::setDescription($category->description);
        }
        return view('pages.user.category.index', [
            'posts' => $category->posts()->publish()->sortOrder()->get(),
            'category' => $category,
            'categories' => $category->children()->onlyHasPost()->sortOrder()
        ]);
    }
}
