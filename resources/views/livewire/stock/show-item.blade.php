<div>
    <div class="p-4 bg-white h-full">
        @livewire('navigation.breadcrumps', [
            'links' => [
                'Estoque' => '#',
                'Listar' => route('stock.list'),
                "#$item->id" => '#',
            ]
        ])

        @livewire('navigation.section-head-info', [
            'title' => $item->name,
            'subtitle' => 'Armazém: ' . $item->warehouse->name
        ])

        <div class="w-full p-4 rounded-md border-solid border flex flex-row">
            <div class="w-1/5 ml-[1rem] rounded-md">
                <img src="{{ $item->illustration_picture_path ? asset('storage/' . $item->illustration_picture_path) : asset('images/default_stock_box_icon.png') }}" alt="Item box logo" class="rounded-2xl">
            </div>
            <div class="flex flex-col ml-4 w-[70%]">
                <h3 class="text-xl mb-3">
                    <span class="font-bold">Nome: &nbsp;</span>
                    <span class="text-[rgba(0, 0, 0, 0.50)]">{{$item->name}}</span>
                </h3>

                <h3 class="text-xl mb-3">
                    <span class="font-bold">Nome comercial: &nbsp;</span>
                    <span class="text-[rgba(0, 0, 0, 0.50)]">{{$item->trade_name ?? '---'}}</span>
                </h3>

                <p class="text-md mb-3 text-truncate">
                    <span class="font-bold">Descrição: &nbsp;</span>
                    <span class="text-[rgba(0, 0, 0, 0.50)]">{{$item->description ?? '---'}}</span>
                </p>
            </div>
        </div>
    </div>
</div>
