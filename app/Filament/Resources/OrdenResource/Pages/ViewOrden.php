<?php

namespace App\Filament\Resources\OrdenResource\Pages;

use App\Filament\Resources\OrdenResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewOrden extends ViewRecord
{
    protected static string $resource = OrdenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\EditAction::make()
        ];
    }
}
