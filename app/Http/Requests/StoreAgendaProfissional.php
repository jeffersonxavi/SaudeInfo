<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAgendaProfissional extends FormRequest
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
            'inicio_atendimento' => 'required',
            'intervalo' => 'required',
            'fim_atendimento' => 'required',
            'max_atendimentos' => 'required|integer|min:1',
            'segunda' => 'boolean',
            'terca' => 'boolean',
            'quarta' => 'boolean',
            'quinta' => 'boolean',
            'sexta' => 'boolean',
            'sabado' => 'boolean',
            'domingo' => 'boolean',
            'observacoes' => 'nullable',
        ];
    }
    public function messages()
    {
        return [
            'inicio_atendimento.required' => 'O campo inicio atendimento é obrigatório.',
            'intervalo.required' => 'O campo intervalo é obrigatório.',
            'fim_atendimento.required' => 'O campo fim atendimento é obrigatório.',
            'max_atendimentos.required' => 'O campo Max atendimentos é obrigatório.',
            'max_atendimentos.integer' => 'O campo Max atendimentos deve ser um número inteiro.',
            'max_atendimentos.min' => 'O campo Max atendimentos deve ter um valor mínimo de 1.',
        ];
    }
}
