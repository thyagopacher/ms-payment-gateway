<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EmailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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
            'to' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'min:2', 'max:255'],
            'body' => ['required', 'string', 'min:2'],
            'attachment' => ['sometimes', 'array'],
        ];
    }

}

