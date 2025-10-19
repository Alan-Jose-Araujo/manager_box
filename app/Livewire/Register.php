<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Http;

class Register extends Component
{
    use WithFileUploads;

    #[Layout('components.layouts.register')]
    
    public $step = 1;

    // Etapa 1 - Dados Pessoais
    #[Validate('required', message: 'O campo Nome é obrigatório')]
    #[Validate('min:6', message: 'O campo Nome deve ter no mínimo 6 caracteres')]
    #[Validate('regex:/^[a-zA-ZÀ-ÿ\s\']+$/', message: 'O campo Nome deve conter apenas letras e espaços')]
    public $user_data_name; 

    #[Validate('required', message: 'O campo Email é obrigatório')]
    #[Validate('email', message: 'O campo Email deve ser um email válido')]
    public $user_data_email; 

    #[Validate('required', message: 'A senha é obrigatória')]
    #[Validate('min:8', message: 'A senha deve ter no mínimo 8 caracteres')]
    public $user_data_password; 

    #[Validate('required', message: 'A confirmação de senha é obrigatória')]
    #[Validate('same:user_data_password', message: 'As senhas não coincidem')]
    public $user_data_password_confirmation; 

    #[Validate('required', message: 'O campo CPF é obrigatório')]
    #[Validate('digits:11', message: 'Informe um CPF válido com 11 dígitos')]
    #[Validate('regex:/^[0-9]{11}$/', message: 'O campo CPF deve conter apenas números')]
    public $user_data_cpf;

    public $user_data_phone_number; 
    public $user_data_profile_picture_path; 
    public $user_data_birth_date;

    
    // Etapa 2 - Endereço Pessoal
    #[Validate('required', message: 'O campo CEP é obrigatório')]
    #[Validate('digits:8', message: 'O campo CEP deve ter 8 dígitos')]
    #[Validate('regex:/^[0-9]{8}$/', message: 'O campo CEP deve conter apenas números')]
    public $user_address_data_cep;

    #[Validate('required', message: 'O campo Número é obrigatório')]
    #[Validate('numeric', message: 'O campo deve ser numérico')]
    #[Validate('regex:/^[0-9]+$/', message: 'O campo Número deve conter apenas números')]
    public $user_address_data_building_number;

    #[Validate('required', message: 'O campo Rua é obrigatório')]
    #[Validate('min:3', message: 'O campo Rua deve ter no mínimo 3 caracteres')]
    #[Validate('regex:/^[a-zA-ZÀ-ÿ0-9\s.,\'-]+$/', message: 'O campo Rua deve conter apenas letras, números, espaços, virgula, ponto, apóstrofo e hífen')]
    public $user_address_data_street;

    #[Validate('required', message: 'O campo Bairro é obrigatório')]
    #[Validate('min:3', message: 'O campo Bairro deve ter no mínimo 3 caracteres')]
    #[Validate('regex:/^[a-zA-ZÀ-ÿ\s\'-]+$/', message: 'O campo Bairro deve conter apenas letras e espaços')]
    public $user_address_data_neighborhood;

    #[Validate('required', message: 'O campo Cidade é obrigatório')]
    #[Validate('min:3', message: 'O campo Cidade deve ter no mínimo 3 caracteres')]
    #[Validate('regex:/^[a-zA-ZÀ-ÿ\s\'-]+$/', message: 'O campo Cidade deve conter apenas letras e espaços')]
    public $user_address_data_city;

    #[Validate('required', message: 'O campo Estado é obrigatório')]
    #[Validate('min:2', message: 'O campo Estado deve ter no mínimo 2 caracteres')]
    #[Validate('regex:/^[a-zA-ZÀ-ÿ\s\'-]+$/', message: 'O campo Estado deve conter apenas letras e espaços')]
    public $user_address_data_state;

    public $user_address_data_complement;


