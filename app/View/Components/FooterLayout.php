<?php

namespace App\View\Components;

use App\Models\Fixtures\Fixture;
use Closure;
use App\Models\Event;
use App\Models\Post;
use App\Services\NavigationMenuItems;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;
use RyanChandler\FilamentNavigation\Models\Navigation;

class FooterLayout extends Component
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
        $menu = Navigation::fromHandle('footer');
        $menuLinks = NavigationMenuItems::transform($menu['items']);

        return view('layouts.footer', [
            'menuLinks' => $menuLinks,
            'latestPosts' => Post::recent()->take(3)->get(),
            'upcomingEvents' => Event::upcoming()->visible()->take(3)->get(),
            'upcomingFixtures' => Fixture::upcoming()->take(3)->get()
        ]);
    }
}
