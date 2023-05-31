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

   
        // Paciente::factory()->count(10000)->create();
        // Profissional::factory()->count(200)->create();
        // Especialidade::factory()->count(20)->create();
        //TipoConsulta::factory()->count(70)->create();
         Consulta::factory()->count(100)->create();
    }
}
