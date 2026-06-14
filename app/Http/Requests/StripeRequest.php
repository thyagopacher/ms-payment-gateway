<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StripeRequest extends FormRequest
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
            'amount' => ['required', 'integer', 'min:1'],
            'currency' => ['required', 'string', 'size:3'],
            'source' => ['required', 'string'],
            'metadata' => ['sometimes', 'array'],
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'The amount field is required.',
            'amount.integer' => 'The amount must be an integer.',
            'amount.min' => 'The amount must be greater than zero.',

            'currency.required' => 'The currency field is required.',
            'currency.size' => 'The currency must contain 3 characters.',

            'source.required' => 'The source field is required.',

            'metadata.array' => 'The metadata field must be an array.',
        ];
    }
}
