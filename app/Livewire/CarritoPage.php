<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Complementos\Navbar;
use Livewire\Attributes\Title;
use Livewire\Component;

class CarritoPage extends Component
{
    #[Title('Carrito')]
    public $cart_items;
    public $total_final;

    public function mount()
    {
        $this->cart_items = CartManagement::getCartItemsFromCookie();
        $this->total_final = CartManagement::calcularTotalFinal($this->cart_items);
    }

    public function removeItem($producto_id)
    {
        $this->cart_items = CartManagement::removeCartItem($producto_id);
        $this->total_final = CartManagement::calcularTotalFinal($this->cart_items);
        $this->dispatch('update-cart-count', total_count: count($this->cart_items))->to(Navbar::class);
    }

    function increaseQty($producto_id)
    {
        $this->cart_items = CartManagement::incrementQuantityToCartItem($producto_id);
        $this->total_final = CartManagement::calcularTotalFinal($this->cart_items);
    }

    function decreaseQty($producto_id)
    {
        $this->cart_items = CartManagement::decrementQuantityToCartItem($producto_id);
        $this->total_final = CartManagement::calcularTotalFinal($this->cart_items);
    }

    public function render()
    {
        return view('livewire.carrito-page');
    }
}
