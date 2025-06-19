<?php

namespace App\Filament\Exports;

use App\Models\Student;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class StudentExporter extends Exporter
{
    protected static ?string $model = Student::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('group.id')
            ->label('Группа'),
            ExportColumn::make('fio')
            ->label('Фио'),
            ExportColumn::make('phone')
            ->label('Номер телефона'),
            ExportColumn::make('addres')
            ->label('Адрес'),
            ExportColumn::make('studentNumber')
            ->label('Номер студенческого'),
            ExportColumn::make('dateStart')
            ->label('Дата начала обучения'),
            ExportColumn::make('dateEnd')
            ->label('Дата окончания обучения'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your student export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
