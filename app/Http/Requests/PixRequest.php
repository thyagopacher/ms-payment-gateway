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
        return false;
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
}
