<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PixRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'person_name' => 'required|string|min:3|max:255',
            'person_city' => 'required|string|min:3|max:255',
            'person_uf' => 'required|string|min:2|max:2',
            'person_cpf_cnpj' => 'required|string|min:11|max:14',
            'person_address' => 'required|string|min:5|max:255',
            'person_zipcode' => 'required|string|min:8|max:8',
            'bill_amount' => 'required|numeric|min:0.01|max:99999999.99',
            'bill_due_date' => 'required|date_format:Y-m-d|min:today'
        ];
    }

    public function messages(): array
    {
        return [
            'person_name.required' => 'O nome é obrigatório.',
            'person_name.string' => 'O nome deve ser uma string.',
            'person_name.min' => 'O nome deve conter pelo menos 3 caracteres.',
            'person_name.max' => 'O nome deve conter no máximo 255 caracteres.',
            'person_city.required' => 'A cidade é obrigatória.',
            'person_city.string' => 'A cidade deve ser uma string.',
            'person_city.min' => 'A cidade deve conter pelo menos 3 caracteres.',
            'person_city.max' => 'A cidade deve conter no máximo 255 caracteres.',
            'person_uf.required' => 'O estado é obrigatório.',
            'person_uf.string' => 'O estado deve ser uma string.',
            'person_uf.min' => 'O estado deve conter pelo menos 2 caracteres.',
            'person_uf.max' => 'O estado deve conter no máximo 2 caracteres.',
            'person_cpf_cnpj.required' => 'O CPF/CNPJ é obrigatório.',
            'person_cpf_cnpj.string' => 'O CPF/CNPJ deve ser uma string.',
            'person_cpf_cnpj.min' => 'O CPF/CNPJ deve conter pelo menos 11 caracteres.',
            'person_cpf_cnpj.max' => 'O CPF/CNPJ deve conter no máximo 14 caracteres.',
            'person_address.required' => 'O endereço é obrigatório.',
            'person_address.string' => 'O endereço deve ser uma string.',
            'person_address.min' => 'O endereço deve conter pelo menos 5 caracteres.',
            'person_address.max' => 'O endereço deve conter no máximo 255 caracteres.',
            'person_zipcode.required' => 'O CEP é obrigatório.',
            'person_zipcode.string' => 'O CEP deve ser uma string.',
            'person_zipcode.min' => 'O CEP deve conter pelo menos 8 caracteres.',
            'bill_amount.required' => 'O valor é obrigatório.',
            'bill_amount.numeric' => 'O valor deve ser numérico.',
            'bill_amount.min' => 'O valor deve ser no mínimo 0.01.',
            'bill_amount.max' => 'O valor deve ser no máximo 99999999.99.',
            'bill_due_date.required' => 'A data de vencimento é obrigatória.',
            'bill_due_date.date_format' => 'A data de vencimento deve estar no formato Y-m-d.',
            'bill_due_date.after_or_equal' => 'A data de vencimento deve ser hoje ou uma data futura.',
        ];
    }
}
