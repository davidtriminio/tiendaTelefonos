<?php

namespace App\Filament\Resources\UsuarioResource\RelationManagers;

use App\Filament\Resources\OrdenResource;
use App\Models\Orden;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdenesRelationManager extends RelationManager
{
    protected static string $relationship = 'Ordenes';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Id de Orden'),

                TextColumn::make('moneda')
                    ->money()
                    ->badge()
                    ->icon(fn(string $state): string => match ($state) {
                        'lps' => 'heroicon-o-currency-pound',
                        'usd' => 'heroicon-o-currency-dollar',
                        'eur' => 'heroicon-o-currency-euro'
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'lps' => 'secondary',
                        'usd' => 'success',
                        'eur' => 'info'
                    })
                    ->formatStateUsing((fn(string $state): string => match ($state) {
                        'lps' => 'Lempiras',
                        'usd' => 'Dólares',
                        'eur' => 'Euros',
                    })
                    ),

                Tables\Columns\TextColumn::make('total_final')
                    ->label('Total de la compra'),

                Tables\Columns\TextColumn::make('estado_envio')
                    ->badge()
                    ->icon(fn(string $state): string => match ($state) {
                        'nuevo' => 'heroicon-s-sparkles',
                        'procesado' => 'heroicon-m-arrow-path',
                        'enviado' => 'heroicon-m-truck',
                        'entregado' => 'heroicon-m-check-badge',
                        'cancelado' => 'heroicon-m-x-circle'
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'nuevo' => 'info',
                        'procesado' => 'warning',
                        'enviado' => 'success',
                        'entregado' => 'success',
                        'cancelado' => 'danger'
                    })
                    ->formatStateUsing((fn(string $state): string => match ($state) {
                        'nuevo' => 'Nuevo',
                        'procesado' => 'procesado',
                        'enviado' => 'Enviado',
                        'entregado' => 'Entregado',
                        'cancelado' => 'Cancelado'
                    })),

                TextColumn::make('metodo_pago')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->icon(fn(string $state): string => match ($state) {
                        'efectivo' => 'heroicon-o-banknotes',
                        'paypal' => 'heroicon-o-building-storefront',
                        'tarjeta' => 'heroicon-o-credit-card'
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'efectivo' => 'success',
                        'paypal' => 'info',
                        'tarjeta' => 'warning'
                    })
                    ->formatStateUsing((fn(string $state): string => match ($state) {
                        'efectivo' => 'Efectivo',
                        'paypal' => 'Paypal',
                        'tarjeta' => 'Tarjeta Crédito/Débito',
                    })),

            ])
            ->filters([
                //
            ])
            ->headerActions([

            ])
            ->actions([
                Tables\Actions\Action::make('Ver Orden')
                    ->url(fn(Orden $record): string => OrdenResource::getUrl('view', ['record' => $record]))
                    ->icon('heroicon-o-eye')
                    ->color('info'),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
