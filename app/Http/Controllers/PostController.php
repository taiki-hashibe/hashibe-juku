<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
    {
        if (auth('users')->check()) {
            return redirect()->route('user.' . request()->route()->getName(), [
                'category' => request()->category,
                'post' => request()->post,
            ]);
        }
        $category = Category::where('slug', request()->category)->first();
        if (!$category) abort(404);
        $post = Post::publish()->where('slug', request()->post)->first();
        if (!$post) abort(404);
        SEOMeta::setTitle($post->title);
        $description = $post->getDescription();
        if ($description) {
            SEOMeta::setDescription($description);
        }
        return view('pages.post.index', [
            'category' => $category,
            'post' => $post,
            'prev' => $post->prev(),
            'next' => $post->next(),
        ]);
    }

    public function post(): \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
    {
        if (auth('users')->check()) {
            return redirect()->route('user.' . request()->route()->getName(), [
                'post' => request()->post,
            ]);
        }
        $post = Post::publish()->where('slug', request()->post)->first();
        if (!$post) abort(404);
        SEOMeta::setTitle($post->title);
        $description = $post->getDescription();
        if ($description) {
            SEOMeta::setDescription($description);
        }
        return view('pages.post.index', [
            'post' => $post,
        ]);
    }
}
