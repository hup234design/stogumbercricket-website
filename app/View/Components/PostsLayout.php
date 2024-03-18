<?php

namespace App\View\Components;

use Closure;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PostsLayout extends Component
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

        $featuredPosts = Post::recent()->featured()->take(5)->get();

        $latestPosts   = Post::recent()->whereNotIn('id', $featuredPosts->pluck('id'))->take(5)->get();

        $categories    = PostCategory::withCount('visible_posts')->get();
        $archives      = collect([]);

        return view('layouts.posts', [
            'latestPosts' => $latestPosts,
            'featuredPosts' => $featuredPosts,
            'categories' => $categories,
            'archives' => $archives,
        ]);
    }
}
