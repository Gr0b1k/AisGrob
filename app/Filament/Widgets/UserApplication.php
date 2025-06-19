<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ApplicationResource;
use App\Filament\Resources\OrderResource;
use App\Models\Application;
use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Filament\Exports\ApplicationExporter;
use App\Filament\User\Resources\ApplicationResource\Pages;
use App\Filament\User\Resources\ApplicationResource\RelationManagers;
use App\Models\Student;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\ExportBulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
class UserApplication extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Выполненые заявки';
    protected static ?int $sort = 2;


    public function table(Table $table): Table
    {

        return $table
            ->query(ApplicationResource::getEloquentQuery()->where('student_id', auth()->user()->student_id)->where('status', 'done'))
            ->defaultPaginationPageOption(5)
            ->defaultSort('updated_at', 'desc')
            ->columns([

                Tables\Columns\TextColumn::make('student.group.name')
                    ->label('Группа')
                    ->sortable(),
                Tables\Columns\TextColumn::make('student.fio')
                    ->label('Фио студента')
                    ->sortable(),
                SelectColumn::make('type')
                    ->disabled()
                    ->label('Тип заявки')
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
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Дата ответа')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->actions([
                Action::make('Подробнее')
                    ->url(fn (Application $record):string => ApplicationResource::getUrl('view', ['record' => $record]))
                    ->color('info')
                    ->icon('heroicon-o-eye'),
            ]);
    }
}
