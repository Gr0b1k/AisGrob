<?php

namespace App\Filament\Resources;

use App\Filament\Exports\GroupExporter;
use App\Filament\Resources\GroupResource\Pages;
use App\Filament\Resources\GroupResource\RelationManagers;
use App\Filament\Resources\StatementRelationManagerResource\RelationManagers\StatementRelationManager;
use App\Filament\Resources\StudentRelationManagerResource\RelationManagers\StudentRelationManager;
use App\Models\Course;
use App\Models\Group;
use App\Models\Specialization;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GroupResource extends Resource
{
    protected static ?string $model = Group::class;
    protected static ?string $modelLabel = 'Группу';
    protected static ?string $pluralModelLabel = 'Группы';
    protected static ?string $navigationGroup = 'Курсы и группы';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
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

    public static function table(Table $table): Table
    {
        return $table
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
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // ExportBulkAction::make()
                //     ->exporter(GroupExporter::class),
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            StudentRelationManager::class,
            StatementRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGroups::route('/'),
            'create' => Pages\CreateGroup::route('/create'),
            'view' => Pages\ViewGroup::route('/{record}'),
            'edit' => Pages\EditGroup::route('/{record}/edit'),
        ];
    }
}
