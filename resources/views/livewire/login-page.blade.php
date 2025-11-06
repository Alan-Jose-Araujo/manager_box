<div class="min-h-screen flex flex-col md:flex-row">
    {{-- Lado esquerdo --}}
    <livewire:side-panel infoText="Ainda não possui uma conta?" buttonText="Cadastre-se agora mesmo"
        buttonLink="{{ route('client.show_register_form') }}" />

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

            <div x-data x-on:auth-login-form-validation-success.window="handleAuthLoginFormValidationSuccess($event)"
                x-on:auth-login-form-validation-fail.window="handlAuthLoginFormValidationFail($event)">

                <x-form wire:submit.prevent="submit" method="POST" action="{{ route('auth.login') }}"
                    class="space-y-4" id="authentication-form" enctype="multipart/form-data" novalidate>
                    @csrf
                    <x-input label="Endereço de email" type="email" wire:model.live.debounce.500ms="user_data_email"
                        required name="email" maxlength="255"/>
                    <x-password label="Senha" wire:model.live.debounce.500ms="user_data_password" required name="password" maxlength="255"/>
                    <div class="flex items-center justify-between">
                        <x-checkbox label="Mantenha-me conectado." wire:model="user_data_remember" name="remember" value="true"/>

                        <a href="{{ '/' }}" class="text-green-700 font-semibold hover:underline">
                            Esqueceu sua senha?
                        </a>
                    </div>

                    <x-button type="submit" class=" bg-green-700 hover:bg-green-800 text-white font-semibold">Entrar</x-button>
                </x-form>

            </div>
        </x-card>
    </div>

    <script>

        function handleAuthLoginFormValidationSuccess(event) {
            document.getElementById('authentication-form').submit();
        }

        function handlAuthLoginFormValidationFail(event) {
            // Lógica para lidar com o sucesso da validação do formulário de login
            console.log('Validação mal-sucedida:', event.detail);
        }

    </script>

</div>
