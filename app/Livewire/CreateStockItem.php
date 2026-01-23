<?php

namespace App\Livewire;

use App\Enums\ItemInStockUnityOfMeasure;
use App\Repositories\BrandRepository;
use App\Repositories\WarehouseRepository;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateStockItem extends Component
{
    use WithFileUploads;

    #[Title('Adicionar novo item ao estoque')]
    #[Layout('components.layouts.app')]

    public $currentTab = 1;

    public $nome;
    public $nome_comercial;
    public $sku;
    public $unidade_medida;
    public $quantidade = 1.00;
    public $quantidade_minima = 0;
    public $quantidade_maxima = 0;
    public $preco_custo;
    public $preco_venda;
    public $foto_ilustrativa;
    public $complemento;

    // (Tab 2)
    public $marca;
    public $armazem;
    public $ativo = true; // toggle

    public $unidades_medida_disponiveis = [];

    public $marcas_disponiveis = [];

    public $armazens_disponiveis = [];

    public function mount()
    {
        $itemInStockUnitsOfMeasure = ItemInStockUnityOfMeasure::cases();
        $brandsAvailable = (new BrandRepository())->paginate([
            'company_id' => [
                'operator' => '=',
                'value' => Auth::user()->company_id,
            ],
            'is_active' => [
                'logical' => 'and',
                'operator' => '=',
                'value' => true,
            ],
        ], 1000)->items();
        $warehousesAvailable = (new WarehouseRepository())->paginate([
            'company_id' => [
                'operator' => '=',
                'value' => Auth::user()->company_id,
            ],
            'is_active' => [
                'logical' => 'and',
                'operator' => '=',
                'value' => true,
            ]
        ], 10000);

        foreach($itemInStockUnitsOfMeasure as $unit) {
            $this->unidades_medida_disponiveis[] = [
                'name' => $unit->name,
                'value' => $unit->value,
            ];
        }

        foreach($brandsAvailable as $brand) {
            $this->marcas_disponiveis[] = [
                'name' => $brand->name,
                'value' => $brand->id,
            ];
        }

        foreach($warehousesAvailable as $warehouse) {
            $this->armazens_disponiveis[] = [
                'name' => $warehouse->name,
                'value' => $warehouse->id,
            ];
        }

    }

    /**
     * (wire:click).
     * @param int $tab O  (1 ou 2).
     */
    public function setTab($tab)
    {
        $this->currentTab = $tab;
    }

    public function render()
    {
        return view('livewire.create-stock-item');
    }
}
