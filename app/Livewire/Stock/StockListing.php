<?php

namespace App\Livewire\Stock;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Services\ItemInStockService;
use Illuminate\Pagination\LengthAwarePaginator;
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

        return (new ItemInStockService())->index([
            'name' => [
                'operator' => 'like',
                'value' => "%$this->search%",
                'logical' => 'or',
            ],
            'sku' => [
                'operator' => 'like',
                'value' => "%$this->search%",
                'logical' => 'or',
            ],
            'description' => [
                'operator' => 'like',
                'value' => "%$this->search%",
                'logical' => 'or',
            ],
        ], orderBy: $this->sortBy);
    }

    public function render()
    {
        confirmDelete('Tem certeza que deseja excluir este item?');
        session()->reflash();
        return view('livewire.stock.stock-listing',[
            'items_in_stock' => $this->items_in_stock()
        ]);
    }
}
