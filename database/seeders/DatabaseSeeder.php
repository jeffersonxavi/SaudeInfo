<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Consulta;
use App\Models\Especialidade;
use App\Models\Paciente;
use App\Models\Profissional;
use App\Models\TipoConsulta;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

   
        // Paciente::factory()->count(200)->create();
        // Profissional::factory()->count(10)->create();
        Especialidade::factory()->count(10)->create();
        TipoConsulta::factory()->count(5)->create();
        Consulta::factory()->count(30)->create();
    }
}
