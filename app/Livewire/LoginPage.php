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
    #[Validate('exists:users,email', message: 'O email informado não está cadastrado')]
    public $user_data_email;

    #[Validate('required', message: 'A senha é obrigatória')]
    #[Validate('min:8', message: 'A senha deve ter no mínimo 8 caracteres')]
    public $user_data_password;

    public function submit()
    {
        $this->validate();

        if(!$this->getErrorBag()->isEmpty()) {
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
