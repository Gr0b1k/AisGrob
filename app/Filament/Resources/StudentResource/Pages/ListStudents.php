<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Exports\StudentExporter;
use App\Filament\Imports\StudentImporter;
use App\Filament\Resources\StudentResource;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    { 
        return [
            \EightyNine\ExcelImport\ExcelImportAction::make('Импорт')
                ->color("gray"),
            // ImportAction::make('StudentImporter')
            //     ->importer(StudentImporter::class),
            // ExportAction::make('StudentExporter')
            //     ->exporter(StudentExporter::class),    
            Actions\CreateAction::make(),
        ];
    }
}
