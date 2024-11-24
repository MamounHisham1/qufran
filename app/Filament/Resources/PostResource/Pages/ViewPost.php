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
                TextEntry::make('title'),
                TextEntry::make('category.name'),
                TextEntry::make('type')
                    ->formatStateUsing(fn($state) => ucfirst($state)),
                AudioPlayerEntry::make('audio')
                    ->visible(fn($state) => !!$state)
                    ->label('Audio'),
                TextEntry::make('video')
                    ->label('Video URL')
                    ->visible(fn($state) => !!$state)
                    ->color(Color::Blue)
                    ->url(fn($state) => $state)
                    ->openUrlInNewTab(),
                ImageEntry::make('image')
                    ->placeholder('N/A'),
                TextEntry::make('description')
                    ->placeholder('N/A')->html(),
                TextEntry::make('body')
                    ->visible(fn($state) => !!$state),
            ]);
    }
}
