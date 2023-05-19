<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaProfissional extends Model
{
    use HasFactory;
    protected $table = 'agenda_profissionais';

    protected $fillable = [
        'profissional_id',
        'inicio_atendimento',
        'intervalo',
        'fim_atendimento',
        'max_atendimentos',
        'segunda',
        'terca',
        'quarta',
        'quinta',
        'sexta',
        'sabado',
        'domingo',
        'observacoes',
    ];

    public function profissional()
    {
        return $this->belongsTo(Profissional::class, 'profissional_id');
    }
}
