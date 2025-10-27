<?php

namespace App\Livewire;

use Livewire\Component;

class SidePanel extends Component
{

    public $title = 'Manager Box';
    public $subtitle = 'Cadastre-se sem complicações';
    public $buttonText = 'Entre agora mesmo';
    public $buttonLink = '/login';

    public function render()
    {
        return view('livewire.side-panel');
    }
}
