<?php

namespace App\Filament\Resources\GroupRelationManagerResource\RelationManagers;

use App\Filament\Resources\StudentRelationManagerResource\RelationManagers\StudentRelationManager;
use App\Models\Course;
use App\Models\Specialization;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table; 
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GroupRelationManager extends RelationManager
{
    protected static ?string $title = 'Группа';
    protected static string $relationship = 'Group';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Основная информация')->schema([
                Forms\Components\Select::make('course_id')
                    ->label('Номер курса')
                    ->required()
                    ->options(Course::pluck('name', 'id')),
                Forms\Components\Select::make('specialization_id')
                    ->label('Код специальности')
                    ->required()
                    ->options(Specialization::pluck('name', 'id')),
                Forms\Components\TextInput::make('name')
                    ->label('Название группы')
                    ->columnSpanFull()
                    ->required(),
                ])->columnSpanFull() ->columns(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Группа')
            ->columns([
                Tables\Columns\TextColumn::make('course.name')
                    ->label('Номер курса')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Название группы')
                    ->searchable(),    
                Tables\Columns\TextColumn::make('specialization.code')
                    ->label('Код специальности')
                    ->sortable(),
                Tables\Columns\TextColumn::make('specialization.name')
                    ->label('Название специальности')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата добавления')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Дата обновления')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([

            ]);
    }

}
