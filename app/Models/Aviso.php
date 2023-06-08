<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aviso extends Model
{
    use HasFactory;
    protected $table = 'avisos';

    protected $fillable = [
        'titulo',
        'descricao',
        'data_criacao',
        'data_expiracao',
        'data_aviso',
        'prioridade',
        'estado',
        'responsavel',
        // 'departamento',
        // 'tipo_aviso',
        // 'destinatarios',
        // 'anexos',
    ];
}
