<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MarcaResource\Pages;
use App\Filament\Resources\MarcaResource\RelationManagers\ProductosRelationManager;
use App\Models\Marca;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class MarcaResource extends Resource
{
    protected static ?string $model = Marca::class;

    protected static ?string $slug = 'marcas';

    protected static ?string $navigationIcon = 'heroicon-s-bolt';

    protected static ?string $recordTitleAttribute = 'nombre';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make('Informacion de la Marca')
                    ->schema([
                        Section::make()
                            ->schema([
                                TextInput::make('nombre')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn(string $operation, $state, Set $set) => $operation
                                    === 'create' ? $set('slug', Str::slug($state)) : null)
                                    ->label('Marca'),

                                TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->disabled()
                                    ->dehydrated()
                                    ->unique(Marca::class, 'slug', ignoreRecord: true),


                                FileUpload::make('imagen')
                                    ->image()
                                    ->directory('marcas')
                                    ->columnSpanFull()
                                    ->preserveFilenames(),

                                Section::make()
                                    ->schema([
                                        Toggle::make('disponibilidad')
                                            ->default(false)
                                            ->label('Disponible')
                                            ->columnSpan(1),

                                        Placeholder::make('created_at')
                                            ->label('Fecha de Creación')
                                            ->columnSpan(2)
                                            ->content(fn(?Marca $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                                        Placeholder::make('updated_at')
                                            ->label('Ultima Actualización')
                                            ->content(fn(?Marca $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
                                    ])->columns(5)

                            ])->columns(2)
                    ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                ImageColumn::make('imagen'),


                TextColumn::make('nombre')
                    ->searchable()
                    ->sortable()
                    ->label('Categoría'),


                IconColumn::make('disponibilidad')
                    ->boolean()
                    ->label('Disponible'),
            ])
            ->filters([
                //
            ])

            ->actions([
                ActionGroup::make([
                    \Filament\Tables\Actions\ViewAction::make(),
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

    public static function getRelations(): array
    {
        return [
            ProductosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMarcas::route('/'),
            'create' => Pages\CreateMarca::route('/create'),
            'edit' => Pages\EditMarca::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['nombre'];
    }
}
