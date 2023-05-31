<?php

namespace Database\Factories;


use App\Models\Especialidade;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class EspecialidadeFactory extends Factory
{

    protected $model = Especialidade::class;

    public function definition()
    {
        $especialidades = [
            'Cardiologia',
            'Dermatologia',
            'Gastroenterologia',
            'Neurologia',
            'Ortopedia',
            'Oftalmologia',
            'Otorrinolaringologia',
            'Urologia',
            'Endocrinologia',
            'Radiologia',
            'Hematologia',
            'Infectologia',
            'Nefrologia',
            'Psiquiatria',
            'Oncologia',
            'Pediatria',
            'Ginecologia e Obstetrícia',
            'Cirurgia Cardiovascular',
            'Cirurgia Plástica',
            'Cirurgia Torácica',
            'Neurocirurgia',
            'Anestesiologia',
            // Adicione mais especialidades médicas conforme necessário
        ];
        
        $this->faker = \Faker\Factory::create('pt_BR');
        return [
            'nome' => $this->faker->unique()->randomElement($especialidades),
            // Defina outros campos do modelo Especialidade, se houver
        ];
        
    }
}
