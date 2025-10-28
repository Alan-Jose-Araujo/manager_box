<div class="min-h-screen flex flex-col md:flex-row">
    {{-- Lado esquerdo --}}
    <livewire:side-panel 
        infoText="Ainda não possui uma conta?"
        buttonText="Cadastre-se agora mesmo"
        buttonLink="/register"
    />

    {{-- Lado direito --}}
    <div class="w-full md:w-2/3 lg:w-3/4 p-6 sm:p-8 md:p-10 flex flex-col justify-center items-center">
        <x-card class="w-full max-w-3xl shadow-lg">

            <h2 class="text-xl md:text-2xl font-semibold text-green-700 flex items-center gap-2 mb-2">
                <img src="{{ asset('images/manager_box_logo.svg') }}" alt="Logo" class="w-7 h-7 md:w-8 md:h-8">
                Seja bem-vindo(a) de volta!
            </h2>

            <p class="text-gray-600 mb-6">
                Insira suas credenciais no formulário para entrar.
            </p>

            <x-form wire:submit.prevent="submit" class="space-y-4">
                <x-input label="Endereço de email" type="email" wire:model.live.debounce.1000ms="user_data_email" required />
                <x-password label="Senha" wire:model.live.debounce.1000ms="user_data_password" required />
                <div class="flex items-center justify-between">
                    <x-checkbox label="Mantenha-me conectado." wire:model="remember" />

                    <a href="{{ '/register' }}" class="text-green-700 font-semibold hover:underline">
                        Cadastre-se
                    </a>
                </div>
                
                <x-button class=" bg-green-700 hover:bg-green-800 text-white font-semibold">Entrar</x-button>
            </x-form>
        </x-card>
    </div>
</div>