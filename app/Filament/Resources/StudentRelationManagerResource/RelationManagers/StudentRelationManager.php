<?php

namespace App\Filament\Resources\StudentRelationManagerResource\RelationManagers;

use App\Models\Group;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentRelationManager extends RelationManager
{
    protected static ?string $title = 'Студенты';
    protected static string $relationship = 'Student';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Основная информация')->schema([
                Forms\Components\Select::make('group_id')
                    ->label('Группа')
                    ->required()
                    ->options(Group::pluck('name', 'id')),
                Forms\Components\TextInput::make('fio')
                    ->label('Фио студента')
                    ->required(),
                Forms\Components\TextInput::make('studentNumber')
                    ->label('Номер студенческого')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('password')
                    ->label('Пароль')
                    ->password()
                    ->required(),
                ])->columnSpanFull() ->columns(2),
                Section::make('Контактная информация')->schema([
                Forms\Components\TextInput::make('phone')
                    ->label('Номер телефона')
                    ->tel()
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('addres')
                    ->label('Адрес')
                    ->required(),
                ])->columnSpanFull() ->columns(2),
                Section::make('Информация об обучении')->schema([
                Forms\Components\DatePicker::make('dateStart')
                    ->label('Дата начала обучения')
                    ->required(),
                Forms\Components\DatePicker::make('dateEnd')
                    ->label('Дата окончания обучения')
                    ->required(),
                ])->columnSpanFull() ->columns(2),
                Forms\Components\Toggle::make('is_active')
                    ->label('Обучается')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('fio')
            ->columns([
                Tables\Columns\TextColumn::make('group.name')
                    ->label('Группа')
                    ->sortable(),
                Tables\Columns\TextColumn::make('fio')
                    ->label('Фио студента')
                    ->searchable(),
                Tables\Columns\TextColumn::make('studentNumber')
                    ->label('Номер студенческого')
                    ->numeric(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Обучается')
                    ->boolean(),
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
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
            ]);
    }
}
