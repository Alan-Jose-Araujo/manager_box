<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

class NotFound extends Component
{
     #[Layout('components.layouts.not-found')]

    public function home(){
        $this->redirect('/');
    }

    public function render()
    {
        return view('livewire.not-found');
    }
}
