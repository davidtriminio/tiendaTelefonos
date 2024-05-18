<?php

namespace App\Filament\Resources\OrdenResource\RelationManagers;

use Faker\Provider\Text;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class DireccionRelationManager extends RelationManager
{
    protected static string $relationship = 'Direccion';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombres')
                    ->required()
                    ->maxLength(100)
                    ->regex('/^[A-Za-z ]+$/')
                    ->validationMessages([
                            'required' => 'Introduzca un nombre.',
                            'regex' => 'No introducir números o caracteres especiales.'
                        ]
                    ),

                Forms\Components\TextInput::make('apellidos')
                    ->required()
                    ->maxLength(100)
                    ->regex('/^[A-Za-z ]+$/')
                    ->validationMessages([
                            'required' => 'Introduzca un apellido.',
                            'regex' => 'No introducir números o caracteres especiales.'
                        ]
                    ),

                Forms\Components\TextInput::make('telefono')
                    ->required()
                    ->tel()
                    ->maxLength(8),


                Forms\Components\Select::make('departamento')
                    ->options($this->getDepartamentos())
                    ->afterStateUpdated(fn (callable $set, $state) => $set('ciudad', null))
                    ->required()
                    ->reactive(),

                Forms\Components\Select::make('ciudad')
                    ->options(function (callable $get) {
                        $departamento = $get('departamento');
                        if ($departamento) {
                            return $this->getMunicipios($departamento);
                        }
                        return [];
                    })
                    ->required(),

                Forms\Components\TextInput::make('codigo_postal')
                    ->maxLength(5),

                Forms\Components\Textarea::make('colonia')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->label('Colonia, Barrio, Aldea o Caserio'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('colonia')
            ->columns([
                Tables\Columns\TextColumn::make('nombre_completo')
                    ->getStateUsing(function ($record) {
                        return $record->nombres . ' ' . $record->apellidos;
                    })
                ->label('Nombre Completo'),
                Tables\Columns\TextColumn::make('telefono'),
                Tables\Columns\TextColumn::make('colonia'),
                Tables\Columns\TextColumn::make('ciudad'),
                Tables\Columns\TextColumn::make('departamento'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions(
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            )
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function getDepartamentos(): array
    {
        $data = file_get_contents(resource_path('assets/departamentos.json'));
        return json_decode($data, true);
    }

    public function getMunicipios($departamento): array
    {
        $municipiosData = file_get_contents(resource_path('assets/municipios.json'));
        $municipios = json_decode($municipiosData, true);

        return $municipios[$departamento] ?? [];
    }


}
