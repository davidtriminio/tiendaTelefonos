<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Title;
use Livewire\Component;

class ForgotPage extends Component
{
    #[Title('Recuperar Contraseña')]

    public $email;

    public function save(){
        $this->validate([
           'email' => 'required|email|exists:users,email|max:255'
        ] ,['email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'email.max' => 'El correo electrónico no puede tener más de 255 caracteres.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'email.exists' => 'El correo no existe.']);

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT){
            session()->flash('success', 'Correo enviado con exito');
            $this->email = '';
        }

    }


    public function render()
    {
        return view('livewire.auth.forgot-page');
    }
}
