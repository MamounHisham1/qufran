<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Category;
use App\Models\Post;
use Filament\Resources\Resource;
use App\PostTypes;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Actions;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'منشور';

    protected static ?string $navigationLabel = 'المنشورات';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->columnSpanFull()
                    ->required(),
                Select::make('category_id')
                    ->label('Category')
                    ->options(Category::pluck('name', 'id'))
                    ->required(),
                Select::make('type')
                    ->options(PostTypes::class)
                    ->default(PostTypes::Photo)
                    ->live()
                    ->required(),
                RichEditor::make('body')
                    ->visible(fn($get) => $get('type') === PostTypes::Article)
                    ->columnSpanFull()
                    ->required(),
                FileUpload::make('audio')
                    ->visible(fn($get) => $get('type') === PostTypes::Audio)
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('video')
                    ->label('Video URL')
                    ->visible(fn($get) => $get('type') === PostTypes::Video)
                    ->columnSpanFull()
                    ->required(),
                FileUpload::make('image')
                    ->image()
                    ->columnSpanFull(),
                RichEditor::make('description')
                    ->columnSpanFull(),
                Toggle::make('is_published')
                    ->default(true),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
            'view' => Pages\ViewPost::route('/{record}'),
        ];
    }
}
