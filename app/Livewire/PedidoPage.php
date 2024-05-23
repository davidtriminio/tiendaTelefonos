<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Mail\OrdenUbicada;
use App\Models\Direccion;
use App\Models\Orden;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Title;
use Livewire\Component;
use Stripe\Checkout\Session;
use Stripe\Stripe;

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

    public function mount(){
        $cart_items = CartManagement::getCartItemsFromCookie();
        if (count($cart_items) === 0 ){
            return redirect('/productos');
        }
    }


    public function realizarOrden(){
        $this->validate([
            'nombres' => 'required|max:100|regex:/^[A-Za-z ]+$/',
            'apellidos' => 'required|max:100|regex:/^[A-Za-z ]+$/',
            'telefono' => 'required|max_digits:8|integer',
            'colonia' => 'required|string',
            'ciudad' => 'required|string',
            'departamento' => 'required|string',
            'codigo_postal' => 'integer|max_digits:5|min_digits:5',
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
            'telefono.max_digits' => 'El campo "Teléfono" no puede tener más de 8 dígitos.',
            'telefono.integer' => 'El campo "Teléfono" debe ser un número entero.',

            'colonia.required' => 'El campo "Colonia" es obligatorio.',
            'colonia.string' => 'El campo "Colonia" debe ser un texto.',

            'ciudad.required' => 'El campo "Ciudad" es obligatorio.',
            'ciudad.string' => 'El campo "Ciudad" debe ser un texto.',

            'departamento.required' => 'El campo "Departamento" es obligatorio.',
            'departamento.string' => 'El campo "Departamento" debe ser un texto.',

            'codigo_postal.numeric' => 'El campo "Código Postal" debe ser un número.',
            'codigo_postal.max_digits' => 'El campo "Código Postal" no puede tener más de 5 dígitos.',
            'codigo_postal.min_digits' => 'El campo "Código Postal" no puede tener menos de 5 dígitos.',

            'metodo_pago.required' => 'Debes seleccionar un método de pago.',
            'metodo_envio.required' => 'Debes seleccionar un método de envío.',
        ]);

        $cart_items = CartManagement::getCartItemsFromCookie();
        $line_items = [];

        foreach ($cart_items as $item) {
            $line_items[] = [
                'price_data' => [
                    'currency' => 'usd', // Usa el código de moneda correcto
                    'unit_amount' => $item['monto_unitario'] * 100,
                    'product_data' => [
                        'name' => $item['nombre'],
                    ],
                ],
                'quantity' => $item['cantidad'],
            ];
        }
        $orden = new Orden();
        $orden -> user_id = auth()->user()->id;
        $orden -> total_final = CartManagement::calcularTotalFinal($cart_items);
        $orden -> metodo_pago = $this->metodo_pago;
        $orden -> estado_pago = 'pendiente';
        $orden -> estado_envio = 'nuevo';
        $orden -> moneda = 'lps';
        $orden -> costos_envio = 0;
        $orden -> metodo_envio = 'expreco';
        $orden -> notas = 'Orden realizada por' . auth()->user()->name;

        $direccion = new Direccion();
        $direccion -> nombres = $this->nombres;
        $direccion -> apellidos = $this->apellidos;
        $direccion -> telefono = $this->telefono;
        $direccion -> departamento = $this->departamento;
        $direccion -> ciudad = $this->ciudad;
        $direccion -> colonia = $this->colonia;
        $direccion -> codigo_postal = $this->codigo_postal;

        $redirect_url = '';

        if ($this->metodo_pago === 'paypal'){
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $session_checkout = Session::create([
                'payment_method_types' => ['card'],
                'customer_email' => auth()->user()->email,
                'line_items' => $line_items,
                'mode' => 'payment',
                'success_url' => route('exito') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('cancelar'),
            ]);
            $redirect_url = $session_checkout->url;
        }
        else{
            $redirect_url = route('exito');
        }
        $orden->save();
        $direccion->orden_id = $orden->id;
        $direccion->save();
        $orden->elementos()->createMany($cart_items);
        CartManagement::clearCartItems();
        Mail::to(request()->user())->send(new OrdenUbicada($orden));
        return redirect($redirect_url);
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
