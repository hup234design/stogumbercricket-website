<?php

namespace App\Filament\Resources\ClubOfficerResource\Pages;

use App\Filament\Resources\ClubOfficerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClubOfficers extends ListRecords
{
    protected static string $resource = ClubOfficerResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->slideOver(),
        ];
    }
}
