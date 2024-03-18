<?php

namespace App\Filament\Resources\Fixtures\FixtureResource\Pages;

use App\Filament\Resources\Fixtures\FixtureResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFixture extends EditRecord
{
    protected static string $resource = FixtureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
