<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PageResource;
use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Pboivin\FilamentPeek\Pages\Actions\PreviewAction;
use Pboivin\FilamentPeek\Pages\Concerns\HasPreviewModal;

class CreatePost extends CreateRecord
{
    use HasPreviewModal;

    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            PreviewAction::make(),
        ];
    }

    protected function getPreviewModalView(): ?string
    {
        return 'cms.post';
    }

    protected function getPreviewModalDataRecordKey(): ?string
    {
        return 'post';
    }
}