    // Etapa 3 - Dados da Empresa
    #[Validate('required', message: 'O campo Nome Fantasia é obrigatório')]
    #[Validate('min:3', message: 'O campo Nome Fantasia deve ter no mínimo 3 caracteres')]
    #[Validate('regex:/^[a-zA-ZÀ-ÿ0-9\s\'\-\.,&\/]+$/', message: 'O campo Nome Fantasia deve conter apenas letras, números, espaços, apóstrofo, hífen, ponto, vírgula, & e /')]
    public $company_data_fantasy_name;

    #[Validate('required', message: 'O campo Razão Social é obrigatório')]
    #[Validate('min:3', message: 'O campo Razão Social deve ter no mínimo 3 caracteres')]
    #[Validate('regex:/^[a-zA-ZÀ-ÿ0-9\s.,&\'-\/]+$/', message: 'O campo Razão Social deve conter apenas letras, números, espaços, apóstrofo, hífen, ponto, vírgula, & e /')]
    public $company_data_corporate_name;

    #[Validate('required', message: 'O campo CNPJ é obrigatório')]
    #[Validate('digits:14', message: 'O campo CNPJ deve ter 14 dígitos')]
    #[Validate('regex:/^[0-9]{14}$/', message: 'O campo CNPJ deve conter apenas números')]
    public $company_data_cnpj;
    
    #[Validate('required', message: 'O campo Inscrição Estadual é obrigatório')]
    public $company_data_state_registration;

    #[Validate('required', message: 'O campo Email de contato é obrigatório')]
    #[Validate('email', message: 'O campo Email de contato deve ser um email válido')]
    public $company_data_contact_email;

    public $company_data_phone_number;
    public $company_data_landline_number;
    public $company_data_logo_picture_path;
    public $company_data_foundation_date;
    public $company_data_company_same_user_address;


    // Etapa 4 - Endereço da Empresa
    #[Validate('required', message: 'O campo CEP é obrigatório')]
    #[Validate('digits:8', message: 'O campo CEP deve ter 8 dígitos')]
    #[Validate('regex:/^[0-9]{8}$/', message: 'O campo CEP deve conter apenas números')]
    public $company_address_data_cep;

    #[Validate('required', message: 'O campo Número é obrigatório')]
    #[Validate('numeric', message: 'O campo deve ser numérico')]
    #[Validate('regex:/^[0-9]+$/', message: 'O campo Número deve conter apenas números')]
    public $company_address_data_building_number;

    #[Validate('required', message: 'O campo Rua é obrigatório')]
    #[Validate('min:3', message: 'O campo Rua deve ter no mínimo 3 caracteres')]
    #[Validate('regex:/^[a-zA-ZÀ-ÿ0-9\s.,\'-]+$/', message: 'O campo Rua deve conter apenas letras, números, espaços, virgula, ponto, apóstrofo e hífen')]
    public $company_address_data_street;

    #[Validate('required', message: 'O campo Bairro é obrigatório')]
    #[Validate('min:3', message: 'O campo Bairro deve ter no mínimo 3 caracteres')]
    #[Validate('regex:/^[a-zA-ZÀ-ÿ\s\'-]+$/', message: 'O campo Bairro deve conter apenas letras e espaços')]
    public $company_address_data_neighborhood;

    #[Validate('required', message: 'O campo Cidade é obrigatório')]
    #[Validate('min:3', message: 'O campo Cidade deve ter no mínimo 3 caracteres')]
    #[Validate('regex:/^[a-zA-ZÀ-ÿ\s\'-]+$/', message: 'O campo Cidade deve conter apenas letras e espaços')]
    public $company_address_data_city;

    #[Validate('required', message: 'O campo Estado é obrigatório')]
    #[Validate('min:2', message: 'O campo Estado deve ter no mínimo 2 caracteres')]
    #[Validate('regex:/^[a-zA-ZÀ-ÿ\s\'-]+$/', message: 'O campo Estado deve conter apenas letras e espaços')]
    public $company_address_data_state;

