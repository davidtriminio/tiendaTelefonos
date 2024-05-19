<?php

namespace App\Livewire;

use App\Models\Categoria;
use App\Models\Marca;
use Livewire\Attributes\Title;
use Livewire\Component;

class PaginaInicial extends Component
{
    #[Title('Pagina Inicial - Triminios Shop')]
    public function render()
    {
        $marcas = Marca::where('disponibilidad', 1)->get();
        $categorias = Categoria::where('disponibilidad', 1)->get();
        return view('livewire.pagina-inicial',
            ['marcas' => $marcas, 'categorias' => $categorias]);
    }
}
