<?php

namespace App\Livewire\Stock;

use App\Models\ItemInStock;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;

class MovementListing extends Component
{
    public ItemInStock $item;

    public string $search = '';

    public array $sortBy = ['column' => 'created_at', 'direction' => 'desc'];

    public function headers (): array
    {
        return [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'movement_type', 'label' => 'Tipo'],
            ['key' => 'quantity_moved', 'label' => 'Quantidade movimentada'],
            ['key' => 'created_at', 'label' => 'Ocorrida em'],
        ];
    }

    public function mount(ItemInStock $item)
    {
        $this->item = $item;
    }

    public function item_in_stock_movements(): LengthAwarePaginator
    {
        return $this->
        item->
        movements()->
        where('movement_type', 'like', "%$this->search%")->
        orderBy($this->sortBy['column'], $this->sortBy['direction'])->
        paginate();
    }

    public function render()
    {
        return view('livewire.stock.movement-listing', [
            'item_in_stock_movements' => $this->item_in_stock_movements(),
        ]);
    }
}
