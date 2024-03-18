<?php

namespace App\Filament\Resources\IndexPageResource\Pages;

use App\Filament\Resources\IndexPageResource;
//use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIndexPages extends ListRecords
{
    protected static string $resource = IndexPageResource::class;

//    protected function getHeaderActions(): array
//    {
//        return [
//            Actions\CreateAction::make(),
//        ];
//    }
}
