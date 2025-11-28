<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class ErrorScreen extends Component
{
    #[Layout('components.layouts.not-found')]

    function home()
    {
        $this->redirect('/');
    }

    public function render()
    {
        return view('livewire.error-screen');
    }
}
