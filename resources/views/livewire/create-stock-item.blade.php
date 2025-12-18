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

    @if ($currentTab === 1)
        <form>

            <div class="space-y-4 mb-6">
                <label for="nome" class="block text-sm font-medium text-red-600">Nome *</label>
                <input wire:model="nome" type="text" id="nome" name="nome" placeholder="" class="w-full bg-gray-200 h-10 rounded-lg border-none focus:ring-green-500 focus:border-green-500 transition duration-150">

                <label for="nome_comercial" class="block text-sm font-medium text-gray-700">Nome Comercial</label>
                <input wire:model="nome_comercial" type="text" id="nome_comercial" name="nome_comercial" placeholder="" class="w-full bg-gray-200 h-10 rounded-lg border-none focus:ring-green-500 focus:border-green-500 transition duration-150">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="sku" class="block text-sm font-medium text-gray-700">
                        SKU
                        <svg class="w-4 h-4 inline ml-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </label>
                    <input wire:model="sku" type="text" id="sku" name="sku" placeholder="" class="w-full bg-gray-200 h-10 rounded-lg border-none focus:ring-green-500 focus:border-green-500 transition duration-150">
                </div>
                <div>
                    <label for="unidade_medida" class="block text-sm font-medium text-gray-700">
                        Unidade de medida
                        <svg class="w-4 h-4 inline ml-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </label>
                    <input wire:model="unidade_medida" type="text" id="unidade_medida" name="unidade_medida" class="w-full bg-gray-200 h-10 rounded-lg border-none focus:ring-green-500 focus:border-green-500 transition duration-150">
                </div>
            </div>

            <div class="grid grid-cols-3 gap-6 mb-6">
                <div>
                    <label for="quantidade" class="block text-sm font-medium text-gray-700">Quantidade</label>
                    <input wire:model="quantidade" type="number" id="quantidade" name="quantidade" class="w-full bg-gray-200 h-10 rounded-lg focus:ring-green-500 focus:border-green-500 transition duration-150">
                </div>
                <div>
                    <label for="quantidade_minima" class="block text-sm font-medium text-gray-700">Quantidade mínima</label>
                    <input wire:model="quantidade_minima" type="number" id="quantidade_minima" name="quantidade_minima" class="w-full bg-gray-200 h-10 rounded-lg focus:ring-green-500 focus:border-green-500 transition duration-150">
                </div>
                <div>
                    <label for="quantidade_maxima" class="block text-sm font-medium text-gray-700">Quantidade máxima</label>
                    <input wire:model="quantidade_maxima" type="number" id="quantidade_maxima" name="quantidade_maxima" class="w-full bg-gray-200 h-10 rounded-lg focus:ring-green-500 focus:border-green-500 transition duration-150">
                </div>
            </div>

            <div class="grid grid-cols-3 gap-6 mb-6">
                <div>
                    <label for="preco_custo" class="block text-sm font-medium text-gray-700">Preço de custo</label>
                    <input wire:model="preco_custo" type="text" id="preco_custo" name="preco_custo" placeholder="0.00" class="w-full bg-gray-200 h-10 rounded-lg focus:ring-green-500 focus:border-green-500 transition duration-150">
                </div>
                <div>
                    <label for="preco_venda" class="block text-sm font-medium text-gray-700">Preço de venda</label>
                    <input wire:model="preco_venda" type="text" id="preco_venda" name="preco_venda" placeholder="0.00" class="w-full bg-gray-200 h-10 rounded-lg border-none focus:ring-green-500 focus:border-green-500 transition duration-150">
                </div>
                <div>
                    <label for="foto_ilustrativa" class="block text-sm font-medium text-gray-700">Foto Ilustrativa</label>
                    <label for="upload-foto" class="w-full h-10 flex items-center justify-center bg-gray-200 rounded-lg text-gray-500 text-sm overflow-hidden border border-gray-300 cursor-pointer hover:bg-gray-300 transition duration-150">
                         {{ $foto_ilustrativa ? 'Arquivo Selecionado' : 'Nenhum arquivo selecionado' }}
                    </label>
                    <input wire:model="foto_ilustrativa" type="file" id="upload-foto" name="foto_ilustrativa" class="sr-only">
                </div>
            </div>

            <div class="mb-6">
                <label for="complemento" class="block text-sm font-medium text-gray-700">Complemento</label>
                <textarea wire:model="complemento" id="complemento" name="complemento" rows="4" class="w-full bg-gray-200 rounded-lg border-none focus:ring-green-500 focus:border-green-500 transition duration-150"></textarea>
            </div>

            <div class="flex justify-end space-x-4">
                <button type="button" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">Limpar</button>
                <button wire:click.prevent="setTab(2)" type="button" class="px-4 py-2 text-white bg-green-700 rounded-lg hover:bg-green-600 transition duration-150">Próxima Aba</button>
            </div>
        </form>
    @endif

    @if ($currentTab === 2)
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                <div>
                    <label for="marca" class="block text-sm font-medium text-gray-700">Marca</label>

                    <input wire:model="marca" type="text" id="marca" name="marca" placeholder="Selecione a Marca" class="w-full bg-gray-200 h-10 rounded-lg border-none focus:ring-green-500 focus:border-green-500 transition duration-150">
                </div>

                {{-- Armazém (Select Field) --}}
                <div>
                    <label for="armazem" class="block text-sm font-medium text-gray-700">Armazém</label>
                    <input wire:model="armazem" type="text" id="armazem" name="armazem" placeholder="Selecione o Armazém" class="w-full bg-gray-200 h-10 rounded-lg border-none focus:ring-green-500 focus:border-green-500 transition duration-150">
                </div>
            </div>

            {{-- (Toggle Switch) --}}
            <div class="flex items-center space-x-4 mb-6">
                <label for="ativo" class="block text-sm font-medium text-gray-700">Ativo</label>


                <label class="relative inline-flex items-center cursor-pointer">

                    <input wire:model="ativo" type="checkbox" id="ativo" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-700"></div>
                </label>
            </div>

            <div class="flex justify-start space-x-4 mt-6">
                <button wire:click.prevent="setTab(1)" type="button" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition duration-150">Voltar</button>
                <button type="submit" class="px-4 py-2 text-white bg-green-700 rounded-lg hover:bg-green-600 transition duration-150">Salvar Item</button>
            </div>
        </div>
    @endif

    </div>

</div>
