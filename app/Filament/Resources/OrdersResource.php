<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrdersResource\Pages;
use App\Filament\Resources\OrdersResource\RelationManagers;
use App\Filament\Resources\StudentRelationManagerResource\RelationManagers\StudentRelationManager;
use App\Models\Orders;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrdersResource extends Resource
{
    protected static ?string $model = Orders::class;
    protected static ?string $modelLabel = 'Приказ';
    protected static ?string $pluralModelLabel = 'Приказы';
    protected static ?string $navigationGroup = 'Ведомости и приказы';
    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    public static function form(Form $form): Form
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
                            'Зачисление' => 'Зачисление',
                            'Отчисление' => 'Отчисление',
                            'Мероприятие' => 'Мероприятие'
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
                            ->options(Student::pluck('fio', 'id')),
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

    public static function table(Table $table): Table
    {
        return $table
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
            StudentRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrders::route('/create'),
            'view' => Pages\ViewOrders::route('/{record}'),
            'edit' => Pages\EditOrders::route('/{record}/edit'),
        ];
    }
}
