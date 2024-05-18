<?php

namespace App\Filament\Resources\UsuarioResource\Pages;

use App\Filament\Resources\UsuarioResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUsuario extends CreateRecord
{
    protected ?string $heading = 'Crear Usuario';
    protected static ?string $title = 'Crear Usuario';
    protected static string $resource = UsuarioResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
