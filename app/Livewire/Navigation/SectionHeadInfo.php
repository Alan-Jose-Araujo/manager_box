<?php

namespace App\Livewire\Navigation;

use Livewire\Component;

class SectionHeadInfo extends Component
{
    public string $title;

    public string $subtitle;

    public function mount(string $title = '', string $subtitle = '')
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
    }

    public function render()
    {
        return view('livewire.navigation.section-head-info');
    }
}
