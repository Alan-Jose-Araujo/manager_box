<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

class Register extends Component
{
    use WithFileUploads;

    #[Layout('components.layouts.register')]

    public $step = 1;
    public $totalSteps = 4;

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
    public $user_data_cpf;

    public $user_data_phone_number;
    public $user_data_profile_picture_path;
    public $user_data_birth_date;


    // Etapa 2 - Endereço Pessoal
    #[Validate('required', message: 'O campo CEP é obrigatório')]
    #[Validate('min:8', message: 'CEP inválido')]
    public $user_address_data_zip_code;

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
    public $company_data_company_same_user_address = false;


    // Etapa 4 - Endereço da Empresa
    #[Validate('required', message: 'O campo CEP é obrigatório')]
    #[Validate('min:8', message: 'CEP inválido')]
    public $company_address_data_zip_code;

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

    public function getTotalStepsProperty()
    {
        return $this->company_data_company_same_user_address ? 3 : 4;
    }

    public function nextStep()
    {

        $valid = true;

        match ($this->step) {
            1 => $this->validate([
                'user_data_name' => 'required|min:6|regex:/^[a-zA-ZÀ-ÿ\s\']+$/',
                'user_data_email' => 'required|email',
                'user_data_password' => 'required|min:8',
                'user_data_password_confirmation' => 'required|same:user_data_password',
                'user_data_cpf' => 'required',
            ]),
            2 => $this->validate([
                'user_address_data_zip_code' => 'required|min:8',
                'user_address_data_building_number' => 'required|numeric|regex:/^[0-9]+$/',
                'user_address_data_street' => 'required|min:3|regex:/^[a-zA-ZÀ-ÿ0-9\s.,\'-]+$/',
                'user_address_data_neighborhood' => 'required|min:3|regex:/^[a-zA-ZÀ-ÿ\s\'-]+$/',
                'user_address_data_city' => 'required|min:3|regex:/^[a-zA-ZÀ-ÿ\s\'-]+$/',
                'user_address_data_state' => 'required|min:2|regex:/^[a-zA-ZÀ-ÿ\s\'-]+$/',
            ]),
            3 => $this->validate([
                'company_data_fantasy_name' => 'required|min:3|regex:/^[a-zA-ZÀ-ÿ0-9\s\'\-\.,&\/]+$/',
                'company_data_corporate_name' => 'required|min:3|regex:/^[a-zA-ZÀ-ÿ0-9\s.,&\'-\/]+$/',
                'company_data_cnpj' => 'required',
                'company_data_state_registration' => 'required',
                'company_data_contact_email' => 'required|email',
            ]),
            4 => $this->validate([
                'company_address_data_zip_code' => 'required|min:8',
                'company_address_data_building_number' => 'required|numeric|regex:/^[0-9]+$/',
                'company_address_data_street' => 'required|min:3|regex:/^[a-zA-ZÀ-ÿ0-9\s.,\'-]+$/',
                'company_address_data_neighborhood' => 'required|min:3|regex:/^[a-zA-ZÀ-ÿ\s\'-]+$/',
                'company_address_data_city' => 'required|min:3|regex:/^[a-zA-ZÀ-ÿ\s\'-]+$/',
                'company_address_data_state' => 'required|min:2|regex:/^[a-zA-ZÀ-ÿ\s\'-]+$/',
            ]),
            default => null,
        };


        if ($this->step === 1 && !$this->validateCPF($this->user_data_cpf)) {
            $this->addError('user_data_cpf', 'O CPF informado é inválido.');
            $valid = false;
        }

        if ($this->step === 3 && !$this->validateCNPJ($this->company_data_cnpj)) {
            $this->addError('company_data_cnpj', 'O CNPJ informado é inválido.');
            $valid = false;
        }

        if ($this->step === 2 && empty($this->user_address_data_street)) {
            $this->addError('user_address_data_zip_code', 'CEP inválido ou não encontrado.');
            $valid = false;
        }

        if ($this->step === 4 && empty($this->company_address_data_street)) {
            $this->addError('company_address_data_zip_code', 'CEP inválido ou não encontrado.');
            $valid = false;
        }

        if ($valid) {
            if ($this->step < 3) {
                $this->step++;
            } elseif ($this->step === 3 && !$this->company_data_company_same_user_address) {
                $this->step++;
            }
        }
    }

    public function prevStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function updatedUserAddressDataZipCode($value)
    {
        $cep = preg_replace('/[^0-9]/', '', $value);

        if (strlen($cep) === 8) {
            $this->searchAddressZipCode($cep, 'user');
        }
    }

    public function updatedCompanyAddressDataZipCode($value)
    {
        $cep = preg_replace('/[^0-9]/', '', $value);

        if (strlen($cep) === 8) {
            $this->searchAddressZipCode($cep, 'company');
        }
    }

