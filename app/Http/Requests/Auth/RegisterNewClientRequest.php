<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterNewClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // User data.
            'user_data_name' => [
                'required',
                'string',
                'min:4',
                'max:255',
            ],
            'user_data_email' => [
                'required',
                'string',
                'email',
                'unique:users,email',
                'max:255',
            ],
            'user_data_password' => [
                'required',
                'string',
                'min:8',
                'max:255',
                'confirmed',
            ],
            'user_data_cpf' => [
                'required',
                'string',
                'unique:users,cpf',
                "regex:/^\d{11}$/"
            ],
            'user_data_profile_picture_path' => [
                'nullable',
                'file',
                'mimetypes:image/png,image/jpeg',
                'max:3000',
            ],
            'user_data_phone_number' => [
                'nullable',
                'string',
                "regex:/\d{13,15}/",
            ],
            'user_data_birth_date' => [
                'nullable',
                'date',
                Rule::date()->format('Y-m-d'),
                Rule::date()->beforeOrEqual(now()->subYears(18)),
            ],

            // Company data.
            'company_data_fantasy_name' => [
                'required',
                'string',
                'min:4',
                'max:255',
            ],
            'company_data_corporate_name' => [
                'required',
                'string',
                'min:4',
                'max:255'
            ],
            'company_data_cnpj' => [
                'required',
                'string',
                'unique:companies,cnpj',
                "regex:/^\d{14}$/" // Regra temporária, pois o cnpj adicionará caracteres ao padrão.
            ],
            'company_data_state_registration' => [
                'nullable',
                'string',
                "regex:/^\d{8,15}$/",
            ],
            'company_data_logo_picture_path' => [
                'nullable',
                'file',
                'mimetypes:image/png,image/jpeg',
                'max:3000',
            ],
            'company_data_logo_phone_number' => [
                'nullable',
                'string',
                "regex:/\d{13,15}/",
            ],
            'company_data_logo_landline_number' => [
                'nullable',
                'string',
                "regex:/\d{13,15}/",
            ],
            'company_data_contact_email' => [
                'nullable',
                'string',
                'email',
                'unique:companies,contact_email',
                'max:255',
            ],
            'company_data_website_url' => [
                'nullable',
                'string',
                'active_url',
            ],

            //User Address data.
            'user_address_data_street' => [
                'required',
                'string',
                'min:3',
                'max:180',
            ],
            'user_address_data_building_number' => [
                'required',
                'string',
                "regex:/^(?=.*\d)[A-Za-z0-9]{1,5}$/"
            ],
            'user_address_data_complement' => [
                'nullable',
                'string',
                'min:5',
                'max:500',
            ],
            'user_address_data_neighborhood' => [
                'required',
                'string',
                'min:3',
                'max:180'
            ],
            'user_address_data_city' => [
                'required',
                'string',
                'min:3',
                'max:150',
            ],
            'user_address_data_state' => [
                'required',
                'string',
                'in:AC,AL,AP,AM,BA,CE,DF,ES,GO,MA,MT,MS,MG,PA,PB,PR,PE,PI,RJ,RN,RS,RO,RR,SC,SP,SE,TO'
            ],
            'user_address_data_company_same_user_address' => [
                'required',
                'boolean',
            ],

            // Company Address data.
            'company_address_data_street' => [
                'required_if:user_address_data_company_same_user_address,false',
                'string',
                'min:3',
                'max:180',
            ],
            'company_address_data_building_number' => [
                'required_if:user_address_data_company_same_user_address,false',
                'string',
                "regex:/^(?=.*\d)[A-Za-z0-9]{1,5}$/"
            ],
            'company_address_data_complement' => [
                'nullable',
                'string',
                'min:5',
                'max:500',
            ],
            'company_address_data_neighborhood' => [
                'required_if:user_address_data_company_same_user_address,false',
                'string',
                'min:3',
                'max:180'
            ],
            'company_address_data_city' => [
                'required_if:user_address_data_company_same_user_address,false',
                'string',
                'min:3',
                'max:150',
            ],
            'company_address_data_state' => [
                'required_if:user_address_data_company_same_user_address,false',
                'string',
                'in:AC,AL,AP,AM,BA,CE,DF,ES,GO,MA,MT,MS,MG,PA,PB,PR,PE,PI,RJ,RN,RS,RO,RR,SC,SP,SE,TO'
            ],
        ];
    }
}
