<?php

namespace App\Filament\Resources\SuggestionResource\Pages;

use App\Filament\Resources\SuggestionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSuggestion extends EditRecord
{
    protected static string $resource = SuggestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
