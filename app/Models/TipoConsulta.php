<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoConsulta extends Model
{
    use HasFactory;
    protected $table = 'tipos_consultas';
    protected $fillable = [
        'nome',
        'descricao',
        'valor',
        'duracao_estimada',
        'especialidade_id'
    ];

    public function especialidade()
    {
        return $this->belongsTo(Especialidade::class);
    }
}
