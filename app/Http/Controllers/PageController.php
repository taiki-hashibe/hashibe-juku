<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Artesaos\SEOTools\Facades\SEOMeta;

class PageController extends Controller
{
    public function index(Page $page)
    {
        SEOMeta::setTitle($page->title);
        return view('pages.page.index', ['page' => $page]);
    }
}
