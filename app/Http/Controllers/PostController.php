<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Artesaos\SEOTools\Facades\SEOMeta;

class PostController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View
    {
        $category = Category::where('slug', request()->category)->first();
        if (!$category) abort(404);
        $post = Post::publish()->where('slug', request()->post)->first();
        if (!$post) abort(404);
        SEOMeta::setTitle($post->title);
        SEOMeta::setDescription($post->getDescription());
        return view('pages.post.index', [
            'category' => $category,
            'post' => $post,
            'prev' => $post->prev(),
            'next' => $post->next(),
        ]);
    }

    public function post(): \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
    {
        $post = Post::publish()->where('slug', request()->post)->first();
        if (!$post) abort(404);
        if ($post->category) {
            return redirect()->route('content.post', [
                'category' => $post->category->slug,
                'post' => $post->slug,
            ]);
        }
        SEOMeta::setTitle($post->title);
        SEOMeta::setDescription($post->getDescription());
        return view('pages.post.index', [
            'post' => $post,
            'prev' => $post->prev(),
            'next' => $post->next(),
        ]);
    }
}
