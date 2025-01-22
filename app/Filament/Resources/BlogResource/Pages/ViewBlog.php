<?php

namespace App\Filament\Resources\BlogResource\Pages;

use App\Filament\Resources\BlogResource;
use Filament\Actions;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewBlog extends ViewRecord
{
    protected static string $resource = BlogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->columns(2)
            ->schema([
                TextEntry::make('title')
                    ->label(__('Title'))
                    ->columnSpanFull(),
                ImageEntry::make('image')
                    ->label(__('Image'))
                    ->columnSpanFull(),
                TextEntry::make('author.name')
                    ->label(__('Author'))
                    ->columnSpanFull(),
                TextEntry::make('category.name')
                    ->label(__('Category'))
                    ->columnSpanFull(),
            ]);
    }
}

