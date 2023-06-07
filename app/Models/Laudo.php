<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laudo extends Model
{
    protected $table = 'laudos';

    protected $fillable = [
        'consulta_id',
        'profissional_id',
        'paciente_id',
        'tipo_consulta_id',
        'motivo_consulta',
        'diagnostico',
        'tratamento_recomendado',
        'data',
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }

    public function profissional()
    {
        return $this->belongsTo(Profissional::class);
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
    public function tipoConsulta()
    {
        return $this->belongsTo(TipoConsulta::class);
    }
}
