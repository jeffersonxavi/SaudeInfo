<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cpf',
        'rg',
        'telefone',
        'email',
        'cep',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'uf',
        'ativo',
    ];
    
}
