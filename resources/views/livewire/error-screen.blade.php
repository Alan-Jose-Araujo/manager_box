<div class="flex flex-col items-center justify-center min-h-screen">
    <div class="max-w-md text-center">
        <h1 class="text-9xl font-bold text-[#0f7a4f] mb-4">500</h1>
        <h2 class="text-3xl font-semibold text-[#2d2d2d] mb-4">Erro interno</h2>
        <p class="text-lg text-gray-600 mb-6">
            Oops! Houve um erro interno em nossa aplicação, não se preocupe, não foi culpa sua.
            Faremos o possível para que retornemos à normalidade.
        </p>

        <x-button wire:click="home" icon="o-home"
            class="bg-green-700 hover:bg-green-800 text-white font-semibold">
            Voltar para a página inicial
        </x-button>

    </div>
</div>

