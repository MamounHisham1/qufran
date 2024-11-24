<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Infolists\Components\AudioPlayerEntry;
use Filament\Actions;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Colors\Color;

class ViewPost extends ViewRecord
{
    protected static string $resource = PostResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('title')
                    ->label(__('Title')),
                TextEntry::make('category.name')
                    ->label(__('Category')),
                TextEntry::make('type')
                    ->label(__('Type'))
                    ->formatStateUsing(fn($state) => ucfirst($state)),
                AudioPlayerEntry::make('audio')
                    ->label(__('Audio'))
                    ->visible(fn($state) => !!$state),
                TextEntry::make('video')
                    ->label(__('Video'))
                    ->visible(fn($state) => !!$state)
                    ->color(Color::Blue)
                    ->url(fn($state) => $state)
                    ->openUrlInNewTab(),
                ImageEntry::make('image')
                    ->label(__('Image'))
                    ->placeholder('N/A'),
                TextEntry::make('description')
                    ->label(__('Description'))
                    ->placeholder('N/A')->html(),
                TextEntry::make('body')
                    ->label(__('Body'))
                    ->visible(fn($state) => !!$state),
            ]);
    }
}
