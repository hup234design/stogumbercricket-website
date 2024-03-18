<?php

namespace App\Filament\Resources\EnquiryResource\Pages;

use App\Filament\Resources\EnquiryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Livewire\Features\SupportPageComponents\Layout;

class ListEnquiries extends ListRecords
{
    protected static string $resource = EnquiryResource::class;
}
