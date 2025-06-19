<?php

namespace App\Filament\User\Resources;

use App\Filament\Exports\ApplicationExporter;
use App\Filament\User\Resources\ApplicationResource\Pages;
use App\Filament\User\Resources\ApplicationResource\RelationManagers;
use App\Models\Application;
use App\Models\Student;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Components\ToggleButtons;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;
    protected static ?string $modelLabel = 'Заявку';
    protected static ?string $pluralModelLabel = 'Заявки';
    protected static ?string $navigationGroup = 'Обращения';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

        public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery(Application::class)->where('student_id', auth()->user()->student_id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Основная информация')->schema([
                    Forms\Components\Select::make('student_id')
                        ->label('Студент')
                        ->required()
                        ->options(Student::where('id', auth()->user()->student_id)->pluck('fio', 'id')),
                    Select::make('type')
                        ->label('Тип заявки')
                        ->options([
                            'Справка для военкомата',
                            'Справка для налоговой',
                            'Справка для ...',
                        ])
                        ->required(),
                ])->columnSpanFull()->columns(2),
                    Forms\Components\FileUpload::make('file')
                        ->downloadable('application')
                        ->directory('application')
                        ->disabled()
                        ->label('Файл справки')
                        ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student.group.name')
                    ->label('Группа')
                    ->sortable(),
                Tables\Columns\TextColumn::make('student.fio')
                    ->label('Фио студента')
                    ->sortable(),
                SelectColumn::make('type')
                    ->label('Тип заявки')
                    ->sortable()
                    ->disabled()
                    ->options([
                        'Справка для военкомата',
                        'Справка для налоговой',
                        'Справка для ...',
                    ]),
                TextColumn::make('status')
                    ->label('Статус заявки')
                    ->sortable()
                    ->size(TextColumn\TextColumnSize::Large)
                    ->weight(FontWeight::Bold)
                    ->disabled()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->icon(fn(string $state): string => match ($state) {
                        'approved' => 'heroicon-o-clipboard-document-check',
                        'done' => 'heroicon-o-hand-thumb-up',
                        'rejected' => 'heroicon-o-x-mark'
                    })
                        ->formatStateUsing(fn(string $state): string => match ($state) {
                    'approved' => 'Принята',
                    'done' => 'Выполнено',
                    'rejected' => 'Отклонена',
                    default => $state,
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'approved' => 'info',
                        'done' => 'success',
                        'rejected' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([

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
            'index' => Pages\ListApplications::route('/'),
            'create' => Pages\CreateApplication::route('/create'),
            'view' => Pages\ViewApplication::route('/{record}'),
            'edit' => Pages\EditApplication::route('/{record}/edit'),
        ];
    }
}
