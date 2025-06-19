<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrdersRelationManagerResource\RelationManagers\OrdersRelationManager;
use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Course;
use App\Models\Group;
use App\Models\Orders;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;
    protected static ?string $modelLabel = 'Студента';
    protected static ?string $pluralModelLabel = 'Студенты';
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function form(Form $form): Form
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
                Forms\Components\TextInput::make('fio')
                    ->label('Фио студента')
                    ->required(),
                Forms\Components\TextInput::make('studentNumber')
                    ->label('Номер студенческого')
                    ->required()
                    ->numeric(),
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
                Section::make('Обучение')->schema([
                    Forms\Components\Select::make('orders_id')
                        ->label('Приказ')
                        ->required()
                        ->searchable()
                        ->options(function() {
                        return Orders::all()->mapWithKeys(function ($q) {
                            $key = "Номер приказа: ({$q->number})"; // Добавляем ID для уникальности
                            return [$q->id => $key];
                        });
                    }),
                    Forms\Components\Toggle::make('is_active')
                        ->label('Обучается')
                        ->required(),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('group.name')
                    ->label('Группа')
                    ->sortable(),
                Tables\Columns\TextColumn::make('group.course.name')
                    ->label('Курс')
                    ->sortable(),
                Tables\Columns\TextColumn::make('fio')
                    ->label('Фио студента')
                    ->searchable(),
                Tables\Columns\TextColumn::make('studentNumber')
                    ->label('Номер студенческого')
                    ->numeric()
                    ->sortable(),
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
                SelectFilter::make('group.course.name')
                    ->label('Номер курса')
                    ->attribute('group_id')
                    ->options(Course::pluck('name', 'id')),
                SelectFilter::make('group.name')
                    ->label('Группа')
                    ->attribute('group_id')
                    ->options(function() {
                        return Group::all()->mapWithKeys(function ($q) {
                            $key = "{$q->name} ({$q->course->name} курс)"; // Добавляем ID для уникальности
                            return [$q->id => $key];
                        });
                    }),
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
            OrdersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'view' => Pages\ViewStudent::route('/{record}'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
