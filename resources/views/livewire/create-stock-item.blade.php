<div>

    <div class="p-4">

        @livewire('navigation.breadcrumps', [
        'links' => [
        'Estoque' => '#',
        'Adicionar novo' => '#'
        ]
        ])

        @livewire('navigation.section-head-info', [
        'title' => 'Adicionar novo item ao estoque',
        'subtitle' => 'Preencha todos os campos necessários'
        ])

        <div class="flex mb-4">
            <button wire:click="setTab(1)" class="px-4 py-2 text-sm font-medium border-b-2
                @if ($currentTab === 1)
                    border-green-700 text-white bg-green-700
                @else
                    border-transparent text-gray-700 hover:text-green-700 hover:border-green-300
                @endif
                rounded-t-md transition-colors duration-150">
                Geral
            </button>
            <button wire:click="setTab(2)" class="px-4 py-2 text-sm font-medium border-b-2
                @if ($currentTab === 2)
                    border-green-700 text-white bg-green-700
                @else
                    border-transparent text-gray-700 hover:text-green-700 hover:border-green-300
                @endif
                rounded-t-md transition-colors duration-150">
                Complementos
            </button>
        </div>

        <form method="" action="" class="" id="">

            @csrf

            <div id="tab-1-content" class="{{ $currentTab === 1 ? '' : 'hidden' }}">

                <div class="space-y-4 mb-6">
                    <x-input label="Nome" wire:model.live.debounce.500ms="nome" required name="name" id="name" />

                    <x-input label="Nome comercial" wire:model.live.debounce.500ms="nome_comercial" name="trade_name" id="trade_name" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <x-input label="SKU" wire:model.live.debounce.500ms="sku" name="sku" id="sku" minlength="8" maxlength="50" />
                    </div>
                    <div>
                        <x-select label="Unidade de medida" wire:model="unidade_medida" name="unity_of_measure" :options="$unidades_medida_disponiveis" option-label="name" option-value="value" />
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-6 mb-6">
                    <div>
                        <x-input x-mask="9999999999.99" label="Quantidade" wire:model.live.debounce.500ms="quantidade" name="quantity" id="quantity" maxlength="13" />
                    </div>
                    <div>
                        <x-input x-mask="9999999999.99" label="Quantidade mínima" wire:model.live.debounce.500ms="quantidade_minima" name="minimum_quantity" id="minimum_quantity" maxlength="13" />
                    </div>
                    <div>
                        <x-input x-mask="9999999999.99" label="Quantidade máxima" wire:model.live.debounce.500ms="quantidade_maxima" name="maximum_quantity" id="maximum_quantity" maxlength="13" />
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-6 mb-6">
                    <div>
                        <x-input required money prefix="R$" x-mask="9999999999.99" label="Preço de custo" wire:model.live.debounce.500ms="preco_custo" name="cost_price" id="cost_price" maxlength="13" />
                    </div>
                    <div>
                        <x-input money prefix="R$" x-mask="9999999999.99" label="Preço de venda" wire:model.live.debounce.500ms="preco_venda" name="sale_price" id="sale_price" maxlength="13" />
                    </div>
                    <div>
                        <x-file wire:model="foto_ilustrativa" label="Foto ilustrativa" name="illustration_picture_path" id="illustration_picture_path" accept="image/jpeg,image/jpg,image/png" />
                    </div>
                </div>

                <div class="mb-6">
                     <x-textarea label="Complemento" class="resize-none" wire:model="complemento" name="description" placeholder="Adicione informações adicionais..." maxlength="500" hint="Máximo de 500 caracteres" rows="4" />
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="button" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">Limpar</button>
                    <button wire:click.prevent="setTab(2)" type="button" class="px-4 py-2 text-white bg-green-700 rounded-lg hover:bg-green-600 transition duration-150">Próxima Aba</button>
                </div>

            </div>

            <div id="tab-2-content" class="{{ $currentTab === 2 ? '' : 'hidden' }}">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                        <div>
                            <x-select label="Marca" wire:model="marca" :options="$marcas_disponiveis" name="brand_id" id="brand" option-label="name" option-value="value" />
                        </div>

                        {{-- Armazém (Select Field) --}}
                        <div>
                            <x-select label="Armazém" wire:model="armazem" name="warehouse_id" :options="$armazens_disponiveis" id="warehouse" option-label="name" option-value="value" />
                        </div>
                    </div>

                    {{-- (Toggle Switch) --}}
                    <div class="flex items-center space-x-4 mb-6">
                        <x-checkbox label="Ativo" wire:model="ativo" name="is_active" />
                    </div>

                    <div class="flex justify-start space-x-4 mt-6">
                        <button wire:click.prevent="setTab(1)" type="button" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition duration-150">Voltar</button>
                        <button type="submit" class="px-4 py-2 text-white bg-green-700 rounded-lg hover:bg-green-600 transition duration-150">Salvar Item</button>
                    </div>
                </div>

            </div>
        </form>


    </div>

</div>