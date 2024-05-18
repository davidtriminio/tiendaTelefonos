<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DireccionController extends Controller
{
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
