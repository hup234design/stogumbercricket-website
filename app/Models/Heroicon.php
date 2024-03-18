<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Heroicon extends Model
{
    use \Sushi\Sushi;

    protected $rows = [];

    public function getRows()
    {
        $icons = collect(File::files(base_path('vendor/blade-ui-kit/blade-heroicons/resources/svg')))
            ->map(function ($file) {
                return [
                    'name' => preg_replace('/^[mso]-/', '', $file->getFilenameWithoutExtension()),
                ];
            })
            ->toArray();

        return $icons;
    }
}

