<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

class LoginPage extends Component
{
    #[Layout('components.layouts.login')]

    #[Validate('required', message: 'O campo Email é obrigatório')]
    #[Validate('email', message: 'O campo Email deve ser um email válido')]
    public $user_login_email;

    #[Validate('required', message: 'A senha é obrigatória')]
    #[Validate('min:8', message: 'A senha deve ter no mínimo 8 caracteres')]
    public $user_login_password; 

    public function render()
    {
        return view('livewire.login-page');
    }
}
