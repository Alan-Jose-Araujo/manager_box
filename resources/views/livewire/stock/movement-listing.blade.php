<div class="mt-10">

    <x-header separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Buscar..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
    </x-header>

    <div class="flex flex-row w-full align-middle justify-between mb-3">
        <h3 class="text-2xl mb-4 text-black">
            Movimentações
        </h3>

        <a href="{{ route('stock.show_create_item_form') }}" class="btn btn-sm text-white bg-green-700 rounded-md">
            <x-icon name="o-plus" class="w-4 h-4" />
            Criar nova movimentação
        </a>
    </div>

    @if($item_in_stock_movements->isEmpty())
        <x-card shadow separator>
            <div class="p-4 text-center text-gray-500">
                Este item não possui movimentações ainda.
            </div>
        </x-card>
        @else
        <x-card shadow separator>
            <x-table :headers="$this->headers()" :rows="$item_in_stock_movements" :sort-by="$sortBy" with-pagination>
                @scope('cell_created_at', $movement)
                {{ date_format($movement->created_at, 'd/m/Y - H:i:s')  }}
                @endscope
            </x-table>
        </x-card>
    @endif
</div>
