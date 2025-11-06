<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

class LoginPage extends Component
{
    #[Layout('components.layouts.auth-layout')]

    #[Validate('required', message: 'O campo Email é obrigatório')]
    #[Validate('email', message: 'O campo Email deve ser um email válido')]
    public $user_data_email;

    #[Validate('required', message: 'A senha é obrigatória')]
    #[Validate('min:8', message: 'A senha deve ter no mínimo 8 caracteres')]
    public $user_data_password;

    #[Validate('boolean')]
    public $user_data_remember = false;

    public function submit()
    {
        $this->validate([
            'user_data_email' => 'required|email|max:255|exists:users,email',
            'user_data_password' => 'required|min:8|max:255',
        ]);

        if ($this->getErrorBag()->isEmpty()) {
            $this->dispatch('auth-login-form-validation-success', [
                'success' => true,
                'message' => 'Formulário validado com sucesso.'
            ]);
        } else {
            $this->dispatch('auth-login-form-validation-fail', [
                'success' => false,
                'message' => 'Erros encontrados no formulário. Verifique os campos destacados.'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.login-page');
    }
}
