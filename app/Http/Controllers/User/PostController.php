<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\UserTrialViewingPost;
use Artesaos\SEOTools\Facades\SEOMeta;

class PostController extends Controller
{
    public function index()
    {
        /**
         * 〇課金ユーザー
         * 〇トライアルチケット使用ユーザー
         * ×トライアルチケット未使用ユーザー
         * ×トライアルチケット使い切ったユーザー
         */
        $category = Category::where('slug', request()->category)->first();
        if (!$category) abort(404);
        $post = Post::publish()->where('slug', request()->post)->first();
        if (!$post) abort(404);
        SEOMeta::setTitle($post->title);
        SEOMeta::setDescription($post->getDescription());
        return view('pages.user.post.index', [
            'category' => $category,
            'post' => $post,
        ]);
    }

    public function post()
    {
        $post = Post::publish()->where('slug', request()->post)->first();
        if (!$post) abort(404);
        if ($post->category) {
            return redirect()->route('post.category', [
                'category' => $post->category->slug,
                'post' => $post->slug,
            ]);
        }
        SEOMeta::setTitle($post->title);
        SEOMeta::setDescription($post->getDescription());
        return view('pages.user.post.index', [
            'post' => $post,
        ]);
    }

    public function trialViewing()
    {
        $user = auth('users')->user();
        $post = Post::where('id', request()->post_id)->first();
        if (UserTrialViewingPost::where('user_id', $user->id)->count() > 4) {
            return redirect()->route('user.register.guidance')->with('message', 'トライアルチケットを使い切りました');
        }
        if (!UserTrialViewingPost::where('user_id', $user->id)->where('post_id', $post->id)->exists()) {
            UserTrialViewingPost::create([
                'user_id' => $user->id,
                'post_id' => $post->id
            ]);
        }
        return redirect($post->category ? route('user.post.category', [
            'post' => $post->slug,
            'category' => $post->category->slug
        ]) : route('user.post.post', [
            'post' => $post->slug,
        ]))->with('message', 'トライアルチケットを使用しました！');
    }
}
