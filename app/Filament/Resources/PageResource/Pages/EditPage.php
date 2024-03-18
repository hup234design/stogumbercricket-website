<?php

namespace App\Filament\Resources\PageResource\Pages;

//use Filament\Forms\Components\Builder;
//use Filament\Forms\Components\Component;
use App\Filament\Resources\PageResource;
//use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
//use App\Livewire\Blocks\ContactBlock;
//use App\Livewire\Blocks\CtaBlock;
//use App\Livewire\Blocks\EventsBlock;
//use App\Livewire\Blocks\FeaturesBlock;
//use App\Livewire\Blocks\GalleryBlock;
//use App\Livewire\Blocks\ImageBlock;
//use App\Livewire\Blocks\PostsBlock;
//use App\Livewire\Blocks\RichTextBlock;
//use App\Livewire\Blocks\SliderBlock;
//use App\Livewire\Blocks\TestimonialsBlock;
use Pboivin\FilamentPeek\Pages\Actions\PreviewAction;
//use Pboivin\FilamentPeek\Pages\Concerns\HasBuilderPreview;
use Pboivin\FilamentPeek\Pages\Concerns\HasPreviewModal;

class EditPage extends EditRecord
{
    use HasPreviewModal;

    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //PreviewAction::make(),
        ];
    }


//    protected function getPreviewModalView(): ?string
//    {
//        return 'page';
//    }
//
//    protected function getPreviewModalDataRecordKey(): ?string
//    {
//        return 'page';
//    }

}
