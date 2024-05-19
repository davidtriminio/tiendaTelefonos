<?php

namespace App\Livewire;

use App\Models\Producto;
use Livewire\Component;

class DetallesProductoPage extends Component
{
    public $slug;

    public function  mount($slug){
        $this -> slug = $slug;
    }

    public function render()
    {

        return view('livewire.detalles-producto-page',
        ['producto' => Producto::where('slug', $this->slug)->firstOrFail()]);

    }
}
