<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrdenResource\Pages;
use App\Filament\Resources\OrdenResource\RelationManagers\DireccionRelationManager;
use App\Models\Orden;
use App\Models\Producto;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Stmt\Switch_;

class OrdenResource extends Resource
{
    protected static ?string $model = Orden::class;

    protected static ?string $slug = 'ordenes';
    protected static ?string $pluralModelLabel = 'Ordenes';
    public static function getRecordTitle(Orden|Model|null $record): string
    {
        return 'Orden ' . $record->id;
    }

    protected static ?string $navigationIcon = 'heroicon-s-truck';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Group::make()->schema([
                    Section::make('Informacion Personal')
                        ->schema([
                            Select::make('user_id')
                                ->relationship('user', 'name')
                                ->searchable()
                                ->required()
                                ->preload()
                                ->label('Comprador')
                                ->validationMessages([
                                    'required' => 'Debe seleccionar un comprador',
                                    'alpha' => 'El nombre solo debe contener letras'
                                ]),

                            Select::make('metodo_pago')
                                ->options([
                                    'efectivo' => 'Efectivo',
                                    'paypal' => 'Paypal',
                                    'tarjeta' => 'Tarjeta de Crédito/Débito'
                                ])
                                ->required()
                                ->default('efectivo'),

                            Select::make('estado_pago')
                                ->options([
                                    'pendiente' => 'Pendiente',
                                    'pagado' => 'Pagado',
                                    'fallo' => 'Falló el pago'
                                ])
                                ->required()
                                ->default('pendiente'),

                            ToggleButtons::make('estado_envio')
                                ->required()
                                ->options([
                                    'nuevo' => 'Nuevo',
                                    'procesado' => 'En Proceso',
                                    'enviado' => 'Enviado',
                                    'entregado' => 'Entregado',
                                    'cancelado' => 'Cancelado',
                                ])
                                ->inline()
                                ->default('nuevo')
                                ->colors([
                                    'nuevo' => 'info',
                                    'procesado' => 'warning',
                                    'enviado' => 'success',
                                    'entregado' => 'success',
                                    'cancelado' => 'danger'
                                ])
                                ->icons([
                                        'nuevo' => 'heroicon-s-sparkles',
                                        'procesado' => 'heroicon-m-arrow-path',
                                        'enviado' => 'heroicon-m-truck',
                                        'entregado' => 'heroicon-m-check-badge',
                                        'cancelado' => 'heroicon-m-x-circle']
                                ),

                            Select::make('moneda')
                                ->options([
                                    'lps' => 'Lempiras',
                                    'usd' => 'Dolar Estadounidense',
                                    'eur' => 'Euros'
                                ])
                                ->reactive()
                                ->required()
                                ->default('lps'),

                            Select::make('metodo_envio')
                                ->options([
                                    'expreco' => 'Cargo Expreco',
                                    'c807' => 'C807 Express',
                                    'cargo_expreso' => 'Cargo Expreso'
                                ])
                                ->default('cargo_expreso'),

                            Textarea::make('notas')
                                ->columnSpanFull(),
                        ])->columns(2)/*Fin de Section*/

                ])->columnSpan(2),/*Fin de grupo*/

                Section::make('Ordenes')
                    ->schema([
                        Repeater::make('elementos')
                            ->relationship()
                            ->schema([
                                Select::make('producto_id')
                                    ->relationship('producto', 'nombre')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->distinct()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->reactive()
                                    ->afterStateUpdated(fn($state, Set $set) => $set('monto_unitario', Producto::find($state)
                                        ?->precio ?? 0))
                                    ->afterStateUpdated(fn($state, Set $set) => $set('monto_total', Producto::find($state)
                                        ?->precio ?? 0))
                                    ->columnSpan(4),

                                TextInput::make('cantidad')
                                    ->numeric()
                                    ->required()
                                    ->default(1)
                                    ->minValue(1)
                                    ->columnSpan(2)
                                    ->reactive()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(
                                        fn($state, Set $set, Get $get) => $set('monto_total', $state * $get('monto_unitario')))
                                    ->validationMessages([
                                        'required' => 'Debe introducir una cantidad',
                                    ]),

                                TextInput::make('monto_unitario')
                                    ->numeric()
                                    ->required()
                                    ->disabled()
                                    ->dehydrated()
                                    ->columnSpan(3),

                                TextInput::make('monto_total')
                                    ->numeric()
                                    ->disabled()
                                    ->required()
                                    ->dehydrated()
                                    ->reactive()
                                    ->columnSpan(3)
                            ])->columns(12),

                        Placeholder::make('total_final_placeholder')
                            ->label('Total Final: ')
                            ->content(function (Get $get, Set $set) {
                                $total = 0;
                                $moneda = $get('moneda');
                                if (!$repeaters = $get('elementos')) {
                                    return $total;
                                }

                                foreach ($repeaters as $key => $repeater) {
                                    $total += $get("elementos.{$key}.monto_total");
                                }

                                switch ($moneda) {
                                    case 'usd':
                                        $total /= 24.75;
                                        break;
                                    case 'eur':
                                        $total /= 26.84;
                                        break;
                                }

                                $set('total_final', $total);
                                return \Number::currency($total, $moneda);
                            }),

                        Hidden::make('total_final')
                            ->default(0)

                    ])/*Fin de seccion*/
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('Comprador'),

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

                TextColumn::make('total_final')
                    ->label('Total compra'),

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

                TextColumn::make('estado_pago')
                    ->searchable()
                    ->sortable(),

                SelectColumn::make('estado_envio')
                    ->options([
                        'nuevo' => 'Nuevo',
                        'procesado' => 'En Proceso',
                        'enviado' => 'Enviado',
                        'entregado' => 'Entregado',
                        'cancelado' => 'Cancelado',
                    ])
                    ->searchable()
                    ->sortable(),

                SelectColumn::make('metodo_envio')
                    ->options([
                        'expreco' => 'Cargo Expreco',
                        'c807' => 'C807 Express',
                        'cargo_expreso' => 'Cargo Expreso'
                    ])
                    ->searchable()
                    ->sortable(),

                TextColumn::make('notas')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                ->sortable()
                ->searchable()
                ->label('Fecha de Creación')
                ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->sortable()
                    ->searchable()
                    ->label('Fecha de Actualizacion')
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                //
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

    public static function getNavigationBadge(): ?string
    {
        return self::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::count() > 5 ? 'success' : 'danger';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrdens::route('/'),
            'create' => Pages\CreateOrden::route('/create'),
            'view' => Pages\ViewOrden::route('/{record}'),
            'edit' => Pages\EditOrden::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['user']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['user.name', 'id'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];


        if ($record->user) {
            $details['Usuario'] = $record->user->name;
        }

        return $details;
    }

    public static function getRelations(): array
    {
        return[
          DireccionRelationManager::class,
        ];
    }
}
