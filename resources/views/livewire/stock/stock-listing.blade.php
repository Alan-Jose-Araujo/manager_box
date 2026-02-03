<div>

    <div class="p-4 bg-white h-full">

        @livewire('navigation.breadcrumps', [
            'links' => [
                'Estoque' => '#',
                'Listar' => '#'
            ]
        ])

        @livewire('navigation.section-head-info', [
            'title' => 'Listar itens em estoque',
            'subtitle' => 'Visualize seus itens em estoque'
        ])

    <x-header separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Buscar..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
    </x-header>

    <div class="flex flex-row w-full align-middle justify-end">
        <a href="{{ route('stock.show_create_item_form') }}" class="btn btn-sm text-white bg-green-700 rounded-md">
            <x-icon name="o-plus" class="w-4 h-4" />
            Adicionar novo item
        </a>
    </div>

    @if ($items_in_stock->isEmpty())

        <x-card shadow separator>

        <x-table :headers="$this->headers()" :rows="$this->items_in_stock()" :sort-by="$sortBy" with-pagination />
                <div class="p-4 text-center text-gray-500">
                    Não possui itens cadastrados.
                </div>
        </x-card>

    @else
        <x-card shadow separator>
            <x-table :headers="$this->headers()" :rows="$this->items_in_stock()" :sort-by="$sortBy" with-pagination>
                @scope('cell_id', $itemInStock)
                    <a href="{{ route('stock.show_item', ['item' => $itemInStock]) }}" class="hover:text-blue-500">
                        {{$itemInStock->id}}
                    </a>
                @endscope

                @scope('cell_name', $itemInStock)
                    <a href="{{ route('stock.show_item', ['item' => $itemInStock]) }}" class="hover:text-blue-500">
                        {{$itemInStock->name}}
                    </a>
                @endscope

                @scope('actions', $itemInStock)
                    <div class="flex flex-row items-center">
                        <a href="{{ route('stock.show_item', ['item' => $itemInStock]) }}"
                           class="btn btn-sm text-white bg-green-700 rounded-md">
                            <x-icon name="o-eye" class="w-4 h-4" />
                        </a>

                        <a href="{{ route('stock.delete_item', ['id' => $itemInStock->id]) }}"
                           class="btn btn-sm text-white bg-red-500 rounded-md"
                           data-confirm-delete="true">
                            <x-icon name="o-trash" class="w-4 h-4" />
                        </a>
                    </div>
                @endscope
            </x-table>
        </x-card>
    @endif

    </div>

    <script defer>
        function goToShowItemPageFromTable(event) {
            window.location.href = `{{url('stock/show')}}/${event.detail.id}`;
        }
    </script>

</div>
