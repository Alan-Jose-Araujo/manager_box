<?php

namespace App\Livewire\Stock;

use App\Models\ItemInStock;
use Livewire\Component;

class ShowItem extends Component
{
    public ItemInStock $item;

    public function render()
    {
        return view('livewire.stock.show-item');
    }
}
