<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Artesaos\SEOTools\Facades\SEOMeta;

class CategoryController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
    {
        if (auth('users')->check()) {
            return redirect()->route('user.' . request()->route()->getName(), [
                'category' => request()->category
            ]);
        }
        $category = Category::onlyHasPost()->where('slug', request()->category)->first();
        if (!$category) abort(404);
        SEOMeta::setTitle($category->name);
        if ($category->description) {
            SEOMeta::setDescription($category->description);
        }
        return view('pages.category.index', [
            'posts' => $category->posts()->publish()->sortOrder()->get(),
            'category' => $category,
            'categories' => $category->children()->onlyHasPost()->sortOrder()
        ]);
    }
}
