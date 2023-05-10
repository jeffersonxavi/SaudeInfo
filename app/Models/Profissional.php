<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profissional extends Model
{
    use HasFactory;
    protected $table = 'profissionais';

    protected $fillable = [
        'nome',
        'crm',
        'cpf',
        'cep',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'uf',
        'telefone',
        'email',
        'senha',
        'tipo_profissional',
    ];

    public function especialidades()
    {
        return $this->belongsToMany(Especialidade::class);
    }

    public function pacientes()
    {
        return $this->belongsToMany(Paciente::class);
    }
}
