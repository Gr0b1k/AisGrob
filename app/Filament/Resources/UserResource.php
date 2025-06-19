<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentRelationManagerResource\RelationManagers\StudentRelationManager;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Student;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $modelLabel = 'Пользователя';
    protected static ?string $pluralModelLabel = 'Пользователи';
    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Основная информация')->schema([
                Forms\Components\Select::make('student_id')
                    ->label('Студент')
                    ->required()
                    ->searchable()
                    ->options(Student::pluck('fio', 'id')),
                Forms\Components\TextInput::make('login')
                    ->label('Логин')
                    ->helperText('Номер студенческого билета')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label('Имя')
                    ->required(),
                Forms\Components\TextInput::make('password')
                    ->label('Пароль')
                    ->password()
                    ->required(),
                ])->columnSpanFull() ->columns(2),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery(User::class)->where('is_admin', false);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student.fio')
                    ->label('Студент')
                    ->sortable(),
                Tables\Columns\TextColumn::make('login')
                    ->label('Логин')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата добавления')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Дата изменения')
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
            StudentRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
