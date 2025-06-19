<?php

namespace App\Filament\Resources\OrdersRelationManagerResource\RelationManagers;

use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrdersRelationManager extends RelationManager
{
    protected static ?string $title = 'Приказы';
    protected static string $relationship = 'Orders';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                 Section::make('Основная информация')->schema([
                    Forms\Components\DatePicker::make('date')
                        ->label('Дата приказа')
                        ->required(),
                    Forms\Components\TextInput::make('number')
                        ->label('Номер приказа')
                        ->required(),
                    Select::make('name')
                        ->label('Тип приказа')
                        ->options([
                            'Зачисление',
                            'Отчисление',
                            'Мероприятие'
                        ])
                        ->required(),
                    Select::make('student_id')
                        ->label('Студент')
                        ->options(Student::pluck('fio', 'id'))
                        ->required(),    
                    Repeater::make('students')
                    ->label('Студенты')
                    ->schema([
                        Select::make('student_id')
                            ->label('Студент')
                            ->options(Student::pluck('fio', 'id'))
                            ->required(),
                    ])->columnSpanFull(),
                ])->columnSpanFull() ->columns(2),
                Section::make('Основная информация')->schema([
                    Forms\Components\RichEditor::make('content')
                        ->required()
                        ->label('Содержание приказа')
                        ->fileAttachmentsDirectory('order')
                        ->columnSpanFull(),
                    Forms\Components\FileUpload::make('document')
                        ->label('Word документ')
                        ->downloadable()
                        ->directory('order')
                        ->columnSpanFull(),
                ])->columnSpanFull() ->columns(2),
                Forms\Components\Toggle::make('is_active')
                    ->label('Активный приказ')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Приказы')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Название приказа')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Дата приказа')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('number')
                    ->label('Номер приказа')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Действующий приказ')
                    ->boolean(),
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
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
            ]);
    }
}
