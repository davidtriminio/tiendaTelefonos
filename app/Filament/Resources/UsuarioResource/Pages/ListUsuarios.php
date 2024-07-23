<?php

namespace App\Filament\Resources\UsuarioResource\Pages;

use App\Filament\Resources\UsuarioResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ListUsuarios extends ListRecords
{
    protected static string $resource = UsuarioResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Nombre'),

                TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->label('Correo Electrónico'),

                TextColumn::make('email_verified_at')
                    ->label('Fecha de verificación de Correo')
                    ->date(),

                TextColumn::make('created_at')
                    ->label('Fecha de Creación')
                    ->date()
            ])
            ->filters([
                //
            ])
            ->actions([

                    ViewAction::make()
                    ->hiddenLabel()

            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Nuevo Usuario'),
        ];
    }
}
