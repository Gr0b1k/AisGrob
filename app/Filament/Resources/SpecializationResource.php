<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SpecializationResource\Pages;
use App\Filament\Resources\SpecializationResource\RelationManagers;
use App\Models\Specialization;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SpecializationResource extends Resource
{
    protected static ?string $model = Specialization::class;
    protected static ?string $modelLabel = 'Специальность';
    protected static ?string $pluralModelLabel = 'Специальности';
    protected static ?string $navigationGroup = 'Курсы и группы';
    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Основная информация')->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Название специальности')
                    ->required(),
                Forms\Components\TextInput::make('code')
                    ->label('Код специальности')
                    ->required(),    
                Forms\Components\TextInput::make('cafedra')
                    ->label('Кафедра')
                    ->required(),    
                ])->columnSpanFull() ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Название специальности')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->label('Код специальности')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cafedra')
                    ->label('Кафедра')
                    ->searchable(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSpecializations::route('/'),
            'create' => Pages\CreateSpecialization::route('/create'),
            'view' => Pages\ViewSpecialization::route('/{record}'),
            'edit' => Pages\EditSpecialization::route('/{record}/edit'),
        ];
    }
}
