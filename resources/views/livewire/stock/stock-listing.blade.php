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


    @if ($items_in_stock->isEmpty())

        <x-card shadow separator>

        <x-table :headers="$this->headers()" :rows="$this->items_in_stock()" :sort-by="$sortBy" with-pagination />
                <div class="p-4 text-center text-gray-500">
                    Não possui itens cadastrados.
                </div>

        </x-card>

    @else
        <x-card shadow separator>
            <x-table :headers="$this->headers()" :rows="$this->items_in_stock()" :sort-by="$sortBy" @row-click="($event) => goToShowItemPageFromTable($event)" with-pagination/>
        </x-card>
    @endif

    </div>

    <script defer>
        function goToShowItemPageFromTable(event) {
            window.location.href = `{{url('stock/show')}}/${event.detail.id}`;
        }
    </script>

</div>
