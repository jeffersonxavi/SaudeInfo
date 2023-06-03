<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Consulta extends Model
{

    use HasFactory;

    protected $table = 'consultas';

    protected $fillable = [
        'paciente_id',
        'profissional_id',
        'tipo_consulta_id',
        'dia_marcacao',
        'dia_consulta',
        'hora_consulta',
        'descricao',
        'status',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function profissional()
    {
        return $this->belongsTo(Profissional::class, 'profissional_id');
    }

    public function tipoConsulta()
    {
        return $this->belongsTo(TipoConsulta::class, 'tipo_consulta_id');
    }
    public function consultas()
    {
        return $this->hasMany(Consulta::class, 'profissional_id');
    }
    public function laudo()
    {
        return $this->hasOne(Laudo::class);
    }
}
