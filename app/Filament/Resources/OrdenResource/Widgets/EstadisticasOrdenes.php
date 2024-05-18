<?php

namespace App\Filament\Resources\OrdenResource\Widgets;

use App\Models\Orden;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EstadisticasOrdenes extends BaseWidget
{
    protected function getStats(): array
    {
        return array(
            Stat::make('Nuevas Ordenes', Orden::query()->where('estado_envio', 'nuevo')->count()),
            Stat::make('Ordenes En Proceso', Orden::query()->where('estado_envio', 'procesado')->count()),
            Stat::make('Ordenes Enviadas', Orden::query()->where('estado_envio', 'enviado')->count()),
            Stat::make('Total Ventas', \Number::currency(Orden::query()->avg('total_final')), 'LPS'),
        );
    }
}
