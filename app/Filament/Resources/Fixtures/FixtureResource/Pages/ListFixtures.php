<?php

namespace App\Filament\Resources\Fixtures\FixtureResource\Pages;

use App\Filament\Resources\Fixtures\FixtureResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFixtures extends ListRecords
{
    protected static string $resource = FixtureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
