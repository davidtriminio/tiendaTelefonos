<?php

namespace App\Livewire;

use App\Models\Direccion;
use App\Models\ElementoOrdenes;
use App\Models\Orden;
use Livewire\Attributes\Title;
use Livewire\Component;

class DetallesPedidoPage extends Component
{
    #[Title('Detalles de pedido')]
    public $orden_id;

    public function mount($orden_id){
        $this->orden_id = $orden_id;
    }

    public function render()
    {
        $elementos_orden = ElementoOrdenes::with('producto')->where('orden_id', $this->orden_id)->get();
        $direccion = Direccion::where('orden_id', $this->orden_id)->first();
        $orden = Orden::where('id', $this->orden_id)->first();
        return view('livewire.detalles-pedido-page',
        [
            'elementos_orden' => $elementos_orden,
            'direccion' => $direccion,
            'orden' => $orden
        ]);
    }
}
