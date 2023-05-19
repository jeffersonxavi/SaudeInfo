<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Paciente extends Model
{
    use HasFactory;
    protected $table = 'pacientes';

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
        'numero_sus',
        'genero',
        'estado_civil',
        'data_nascimento',
        'ativo',
    ];
    // Definindo o atributo virtual "idade"
    protected $appends = ['idade'];

    public function profissionais()
    {
        return $this->belongsToMany(Profissional::class);
    }
    
   //Chamar o atributo virtual "idade" de acordo com data nascimento
   public function getIdadeAttribute()
   {
        return Carbon::parse($this->data_nascimento)->diffInYears(now());
    }    
}
