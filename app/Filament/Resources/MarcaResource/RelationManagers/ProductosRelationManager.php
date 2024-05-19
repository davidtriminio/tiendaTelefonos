<?php

namespace App\Filament\Resources\MarcaResource\RelationManagers;

use App\Models\Producto;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
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
                TextColumn::make('nombre'),

                TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('descripcion')
                ->limit(20),

                TextColumn::make('precio'),

                IconColumn::make('activo')
                ->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
               ActionGroup::make([
                   ViewAction::make(),
                   EditAction::make(),
                   DeleteAction::make(),
               ])
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
