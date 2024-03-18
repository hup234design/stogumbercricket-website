<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home() : View
    {
        $page = Page::pages()->where('home',true)->firstOrFail();

        return view('home', [
            'page' => $page
        ]);
    }

    public function page($slug) : View
    {
        $page = Page::pages()->visible()->where('home',false)->whereSlug($slug)->firstOrFail();

        return view('page', [
            'page' => $page
        ]);
    }
}
