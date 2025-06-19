<?php

namespace App\Filament\Resources\StatementRelationManagerResource\RelationManagers;

use App\Models\Group;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StatementRelationManager extends RelationManager
{
    protected static ?string $title = 'Ведомости';
    protected static string $relationship = 'Statement';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Основная информация')->schema([
                Forms\Components\Select::make('group_id')
                    ->label('Группа')
                    ->required()
                    ->searchable()
                    ->options(function() {
                        return Group::all()->mapWithKeys(function ($q) {
                            $key = "{$q->name} ({$q->course->name} курс)"; // Добавляем ID для уникальности
                            return [$q->id => $key];
                        });
                    }),
                    Forms\Components\TextInput::make('name')
                        ->label('Название ведомости')
                        ->required(),
                    Forms\Components\DatePicker::make('date')
                        ->label('Дата проведения')
                        ->required(),
                ])->columnSpanFull()->columns(2),
                Forms\Components\FileUpload::make('document')
                        ->label('Word документ')
                        ->downloadable()
                        ->directory('statement')
                        ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Ведомости')
            ->columns([
                Tables\Columns\TextColumn::make('group.name')
                    ->label('Группа')
                    ->sortable(),
                Tables\Columns\TextColumn::make('group.course.name')
                    ->label('Курс')
                    ->sortable(),
                Tables\Columns\TextColumn::make('group.specialization.code')
                    ->label('Код специальности')
                    ->sortable(),    
                Tables\Columns\TextColumn::make('group.specialization.name')
                    ->label('Название специальности')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),    
                Tables\Columns\TextColumn::make('name')
                    ->label('Название ведомости')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Дата проведения')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата создания')
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
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
            ]);
    }
}
