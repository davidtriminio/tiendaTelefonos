<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

class PedidoPage extends Component
{
    #[Title('Pedidos - Triminios Store')]
    public function render()
    {
        return view('livewire.pedido-page');
    }
}
