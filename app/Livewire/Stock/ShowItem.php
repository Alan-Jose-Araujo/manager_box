<?php

namespace App\Livewire\Stock;

use App\Models\ItemInStock;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class ShowItem extends Component
{
    #[Layout('components.layouts.app')]
    #[Title('Item')]

    public ItemInStock $item;

    public function render()
    {
        return view('livewire.stock.show-item');
    }
}
