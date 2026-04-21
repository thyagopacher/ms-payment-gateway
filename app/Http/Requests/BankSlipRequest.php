<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BankSlipRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $auth = $this->header('Authorization');
        return !empty($auth) && str_starts_with($auth, 'Bearer ');
    }

    protected function prepareForValidation()
    {
        $this->headers->set('Accept', 'application/json');
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
            'person_uf' => 'required|string|min:2|max:2|exists:state,abbreviation',
            'person_document' => 'required|string|min:11|max:14',
            'person_address' => 'required|string|min:5|max:255',
            'person_zipcode' => 'required|string|min:8|max:8',
            'bill_amount' => 'required|numeric|min:0.01|max:99999999.99',
            'bill_due_date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'bank' => 'string|in:itau,santander,bradesco,bb'
        ];
    }

    public function attributes(): array
    {
        return [
            'person_name' => __('validation.attributes.person_name'),
            'person_city' => __('validation.attributes.person_city'),
            'person_uf' => __('validation.attributes.person_uf'),
            'person_document' => __('validation.attributes.person_document'),
            'person_address' => __('validation.attributes.person_address'),
            'person_zipcode' => __('validation.attributes.person_zipcode'),
            'bill_amount' => __('validation.attributes.bill_amount'),
            'bill_due_date' => __('validation.attributes.bill_due_date'),
            'bank' => __('validation.attributes.bank'),
        ];
    }
}
