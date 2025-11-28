<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class NotFound extends Component
{
    #[Title('Página não encontrada')]
     #[Layout('components.layouts.not-found')]

    public function home(){
        $this->redirect('/');
    }

    public function render()
    {
        return view('livewire.not-found');
    }
}
