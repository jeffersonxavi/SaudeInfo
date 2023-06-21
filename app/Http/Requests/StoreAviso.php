<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAviso extends FormRequest
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
            'titulo' => 'required',
            'descricao' => 'required',
            'data_criacao' => 'required|date',
            'data_expiracao' => 'required|date|after_or_equal:data_criacao',
            'data_aviso' => 'required|date',
            'prioridade' => 'required',
            'estado' => 'required',
            'responsavel' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'titulo.required' => 'O campo título é obrigatório.',
            'descricao.required' => 'O campo descrição é obrigatório.',
            'data_criacao.required' => 'O campo data de criação é obrigatório.',
            'data_criacao.date' => 'O campo data de criação deve estar no formato de data válido.',
            'data_expiracao.required' => 'O campo data de expiração é obrigatório.',
            'data_expiracao.date' => 'O campo data de expiração deve estar no formato de data válido.',
            'data_expiracao.after_or_equal' => 'A data de expiração deve ser igual ou posterior à data de criação.',
            'data_aviso.required' => 'O campo data de aviso é obrigatório.',
            'data_aviso.date' => 'O campo data de aviso deve estar no formato de data válido.',
            'prioridade.required' => 'O campo prioridade é obrigatório.',
            'estado.required' => 'O campo estado é obrigatório.',
            'responsavel.required' => 'O campo responsável é obrigatório.',
        ];
    }
}
