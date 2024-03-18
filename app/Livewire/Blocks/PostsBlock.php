<?php

namespace App\Livewire\Blocks;

use Filament\Forms;
use FilamentTiptapEditor\TiptapEditor;
use App\Filament\Services\FormComponents;
use App\Filament\Support\ContentBlock;
use App\Models\Post;
use Illuminate\Contracts\View\View;

class PostsBlock extends ContentBlock
{

    public static function block() {
        return Forms\Components\Builder\Block::make('posts-block')
            ->label('Latest Posts')
            ->icon('heroicon-o-newspaper')
            ->schema(
                FormComponents::contentBlock(
                    [
                        //
                    ]
                )
            );
    }

    public function render(): View
    {
        return view('livewire.blocks.posts-block', [
            'posts' => Post::recent()->orderBy('publish_at', 'desc')->take(3)->get(),
        ]);
    }
}
