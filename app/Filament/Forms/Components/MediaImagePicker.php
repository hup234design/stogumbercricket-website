<?php

namespace App\Filament\Forms\Components;

use Closure;
use Exception;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Field;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class MediaImagePicker extends Field
{
    protected string $view = 'filament.forms.components.media-image-picker';

    protected string | Closure | null $useConversion = "";

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->registerActions([
            fn (MediaImagePicker $component): Action => $component->getMediaImagePickerAction(),
            fn (MediaImagePicker $component): Action => $component->getRemoveMediaImageAction(),
        ]);
    }

    public function useConversion(): string
    {
        return $this->evaluate($this->useConversion);
    }

    public function conversion(string | Closure $condition = ""): static
    {
        $this->useConversion = $condition;
        return $this;
    }

    public function getMediaImagePickerAction(): Action
    {
        return Action::make('open_media_image_picker')
            //->label($this->getButtonLabel())
            ->label('Select Image')
            //->color($this->getColor())
            //->outlined($this->isOutlined())
            //->size($this->getSize())
            ->modalWidth('screen')
            ->modalFooterActions(fn () => [])
            ->modalHeading(static function () {
                return "Select Image";
            })
            ->modalContent(static function (MediaImagePicker $component) {
                return View::make('filament.actions.media-picker-action', [
                    'statePath' => $component->getStatePath(),
                    'modalId' => $component->getLivewire()->getId() . '-form-component-action',
                    'mediaImageId' => $component->getState(),
                    'conversion' => $component->useConversion(),
                ]);
            });
    }

    public function getRemoveMediaImageAction(): Action
    {
        return Action::make('remove_media_image')
            ->label('Remove Image')
            ->icon('heroicon-s-minus-circle')
            ->color('gray')
            ->hidden(fn(MediaImagePicker $component): bool => $component->isDisabled())
            ->action(function (array $arguments, MediaImagePicker $component): void {
                $component->state(null);
            })
            ->requiresConfirmation();
    }
}
