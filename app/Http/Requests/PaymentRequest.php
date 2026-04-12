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
            'amount' => ['required', 'numeric', 'min:0.01', 'max:9999999999.99'],

            'status' => [
                'sometimes',
                Rule::in(PaymentStatus::values())
            ],

            'payment_method' => [
                'required',
                Rule::in(PaymentMethod::values())
            ],

            'paid_at' => [
                'nullable',
                'date',
                'after_or_equal:due_date'
            ],

            'due_date' => [
                'required',
                'date',
                'after_or_equal:today'
            ],

            'person_id' => [
                'required',
                'exists:person,id'
            ],
        ];
    }
}
