<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Page;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index() : View
    {
        $page = Page::indexPages()->whereSlug('events')->firstOrFail();

        $events = Event::upcoming()->visible()->orderBy('date', 'asc')->get();

        return view('events', [
            'page'  => $page,
            'events' => $events,
        ]);
    }

    public function event($slug) : View
    {
        $page = Event::visible()->whereSlug($slug)->firstOrFail();

        return view('event', [
            'page' => $page
        ]);
    }
}
