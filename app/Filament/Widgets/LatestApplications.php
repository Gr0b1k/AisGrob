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

class LatestApplications extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
protected static ?string $heading = 'Последние заявки';
    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(ApplicationResource::getEloquentQuery()->where('status', 'approved'))
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
                SelectColumn::make('status')
                    ->label('Статус заявки')
                    ->disabled()
                    ->sortable()
                    ->options([
                        'approved' => 'Одобрено',
                        'done' => 'Выполнено',
                        'rejected' => 'Отклонено'
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                ])
                ->actions([
                    Action::make('Подробнее')
                        ->url(fn (Application $record):string => ApplicationResource::getUrl('view', ['record' => $record]))
                        ->color('info')
                        ->icon('heroicon-o-eye'),
                    Action::make('Изменить')
                        ->url(fn (Application $record):string => ApplicationResource::getUrl('edit', ['record' => $record]))
                        ->icon('heroicon-o-pencil-square'),
                ]);
    }
}
