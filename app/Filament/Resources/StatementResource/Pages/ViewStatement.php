<?php

namespace App\Filament\Resources\StatementResource\Pages;

use App\Filament\Resources\StatementResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewStatement extends ViewRecord
{
    protected static string $resource = StatementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
