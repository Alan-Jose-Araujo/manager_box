<?php

namespace App\Livewire;

use App\Enums\ItemInStockUnityOfMeasure;
use App\Repositories\BrandRepository;
use App\Repositories\WarehouseRepository;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateStockItem extends Component
{
    use WithFileUploads;

    #[Title('Adicionar novo item ao estoque')]
    #[Layout('components.layouts.app')]

    public $currentTab = 1;

    #[Validate('required')]
    #[Validate('string')]
    #[Validate('min:2')]
    #[Validate('max:255')]
    public $nome;

    #[Validate('nullable')]
    #[Validate('string')]
    #[Validate('min:2')]
    #[Validate('max:255')]
    public $nome_comercial;

    #[Validate('nullable')]
    #[Validate('string')]
    #[Validate('min:8')]
    #[Validate('max:50')]
    public $sku;

    #[Validate('required', ItemInStockUnityOfMeasure::class)]
    #[Validate('string')]
    public $unidade_medida;

    #[Validate('required')]
    #[Validate('decimal:0,2')]
    #[Validate('numeric')]
    #[Validate('min:1')]
    #[Validate('max:9999999999')]
    public $quantidade = 1.00;

    #[Validate('nullable')]
    #[Validate('decimal:0,2')]
    #[Validate('numeric')]
    #[Validate('min:1')]
    #[Validate('max:9999999999')]
    public $quantidade_minima = 1.00;

    #[Validate('nullable')]
    #[Validate('decimal:0,2')]
    #[Validate('numeric')]
    #[Validate('min:0')]
    #[Validate('max:9999999999')]
    public $quantidade_maxima = 0;

    #[Validate('required')]
    #[Validate('decimal:0,2')]
    #[Validate('numeric')]
    #[Validate('min:1')]
    #[Validate('max:9999999999')]
    public $preco_custo;

    #[Validate('nullable')]
    #[Validate('decimal:0,2')]
    #[Validate('numeric')]
    #[Validate('min:1')]
    #[Validate('max:9999999999')]
    public $preco_venda;

    #[Validate('nullable')]
    #[Validate('mimetypes:image/jpeg,image/jpg,image/png')]
    #[Validate('max:2048')]
    public $foto_ilustrativa;

    #[Validate('nullable')]
    #[Validate('string')]
    #[Validate('min:1')]
    #[Validate('max:500')]
    public $complemento;

    // (Tab 2)

    #[Validate('nullable')]
    #[Validate('exists:brands,id')]
    public $marca;

    #[Validate('nullable')]
    #[Validate('exists:warehouses,id')]
    public $armazem;

    #[Validate('boolean')]
    public $ativo = true;

    #[Validate('boolean')]
    public $ir_para_listagem = false;

    public $has_error = false;

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
