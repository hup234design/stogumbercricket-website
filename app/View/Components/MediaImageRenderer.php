<?php

namespace App\View\Components;

use App\Models\MediaImage;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MediaImageRenderer extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public int|string|MediaImage|null $mediaImage,
        public string|null $conversion = "",
        public bool|null $lightbox = false
    ) {
        if (! $mediaImage instanceof MediaImage) {
            $this->mediaImage = MediaImage::where('id', $mediaImage)->first();
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.media-image-renderer');
    }
}
