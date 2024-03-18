<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\PageResource;
use App\Filament\Resources\ProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Pboivin\FilamentPeek\Pages\Actions\PreviewAction;
use Pboivin\FilamentPeek\Pages\Concerns\HasPreviewModal;

class CreateProject extends CreateRecord
{
    use HasPreviewModal;

    protected static string $resource = ProjectResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type'] = 'project';
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            PreviewAction::make(),
        ];
    }

    protected function getPreviewModalView(): ?string
    {
        return 'cms.project';
    }

    protected function getPreviewModalDataRecordKey(): ?string
    {
        return 'project';
    }
}

