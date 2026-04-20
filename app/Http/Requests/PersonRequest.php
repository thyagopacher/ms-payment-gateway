<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PersonRequest extends FormRequest
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
            'person_name' => 'required|string|min:3|max:255',
            'person_mail' => 'required|string|min:3|max:255',
            'person_phone' => 'required|string|min:10|max:30',
            'person_document' => 'required|string|min:11|max:14|unique:person,document',
        ];
    }

    public function attributes(): array
    {
        return [
            'person_name' => __('validation.attributes.person_name'),
            'person_mail' => __('validation.attributes.person_mail'),
            'person_phone' => __('validation.attributes.person_phone'),
            'person_document' => __('validation.attributes.person_document'),
        ];
    }
}

