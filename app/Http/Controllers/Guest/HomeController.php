<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function home()
    {
        return view('pages.guest.home.index');
    }

    public function legal()
    {
        return view('pages.guest.legal.index');
    }

    public function privacy()
    {
        return view('pages.guest.privacy.index');
    }

    public function term()
    {
        return view('pages.guest.term.index');
    }
}
