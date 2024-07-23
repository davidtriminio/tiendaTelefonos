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





    public static function getPages(): array
    {
        return [
            'index' => UsuarioResource\Pages\ListUsuarios::route('/'),
            'create' => UsuarioResource\Pages\CreateUsuario::route('/create'),
            'edit' =>UsuarioResource\Pages\EditUsuario::route('/{record}/edit'),
            'view' =>UsuarioResource\Pages\ViewUsuarios::route('/{record}/view')
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
