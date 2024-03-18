<?php

namespace App\View\Components;

use Closure;
use App\Models\Event;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EventsLayout extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $upcomingEvents = Event::upcoming()->visible()->orderBy('date', 'asc')->take(5)->get();

        $categories = collect([]);

        return view('layouts.events', [
            'upcomingEvents' => $upcomingEvents,
            'categories' => $categories
        ]);
    }
}
