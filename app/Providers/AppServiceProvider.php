<?php

namespace App\Providers;

use App\Filament\Support\CmsSettings;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\ServiceProvider;
use RyanChandler\FilamentNavigation\Filament\Resources\NavigationResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CmsSettings::class, function () {
            return CmsSettings::make(storage_path('app/settings.json'));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentAsset::register([
            Css::make('cropper', __DIR__ . '/../../resources/dist/css/cropper.min.css'),
            Js::make('cropper', __DIR__ . '/../../resources/dist/js/cropper.min.js'),
        ]);

        NavigationResource::navigationGroup('Site Management');
        NavigationResource::navigationSort(3);
    }
}
