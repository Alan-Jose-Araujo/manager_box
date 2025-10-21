<div class="pb-8">

    {{-- Grid - desktops (lg) --}}
    <div class="grid lg:grid-cols-2 gap-6">

        {{-- BLOC 1 --}}
        <x-card title="Entradas e saídas" class="col-span-1">
            <x-chart wire:model="chartEntradasSaidas" />

            <div class="mt-4 flex flex-wrap justify-between text-xs text-gray-500 gap-2">
                <span>Gabinte Gamer Algo DarkFlash</span>
                <span>Placa de Vídeo Geforce RTX 4090</span>
                <span>Processador Intel Core I5-13500F</span>
                <span>Placa Mãe Pichau Danuri B550M PA</span>
            </div>
        </x-card>

        {{-- BLOC 2 --}}
        <x-card title="Itens por Categoria" class="col-span-1">
            <div class="flex items-center">
                <div class="w-2/3 h-56">
                    <x-chart wire:model="chartItensCategoria" />
                </div>

                <div class="w-1/3 p-4 space-y-3">
                    <div class="text-sm">
                        <span class="text-orange-600 font-bold">74</span> <span class="text-xs text-gray-500">10.79%</span>
                        <div class="text-xs text-gray-600">Placas mãe</div>
                    </div>
                    <div class="text-sm">
                        <span class="text-purple-600 font-bold">150</span> <span class="text-xs text-gray-500">21.87%</span>
                        <div class="text-xs text-gray-600">Gabinetes</div>
                    </div>
                    <div class="text-sm">
                        <span class="text-red-600 font-bold">182</span> <span class="text-xs text-gray-500">23.82%</span>
                        <div class="text-xs text-gray-600">Placas de vídeo</div>
                    </div>
                    <div class="text-sm">
                        <span class="text-cyan-600 font-bold">300</span> <span class="text-xs text-gray-500">43.73%</span>
                        <div class="text-xs text-gray-600">Processadores</div>
                    </div>
                </div>
            </div>
        </x-card>
    </div>

    <div class="grid lg:grid-cols-4 gap-6 mt-6">

        {{-- BLOC 3 --}}
        <x-card title="Produtos sem rotatividade" class="col-span-1 h-full">
            <div class="grid grid-cols-2 gap-4">
                @foreach($produtosSemRotatividade as $produto)
                    <div class="border border-base-content/20 p-3 rounded-lg flex flex-col justify-between">
                        <span class="text-sm font-semibold">{{ $produto['nome'] }}</span>
                        <span class="text-xs text-gray-500 mt-1">{{ $produto['dias'] }} dias parados</span>
                    </div>
                @endforeach
            </div>
        </x-card>

        {{-- BLOC 4 --}}
        <x-card title="Saídas neste mês" class="col-span-1 flex items-center justify-center">
            <div class="flex items-center space-x-6">
                <div class="radial-progress text-purple-600"
                    @style([
                        '--value: 62',
                        '--size: 7rem',
                        '--thickness: 0.8rem',
                    ])
                >
                    <span class="text-3xl font-bold">62</span>
                </div>

                <div class="space-y-2">
                    <div class="flex items-center text-sm">
                        <span class="inline-block w-3 h-3 rounded-full bg-purple-500 mr-2"></span>
                        <span>Placas de vídeo</span>
                    </div>
                    <div class="flex items-center text-sm">
                        <span class="inline-block w-3 h-3 rounded-full bg-red-500 mr-2"></span>
                        <span>Processadores</span>
                    </div>
                    <div class="flex items-center text-sm">
                        <span class="inline-block w-3 h-3 rounded-full bg-sky-500 mr-2"></span>
                        <span>Placas mãe</span>
                    </div>
                </div>
            </div>
        </x-card>

        {{-- BLOC 5 --}}
        <x-card title="Preço médio por categoria" class="col-span-2">
            <div class="h-64">
                <x-chart wire:model="chartPrecoMedio" />
            </div>
        </x-card>

    </div>

    <div class="grid lg:grid-cols-4 gap-6 mt-6">

        {{-- BLOC 6 --}}
        <x-card title="Rotatividade de estoque" class="col-span-1">
            <div class="text-2xl font-bold text-gray-700">
                {{ $rotatividadeEstoque }}
            </div>
        </x-card>

        {{-- BLOC 7 --}}
        <x-card title="Indicadores-chave de desempenho" class="col-span-1">
            <div class="space-y-2 text-gray-700">
                <div class="text-lg">Total de itens: <span class="font-bold">{{ $totalItens }}</span></div>
                <div class="text-lg">Total de categorias: <span class="font-bold">{{ $totalCategorias }}</span></div>
                <div class="text-lg">Valor do estoque: <span class="font-bold text-green-600">{{ $valorEstoque }}</span></div>
            </div>
        </x-card>

        <div class="col-span-2"></div>
    </div>
</div>
