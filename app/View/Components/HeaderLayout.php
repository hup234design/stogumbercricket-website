<?php

namespace App\View\Components;

use App\Models\Sponsor;
use Closure;
use App\Models\Post;
use App\Services\NavigationMenuItems;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;
use RyanChandler\FilamentNavigation\Models\Navigation;

class HeaderLayout extends Component
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
        $menu = Navigation::fromHandle('header');
        $menuLinks = NavigationMenuItems::transform($menu['items']);

        $sponsor = cms('sponsor_id', null) ? Sponsor::find(cms('sponsor_id')) : null;

        return view('layouts.header', [
            'menuLinks' => $menuLinks,
            'sponsor' => $sponsor
        ]);
    }
}
