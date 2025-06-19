<?php

namespace App\Filament\Resources\ApplicationResource\Widgets;

use App\Models\Application;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ApplicationStatic extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make("Новые заявки", Application::query()->where('status', 'approved')->count()),
        ];
    }
}
