<?php

namespace App\Filament\Resources\UsuarioResource\Pages;

use App\Filament\Resources\UsuarioResource;
use App\Models\User;
use Filament\Actions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\ViewRecord;

class ViewUsuarios extends ViewRecord
{
    protected static string $resource = UsuarioResource::class;

    public function form(Form $form): Form
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

    protected function getHeaderActions(): array
    {
        return[
            Actions\EditAction::make(),
        ];
    }

}
