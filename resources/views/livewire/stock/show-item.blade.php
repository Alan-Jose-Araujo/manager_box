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
            'title' => 'Visualizar item',
            'subtitle' => 'Armazém: ' . $item->warehouse->name
        ])
    </div>

        <div class="rounded-xl overflow-hidden bg-gray-100">

            <div class="grid grid-cols-1 md:grid-cols-3">

                <div class="md:col-span-1 flex items-center justify-center p-6 border-b md:border-b-0 md:border-r border-gray-100">

                    @if($item->illustration_picture_path)
                        <img
                            src="{{ asset('storage/' . $item->illustration_picture_path) }}"
                            alt="Foto de {{ $item->name }}"
                            class="w-full h-auto object-cover rounded-lg shadow-sm hover:scale-105 transition-transform duration-300"
                        >
                    @else
                        <div class="text-gray-400 flex flex-col items-center">
                            <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm">Sem imagem</span>
                        </div>
                    @endif
                </div>

                <div class="md:col-span-2 p-8 flex flex-col justify-start">

                    <div class="mb-6">
                        <h2 class="text-sm font-bold tracking-widest text-green-800 uppercase mb-1">
                            {{ $item->trade_name }}
                        </h2>
                        <h1 class="text-3xl font-extrabold text-gray-900">
                            {{ $item->name }}
                        </h1>
                    </div>

                    <div class="prose prose-sm text-gray-600 mb-8">
                        <h3 class="text-gray-900 font-semibold mb-2">Descrição do Produto</h3>
                        <p class="leading-relaxed">
                            {{ $item->description ?: 'Nenhuma descrição disponível para este item.' }}
                        </p>
                    </div>

                    <div class="mt-auto pt-6 border-t border-gray-100 flex items-center justify-between text-sm text-gray-500">
                        <span>
                            <p class="mb-2">
                                Código: #{{ $item->id }}
                            </p>
                            <p>
                                Quantidade em estoque: {{ number_format($item->quantity, 2) }} <span class="bg-green-100 p-2 rounded-xl font-bold">({{ ucfirst($item->unity_of_measure->value)  }})</span>
                            </p>
                        </span>

                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{$item->quantity > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}}">
                            @if($item->quantity)
                                Em Estoque
                                @else
                                Fora de Estoque
                            @endif
                        </span>
                    </div>
                </div>

            </div>
        </div>



</div>
