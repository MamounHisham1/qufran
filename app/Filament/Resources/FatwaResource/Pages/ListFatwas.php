<?php

namespace App\Filament\Resources\FatwaResource\Pages;

use App\Filament\Resources\FatwaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFatwas extends ListRecords
{
    protected static string $resource = FatwaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
