<?php

namespace App\Filament\Resources;


use App\Filament\Resources\UsuarioResource\RelationManagers\OrdenesRelationManager;
use App\Filament\Resources\UsuarioResource\RelationManagers\OrdenRelationManager;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsuarioResource extends Resource
{

    protected static ?string $model = User::class;
    protected static ?string $pluralModelLabel = 'Usuarios';
    protected static ?string $navigationIcon = 'heroicon-s-users';
    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->label('Nombre')
                    ->alpha()
                    ->maxLength(100)
                    ->validationMessages([
                        'maxLength' => 'El nombre no debe contener mas de 100 caracteres',
                        'required' => 'Debe introducir un nombre',
                        'alpha' => 'El nombre solo debe contener letras'
                    ]),

                TextInput::make('email')
                    ->required()
                    ->email()
                    ->maxLength(255)
                    ->label('Correo Electrónico')
                    ->unique(ignoreRecord: true)
                    ->validationMessages([
                        'unique' => 'El correo lectrónico ya se encuentra registrado.',
                    ]),
                DateTimePicker::make('email_verified_at')
                    ->default(now())
                    ->label('Fecha de Verificación de Correo')
                    ->required(),

                TextInput::make('password')
                    ->validationMessages([
                        'required' => 'Debe introducir una contraseña',
                    ])
                    ->password()
                    ->required()
                    ->revealable()
                    ->label('Contraseña')
                    ->dehydrated(fn($state) => filled($state))
                    ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord),

                Placeholder::make('created_at')
                    ->label('Fecha de creación')
                    ->content(fn(?User $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Ultima modificación')
                    ->content(fn(?User $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            ]);
    }

    public static function table(Table $table): Table
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

    public static function getPages(): array
    {
        return [
            'index' => UsuarioResource\Pages\ListUsuarios::route('/'),
            'create' => UsuarioResource\Pages\CreateUsuario::route('/create'),
            'edit' =>UsuarioResource\Pages\EditUsuario::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }

    public static function getRelations(): array
    {
        return[
            OrdenesRelationManager::class
        ];
    }

}
