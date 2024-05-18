<?php

namespace App\Filament\Resources\OrdenResource\Pages;

use App\Filament\Resources\OrdenResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListOrdens extends ListRecords
{
    protected static string $resource = OrdenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('All'),
            'nuevo' => Tab::make()->query(fn ($query) => $query->where('estado_envio', 'nuevo')),
            'procesado' => Tab::make()->query(fn ($query) => $query->where('estado_envio', 'procesado')),
            'enviado' => Tab::make()->query(fn ($query) => $query->where('estado_envio', 'enviado')),
            'entregado' => Tab::make()->query(fn ($query) => $query->where('estado_envio', 'entregado')),
            'cancelado' => Tab::make()->query(fn ($query) => $query->where('estado_envio', 'cancelado')),
        ];
    }
}
