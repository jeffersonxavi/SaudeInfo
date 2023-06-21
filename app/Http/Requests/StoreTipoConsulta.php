<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTipoConsulta extends FormRequest
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
            'nome' => ['required', 'string', 'max:255'],
            'descricao' => ['required', 'string'],
            'valor' => ['required', 'numeric', 'min:0'],
            'duracao_estimada' => ['required', 'integer', 'min:0'],
            'especialidade_id' => ['required', 'exists:especialidades,id'],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string' => 'O campo :attribute deve ser uma string.',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
            'numeric' => 'O campo :attribute deve ser um valor numérico.',
            'min' => 'O campo :attribute deve ser no mínimo :min.',
            'integer' => 'O campo :attribute deve ser um valor inteiro.',
            'exists' => 'O :attribute informado não existe.',
        ];
    }
}
