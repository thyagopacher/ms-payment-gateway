<?php

namespace App\Http\Requests;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $auth = $this->header('Authorization');

        return !empty($auth) && str_starts_with($auth, 'Bearer ');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'bill_amount' => ['required', 'numeric', 'min:0.01', 'max:9999999999.99'],

            'status' => [
                'sometimes',
                Rule::in(PaymentStatus::values())
            ],

            'payment_method' => [
                'required',
                Rule::in(PaymentMethod::values())
            ],

            'bill_paid_at' => [
                'nullable',
                'date',
                'after_or_equal:bill_due_date'
            ],

            'bill_due_date' => [
                'required',
                'date',
                'after_or_equal:today'
            ],

            'person_document' => [
                'required',
                'exists:person,document'
            ],
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
            'bill_paid_at' => __('validation.attributes.bill_paid_at'),
            'bank' => __('validation.attributes.bank'),
        ];
    }
}
