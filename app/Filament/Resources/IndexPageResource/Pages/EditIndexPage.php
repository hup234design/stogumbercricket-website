<?php

namespace App\Filament\Resources\IndexPageResource\Pages;

use App\Filament\Resources\IndexPageResource;
//use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
//use Pboivin\FilamentPeek\Pages\Actions\PreviewAction;
//use Pboivin\FilamentPeek\Pages\Concerns\HasPreviewModal;

class EditIndexPage extends EditRecord
{
//    use HasPreviewModal;

    protected static string $resource = IndexPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //PreviewAction::make(),
        ];
    }

//    protected function getPreviewModalView(): ?string
//    {
//        return 'cms.page';
//    }

//    protected function getPreviewModalDataRecordKey(): ?string
//    {
//        return 'page';
//    }
}
