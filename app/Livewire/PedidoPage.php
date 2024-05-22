<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use Livewire\Attributes\Title;
use Livewire\Component;

class PedidoPage extends Component
{
    #[Title('Pedidos - Triminios Store')]

    public $nombres;
    public $apellidos;
    public $telefono;
    public $colonia;
    public $ciudad;
    public $departamento;
    public $codigo_postal;
    public $metodo_pago;
    public $metodo_envio;
    public $created_at;
    public $updated_at;


    public function realizarOrden(){
        $this->validate([
            'nombres' => 'required|max:100|regex:/^[A-Za-z ]+$/',
            'apellidos' => 'required|max:100|regex:/^[A-Za-z ]+$/',
            'telefono' => 'required|max:8|integer',
            'colonia' => 'required|string',
            'ciudad' => 'required|string',
            'departamento' => 'required|string',
            'codigo_postal' => 'numeric|max:5|min:5',
            'metodo_pago' => 'required',
            'metodo_envio' => 'required'
        ],[
            'nombres.required' => 'El campo "Nombres" es obligatorio.',
            'nombres.max' => 'El campo "Nombres" no puede tener más de 100 caracteres.',
            'nombres.regex' => 'El campo "Nombres" solo puede contener letras y espacios.',

            'apellidos.required' => 'El campo "Apellidos" es obligatorio.',
            'apellidos.max' => 'El campo "Apellidos" no puede tener más de 100 caracteres.',
            'apellidos.regex' => 'El campo "Apellidos" solo puede contener letras y espacios.',

            'telefono.required' => 'El campo "Teléfono" es obligatorio.',
            'telefono.max' => 'El campo "Teléfono" no puede tener más de 8 dígitos.',
            'telefono.integer' => 'El campo "Teléfono" debe ser un número entero.',

            'colonia.required' => 'El campo "Colonia" es obligatorio.',
            'colonia.string' => 'El campo "Colonia" debe ser un texto.',

            'ciudad.required' => 'El campo "Ciudad" es obligatorio.',
            'ciudad.string' => 'El campo "Ciudad" debe ser un texto.',

            'departamento.required' => 'El campo "Departamento" es obligatorio.',
            'departamento.string' => 'El campo "Departamento" debe ser un texto.',

            'codigo_postal.numeric' => 'El campo "Código Postal" debe ser un número.',
            'codigo_postal.max' => 'El campo "Código Postal" no puede tener más de 5 dígitos.',
            'codigo_postal.min' => 'El campo "Código Postal" no puede tener menos de 5 dígitos.',

            'metodo_pago.required' => 'Debes seleccionar un método de pago.',
            'metodo_envio.required' => 'Debes seleccionar un método de envío.',
        ]);
    }

    public function render()
    {
        $cart_items = CartManagement::getCartItemsFromCookie();
        $total_final = CartManagement::calcularTotalFinal($cart_items);

        return view('livewire.pedido-page', [
            'cart_items' => $cart_items,
            'total_final' => $total_final,
        ]);
    }
}
