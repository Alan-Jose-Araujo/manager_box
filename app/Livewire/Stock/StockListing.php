<?php

namespace App\Livewire\Stock;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\ItemInStock;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

class StockListing extends Component
{
    use WithPagination;

    #[Layout('components.layouts.app')]
    #[Title('Listar itens em estoque')]


    public string $search = '';

    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    public function headers (): array
    {
        return [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'Nome'],
            ['key' => 'trade_name', 'label' => 'Troca'],
            ['key' => 'description', 'label' => 'Descrição'],
            ['key' => 'sku', 'label' => 'SKU'],
            ['key' => 'unity_of_measure', 'label' => 'Unidade de medida'],
            ['key' => 'quantity', 'label' => 'Quantidade'],
            ['key' => 'minimum_quantity', 'label' => 'Quantidade mínima'],
            ['key' => 'maximum_quantity', 'label' => 'Quantidade máxima'],
            ['key' => 'cost_price', 'label' => 'Preço de custo'],
            ['key' => 'sale_price', 'label' => 'Preço de venda'],
            ['key' => 'is_active', 'label' => 'Ativo'],
        ];
    }

    public function items_in_stock(): LengthAwarePaginator
    {
        return ItemInStock::query()
        ->when($this->search, fn(Builder $q) =>
            $q->where('name', 'like', "%$this->search%")
            ->orWhere('sku', 'like', "%$this->search%")
            ->orWhere('description', 'like', "%$this->search%")
            ->orWhere('id', 'like', "%$this->search%")
        )
        ->orderBy(...array_values($this->sortBy))
        ->paginate(10);
    }

    public function render()
    {

        return view('livewire.stock.stock-listing',[
            'items_in_stock' => $this->items_in_stock()
        ]);
    }
}
