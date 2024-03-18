<?php

namespace App\Filament\Resources\Fixtures\FixtureResource\Pages;

use App\Filament\Resources\Fixtures\FixtureResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFixture extends CreateRecord
{
    protected static string $resource = FixtureResource::class;
}
