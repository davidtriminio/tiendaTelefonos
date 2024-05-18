<?php

namespace App\Filament\Resources\OrdenResource\Widgets;

use App\Filament\Resources\OrdenResource;
use App\Models\Orden;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class UltimasOrdenes extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(OrdenResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Id de Orden')
                    ->searchable()
                    ->sortable(),

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
                    )
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_final')
                    ->label('Total de la compra')
                    ->searchable()
                    ->sortable(),

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
                    }))
                    ->searchable()
                    ->sortable(),

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
                    }))
                    ->searchable()
                    ->sortable(),

            ])
            ->actions([
                Tables\Actions\Action::make('Ver Orden')
                    ->url(fn(Orden $record): string => OrdenResource::getUrl('view', ['record' => $record]))
                    ->icon('heroicon-o-eye')
                    ->color('info'),
                Tables\Actions\DeleteAction::make()
            ]);
    }

    public static function getDepartamentos(): array
    {
        $data = file_get_contents(resource_path('assets/departamentos.json'));
        $departamentos = json_decode($data, true);

        $result = [];
        foreach ($departamentos as $key => $value) {
            $result[$key] = $value; // Claves son los identificadores, valores son los textos
        }

        return $result;
    }


    public function getMunicipios($departamento): array
    {
        $municipiosData = file_get_contents(resource_path('assets/municipios.json'));
        $municipios = json_decode($municipiosData, true);

        $departamentosData = file_get_contents(resource_path('assets/departamentos.json'));
        $departamentos = json_decode($departamentosData, true);
        $departamentoKey = array_search($departamento, $departamentos);

        return $municipios[$departamentoKey] ?? [];
    }


}
