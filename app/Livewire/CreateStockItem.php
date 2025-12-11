<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class CreateStockItem extends Component
{
    use WithFileUploads;

    public $currentTab = 1;

    public $nome;
    public $nome_comercial;
    public $sku;
    public $unidade_medida;
    public $quantidade = 0;
    public $quantidade_minima = 0;
    public $quantidade_maxima = 0;
    public $preco_custo;
    public $preco_venda;
    public $foto_ilustrativa;
    public $complemento;

    /**
     * (wire:click).
     * @param int $tab O  (1 ou 2).
     */
    public function setTab($tab)
    {
        $this->currentTab = $tab;
    }
// In the future, the validation and saving logic will be included here

//public function saveItem()

    public function render()
    {
        return view('livewire.create-stock-item');
    }
}
