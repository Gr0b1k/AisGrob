<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GroupRelationManagerResource\RelationManagers\GroupRelationManager;
use App\Filament\Resources\StatementResource\Pages;
use App\Filament\Resources\StatementResource\RelationManagers;
use App\Filament\Resources\StudentRelationManagerResource\RelationManagers\StudentRelationManager;
use App\Models\Group;
use App\Models\Statement;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StatementResource extends Resource
{
    protected static ?string $model = Statement::class;
    protected static ?string $modelLabel = 'Ведомость';
    protected static ?string $pluralModelLabel = 'Ведомости';
    protected static ?string $navigationGroup = 'Ведомости и приказы';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard';

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
            GroupRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStatements::route('/'),
            'create' => Pages\CreateStatement::route('/create'),
            'view' => Pages\ViewStatement::route('/{record}'),
            'edit' => Pages\EditStatement::route('/{record}/edit'),
        ];
    }
}
