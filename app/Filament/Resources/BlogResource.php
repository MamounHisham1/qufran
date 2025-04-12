<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\Pages;
use App\Filament\Resources\BlogResource\RelationManagers;
use App\Models\Author;
use App\Models\Blog;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    protected static ?string $navigationLabel = 'المجلة';

    protected static ?string $pluralNavigationLabel = 'مقالات';

    protected static ?string $pluralModelLabel = 'مقالات';

    protected static ?string $modelLabel = 'المجلة';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Select::make('category_id')
                    ->label(__('Category'))
                    ->required()
                    ->options(Category::all()->pluck('name', 'id'))
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Select::make('parent_category_id')
                            ->label(__('Parent category'))
                            ->options(Category::where('is_published', true)->pluck('name', 'id'))
                            ->nullable(),
                        Toggle::make('is_published')
                            ->label(__('Is published'))
                            ->default(true),
                    ])
                    ->createOptionUsing(function (array $data): Category {
                        return Category::create($data);
                    }),
                Select::make('author_id')
                    ->label('Author')
                    ->required()
                    ->options(Author::all()->pluck('name', 'id'))
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        FileUpload::make('image')
                            ->image(),
                        RichEditor::make('description')
                            ->columnSpanFull(),
                    ])
                    ->createOptionUsing(function (array $data): Author {
                        return Author::create($data);
                    }),
                RichEditor::make('description')
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->image()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category_id')
                    ->label(__('Category'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('author_id')
                    ->label(__('Author'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->searchable(),
                ImageColumn::make('image')
                    ->label(__('Image'))
                    ->circular(),
                TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('Updated at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            RelationManagers\SectionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'view' => Pages\ViewBlog::route('/{record}'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
