<?php

namespace App\Filament\Resources\ExaminationResource\RelationManagers;

use App\Models\Answer;
use App\QuestionTypes;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';

    protected static ?string $label = 'سؤال';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('type')
                    ->label(__('Type'))
                    ->options(QuestionTypes::class)
                    ->live()
                    ->required(),
                TextInput::make('body')
                    ->required()
                    ->maxLength(255),
                TableRepeater::make('answers')
                    ->visible(fn($get): bool => $get('type') === QuestionTypes::PickOneAnswer->value)
                    ->relationship('answers')
                    ->schema([
                        TextInput::make('body')
                            ->required(),
                    ])
                    ->reorderable()
                    ->collapsible()
                    ->minItems(1)
                    ->maxItems(4)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('body')
            ->columns([
                TextColumn::make('body')
                    ->label(__('Body')),
                SelectColumn::make('correct_answer_id')
                    ->label(__('Correct answer'))
                    ->options(fn($record) => $record->answers->pluck('body', 'id')),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
