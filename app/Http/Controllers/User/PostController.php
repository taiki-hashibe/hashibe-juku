<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\UserTrialViewingPost;

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
    }

    public function post()
    {
    }

    public function trialViewing(Post $post)
    {
        $user = auth('users')->user();
        if (UserTrialViewingPost::where('user_id', $user->id)->count() > 4) {
            return redirect()->route('user.post.post', [
                'post' => request()->post,
            ])->with('message', 'トライアルチケットを使い切りました');
        }
        if (!UserTrialViewingPost::where('user_id', $user->id)->where('post_id', $post->id)->exists()) {
            UserTrialViewingPost::create([
                'user_id' => $user->id,
                'post_id' => $post->id
            ]);
        }
        return redirect()->route('user.post.post', [
            'post' => request()->post,
        ]);
    }
}
