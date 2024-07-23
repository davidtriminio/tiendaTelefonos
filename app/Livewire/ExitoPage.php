<?php

namespace App\Livewire;

use App\Models\Orden;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class ExitoPage extends Component
{


    #[Url]
    public $session_id;

    #[Title('Exito - Tienda')]
    public function render()
    {
        $ultima_orden = Orden::with('direccion')->where('user_id', auth()->user()->id)->latest()->first();

        if ($this->session_id){
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $session_info = Session::retrieve($this->session_id);

            if ($session_info->payment_status != 'paid'){
                $ultima_orden -> estado_pago = 'fallo';
                $ultima_orden->save();
                return redirect()->route('cancelar');
            } elseif ($session_info -> payment_status == 'paid'){
                $ultima_orden->estado_pago = 'pagado';
                $ultima_orden -> save();
            }
        }

        return view('livewire.exito-page', [
            'orden' => $ultima_orden,
        ]);
    }
}
