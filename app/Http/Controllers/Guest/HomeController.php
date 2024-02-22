<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOMeta;

class HomeController extends Controller
{
    public function home()
    {
        return view('pages.guest.home.index');
    }

    public function legal()
    {
        SEOMeta::setTitle('特定商取引法に基づく表記');
        return view('pages.guest.legal.index');
    }

    public function privacy()
    {
        SEOMeta::setTitle('プライバシーポリシー');
        return view('pages.guest.privacy.index');
    }

    public function term()
    {
        SEOMeta::setTitle('利用規約');
        return view('pages.guest.term.index');
    }
}
