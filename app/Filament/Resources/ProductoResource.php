<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductoResource\Pages;
use App\Models\Producto;
use Filament\Actions\ActionGroup;
use Filament\Facades\Filament;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductoResource extends Resource
{
    protected static ?string $model = Producto::class;
    protected static ?string $slug = 'productos';
    protected static ?string $navigationIcon = 'heroicon-s-gift';

    protected static ?string $recordTitleAttribute = 'nombre';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Información del Producto')
                        ->schema([
                            TextInput::make('nombre')
                                ->required()
                                ->label('Producto')
                                ->maxLength(255)
                                ->reactive()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn(string $operation, $state, Set $set) => $operation
                                === 'create' ? $set('slug', Str::slug($state)) : null),

                            TextInput::make('slug')
                                ->maxLength(255)
                                ->disabled()
                                ->dehydrated()
                                ->required()
                                ->unique(Producto::class, ignoreRecord: true),

                            MarkdownEditor::make('descripcion')
                                ->columnSpanFull()
                                ->fileAttachmentsDirectory('producto/descripciones')
                                ->label('Descripción'),

                            FileUpload::make('imagen')
                                ->directory('productos')
                                ->maxFiles(5)
                                ->image()
                                ->required()
                                ->multiple(true)
                                ->reorderable()
                                ->label('Imagenes')
                                ->columnSpanFull()
                                ->visibility('public')
                                ->openable()
                                ->removeUploadedFileButtonPosition('right')
                        ])->columns(2)
                ])->columnSpan(2),

                Group::make()->schema([
                    Section::make('Detalles de Precio')
                    ->schema([
                        TextInput::make('precio')
                            ->numeric()
                            ->required()
                            ->prefix('LPS. ')
                    ]),

                    Section::make('Detalles del Producto')
                        ->schema([
                            Select::make('categoria_id')
                                ->relationship('categoria', 'nombre')
                                ->searchable()
                                ->required()
                                ->preload()
                                ->label('Categoria'),

                            Select::make('marca_id')
                                ->relationship('marca', 'nombre')
                                ->required()
                                ->preload()
                                ->searchable()
                                ->label('Marca')
                        ])
                ]),

                Section::make('Detalles de Disponibilidad')->schema([
                    Toggle::make('activo')
                        ->default(true)
                        ->required(),

                    Toggle::make('presentado')
                        ->default(true)
                        ->required(),

                    Toggle::make('en_existencia')
                        ->default(true)
                        ->required(),

                    Toggle::make('en_venta')
                        ->default(true)
                        ->required(),

                    Placeholder::make('created_at')
                        ->label('Created Date')
                        ->content(fn(?Producto $record): string => $record?->created_at?->diffForHumans() ?? '-')
                        ->label('Fecha de Creación'),

                    Placeholder::make('updated_at')
                        ->label('Last Modified Date')
                        ->content(fn(?Producto $record): string => $record?->updated_at?->diffForHumans() ?? '-')
                        ->label('Última Actualización'),
                ])->columnSpan(1),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([


                TextColumn::make('nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('precio')
                    ->money('LPS. '),

                TextColumn::make('categoria.nombre')
                    ->label('Categoría')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('marca.nombre')
                    ->label('Marca')
                    ->searchable()
                    ->sortable(),

                IconColumn::make('activo')
                    ->boolean(),

                IconColumn::make('presentado')
                    ->boolean(),

                IconColumn::make('en_existencia')
                    ->boolean(),

                IconColumn::make('en_venta')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                \Filament\Tables\Actions\ActionGroup::make([
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductos::route('/'),
            'create' => Pages\CreateProducto::route('/create'),
            'edit' => Pages\EditProducto::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['nombre'];
    }
}
