<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoriaResource\Pages;
use App\Models\Categoria;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
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
use Nette\Utils\Image;

class CategoriaResource extends Resource
{
    protected static ?string $model = Categoria::class;

    protected static ?string $slug = 'categorias';
    protected static ?string $recordTitleAttribute = 'nombre';
    protected static ?string $navigationIcon = 'heroicon-s-tag';
    protected static ?int $navigationSort = 2;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make('Informacion de la categoria')
                    ->schema([
                        Section::make()
                            ->schema([
                                TextInput::make('nombre')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn(string $operation, $state, Set $set) => $operation
                                    === 'create' ? $set('slug', Str::slug($state)) : null)
                                    ->label('Categoria'),

                                TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->disabled()
                                    ->dehydrated()
                                    ->unique(Categoria::class, 'slug', ignoreRecord: true),


                                FileUpload::make('imagen')
                                    ->image()
                                    ->directory('categorias')
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
                                            ->content(fn(?Categoria $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                                        Placeholder::make('updated_at')
                                            ->label('Ultima Actualización')
                                            ->content(fn(?Categoria $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
                                    ])->columns(5)

                            ])->columns(2)
                    ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                ImageColumn::make('imagen')
                    ->circular(),


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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategorias::route('/'),
            'create' => Pages\CreateCategoria::route('/create'),
            'edit' => Pages\EditCategoria::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['nombre'];
    }
}
