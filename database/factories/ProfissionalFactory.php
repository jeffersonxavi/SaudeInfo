<?php

namespace Database\Factories;
use App\Models\Profissional;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class ProfissionalFactory extends Factory
{
    use HasFactory;

    protected $model = Profissional::class;

    public function definition()
    {
        $this->faker = \Faker\Factory::create('pt_BR');
        return [
            'nome' => $this->faker->name,
            'crm' => $this->faker->numerify('##########'),
            'cpf' => $this->faker->numerify('###.###.###-##'),
            'cep' => $this->faker->numerify('#####-###'),
            'endereco' => $this->faker->streetName,
            'numero' => $this->faker->buildingNumber,
            'complemento' => $this->faker->secondaryAddress,
            'bairro' => $this->faker->citySuffix,
            'cidade' => $this->faker->city,
            'uf' => $this->faker->stateAbbr,
            'telefone' => $this->faker->numerify('(##) ####-####'),
            'email' => $this->faker->email,
            'senha' => Hash::make('senha123'),
        ];
    }
}
