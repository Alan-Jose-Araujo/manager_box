<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class ErrorScreen extends Component
{
    #[Title('Erro interno')]
    #[Layout('components.layouts.not-found')]

    function home()
    {
        $this->redirect('/');
    }

    public function render()
    {
        return view('errors.500');
    }
}
