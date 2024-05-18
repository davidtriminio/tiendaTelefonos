<?php

namespace App\Filament\Resources\UsuarioResource\Pages;

use App\Filament\Resources\UsuarioResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUsuario extends EditRecord
{
    protected static string $resource = UsuarioResource::class;
    protected ?string $heading = 'Editar Usuario';
    protected static ?string $title = 'Editar Usuario';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
