<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use App\Models\Post;

class CurriculumController extends Controller
{
    public function index(Curriculum $curriculum)
    {
        /** @var \App\Models\User $user */
        $user = auth('users')->user();
        if (!$user->subscribed('online-salon')) {
            return redirect()->route('user.register.guidance')->with('message', 'カリキュラムを閲覧するには本入会手続きが必要です');
        }
        return view('pages.user.curriculum.index', [
            'curriculum' => $curriculum,

        ]);
    }

    public function post(Curriculum $curriculum, Post $post)
    {
        /** @var \App\Models\User $user */
        $user = auth('users')->user();
        if (!$user->subscribed('online-salon')) {
            return redirect()->route('user.register.guidance')->with('message', 'カリキュラムを閲覧するには本入会手続きが必要です');
        }
        return view('pages.user.curriculum.post', [
            'curriculum' => $curriculum,
            'post' => $post,
        ]);
    }
}
