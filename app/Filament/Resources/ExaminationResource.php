<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExaminationResource\Pages;
use App\Filament\Resources\ExaminationResource\RelationManagers;
use App\Filament\Resources\ExaminationResource\RelationManagers\QuestionsRelationManager;
use App\Models\Examination;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;

class ExaminationResource extends Resource
{
    protected static ?string $model = Examination::class;

    protected static ?int $navigationSort = 4;

    protected static ?string $modelLabel = 'امتحان';

    protected static ?string $navigationLabel = 'الامتحانات';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Select::make('category_id')
                    ->label('Category')
                    ->options(Category::pluck('name', 'id')),
                Textarea::make('description')
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
