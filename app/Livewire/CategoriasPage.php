<?php

namespace App\Livewire;

use App\Models\Categoria;
use Livewire\Attributes\Title;
use Livewire\Component;

class CategoriasPage extends Component
{
    #[Title('Categorias - Tienda')]
    public function render()
    {

        $categorias = Categoria::where('disponibilidad', 1)->get();
        return view('livewire.categorias-page',
            ['categorias' => $categorias]);
    }
}