    public $company_address_data_complement;
    
    public function nextStep()
    {

        match ($this->step) {
            1 => $this->validate([
                'user_data_name' => 'required|min:6|regex:/^[a-zA-ZÀ-ÿ\s\']+$/',
                'user_data_email' => 'required|email',
                'user_data_password' => 'required|min:8',
                'user_data_password_confirmation' => 'required|same:user_data_password',
                'user_data_cpf' => 'required|digits:11|regex:/^[0-9]{11}$/',
            ]),
            2 => $this->validate([
                'user_address_data_cep' => 'required|digits:8|regex:/^[0-9]{8}$/',
                'user_address_data_building_number' => 'required|numeric|regex:/^[0-9]+$/',
                'user_address_data_street' => 'required|min:3|regex:/^[a-zA-ZÀ-ÿ0-9\s.,\'-]+$/',
                'user_address_data_neighborhood' => 'required|min:3|regex:/^[a-zA-ZÀ-ÿ\s\'-]+$/',
                'user_address_data_city' => 'required|min:3|regex:/^[a-zA-ZÀ-ÿ\s\'-]+$/',
                'user_address_data_state' => 'required|min:2|regex:/^[a-zA-ZÀ-ÿ\s\'-]+$/',
            ]),
            3 => $this->validate([
                'company_data_fantasy_name' => 'required|min:3|regex:/^[a-zA-ZÀ-ÿ0-9\s\'\-\.,&\/]+$/',
                'company_data_corporate_name' => 'required|min:3|regex:/^[a-zA-ZÀ-ÿ0-9\s.,&\'-\/]+$/',
                'company_data_cnpj' => 'required|digits:14|regex:/^[0-9]{14}$/',
                'company_data_state_registration' => 'required',
                'company_data_contact_email' => 'required|email',
            ]),
            4 => $this->validate([
                'company_address_data_cep' => 'required|digits:8|regex:/^[0-9]{8}$/',
                'company_address_data_building_number' => 'required|numeric|regex:/^[0-9]+$/',
                'company_address_data_street' => 'required|min:3|regex:/^[a-zA-ZÀ-ÿ0-9\s.,\'-]+$/',
                'company_address_data_neighborhood' => 'required|min:3|regex:/^[a-zA-ZÀ-ÿ\s\'-]+$/',
                'company_address_data_city' => 'required|min:3|regex:/^[a-zA-ZÀ-ÿ\s\'-]+$/',
                'company_address_data_state' => 'required|min:2|regex:/^[a-zA-ZÀ-ÿ\s\'-]+$/',
            ]),
            default => null,
        };

        if ($this->step < 4) {
            $this->step++;
        }
    }

    public function prevStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function updatedUserAddressDataCep($value)
    {
        $cep = preg_replace('/[^0-9]/', '', $value);

        if (strlen($cep) === 8) {
            $this->buscarEnderecoPorCep($cep);
        }
    }

    private function buscarEnderecoPorCep($cep)
    {
        try {
            $response = \Illuminate\Support\Facades\Http::withoutVerifying()
                ->get("https://viacep.com.br/ws/{$cep}/json/");

            if ($response->successful() && !$response->json('erro')) {
                $dados = $response->json();

                $this->user_address_data_street = $dados['logradouro'] ?? '';
                $this->user_address_data_neighborhood = $dados['bairro'] ?? '';
                $this->user_address_data_city = $dados['localidade'] ?? '';
                $this->user_address_data_state = $dados['uf'] ?? '';
            } else {
                $this->addError('user_address_data_cep', 'CEP inválido ou não encontrado.');
            }
        } catch (\Exception $e) {
            $this->addError('user_address_data_cep', 'Erro ao buscar o CEP.');
        }
    }

    public function submit()
    {
       
    }
    
    public function render()
    {
        return view('livewire.register');
    }
}
