<div class="p-4">

    {{-- HEADER E ABAS (TABS) --}}
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h1 class="text-xl font-semibold text-gray-800 mb-2">Adicionar novo item ao estoque</h1>
        <p class="text-gray-500 mb-4">Preencha todos os campos necessários</p>

        {{-- NAVEGAÇÃO DAS ABAS --}}
        <div class="flex border-b border-gray-200">
            {{-- Botão Geral --}}
            <button wire:click="setTab(1)" class="px-4 py-2 text-sm font-medium border-b-2
                @if ($currentTab === 1)
                    border-green-700 text-white bg-green-700
                @else
                    border-transparent text-gray-700 hover:text-green-700 hover:border-green-300
                @endif
                rounded-t-md transition-colors duration-150">
                Geral
            </button>
            {{-- Botão Complementos --}}
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
    </div>

    {{-- FORMULÁRIO PRINCIPAL (TAB 1: GERAL) --}}
    @if ($currentTab === 1)
        {{-- Formulário de Adição de Estoque --}}
        <form class="bg-white rounded-lg shadow-lg p-6">

            {{-- Linha 1: Nome e Nome Comercial --}}
            <div class="space-y-4 mb-6">
                <label for="nome" class="block text-sm font-medium text-red-600">Nome *</label>
                <input wire:model="nome" type="text" id="nome" name="nome" placeholder="" class="w-full bg-gray-200 h-10 rounded-lg border-none focus:ring-green-500 focus:border-green-500 transition duration-150">

                <label for="nome_comercial" class="block text-sm font-medium text-gray-700">Nome Comercial</label>
                <input wire:model="nome_comercial" type="text" id="nome_comercial" name="nome_comercial" placeholder="" class="w-full bg-gray-200 h-10 rounded-lg border-none focus:ring-green-500 focus:border-green-500 transition duration-150">
            </div>

            {{-- Linha 2: SKU e Unidade de Medida --}}
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

            {{-- Linha 3: Quantidades --}}
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

            {{-- Linha 4: Preços e Foto Ilustrativa --}}
            <div class="grid grid-cols-3 gap-6 mb-6">
                <div>
                    <label for="preco_custo" class="block text-sm font-medium text-gray-700">Preço de custo</label>
                    <input wire:model="preco_custo" type="text" id="preco_custo" name="preco_custo" placeholder="0.00" class="w-full bg-gray-200 h-10 rounded-lg focus:ring-green-500 focus:border-green-500 transition duration-150">
                </div>
                <div>
                    <label for="preco_venda" class="block text-sm font-medium text-gray-700">Preço de venda</label>
                    <input wire:model="preco_venda" type="text" id="preco_venda" name="preco_venda" placeholder="0.00" class="w-full bg-gray-200 h-10 rounded-lg focus:ring-green-500 focus:border-green-500 transition duration-150">
                </div>
                <div>
                    <label for="foto_ilustrativa" class="block text-sm font-medium text-gray-700">Foto Ilustrativa</label>
                    {{-- Input de Arquivo Customizado (Aparência de botão) --}}
                    <label for="upload-foto" class="w-full h-10 flex items-center justify-center bg-gray-200 rounded-lg text-gray-500 text-sm overflow-hidden border border-gray-300 cursor-pointer hover:bg-gray-300 transition duration-150">
                         {{ $foto_ilustrativa ? 'Arquivo Selecionado' : 'Nenhum arquivo selecionado' }}
                    </label>
                    <input wire:model="foto_ilustrativa" type="file" id="upload-foto" name="foto_ilustrativa" class="sr-only">
                </div>
            </div>

            {{-- Linha 5: Complemento (Área de texto grande) --}}
            <div class="mb-6">
                <label for="complemento" class="block text-sm font-medium text-gray-700">Complemento</label>
                <textarea wire:model="complemento" id="complemento" name="complemento" rows="4" class="w-full bg-gray-200 rounded-lg border-none focus:ring-green-500 focus:border-green-500 transition duration-150"></textarea>
            </div>

            {{-- Botões de Ação --}}
            <div class="flex justify-end space-x-4">
                <button type="button" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">Limpar</button>
                <button wire:click.prevent="setTab(2)" type="button" class="px-4 py-2 text-white bg-green-700 rounded-lg hover:bg-green-600 transition duration-150">Próxima Aba</button>
            </div>
        </form>
    @endif

    {{-- ABA 2: COMPLEMENTOS (Conteúdo placeholder) --}}
    @if ($currentTab === 2)
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Complementos do Item</h2>
            <p class="text-gray-600">Aqui será o conteúdo da segunda aba, onde você pode adicionar campos como Fornecedor, Localização no Estoque, etc.</p>
            <div class="flex justify-start space-x-4 mt-6">
                <button wire:click.prevent="setTab(1)" type="button" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition duration-150">Voltar</button>
            </div>
        </div>
    @endif

</div>
