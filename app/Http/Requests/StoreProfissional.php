<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfissional extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            // 'user_id' => ['required', 'exists:users,id'],
            'nome' => ['required', 'string', 'max:255'],
            // 'crm' => ['required', 'max:255'],
            'cpf' => ['required', 'max:14'],
            'cep' => ['required', 'max:9'],
            'endereco' => ['required', 'string', 'max:255'],
            'numero' => ['required', 'max:10'],
            'complemento' => ['nullable', 'string', 'max:255'],
            'bairro' => ['required', 'string', 'max:255'],
            'cidade' => ['required', 'string', 'max:255'],
            'uf' => ['required', 'string', 'max:2'],
            'telefone' => ['required', 'max:20'],
            'email' => 'required|email',
            'senha' => ['required', 'string', 'min:6'],
            'tipo_profissional' => ['required'],
        ];
    }
    
    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string' => 'O campo :attribute deve ser uma string.',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
            'email' => 'O campo :attribute deve ser um endereço de e-mail válido.',
            'unique' => 'O :attribute informado já está em uso.',
            'min' => 'O campo :attribute deve ter pelo menos :min caracteres.',
            'exists' => 'O :attribute informado não existe.',
            'in' => 'O valor do campo :attribute é inválido.',
        ];
    }
}
