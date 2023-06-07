<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\ProfissionalController;
use App\Http\Controllers\EspecialidadeController;
use App\Http\Controllers\AgendaProfissionalController;
use App\Http\Controllers\TipoConsultaController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaudoController;
use App\Models\Consulta;
use App\Models\Paciente;
use App\Models\Profissional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');




    Route::get('/pacientes', [PacienteController::class, 'index'])->name('pacientes.index');
    Route::get('/pacientes/create', [PacienteController::class, 'create'])->name('pacientes.create');
    Route::post('/pacientes', [PacienteController::class, 'store'])->name('pacientes.store');
    Route::get('/pacientes/{id}/edit', [PacienteController::class, 'edit'])->name('pacientes.edit');
    Route::put('/pacientes/{id}', [PacienteController::class, 'update'])->name('pacientes.update');
    Route::delete('/pacientes/{id}', [PacienteController::class, 'destroy'])->name('pacientes.destroy');


    Route::get('profissionais/ajax', [ProfissionalController::class, 'paginacaoAjax'])->name('profissionais.ajax');
    //buscar profissionais em consulta
    Route::post('profissionais/consulta/ajax', [ConsultaController::class, 'buscarProfissional'])->name('profissionais.buscar');
    //buscar profissional em consulta
    Route::get('profissional/consulta/ajax', [ConsultaController::class, 'consultaProfissional'])->name('profissional.buscarConsulta');
    //buscar paciente em agenda
    Route::post('pacientes/ajax', [ConsultaController::class, 'buscarPaciente'])->name('pacientes.buscar');
    Route::get('paciente/ajax', [PacienteController::class, 'paginacaoAjax'])->name('pacientes.ajax');
    Route::get('agendas/ajax', [AgendaProfissionalController::class, 'paginacaoAjax'])->name('agendas.ajax');
    Route::get('profissionais/ajax/{id}/pacientes', [ProfissionalController::class, 'getPacientes'])->name('profissionais.pacientes');
    Route::put('/profissionais/atualizarPaciente/{id}', [ProfissionalController::class, 'atualizarPaciente'])->name('profissional.atualizarPaciente');

    Route::get('/especialidades', [EspecialidadeController::class, 'index'])->name('especialidades.index');

    Route::get('/profissionais', [ProfissionalController::class, 'index'])->name('profissionais.index');
    Route::get('/profissionais/create', [ProfissionalController::class, 'create'])->name('profissionais.create');
    Route::post('/profissionais', [ProfissionalController::class, 'store'])->name('profissionais.store');
    Route::get('/profissionais/{id}/edit', [ProfissionalController::class, 'edit'])->name('profissionais.edit');
    Route::put('/profissionais/{id}', [ProfissionalController::class, 'update'])->name('profissionais.update');
    Route::delete('/profissionais/{id}', [ProfissionalController::class, 'destroy'])->name('profissionais.destroy');
    Route::get('profissional/consultas/ajax', [ProfissionalController::class, 'buscarConsultaProfissional'])->name('profissional.consultas.ajax');

    Route::get('/especialidades', [EspecialidadeController::class, 'index'])->name('especialidades.index');
    Route::get('/especialidades/create', [EspecialidadeController::class, 'create'])->name('especialidades.create');
    Route::post('/especialidades', [EspecialidadeController::class, 'store'])->name('especialidades.store');
    Route::get('/especialidades/{id}/edit', [EspecialidadeController::class, 'edit'])->name('especialidades.edit');
    Route::put('/especialidades/{id}', [EspecialidadeController::class, 'update'])->name('especialidades.update');
    Route::delete('/especialidades/{id}', [EspecialidadeController::class, 'destroy'])->name('especialidades.destroy');

    Route::get('agendas/ajax', [AgendaProfissionalController::class, 'paginacaoAjax'])->name('agendas.ajax');
    Route::get('/agendas', [AgendaProfissionalController::class, 'index'])->name('agendas.index');
    Route::get('/agendas/create', [AgendaProfissionalController::class, 'create'])->name('agendas.create');
    Route::post('/agendas', [AgendaProfissionalController::class, 'store'])->name('agendas.store');
    Route::get('/agendas/{id}/edit', [AgendaProfissionalController::class, 'edit'])->name('agendas.edit');
    Route::put('/agendas/{id}', [AgendaProfissionalController::class, 'update'])->name('agendas.update');
    Route::delete('/agendas/{id}', [AgendaProfissionalController::class, 'destroy'])->name('agendas.destroy');

    Route::get('tipos-consultas/ajax', [TipoConsultaController::class, 'paginacaoAjax'])->name('tipos-consultas.ajax');
    Route::get('/tipos-consultas', [TipoConsultaController::class, 'index'])->name('tipos-consultas.index');
    Route::get('/tipos-consultas/create', [TipoConsultaController::class, 'create'])->name('tipos-consultas.create');
    Route::post('/tipos-consultas', [TipoConsultaController::class, 'store'])->name('tipos-consultas.store');
    Route::get('/tipos-consultas/{id}/edit', [TipoConsultaController::class, 'edit'])->name('tipos-consultas.edit');
    Route::put('/tipos-consultas/{id}', [TipoConsultaController::class, 'update'])->name('tipos-consultas.update');
    Route::match(['PUT', 'DELETE'], '/tipos-consultas/{id}', [TipoConsultaController::class, 'destroy'])->name('tipos-consultas.destroy');

    Route::get('consultas/ajax', [ConsultaController::class, 'paginacaoAjax'])->name('consultas.ajax');
    Route::get('/consultas', [ConsultaController::class, 'index'])->name('consultas.index');
    Route::get('/consultas/create', [ConsultaController::class, 'create'])->name('consultas.create');
    Route::post('/consultas', [ConsultaController::class, 'store'])->name('consultas.store');
    Route::get('/consultas/{id}/edit', [ConsultaController::class, 'edit'])->name('consultas.edit');
    Route::put('/consultas/{id}', [ConsultaController::class, 'update'])->name('consultas.update');
    Route::delete('/consultas/{id}', [ConsultaController::class, 'destroy'])->name('consultas.destroy');
    Route::post('/consultas/update-status', [ConsultaController::class, 'updateStatus'])->name('consultas.updateStatus');

    Route::get('laudos/ajax', [LaudoController::class, 'paginacaoAjax'])->name('laudos.ajax');
    Route::get('/laudos', [LaudoController::class, 'index'])->name('laudos.index');
    Route::get('/laudos/create', [LaudoController::class, 'create'])->name('laudos.create');
    Route::post('/laudos/save', [LaudoController::class, 'salvarAjax'])->name('laudos-salvar.ajax');
    Route::post('/laudos', [LaudoController::class, 'store'])->name('laudos.store');
    Route::get('/laudos/{id}/edit', [LaudoController::class, 'edit'])->name('laudos.edit');
    Route::put('/laudos/{id}', [LaudoController::class, 'update'])->name('laudos.update');
    Route::delete('/laudos/{id}', [LaudoController::class, 'destroy'])->name('laudos.destroy');
    Route::post('/laudos/update-status', [LaudoController::class, 'updateStatus'])->name('laudos.updateStatus');
    Route::get('/gerar-pdf/{id}', [LaudoController::class, 'gerarPDF'])->name('gerar.pdf');

    Route::get('/consultas/{id}', [ConsultaController::class, 'getConsultaDetails'])->name('consultas.details');
});


require __DIR__ . '/auth.php';
