<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PersonRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:255',
            'mail' => 'required|string|min:3|max:255',
            'phone' => 'required|string|min:10|max:30',
            'document' => 'required|string|min:11|max:14|unique:person,document',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser uma string.',
            'name.min' => 'O nome deve conter pelo menos 3 caracteres.',
            'name.max' => 'O nome deve conter no máximo 255 caracteres.',
            'mail.required' => 'O e-mail é obrigatório.',
            'mail.string' => 'O e-mail deve ser uma string.',
            'mail.min' => 'O e-mail deve conter pelo menos 3 caracteres.',
            'mail.max' => 'O e-mail deve conter no máximo 255 caracteres.',
            'phone.required' => 'O telefone é obrigatório.',
            'phone.string' => 'O telefone deve ser uma string.',
            'phone.min' => 'O telefone deve conter pelo menos 10 caracteres.',
            'phone.max' => 'O telefone deve conter no máximo 30 caracteres.',
            'document.required' => 'O documento é obrigatório.',
            'document.string' => 'O documento deve ser uma string.',
            'document.min' => 'O documento deve conter pelo menos 11 caracteres.',
            'document.max' => 'O documento deve conter no máximo 14 caracteres.',
            'document.unique' => 'O documento já está em uso.',
        ];
    }
}
