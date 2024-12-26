<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FatwaResource\Pages;
use App\Filament\Resources\FatwaResource\RelationManagers;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\PostTypes;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FatwaResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?int $navigationSort = 40;

    protected static ?string $modelLabel = 'فتوى';

    protected static ?string $navigationLabel = 'الفتاوى';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('type', 'fatwa');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('type')
                    ->default(PostTypes::Fatwa)
                    ->disabled()
                    ->hidden(),
                Select::make('category_id')
                    ->label('Category')
                    ->options(Category::pluck('name', 'id'))
                    ->required(),
                Select::make('user_id')
                    ->label(__('User'))
                    ->options(User::pluck('name', 'id')),
                RichEditor::make('title')
                    ->label(__('The question'))
                    ->required(),
                RichEditor::make('body')
                    ->label(__('The answer')),
                Toggle::make('is_published')
                    ->label(__('Is published'))
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('The question'))
                    ->searchable()
                    ->limit(20),
                TextColumn::make('body')
                    ->label(__('The answer'))
                    ->searchable()
                    ->limit(40),
                IconColumn::make('is_published')
                    ->label(__('Is published'))
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListFatwas::route('/'),
            'view' => Pages\ViewFatwa::route('/{record}'),
            // 'create' => Pages\CreateFatwa::route('/create'),
            // 'edit' => Pages\EditFatwa::route('/{record}/edit'),
        ];
    }
}
