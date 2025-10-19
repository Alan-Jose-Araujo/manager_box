<div>
<div class="min-h-screen flex flex-col md:flex-row">
    {{-- Lado esquerdo --}}
    <div class="w-full md:w-1/3 lg:w-1/4 bg-[#F8F2EC] flex flex-col justify-center items-center p-8 md:p-10">
        <div class="text-center mt-20 md:mt-0">
            <div class="mb-4 flex justify-center">
                <img src="{{ asset('images/manager_box_logo.svg') }}" alt="Logo" class="w-24 h-24 md:w-28 md:h-28">
            </div>
            <h1 class="text-2xl font-semibold text-gray-800">Manager Box</h1>
            <p class="text-gray-600 mt-2">Cadastre-se sem complicações</p>
        </div>

        <div class="mt-10 md:mt-auto text-center">
            <p class="text-gray-700">Já possui uma conta?</p>
            <a href="/login" class="text-green-700 font-semibold hover:underline">
                Entre agora mesmo
            </a>
        </div>
    </div>

    {{-- Lado direito --}}
    <div class="w-full md:w-2/3 lg:w-3/4 p-6 sm:p-8 md:p-10 flex flex-col justify-center">
        <h2 class="text-xl md:text-2xl font-semibold text-green-700 flex items-center gap-2 mb-2">
            @if ($step === 1)
                 <img src="{{ asset('images/manager_box_logo.svg') }}" alt="Logo" class="w-7 h-7 md:w-8 md:h-8">
                Vamos começar por você!
            @elseif ($step === 2)
                 <img src="{{ asset('images/manager_box_logo.svg') }}" alt="Logo" class="w-7 h-7 md:w-8 md:h-8">
                Vamos começar por você!
            @elseif ($step === 3)
                <img src="{{ asset('images/manager_box_logo.svg') }}" alt="Logo" class="w-7 h-7 md:w-8 md:h-8">
                Estamos ansiosos para conhecer a sua empresa!
            @elseif ($step === 4)
                <img src="{{ asset('images/manager_box_logo.svg') }}" alt="Logo" class="w-7 h-7 md:w-8 md:h-8">
                Estamos ansiosos para conhecer a sua empresa!
            @endif
        </h2>
        <p class="text-gray-600 mb-6 md:mb-8">
            @if ($step === 1)
                Por favor, preencha o formulário com os seus dados.
            @elseif ($step === 2)
                 Por favor, preencha o formulário com o seu endereço.
            @elseif ($step === 3)
                 Agora preencha o formulário com os dados da sua empresa.
            @elseif ($step === 4)
                 Agora preencha o formulário com o endereço da sua empresa.
            @endif
            
        </p>

        <x-form wire:submit.prevent="submit" class="space-y-4">

            {{-- Etapa 1: Dados Pessoais --}}
            @if ($step === 1)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-input label="Nome Completo" wire:model.blur="user_data_name" placeholder="Seu nome" icon="o-user" oninput="this.value = this.value.replace(/[^a-zA-ZÀ-ÿ\s']/g, '')" required/>
                    <x-input label="Endereço de email" type="email" wire:model.blur="user_data_email" required/>
                    <x-password label="Senha" wire:model.blur="user_data_password" required/>
                    <x-password label="Confirmação de senha" wire:model.blur="user_data_password_confirmation" required/>
                    <x-input label="CPF" wire:model.blur="user_data_cpf" inputmode="numeric" maxLength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11)" required/>
                    <x-input label="Número de celular" wire:model="user_data_phone_number" inputmode="numeric" maxlength="14" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 14)"/>
                    <x-input label="Foto de perfil" type="file" wire:model="user_data_profile_picture_path"/>
                    <x-input label="Data de nascimento" type="date" wire:model="user_data_birth_date"/>
                </div>
            @endif
            
             {{-- Etapa 2: Endereço pessoal --}}
            @if ($step === 2)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-input label="CEP" wire:model.blur="user_address_data_cep" inputmode="numeric" maxlength="8" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 8)" required />
                    <x-input label="Número" wire:model.blur="user_address_data_building_number" inputmode="numeric" maxlength="5" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 5)" required />

                    <div class="md:col-span-2">
                        <x-input label="Rua" wire:model.blur="user_address_data_street" oninput="this.value = this.value.replace(/[^a-zA-ZÀ-ÿ0-9\s,.'-]/g, '')" required />
                    </div>

                    <div class="md:col-span-2">
                        <x-input label="Bairro" wire:model.blur="user_address_data_neighborhood" oninput="this.value = this.value.replace(/[^a-zA-ZÀ-ÿ0-9\s'-]/g, '')" required />
                    </div>

                    <x-input label="Cidade" wire:model.blur="user_address_data_city" oninput="this.value = this.value.replace(/[^a-zA-ZÀ-ÿ\s'-]/g, '')" required/>
                    <x-input label="Estado" wire:model.blur="user_address_data_state" oninput="this.value = this.value.replace(/[^a-zA-ZÀ-ÿ\s'-]/g, '')" required/>

                    <div class="md:col-span-2">
                        <x-input label="Complemento" wire:model="user_address_data_complement" class="h-14"/>
                    </div>
                </div>
            @endif

             {{-- Etapa 3: Dados da Empresa --}}
            @if ($step === 3)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <x-input label="Nome Fantasia" wire:model.blur="company_data_fantasy_name" oninput="this.value = this.value.replace(/[^a-zA-ZÀ-ÿ0-9\s&'-.,/]/g, '')" required />
                    </div>

                    <div class="md:col-span-2">
                        <x-input label="Razão Social" wire:model.blur="company_data_corporate_name" oninput="this.value = this.value.replace(/[^a-zA-ZÀ-ÿ0-9\s.,&'-/]/g, '')" required />
                    </div>

                    <x-input label="CNPJ" wire:model.blur="company_data_cnpj" inputmode="numeric" maxlength="14" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 14)" required />
                    <x-input label="Inscrição Estadual" wire:model.blur="company_data_state_registration" required />

                    <div class="md:col-span-2">
                        <x-input label="Email de Contato" wire:model.blur="company_data_contact_email" required/>
                    </div>

                    <x-input label="Número de Celular" wire:model="company_data_phone_number" inputmode="numeric" maxlength="14" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 14)"/>
                    <x-input label="Número de Telefone Fixo" wire:model="company_data_landline_number" inputmode="numeric" maxlength="14" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 14)"/>

                    <x-input label="Logomarca" type="file" wire:model="company_data_logo_picture_path"/>
                    <x-input label="Data de Fundação" type="date" wire:model="company_data_foundation_date"/>
                
                    <x-checkbox label="O endereço da empresa é o mesmo no qual resido." wire:model.live="company_data_company_same_user_address"/>
                </div>
                
            @endif


             {{-- Etapa 4: Endereço da empresa --}}
            @if ($step === 4 && !$company_data_company_same_user_address)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-input label="CEP" wire:model.blur="company_address_data_cep" inputmode="numeric" maxlength="8" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 8)" required />
                    <x-input label="Número" wire:model.blur="company_address_data_building_number" inputmode="numeric" maxlength="5" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 5)" required />

                    <div class="md:col-span-2">
                        <x-input label="Rua" wire:model.blur="company_address_data_street" oninput="this.value = this.value.replace(/[^a-zA-ZÀ-ÿ0-9\s,.'-]/g, '')" required />
                    </div>

                    <div class="md:col-span-2">
                        <x-input label="Bairro" wire:model.blur="company_address_data_neighborhood" oninput="this.value = this.value.replace(/[^a-zA-ZÀ-ÿ0-9\s'-]/g, '')" required />
                    </div>

                    <x-input label="Cidade" wire:model.blur="company_address_data_city" oninput="this.value = this.value.replace(/[^a-zA-ZÀ-ÿ\s'-]/g, '')" required />
                    <x-input label="Estado" wire:model.blur="company_address_data_state" oninput="this.value = this.value.replace(/[^a-zA-ZÀ-ÿ\s'-]/g, '')" required />

                    <div class="md:col-span-2">
                        <x-input label="Complemento" wire:model="company_address_data_complement" class="h-14"/>
                    </div>
                </div>
            @endif

            {{-- Barra de progresso --}}
            <div class="flex items-center justify-between mt-6 flex-wrap gap-2">
                <div class="flex-1 bg-gray-200 rounded-full h-2">
                    <div class="bg-green-700 h-2 rounded-full"  style="width: {{ ($step / $this->totalSteps) * 100 }}%"></div>
                </div>
                <span class="text-sm text-gray-600 whitespace-nowrap"> Etapa {{ $step }} de {{ $this->totalSteps }}</span>
            </div>

            {{-- Botões --}}
            <div class="flex flex-col sm:flex-row sm:justify-end mt-6 gap-2">
                @if ($step > 1)
                    <x-button wire:click="prevStep" class="order-2 sm:order-1" type="button">
                        Voltar
                    </x-button>
                @endif

                @if ($step < $totalSteps)
                    <x-button wire:click="nextStep" type="button" class="btn-success order-1 sm:order-2">
                        Avançar
                    </x-button>
                @else
                    <x-button wire:click="submit" type="submit" class="btn-success order-1 sm:order-2">
                        Enviar
                    </x-button>
                @endif
                
            </div>
        </x-form>
    </div>
</div>
</div>