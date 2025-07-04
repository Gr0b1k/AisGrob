<?php

namespace App\Filament\User\Resources\ApplicationResource\Pages;

use App\Filament\User\Resources\ApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateApplication extends CreateRecord
{
    protected static string $resource = ApplicationResource::class;
}
