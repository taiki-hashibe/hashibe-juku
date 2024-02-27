<?php

namespace App\Http\Controllers;

class CurriculumController extends Controller
{
    public function index()
    {
        return redirect()->route('user.register.guidance')->with('message', 'カリキュラムを閲覧するには本入会手続きが必要です');
    }

    public function post()
    {
        return redirect()->route('user.register.guidance')->with('message', 'カリキュラムを閲覧するには本入会手続きが必要です');
    }
}
