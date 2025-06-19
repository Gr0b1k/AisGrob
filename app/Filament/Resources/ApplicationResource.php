<?php

namespace App\Filament\Resources;

use App\Filament\Exports\ApplicationExporter;
use App\Filament\Resources\ApplicationResource\Pages;
use App\Filament\Resources\ApplicationResource\RelationManagers;
use App\Filament\Resources\StudentRelationManagerResource\RelationManagers\StudentRelationManager;
use App\Models\Application;
use App\Models\Course;
use App\Models\Student;
use Filament\Forms;
use App\Models\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Основная информация')->schema([
                    Forms\Components\Select::make('student_id')
                        ->label('Фио студента')
                        ->required()
                        ->options(Student::pluck('fio', 'id')),
                    Select::make('type')
                        ->label('Тип заявки')
                        ->options([
                            'Справка для военкомата',
                            'Справка для налоговой',
                            'Справка для ...',
                        ])
                        ->required(),
                ])->columnSpanFull()->columns(2),
                Section::make('Ответ на заявку')->schema([
                    ToggleButtons::make('status')
                        ->options([
                            'approved' => 'Принята',
                            'done' => 'Выполнено',
                            'rejected' => 'Отклонено'
                        ])
                        ->colors([
                            'approved' => 'info',
                            'done' => 'success',
                            'rejected' => 'danger'
                        ])
                        ->icons([
                            'approved' => 'heroicon-o-clipboard-document-check',
                            'done' => 'heroicon-o-hand-thumb-up',
                            'rejected' => 'heroicon-o-x-mark'
                        ])
                        ->label('Статус заявки')
                        ->default('approved')
                        ->helperText('Выберите Статус заявки')
                        ->required()
                        ->inline(),
                    Forms\Components\FileUpload::make('file')
                        ->downloadable()
                        ->directory('application')
                        ->label('Файл справки'),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('student.group.name')
                    ->label('Группа')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('student.group.course.name')
                    ->label('Курс')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('student.fio')
                    ->label('Фио студента')
                    ->searchable()
                    ->sortable(),
                SelectColumn::make('type')
                    ->label('Тип заявки')
                    ->disabled()
                    ->sortable()
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
                    ->toggleable(isToggledHiddenByDefault: true)
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
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Дата Обновления')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('group')
                    ->options(Group::pluck('name', 'id'))
                    ->label('Группа')
                    ->relationship('student.group', 'name'),
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
            'index' => Pages\ListApplications::route('/'),
            'create' => Pages\CreateApplication::route('/create'),
            'view' => Pages\ViewApplication::route('/{record}'),
            'edit' => Pages\EditApplication::route('/{record}/edit'),
        ];
    }
}
