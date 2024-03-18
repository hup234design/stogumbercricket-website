<?php

use Illuminate\Support\Facades\View;

// helpers.php

if (!function_exists('cms')) {
    function cms($key = null, $default = null)
    {
        if ($key === null) {
            return app(\App\Filament\Support\CmsSettings::class);
        }
        return app(\App\Filament\Support\CmsSettings::class)->get($key, $default);
    }
}
