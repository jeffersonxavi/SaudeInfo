<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLaudo extends FormRequest
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
            'consulta_id' => 'required',
            'profissional_id' => 'required',
            'paciente_id' => 'required',
            'tipo_consulta_id' => 'required',
            'motivo_consulta' => 'required',
            'diagnostico' => 'required',
            'tratamento_recomendado' => 'required',
            'data' => 'required|date',
        ];
    }
    
    public function messages()
    {
        return [
            'consulta_id.required' => 'O campo "Consulta" é obrigatório.',
            'profissional_id.required' => 'O campo "Profissional" é obrigatório.',
            'paciente_id.required' => 'O campo "Paciente" é obrigatório.',
            'tipo_consulta_id.required' => 'O campo "Tipo de Consulta" é obrigatório.',
            'motivo_consulta.required' => 'O campo "Motivo da Consulta" é obrigatório.',
            'diagnostico.required' => 'O campo "Diagnóstico" é obrigatório.',
            'tratamento_recomendado.required' => 'O campo "Tratamento Recomendado" é obrigatório.',
            'data.required' => 'O campo "Data" é obrigatório.',
            'data.date' => 'O campo "Data" deve ser uma data válida.',
        ];
    }
}
