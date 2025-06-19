<?php

namespace App\Filament\Imports;

use App\Models\Group;
use App\Models\Student;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class StudentImporter extends Importer
{    
    protected static ?string $model = Student::class;
    protected static ?string $modelLabel = 'Студента';
    protected static ?string $title = 'Студенты';
    protected static ?string $pluralModelLabel = 'Студенты';

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('group_id')
                ->requiredMapping()
                ->label('Группа')
                ->relationship(Group::class)
                ->rules(['required', 'integer']),
            ImportColumn::make('fio')
                ->label('Фио')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('phone')
                ->label('Телефон')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('addres')
                ->label('Адрес')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('studentNumber')
                ->label('Номер студенческого')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('dateStart')
                ->label('Дата начала обучения')
                ->requiredMapping()
                ->rules(['required', 'date']),
            ImportColumn::make('dateEnd')
                ->label('Дата окончания обучения')
                ->requiredMapping()
                ->rules(['required', 'date']),
        ];
    }

    public function resolveRecord(): ?Student
    {
        // return Student::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Student();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your student import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
