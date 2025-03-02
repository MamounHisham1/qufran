<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExaminationResource\Pages;
use App\Filament\Resources\ExaminationResource\RelationManagers;
use App\Filament\Resources\ExaminationResource\RelationManagers\QuestionsRelationManager;
use App\Models\Examination;
use App\Models\Post;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;

class ExaminationResource extends Resource
{
    protected static ?string $model = Examination::class;

    protected static ?int $navigationSort = 50;

    protected static ?string $modelLabel = 'امتحان';

    protected static ?string $navigationLabel = 'الامتحانات';

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Select::make('category_id')
                    ->label('Category')
                    ->searchable()
                    ->options(Category::pluck('name', 'id'))
                    ->createOptionForm([
                        TextInput::make('name')
                            ->label(__('Name'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('parent_category_id')
                            ->label(__('Parent category'))
                            ->numeric(),
                        Toggle::make('is_published')
                            ->label(__('Is published')),
                    ])->createOptionUsing(fn($data) => Category::create($data)),
                Select::make('post_id')
                    ->label('Lesson')
                    ->searchable()
                    ->options(Post::where('type', '!=', 'fatwa')->pluck('title', 'id')),
                RichEditor::make('description')
                    ->columnSpanFull(),
                DatePicker::make('start_at')
                    ->label(__('Start date'))
                    ->default(now()),
                DatePicker::make('end_at')
                    ->label(__('End date')),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            QuestionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExaminations::route('/'),
            'create' => Pages\CreateExamination::route('/create'),
            'edit' => Pages\EditExamination::route('/{record}/edit'),
            'view' => Pages\ViewExamination::route('/{record}'),
        ];
    }
}
