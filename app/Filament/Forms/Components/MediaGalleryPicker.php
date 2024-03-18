<?php

namespace App\Filament\Forms\Components;

use Closure;
use Exception;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Field;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class MediaGalleryPicker extends Field
{
    protected string $view = 'filament.forms.components.media-gallery-picker';

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->registerActions([
            fn (MediaGalleryPicker $component): Action => $component->getMediaGalleryPickerAction(),
        ]);
    }

    public function getMediaGalleryPickerAction(): Action
    {
        return Action::make('open_media_gallery_picker')
            //->label($this->getButtonLabel())
            ->label('Select Images')
            //->color($this->getColor())
            //->outlined($this->isOutlined())
            //->size($this->getSize())
            ->modalWidth('screen')
            ->modalFooterActions(fn () => [])
            ->modalHeading(static function () {
                return "Select Image";
            })
            ->modalContent(static function (MediaGalleryPicker $component) {
                return View::make('filament.actions.media-gallery-action', [
                    'statePath' => $component->getStatePath(),
                    'modalId' => $component->getLivewire()->getId() . '-form-component-action',
                    'mediaImageIds' => $component->getState(),
                ]);
            });
    }

}
