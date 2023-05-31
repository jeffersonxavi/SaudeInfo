<?php

namespace Database\Factories;



use App\Models\Consulta;
use App\Models\Paciente;
use App\Models\Profissional;
use App\Models\TipoConsulta;
use Illuminate\Database\Eloquent\Factories\Factory;


class ConsultaFactory extends Factory
{

    protected $model = Consulta::class;

    public function definition()
    {

        $this->faker = \Faker\Factory::create('pt_BR');
        return [
            // 'paciente_id' => \App\Models\Paciente::factory(),
            // 'profissional_id' => \App\Models\Profissional::factory(),
            // 'tipo_consulta_id' => \App\Models\TipoConsulta::factory(),
            'paciente_id' => Paciente::pluck('id')->random(),
            'profissional_id' => Profissional::pluck('id')->random(),
            'tipo_consulta_id' => TipoConsulta::pluck('id')->random(),
            'dia_marcacao' => $this->faker->dateTimeBetween('-90 days', 'now')->format('Y-m-d'),
            'dia_consulta' => $this->faker->dateTimeBetween('now', '130 days')->format('Y-m-d'),
            'hora_consulta' => $this->faker->time('H:i'),
            'descricao' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7]),
        ];
    }
}
