<?php

namespace App\Filament\Resources\MarcaResource\RelationManagers;

use App\Models\Producto;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductosRelationManager extends RelationManager
{
    protected static string $relationship = 'productos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('categoria_id')
                    ->required()
                    ->integer(),

                TextInput::make('nombre')
                    ->required(),

                TextInput::make('slug')
                    ->required(),

                TextInput::make('imagen'),

                TextInput::make('descripcion'),

                TextInput::make('precio')
                    ->required()
                    ->numeric(),

                Checkbox::make('activo'),

                Checkbox::make('presentado'),

                Checkbox::make('en_existencia'),

                Checkbox::make('en_venta'),

                Placeholder::make('created_at')
                    ->label('Created Date')
                    ->content(fn(?Producto $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->content(fn(?Producto $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('categoria_id'),

                TextColumn::make('nombre'),

                TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('imagen'),

                TextColumn::make('descripcion'),

                TextColumn::make('precio'),

                TextColumn::make('activo'),

                TextColumn::make('presentado'),

                TextColumn::make('en_existencia'),

                TextColumn::make('en_venta'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
