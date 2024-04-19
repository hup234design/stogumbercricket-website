<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IndexPageResource\Pages;

class IndexPageResource extends PageResource
{
    protected static ?string $navigationGroup = null;
    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Index Page';
    protected static ?string $pluralModelLabel = 'Index Pages';
    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    protected static string $pageType = 'index';

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIndexPages::route('/'),
            'edit' => Pages\EditIndexPage::route('/{record}/edit'),
        ];
    }
}
