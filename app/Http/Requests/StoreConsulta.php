<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConsulta extends FormRequest
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
            // 'paciente_id' => 'required',
            // 'profissional_id' => 'required',
            // 'tipo_consulta_id' => 'required',
            'dia_marcacao' => 'required|date',
            'dia_consulta' => 'required|date|after_or_equal:dia_marcacao',
            'hora_consulta' => 'required',
        ];
    }

    public function messages()
    {
        return [
            // 'paciente_id.required' => 'O campo paciente é obrigatório.',
            // 'profissional_id.required' => 'O campo profissional é obrigatório.',
            'tipo_consulta_id.required' => 'O campo tipo de consulta é obrigatório.',
            'dia_marcacao.required' => 'O campo dia de marcação é obrigatório.',
            'dia_marcacao.date' => 'O campo dia de marcação deve estar no formato de data válido.',
            'dia_consulta.required' => 'O campo dia de consulta é obrigatório.',
            'dia_consulta.date' => 'O campo dia de consulta deve estar no formato de data válido.',
            'dia_consulta.after_or_equal' => 'O dia da consulta deve ser igual ou posterior ao dia de marcação.',
            'hora_consulta.required' => 'O campo hora da consulta é obrigatório.',
        ];
    }
}