    private function searchAddressZipCode($cep, $tipo)
    {
        try {
            $response = \Illuminate\Support\Facades\Http::withoutVerifying()
                ->get("https://viacep.com.br/ws/{$cep}/json/");

            if ($response->successful() && !$response->json('erro')) {
                $dados = $response->json();

                if ($tipo === 'user') {
                    $this->user_address_data_street = $dados['logradouro'] ?? '';
                    $this->user_address_data_neighborhood = $dados['bairro'] ?? '';
                    $this->user_address_data_city = $dados['localidade'] ?? '';
                    $this->user_address_data_state = $dados['uf'] ?? '';
                } elseif ($tipo === 'company') {
                    $this->company_address_data_street = $dados['logradouro'] ?? '';
                    $this->company_address_data_neighborhood = $dados['bairro'] ?? '';
                    $this->company_address_data_city = $dados['localidade'] ?? '';
                    $this->company_address_data_state = $dados['uf'] ?? '';
                }
            } else {
                $field = $tipo === 'user' ? 'user_address_data_zip_code' : 'company_address_data_zip_code';
                $this->addError($field, 'CEP inválido ou não encontrado.');
            }
        } catch (\Exception $e) {
            $field = $tipo === 'user' ? 'user_address_data_zip_code' : 'company_address_data_zip_code';
            $this->addError($field, 'Erro ao buscar o CEP.');
        }
    }

    public function updatedCompanyDataCnpj($value)
    {

        if (empty($value)) {
            return;
        }

        if (!$this->validateCNPJ($value)) {
            $this->addError('company_data_cnpj', 'O CNPJ informado é inválido.');
        }
    }

    private function validateCNPJ($cnpj)
    {
        $cnpj = preg_replace('/\D/', '', $cnpj);

        if (strlen($cnpj) != 14)
            return false;

        if (preg_match('/(\d)\1{13}/', $cnpj))
            return false;

        if (app()->environment('production')) {
            for ($t = 12; $t < 14; $t++) {
                $d = 0;
                $pos = $t - 7;
                for ($i = 0; $i < $t; $i++) {
                    $d += $cnpj[$i] * $pos--;
                    if ($pos < 2)
                        $pos = 9;
                }
                $digit = ((10 * $d) % 11) % 10;
                if ($cnpj[$t] != $digit)
                    return false;
            }
        }

        return true;
    }

    public function updatedUserDataCpf($value)
    {

        if (empty($value)) {
            return;
        }

        if (!$this->validateCPF($value)) {
            $this->addError('user_data_cpf', 'O CPF informado é inválido.');
        }
    }

    private function validateCPF($cpf)
    {
        $cpf = preg_replace('/\D/', '', $cpf);

        if (strlen($cpf) !== 11) {
            return false;
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        if (app()->environment('production')) {
            for ($t = 9; $t < 11; $t++) {
                $d = 0;
                for ($c = 0; $c < $t; $c++) {
                    $d += $cpf[$c] * (($t + 1) - $c);
                }
                $digit = ((10 * $d) % 11) % 10;
                if ($cpf[$t] != $digit) {
                    return false;
                }
            }
        }

        return true;
    }

    public function updatedCompanyDataCompanySameUserAddress($value)
    {
        if ($value) {
            $this->company_address_data_zip_code = $this->user_address_data_zip_code;
            $this->company_address_data_building_number = $this->user_address_data_building_number;
            $this->company_address_data_street = $this->user_address_data_street;
            $this->company_address_data_neighborhood = $this->user_address_data_neighborhood;
            $this->company_address_data_city = $this->user_address_data_city;
            $this->company_address_data_state = $this->user_address_data_state;
            $this->company_address_data_complement = $this->user_address_data_complement;

            $this->totalSteps = 3;

        } else {
            $this->company_address_data_zip_code = '';
            $this->company_address_data_building_number = '';
            $this->company_address_data_street = '';
            $this->company_address_data_neighborhood = '';
            $this->company_address_data_city = '';
            $this->company_address_data_state = '';
            $this->company_address_data_complement = '';

            $this->totalSteps = 4;
        }
    }

    public function submit()
    {
        $success = true;

        $this->user_data_cpf = preg_replace('/\D/', '', $this->user_data_cpf);
        $this->user_address_data_zip_code = preg_replace('/\D/', '', $this->user_address_data_zip_code);
        $this->company_data_cnpj = preg_replace('/\D/', '', $this->company_data_cnpj);
        $this->company_address_data_zip_code = preg_replace('/\D/', '', $this->company_address_data_zip_code);

        $this->validate();

        if (!$this->validateCPF($this->user_data_cpf)) {
            $this->addError('user_data_cpf', 'O CPF informado é inválido.');
            $success = false;
        }

        if (!$this->validateCNPJ($this->company_data_cnpj)) {
            $this->addError('company_data_cnpj', 'O CNPJ informado é inválido.');
            $success = false;
        }

        if ($success) {
            $this->dispatch('registered-client-form-validation-success', [
                'success' => true,
                'message' => 'Formulário validado com sucesso.'
            ]);
        } else {
            $this->dispatch('registered-client-form-validation-fail', [
                'success' => false,
                'message' => 'Erros encontrados no formulário. Verifique os campos destacados.'
            ]);
        }

    }

    public function render()
    {
        return view('livewire.register');
    }
}
