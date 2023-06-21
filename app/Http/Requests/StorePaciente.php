<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaciente extends FormRequest
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
            // 'user_id' => 'required|integer',
            'nome' => 'required|string|max:255',
            'cpf' => 'required',
            'rg' => 'required|max:20',
            'telefone' => 'max:20',
            'email' => 'required|email|max:255|',
            // 'senha' => 'required|string|min:6',
            'cep' => 'required|max:10',
            'endereco' => 'required|string|max:255',
            'numero' => 'required|string|max:10',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'uf' => 'required|string|max:2',
            'numero_sus' => 'required|string|max:20',
            'genero' => 'required|string',
            'estado_civil' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
        ];
    }
    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'integer' => 'O campo :attribute deve ser um número inteiro.',
            'string' => 'O campo :attribute deve ser uma string.',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
            'unique' => 'O valor informado para o campo :attribute já está em uso.',
            'email' => 'O campo :attribute deve ser um endereço de e-mail válido.',
            'min' => 'O campo :attribute deve ter no mínimo :min caracteres.',
            'nullable' => 'O campo :attribute pode ser nulo.',
            'in' => 'O campo :attribute deve ter um dos valores: :values.',
            'date' => 'O campo :attribute deve ser uma data válida.',
        ];
    }
}
