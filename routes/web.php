<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\ProfissionalController;
use App\Http\Controllers\EspecialidadeController;
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


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
    Route::get('paciente/ajax', [PacienteController::class, 'paginacaoAjax'])->name('pacientes.ajax');
    Route::get('profissionais/ajax/{id}/pacientes', [ProfissionalController::class, 'getPacientes'])->name('profissionais.pacientes');
    Route::put('/profissionais/atualizarPaciente/{id}', [ProfissionalController::class, 'atualizarPaciente'])->name('profissional.atualizarPaciente');
    
    
    Route::get('/especialidades', [EspecialidadeController::class, 'index'])->name('especialidades.index');

    Route::get('/profissionais', [ProfissionalController::class, 'index'])->name('profissionais.index');
    Route::get('/profissionais/create', [ProfissionalController::class, 'create'])->name('profissionais.create');
    Route::post('/profissionais', [ProfissionalController::class, 'store'])->name('profissionais.store');
    Route::get('/profissionais/{id}/edit', [ProfissionalController::class, 'edit'])->name('profissionais.edit');
    Route::put('/profissionais/{id}', [ProfissionalController::class, 'update'])->name('profissionais.update');
    Route::delete('/profissionais/{id}', [ProfissionalController::class, 'destroy'])->name('profissionais.destroy');

    Route::get('/especialidades', [EspecialidadeController::class, 'index'])->name('especialidades.index');
    Route::get('/especialidades/create', [EspecialidadeController::class, 'create'])->name('especialidades.create');
    Route::post('/especialidades', [EspecialidadeController::class, 'store'])->name('especialidades.store');
    Route::get('/especialidades/{id}/edit', [EspecialidadeController::class, 'edit'])->name('especialidades.edit');
    Route::put('/especialidades/{id}', [EspecialidadeController::class, 'update'])->name('especialidades.update');
    Route::delete('/especialidades/{id}', [EspecialidadeController::class, 'destroy'])->name('especialidades.destroy');
});

require __DIR__.'/auth.php';
