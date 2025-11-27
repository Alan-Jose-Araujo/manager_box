<?php

namespace App\Livewire\Navigation;

use Livewire\Component;

class Breadcrumps extends Component
{
    // Array format: ['Label' => 'url'].
    public array $links = [];

    public function mount(array $links = [])
    {
        $this->links = $links;
    }

    public function render()
    {
        return view('livewire.navigation.breadcrumps');
    }
}
