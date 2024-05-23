<?php

namespace App\Livewire;

use App\Models\Orden;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Mis Ordenes')]
class MisPedidosPage extends Component
{
    use WithPagination;
    public function render()
    {
    $mis_ordenes = Orden::where('user_id', auth()->id())->latest()->paginate(10);

        return view('livewire.mis-pedidos-page',
        ['ordenes' => $mis_ordenes]);
    }
}
