<?php

namespace Database\Factories;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class PacienteFactory extends Factory
{
    protected $model = Paciente::class;

    public function definition()
    {
        $this->faker = \Faker\Factory::create('pt_BR');
        return [
            'nome' => $this->faker->name,
            'cpf' => $this->faker->numerify('###.###.###-##'),
            'rg' => $this->faker->numerify('###.###.###-##'),
            'telefone' => $this->faker->numerify('(##) ####-####'),
            'email' => $this->faker->email,
            'cep' => $this->faker->postcode,
            'endereco' => $this->faker->streetAddress,
            'numero' => $this->faker->buildingNumber,
            'complemento' => $this->faker->secondaryAddress,
            'bairro' => $this->faker->citySuffix,
            'cidade' => $this->faker->city,
            'uf' => $this->faker->stateAbbr,
            'ativo' => $this->faker->boolean
        ];
    }
}
