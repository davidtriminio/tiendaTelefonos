<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Complementos\Navbar;
use App\Models\Producto;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class DetallesProductoPage extends Component
{
    use LivewireAlert;
    public $slug;
    public $cantidad = 1;
    public function  mount($slug){
        $this -> slug = $slug;
    }

    public function increaseQty(){
        $this->cantidad ++;
    }

    public function decreaseQty(){
        if ($this->cantidad > 1){
            $this->cantidad --;
        }
    }

    public function addToCart($producto_id) {
        $conteo_total = CartManagement::addItemToCartWithQty($producto_id, $this->cantidad);
        $this->dispatch('update-cart-count', conteo_total: $conteo_total)->to(Navbar::class);
        $this->alert('success', 'El producto fue agregado al carrito', [
            'position' => 'bottom-end',
            'timer' => 2000,
            'toast' => true,
            'timerProgressBar' => true,
        ]);
    }

    public function render()
    {
        return view('livewire.detalles-producto-page',
        ['producto' => Producto::where('slug', $this->slug)->firstOrFail()]);
    }
}
