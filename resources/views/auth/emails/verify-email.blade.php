<x-layouts.verify-email>

    <div class="flex flex-col w-screen h-screen items-center">

        <div class="flex flex-col w-[50%] mt-[8em] items-center">

            <img src="{{ asset('images/manager_box_logo.svg') }}" alt="Logo" class="w-[100px] h-[113.91px]" />
            <div class="text-center">
                <h1 class="text-3xl mb-2 text-black/100 font-bold">Manager Box</h1>
                <h2 class="text-2xl mb-4 text-black/50">Plataforma inteligente de gestão de estoques</h2>
            </div>

            <div class="flex flex-col w-full h-full bg-[#F8F2EC] mt-[2em] items-center py-4">
                <div class="w-[75%]">

                    @php
                        $firstName = explode(' ', auth()->user()->name)[0];
                    @endphp

                    <h3 class="text-1xl text-black/100 font-bold">Olá, {{ $firstName }}!</h3>
                    <p class="mt-3">
                        É bom ter você em nossa plataforma. Antes de começarmos precisamos fazer a verificação de seu email,
                        verifique sua caixa de emails e siga as instruções. Caso não tenha recebido nosso email,
                        clique no botão abaixo para reenviá-lo.
                    </p>

                    <div class="text-center mt-10">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <x-button type="submit" class="bg-[#136235] text-white w-[50%] rounded-box p-8">
                                Reenviar link de verificação
                            </x-button>
                        </form>
                    </div>

                    <p class="mt-3">
                        Caso não seja possível fazer isto agora, clique no botão abaixo para sair.
                    </p>

                    <div class="text-center mt-10">
                        <form method="POST" action="{{ route('auth.logout') }}">
                            @csrf
                            <x-button type="submit" class="bg-red-100 text-red-600 w-[50%] rounded-box p-8">
                                Sair
                            </x-button>
                        </form>
                    </div>

                    <p class="mt-3 text-black/100 font-bold">
                        Atencisoamente,<br>
                        Manager Box.
                    </p>
                </div>
            </div>

        </div>

        <footer class="fixed bottom-0">
            <p>
                &copy; {{ date('Y') }} Manager Box. Todos os direitos reservados.
            </p>
        </footer>

    </div>

</x-layouts.auth-layout>
